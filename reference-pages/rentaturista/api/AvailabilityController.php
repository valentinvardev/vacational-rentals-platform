<?php
/**
 * AvailabilityController
 * 
 * Controlador para gestión de disponibilidad de propiedades (calendario)
 * VERSION 2.2 - HYBRID: Uses stored procedure + price override
 */

class AvailabilityController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Obtener disponibilidad de una propiedad en un rango de fechas
     */
    public function getByPropertyId($propertyId) {
        // Parámetros
        $startDate = $_GET['start_date'] ?? date('Y-m-d');
        $endDate = $_GET['end_date'] ?? date('Y-m-d', strtotime('+3 months'));
        
        // Verificar que la propiedad existe
        $checkSql = "SELECT id, price_per_night FROM properties WHERE id = :id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([':id' => $propertyId]);
        $property = $checkStmt->fetch();
        
        if (!$property) {
            sendError('Propiedad no encontrada', 404);
        }
        
        try {
            // Get all availability records for the date range
            $sql = "
                SELECT 
                    pa.date,
                    pa.status,
                    COALESCE(pa.price_override, :base_price) as price,
                    pa.notes
                FROM property_availability pa
                WHERE pa.property_id = :property_id
                AND pa.date BETWEEN :start_date AND :end_date
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':property_id' => $propertyId,
                ':start_date' => $startDate,
                ':end_date' => $endDate,
                ':base_price' => $property['price_per_night']
            ]);
            
            $existingAvailability = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Create a map of existing dates
            $availabilityMap = [];
            foreach ($existingAvailability as $day) {
                $availabilityMap[$day['date']] = $day;
            }
            
            // Generate all dates in the range
            $calendar = [];
            $current = new DateTime($startDate);
            $end = new DateTime($endDate);
            
            while ($current <= $end) {
                $dateStr = $current->format('Y-m-d');
                
                if (isset($availabilityMap[$dateStr])) {
                    // Use existing availability data
                    $calendar[] = [
                        'date' => $dateStr,
                        'status' => $availabilityMap[$dateStr]['status'],
                        'price' => (float)$availabilityMap[$dateStr]['price'],
                        'is_available' => $availabilityMap[$dateStr]['status'] === 'available',
                        'notes' => $availabilityMap[$dateStr]['notes']
                    ];
                } else {
                    // Default to available with base price
                    $calendar[] = [
                        'date' => $dateStr,
                        'status' => 'available',
                        'price' => (float)$property['price_per_night'],
                        'is_available' => true,
                        'notes' => null
                    ];
                }
                
                $current->modify('+1 day');
            }
            
            sendResponse([
                'success' => true,
                'data' => $calendar
            ]);
        } catch (Exception $e) {
            error_log("Error in getByPropertyId: " . $e->getMessage());
            sendError('Error al obtener disponibilidad', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Establecer disponibilidad para fechas específicas
     */
    public function setAvailability($propertyId) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input || !isset($input['dates'])) {
            sendError('Datos inválidos. Se requiere un array de fechas', 400);
        }
        
        // Verificar que la propiedad existe
        $checkSql = "SELECT id FROM properties WHERE id = :id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([':id' => $propertyId]);
        
        if (!$checkStmt->fetch()) {
            sendError('Propiedad no encontrada', 404);
        }
        
        try {
            $this->db->beginTransaction();
            
            $status = $input['status'] ?? 'available';
            $priceOverride = $input['price_override'] ?? null;
            $notes = $input['notes'] ?? null;
            
            $sql = "
                INSERT INTO property_availability (
                    property_id, date, status, price_override, notes
                ) VALUES (
                    :property_id, :date, :status, :price_override, :notes
                )
                ON DUPLICATE KEY UPDATE
                    status = VALUES(status),
                    price_override = VALUES(price_override),
                    notes = VALUES(notes)
            ";
            
            $stmt = $this->db->prepare($sql);
            
            foreach ($input['dates'] as $date) {
                $stmt->execute([
                    ':property_id' => $propertyId,
                    ':date' => $date,
                    ':status' => $status,
                    ':price_override' => $priceOverride,
                    ':notes' => $notes
                ]);
            }
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Disponibilidad actualizada para ' . count($input['dates']) . ' fecha(s)'
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error setting availability: " . $e->getMessage());
            sendError('Error al establecer disponibilidad', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Bloquear rango de fechas
     */
    public function blockDates($propertyId) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input || empty($input['start_date']) || empty($input['end_date'])) {
            sendError('Se requiere start_date y end_date', 400);
        }
        
        // Verificar que la propiedad existe
        try {
            $checkSql = "SELECT id FROM properties WHERE id = :id";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([':id' => $propertyId]);
            
            if (!$checkStmt->fetch()) {
                sendError('Propiedad no encontrada', 404);
            }
        } catch (Exception $e) {
            error_log("Error checking property: " . $e->getMessage());
            sendError('Error verificando propiedad', 500, ['message' => $e->getMessage()]);
        }
        
        try {
            $this->db->beginTransaction();
            
            $startDate = new DateTime($input['start_date']);
            $endDate = new DateTime($input['end_date']);
            $status = $input['status'] ?? 'blocked';
            $notes = $input['notes'] ?? null;
            
            $sql = "
                INSERT INTO property_availability (
                    property_id, date, status, notes
                ) VALUES (
                    :property_id, :date, :status, :notes
                )
                ON DUPLICATE KEY UPDATE
                    status = VALUES(status),
                    notes = VALUES(notes)
            ";
            
            $stmt = $this->db->prepare($sql);
            $dates = [];
            
            while ($startDate <= $endDate) {
                $dateStr = $startDate->format('Y-m-d');
                $dates[] = $dateStr;
                
                $stmt->execute([
                    ':property_id' => $propertyId,
                    ':date' => $dateStr,
                    ':status' => $status,
                    ':notes' => $notes
                ]);
                
                $startDate->modify('+1 day');
            }
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Bloqueadas ' . count($dates) . ' fechas',
                'data' => ['dates' => $dates]
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error blocking dates: " . $e->getMessage());
            sendError('Error al bloquear fechas', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Liberar/desbloquear fechas
     */
    public function unblockDates($propertyId) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input || empty($input['dates'])) {
            sendError('Se requiere un array de fechas', 400);
        }
        
        try {
            $placeholders = implode(',', array_fill(0, count($input['dates']), '?'));
            
            $sql = "
                DELETE FROM property_availability 
                WHERE property_id = ? 
                AND date IN ($placeholders)
                AND status != 'booked'
            ";
            
            $stmt = $this->db->prepare($sql);
            $params = array_merge([$propertyId], $input['dates']);
            $stmt->execute($params);
            
            sendResponse([
                'success' => true,
                'message' => 'Desbloqueadas ' . $stmt->rowCount() . ' fechas'
            ]);
            
        } catch (Exception $e) {
            error_log("Error unblocking dates: " . $e->getMessage());
            sendError('Error al desbloquear fechas', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Establecer precios especiales para fechas
     */
    public function setSpecialPricing($propertyId) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input || !isset($input['dates']) || !isset($input['price'])) {
            sendError('Se requiere dates y price', 400);
        }
        
        try {
            $this->db->beginTransaction();
            
            $sql = "
                INSERT INTO property_availability (
                    property_id, date, status, price_override, notes
                ) VALUES (
                    :property_id, :date, 'available', :price_override, :notes
                )
                ON DUPLICATE KEY UPDATE
                    price_override = VALUES(price_override),
                    notes = VALUES(notes)
            ";
            
            $stmt = $this->db->prepare($sql);
            $notes = $input['notes'] ?? 'Precio especial';
            
            foreach ($input['dates'] as $date) {
                $stmt->execute([
                    ':property_id' => $propertyId,
                    ':date' => $date,
                    ':price_override' => $input['price'],
                    ':notes' => $notes
                ]);
            }
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Precios especiales establecidos para ' . count($input['dates']) . ' fecha(s)'
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error setting special pricing: " . $e->getMessage());
            sendError('Error al establecer precios especiales', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Obtener resumen de disponibilidad (estadísticas)
     */
    public function getSummary($propertyId) {
        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate = $_GET['end_date'] ?? date('Y-m-t');
        
        try {
            $sql = "
                SELECT 
                    COUNT(*) as total_days,
                    SUM(CASE WHEN status = 'available' THEN 1 ELSE 0 END) as available_days,
                    SUM(CASE WHEN status = 'booked' THEN 1 ELSE 0 END) as booked_days,
                    SUM(CASE WHEN status = 'blocked' THEN 1 ELSE 0 END) as blocked_days,
                    SUM(CASE WHEN status = 'maintenance' THEN 1 ELSE 0 END) as maintenance_days,
                    SUM(CASE WHEN price_override IS NOT NULL THEN 1 ELSE 0 END) as special_pricing_days
                FROM property_availability
                WHERE property_id = :property_id
                AND date BETWEEN :start_date AND :end_date
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':property_id' => $propertyId,
                ':start_date' => $startDate,
                ':end_date' => $endDate
            ]);
            
            $summary = $stmt->fetch();
            
            sendResponse([
                'success' => true,
                'data' => [
                    'period' => [
                        'start_date' => $startDate,
                        'end_date' => $endDate
                    ],
                    'total_days' => (int)$summary['total_days'],
                    'available_days' => (int)$summary['available_days'],
                    'booked_days' => (int)$summary['booked_days'],
                    'blocked_days' => (int)$summary['blocked_days'],
                    'maintenance_days' => (int)$summary['maintenance_days'],
                    'special_pricing_days' => (int)$summary['special_pricing_days']
                ]
            ]);
        } catch (Exception $e) {
            error_log("Error getting summary: " . $e->getMessage());
            sendError('Error al obtener resumen', 500, ['message' => $e->getMessage()]);
        }
    }
}