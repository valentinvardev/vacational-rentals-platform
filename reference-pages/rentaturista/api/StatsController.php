<?php
/**
 * StatsController
 * 
 * Controlador para estadísticas del dashboard
 */

class StatsController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Obtener estadísticas del dashboard
     */
    public function getDashboardStats() {
        try {
            // Total de propiedades
            $totalPropertiesSql = "SELECT COUNT(*) as total FROM properties";
            $totalProperties = $this->db->query($totalPropertiesSql)->fetch()['total'];
            
            // Propiedades activas
            $activePropertiesSql = "SELECT COUNT(*) as total FROM properties WHERE status = 'active'";
            $activeProperties = $this->db->query($activePropertiesSql)->fetch()['total'];
            
            // Propiedades pendientes
            $pendingPropertiesSql = "SELECT COUNT(*) as total FROM properties WHERE status = 'pending'";
            $pendingProperties = $this->db->query($pendingPropertiesSql)->fetch()['total'];
            
            // Propiedades inactivas
            $inactivePropertiesSql = "SELECT COUNT(*) as total FROM properties WHERE status = 'inactive'";
            $inactiveProperties = $this->db->query($inactivePropertiesSql)->fetch()['total'];
            
            // Total de reservas (simulado - necesitarás tabla de bookings)
            $totalBookingsSql = "SELECT SUM(bookings_count) as total FROM properties";
            $totalBookingsResult = $this->db->query($totalBookingsSql)->fetch();
            $totalBookings = $totalBookingsResult['total'] ?? 0;
            
            // Total de reseñas
            $totalReviewsSql = "SELECT COUNT(*) as total FROM reviews WHERE status = 'approved'";
            $totalReviews = $this->db->query($totalReviewsSql)->fetch()['total'];
            
            // Rating promedio general
            $avgRatingSql = "
                SELECT ROUND(AVG(average_rating), 2) as avg_rating 
                FROM properties 
                WHERE average_rating > 0
            ";
            $avgRatingResult = $this->db->query($avgRatingSql)->fetch();
            $avgRating = $avgRatingResult['avg_rating'] ?? 0;
            
            // Ingresos estimados (precio por noche * reservas)
            $estimatedRevenueSql = "
                SELECT ROUND(SUM(price_per_night * bookings_count), 2) as revenue
                FROM properties
            ";
            $revenueResult = $this->db->query($estimatedRevenueSql)->fetch();
            $estimatedRevenue = $revenueResult['revenue'] ?? 0;
            
            // Crecimiento de propiedades (último mes vs mes anterior)
            $lastMonthSql = "
                SELECT COUNT(*) as count
                FROM properties
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
            ";
            $lastMonthCount = $this->db->query($lastMonthSql)->fetch()['count'];
            
            $previousMonthSql = "
                SELECT COUNT(*) as count
                FROM properties
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 2 MONTH)
                AND created_at < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
            ";
            $previousMonthCount = $this->db->query($previousMonthSql)->fetch()['count'];
            
            $propertiesGrowth = $previousMonthCount > 0 
                ? round((($lastMonthCount - $previousMonthCount) / $previousMonthCount) * 100, 1)
                : 0;
            
            // Top 5 propiedades más populares
            $topPropertiesSql = "
                SELECT 
                    p.id, p.title, p.average_rating, p.reviews_count, p.bookings_count,
                    pt.name as type_name, pt.icon as type_icon,
                    (SELECT url FROM property_images WHERE property_id = p.id AND is_primary = 1 LIMIT 1) as image
                FROM properties p
                LEFT JOIN property_types pt ON p.property_type_id = pt.id
                WHERE p.status = 'active'
                ORDER BY p.bookings_count DESC, p.average_rating DESC
                LIMIT 5
            ";
            $topProperties = $this->db->query($topPropertiesSql)->fetchAll();
            
            // Distribución por tipo de propiedad
            $propertyTypesSql = "
                SELECT 
                    pt.name, pt.icon,
                    COUNT(p.id) as count
                FROM property_types pt
                LEFT JOIN properties p ON p.property_type_id = pt.id
                GROUP BY pt.id, pt.name, pt.icon
                HAVING count > 0
                ORDER BY count DESC
            ";
            $propertyTypes = $this->db->query($propertyTypesSql)->fetchAll();
            
            // Reseñas recientes
            $recentReviewsSql = "
                SELECT 
                    r.*,
                    p.title as property_title
                FROM reviews r
                JOIN properties p ON r.property_id = p.id
                WHERE r.status = 'approved'
                ORDER BY r.created_at DESC
                LIMIT 10
            ";
            $recentReviews = $this->db->query($recentReviewsSql)->fetchAll();
            
            // Estadísticas por rango de precio
            $priceRangesSql = "
                SELECT 
                    price_range,
                    COUNT(*) as count,
                    CASE 
                        WHEN price_range = 1 THEN 'Económico'
                        WHEN price_range = 2 THEN 'Moderado'
                        WHEN price_range = 3 THEN 'Alto'
                        WHEN price_range = 4 THEN 'Lujo'
                    END as label
                FROM properties
                WHERE status = 'active'
                GROUP BY price_range
                ORDER BY price_range
            ";
            $priceRanges = $this->db->query($priceRangesSql)->fetchAll();
            
            sendResponse([
                'success' => true,
                'data' => [
                    'overview' => [
                        'total_properties' => (int)$totalProperties,
                        'active_properties' => (int)$activeProperties,
                        'pending_properties' => (int)$pendingProperties,
                        'inactive_properties' => (int)$inactiveProperties,
                        'total_bookings' => (int)$totalBookings,
                        'total_reviews' => (int)$totalReviews,
                        'average_rating' => (float)$avgRating,
                        'estimated_revenue' => (float)$estimatedRevenue
                    ],
                    'growth' => [
                        'properties' => [
                            'last_month' => (int)$lastMonthCount,
                            'previous_month' => (int)$previousMonthCount,
                            'percentage' => (float)$propertiesGrowth
                        ]
                    ],
                    'top_properties' => array_map(function($property) {
                        return [
                            'id' => (int)$property['id'],
                            'title' => $property['title'],
                            'type' => [
                                'name' => $property['type_name'],
                                'icon' => $property['type_icon']
                            ],
                            'rating' => (float)$property['average_rating'],
                            'reviews_count' => (int)$property['reviews_count'],
                            'bookings_count' => (int)$property['bookings_count'],
                            'image' => $property['image']
                        ];
                    }, $topProperties),
                    'property_types_distribution' => array_map(function($type) {
                        return [
                            'name' => $type['name'],
                            'icon' => $type['icon'],
                            'count' => (int)$type['count']
                        ];
                    }, $propertyTypes),
                    'price_ranges_distribution' => array_map(function($range) {
                        return [
                            'range' => (int)$range['price_range'],
                            'label' => $range['label'],
                            'count' => (int)$range['count']
                        ];
                    }, $priceRanges),
                    'recent_reviews' => array_map(function($review) {
                        return [
                            'id' => (int)$review['id'],
                            'property_id' => (int)$review['property_id'],
                            'property_title' => $review['property_title'],
                            'reviewer_name' => $review['reviewer_name'],
                            'rating' => (int)$review['rating'],
                            'comment' => $review['comment'],
                            'created_at' => $review['created_at']
                        ];
                    }, $recentReviews)
                ]
            ]);
            
        } catch (Exception $e) {
            error_log("Error getting dashboard stats: " . $e->getMessage());
            sendError('Error al obtener estadísticas', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Obtener estadísticas de una propiedad específica
     */
    public function getPropertyStats($propertyId) {
        try {
            // Verificar que la propiedad existe
            $checkSql = "SELECT id FROM properties WHERE id = :id";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([':id' => $propertyId]);
            
            if (!$checkStmt->fetch()) {
                sendError('Propiedad no encontrada', 404);
            }
            
            // Vistas totales
            $viewsSql = "SELECT views_count FROM properties WHERE id = :id";
            $viewsStmt = $this->db->prepare($viewsSql);
            $viewsStmt->execute([':id' => $propertyId]);
            $views = $viewsStmt->fetch()['views_count'];
            
            // Reservas
            $bookingsSql = "SELECT bookings_count FROM properties WHERE id = :id";
            $bookingsStmt = $this->db->prepare($bookingsSql);
            $bookingsStmt->execute([':id' => $propertyId]);
            $bookings = $bookingsStmt->fetch()['bookings_count'];
            
            // Rating y reseñas
            $ratingSql = "
                SELECT average_rating, reviews_count
                FROM properties
                WHERE id = :id
            ";
            $ratingStmt = $this->db->prepare($ratingSql);
            $ratingStmt->execute([':id' => $propertyId]);
            $ratingData = $ratingStmt->fetch();
            
            // Distribución de ratings
            $ratingDistributionSql = "
                SELECT 
                    rating,
                    COUNT(*) as count
                FROM reviews
                WHERE property_id = :id
                AND status = 'approved'
                GROUP BY rating
                ORDER BY rating DESC
            ";
            $ratingDistStmt = $this->db->prepare($ratingDistributionSql);
            $ratingDistStmt->execute([':id' => $propertyId]);
            $ratingDistribution = $ratingDistStmt->fetchAll();
            
            sendResponse([
                'success' => true,
                'data' => [
                    'views' => (int)$views,
                    'bookings' => (int)$bookings,
                    'average_rating' => (float)$ratingData['average_rating'],
                    'reviews_count' => (int)$ratingData['reviews_count'],
                    'rating_distribution' => array_map(function($rating) {
                        return [
                            'rating' => (int)$rating['rating'],
                            'count' => (int)$rating['count']
                        ];
                    }, $ratingDistribution),
                    'conversion_rate' => $views > 0 ? round(($bookings / $views) * 100, 2) : 0
                ]
            ]);
            
        } catch (Exception $e) {
            error_log("Error getting property stats: " . $e->getMessage());
            sendError('Error al obtener estadísticas de la propiedad', 500, ['message' => $e->getMessage()]);
        }
    }
}