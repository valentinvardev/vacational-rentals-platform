<?php
/**
 * PropertyController
 * 
 * Controlador para gestión de propiedades
 * UPDATED: Añadido manejo completo de imágenes con ordenamiento
 */

class PropertyController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Obtener todas las propiedades con filtros
     */
    public function getAll() {
        // Parámetros de query
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        $propertyType = $_GET['property_type'] ?? '';  // ✅ AÑADIDO: Filtro por tipo
        $page = max(1, (int)($_GET['page'] ?? 1));
        $limit = min(100, max(1, (int)($_GET['limit'] ?? 20)));
        $offset = ($page - 1) * $limit;
        
        // Construir query
        $where = [];
        $params = [];
        
        if (!empty($search)) {
            $where[] = "(p.title LIKE :search OR p.description LIKE :search OR p.address LIKE :search)";
            $params[':search'] = "%$search%";
        }
        
        if (!empty($status) && $status !== 'all') {
            $where[] = "p.status = :status";
            $params[':status'] = $status;
        }
        
        // ✅ AÑADIDO: Filtro por tipo de propiedad
        if (!empty($propertyType) && is_numeric($propertyType)) {
            $where[] = "p.property_type_id = :property_type";
            $params[':property_type'] = (int)$propertyType;
        }
        
        $whereClause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
        
        // Contar total
        $countSql = "SELECT COUNT(*) as total FROM properties p $whereClause";
        $countStmt = $this->db->prepare($countSql);
        $countStmt->execute($params);
        $total = $countStmt->fetch()['total'];
        
        // Obtener propiedades
        $sql = "
            SELECT 
                p.*,
                pt.name as type_name,
                pt.icon as type_icon,
                (SELECT COUNT(*) FROM property_images WHERE property_id = p.id) as images_count,
                (SELECT url FROM property_images WHERE property_id = p.id AND is_primary = 1 LIMIT 1) as primary_image
            FROM properties p
            LEFT JOIN property_types pt ON p.property_type_id = pt.id
            $whereClause
            ORDER BY p.created_at DESC
            LIMIT :limit OFFSET :offset
        ";
        
        $stmt = $this->db->prepare($sql);
        
        // Bind parámetros
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        $properties = $stmt->fetchAll();
        
        // Formatear respuesta
        $formattedProperties = array_map(function($property) {
            return $this->formatProperty($property);
        }, $properties);
        
        sendResponse([
            'success' => true,
            'data' => [
                'properties' => $formattedProperties,
                'total' => (int)$total,
                'pagination' => [
                    'current_page' => $page,
                    'total_pages' => ceil($total / $limit),
                    'per_page' => $limit,
                    'total_results' => (int)$total,
                    'has_next' => $page < ceil($total / $limit),
                    'has_prev' => $page > 1
                ]
            ]
        ]);
    }
    
    /**
     * Obtener una propiedad por ID
     */
    public function getById($id) {
        $sql = "
            SELECT 
                p.*,
                pt.name as type_name,
                pt.icon as type_icon
            FROM properties p
            LEFT JOIN property_types pt ON p.property_type_id = pt.id
            WHERE p.id = :id
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $property = $stmt->fetch();
        
        if (!$property) {
            sendError('Propiedad no encontrada', 404);
        }
        
        // Obtener amenidades
        $amenitiesSql = "
            SELECT a.*, pa.value
            FROM property_amenities pa
            JOIN amenities a ON pa.amenity_id = a.id
            WHERE pa.property_id = :id
            ORDER BY a.sort_order
        ";
        $amenitiesStmt = $this->db->prepare($amenitiesSql);
        $amenitiesStmt->execute([':id' => $id]);
        $property['amenities'] = $amenitiesStmt->fetchAll();
        
        // Obtener imágenes ordenadas
        $imagesSql = "
            SELECT *
            FROM property_images
            WHERE property_id = :id
            ORDER BY is_primary DESC, sort_order ASC
        ";
        $imagesStmt = $this->db->prepare($imagesSql);
        $imagesStmt->execute([':id' => $id]);
        $property['images'] = $imagesStmt->fetchAll();
        
        // Obtener reseñas
        $reviewsSql = "
            SELECT *
            FROM reviews
            WHERE property_id = :id
            AND status = 'approved'
            ORDER BY created_at DESC
        ";
        $reviewsStmt = $this->db->prepare($reviewsSql);
        $reviewsStmt->execute([':id' => $id]);
        $property['reviews'] = $reviewsStmt->fetchAll();
        
        sendResponse([
            'success' => true,
            'data' => $this->formatProperty($property, true)
        ]);
    }
    
    /**
     * ✅ NUEVO: Obtener imágenes de una propiedad
     */
    public function getImages($propertyId) {
        try {
            // Verificar que la propiedad existe
            $checkSql = "SELECT id FROM properties WHERE id = :id";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([':id' => $propertyId]);
            
            if (!$checkStmt->fetch()) {
                sendError('Propiedad no encontrada', 404);
            }
            
            // Obtener imágenes
            $sql = "
                SELECT *
                FROM property_images
                WHERE property_id = :property_id
                ORDER BY is_primary DESC, sort_order ASC
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':property_id' => $propertyId]);
            $images = $stmt->fetchAll();
            
            sendResponse([
                'success' => true,
                'data' => $images
            ]);
            
        } catch (Exception $e) {
            error_log("Error getting images: " . $e->getMessage());
            sendError('Error al obtener imágenes', 500);
        }
    }
    
    /**
     * ✅ NUEVO: Subir nueva imagen
     */
    public function uploadImage($propertyId) {
        try {
            // Verificar que la propiedad existe
            $checkSql = "SELECT id FROM properties WHERE id = :id";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([':id' => $propertyId]);
            
            if (!$checkStmt->fetch()) {
                sendError('Propiedad no encontrada', 404);
            }
            
            // Verificar que hay archivo
            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                sendError('No se recibió ninguna imagen válida', 400);
            }
            
            $file = $_FILES['image'];
            
            // Validar tipo de archivo
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);
            
            if (!in_array($mimeType, $allowedTypes)) {
                sendError('Tipo de archivo no permitido. Solo se aceptan imágenes JPG, PNG, WebP y GIF', 400);
            }
            
            // Validar tamaño (máximo 10MB)
            if ($file['size'] > 10 * 1024 * 1024) {
                sendError('El archivo es demasiado grande. Máximo 10MB', 400);
            }
            
            // Crear directorio si no existe
            $uploadDir = __DIR__ . '/../uploads/properties/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            // Generar nombres de archivo únicos
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $filename = 'property_' . $propertyId . '_' . uniqid() . '.' . $extension;
            $thumbFilename = 'thumb_' . $filename;
            
            $filePath = $uploadDir . $filename;
            $thumbPath = $uploadDir . $thumbFilename;
            
            // Mover archivo
            if (!move_uploaded_file($file['tmp_name'], $filePath)) {
                sendError('Error al guardar el archivo', 500);
            }
            
            // Crear miniatura
            $this->createThumbnail($filePath, $thumbPath, 400, 300);
            
            // Obtener el sort_order más alto actual
            $maxOrderSql = "SELECT COALESCE(MAX(sort_order), -1) as max_order FROM property_images WHERE property_id = :property_id";
            $maxOrderStmt = $this->db->prepare($maxOrderSql);
            $maxOrderStmt->execute([':property_id' => $propertyId]);
            $maxOrder = $maxOrderStmt->fetch()['max_order'];
            
            // Verificar si es la primera imagen (será la primaria)
            $countSql = "SELECT COUNT(*) as count FROM property_images WHERE property_id = :property_id";
            $countStmt = $this->db->prepare($countSql);
            $countStmt->execute([':property_id' => $propertyId]);
            $isFirstImage = $countStmt->fetch()['count'] == 0;
            
            // Guardar en base de datos
            $sql = "
                INSERT INTO property_images (
                    property_id, url, thumbnail_url, alt_text, 
                    sort_order, is_primary, type
                ) VALUES (
                    :property_id, :url, :thumbnail_url, :alt_text,
                    :sort_order, :is_primary, :type
                )
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':property_id' => $propertyId,
                ':url' => '/uploads/properties/' . $filename,
                ':thumbnail_url' => '/uploads/properties/' . $thumbFilename,
                ':alt_text' => $file['name'],
                ':sort_order' => $maxOrder + 1,
                ':is_primary' => $isFirstImage ? 1 : 0,
                ':type' => 'other'
            ]);
            
            $imageId = $this->db->lastInsertId();
            
            // Obtener la imagen insertada
            $getImageSql = "SELECT * FROM property_images WHERE id = :id";
            $getImageStmt = $this->db->prepare($getImageSql);
            $getImageStmt->execute([':id' => $imageId]);
            $image = $getImageStmt->fetch();
            
            sendResponse([
                'success' => true,
                'message' => 'Imagen subida exitosamente',
                'data' => $image
            ], 201);
            
        } catch (Exception $e) {
            error_log("Error uploading image: " . $e->getMessage());
            sendError('Error al subir imagen', 500);
        }
    }
    
    /**
     * ✅ NUEVO: Reordenar imágenes
     */
    public function reorderImages($propertyId) {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            
            if (!$input || !isset($input['order']) || !is_array($input['order'])) {
                sendError('Datos de orden inválidos', 400);
            }
            
            $this->db->beginTransaction();
            
            // Actualizar el sort_order de cada imagen
            $sql = "UPDATE property_images SET sort_order = :sort_order WHERE id = :id AND property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            
            foreach ($input['order'] as $index => $imageId) {
                $stmt->execute([
                    ':sort_order' => $index,
                    ':id' => $imageId,
                    ':property_id' => $propertyId
                ]);
            }
            
            // La primera imagen del orden será la primaria
            if (!empty($input['order'])) {
                $firstImageId = $input['order'][0];
                
                // Desmarcar todas como primarias
                $updateAllSql = "UPDATE property_images SET is_primary = 0 WHERE property_id = :property_id";
                $updateAllStmt = $this->db->prepare($updateAllSql);
                $updateAllStmt->execute([':property_id' => $propertyId]);
                
                // Marcar la primera como primaria
                $updatePrimarySql = "UPDATE property_images SET is_primary = 1 WHERE id = :id AND property_id = :property_id";
                $updatePrimaryStmt = $this->db->prepare($updatePrimarySql);
                $updatePrimaryStmt->execute([
                    ':id' => $firstImageId,
                    ':property_id' => $propertyId
                ]);
            }
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Orden de imágenes actualizado exitosamente'
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error reordering images: " . $e->getMessage());
            sendError('Error al reordenar imágenes', 500);
        }
    }
    
    /**
     * ✅ NUEVO: Eliminar imagen
     */
    public function deleteImage($propertyId, $imageId) {
        try {
            $this->db->beginTransaction();
            
            // Obtener información de la imagen
            $sql = "SELECT * FROM property_images WHERE id = :id AND property_id = :property_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':id' => $imageId,
                ':property_id' => $propertyId
            ]);
            $image = $stmt->fetch();
            
            if (!$image) {
                sendError('Imagen no encontrada', 404);
            }
            
            $wasPrimary = $image['is_primary'];
            
            // Eliminar archivos físicos
            $uploadDir = __DIR__ . '/../uploads/properties/';
            $filename = basename($image['url']);
            $thumbFilename = basename($image['thumbnail_url']);
            
            if (file_exists($uploadDir . $filename)) {
                unlink($uploadDir . $filename);
            }
            if (file_exists($uploadDir . $thumbFilename)) {
                unlink($uploadDir . $thumbFilename);
            }
            
            // Eliminar de base de datos
            $deleteSql = "DELETE FROM property_images WHERE id = :id";
            $deleteStmt = $this->db->prepare($deleteSql);
            $deleteStmt->execute([':id' => $imageId]);
            
            // Si era la imagen primaria, hacer que la siguiente sea primaria
            if ($wasPrimary) {
                $newPrimarySql = "
                    UPDATE property_images 
                    SET is_primary = 1 
                    WHERE property_id = :property_id 
                    ORDER BY sort_order ASC 
                    LIMIT 1
                ";
                $newPrimaryStmt = $this->db->prepare($newPrimarySql);
                $newPrimaryStmt->execute([':property_id' => $propertyId]);
            }
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Imagen eliminada exitosamente'
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error deleting image: " . $e->getMessage());
            sendError('Error al eliminar imagen', 500);
        }
    }
    
    /**
     * ✅ NUEVO: Establecer imagen como primaria
     */
    public function setPrimaryImage($propertyId, $imageId) {
        try {
            $this->db->beginTransaction();
            
            // Verificar que la imagen existe y pertenece a la propiedad
            $checkSql = "SELECT id FROM property_images WHERE id = :id AND property_id = :property_id";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([
                ':id' => $imageId,
                ':property_id' => $propertyId
            ]);
            
            if (!$checkStmt->fetch()) {
                sendError('Imagen no encontrada', 404);
            }
            
            // Desmarcar todas como primarias
            $updateAllSql = "UPDATE property_images SET is_primary = 0 WHERE property_id = :property_id";
            $updateAllStmt = $this->db->prepare($updateAllSql);
            $updateAllStmt->execute([':property_id' => $propertyId]);
            
            // Marcar la seleccionada como primaria
            $updateSql = "UPDATE property_images SET is_primary = 1 WHERE id = :id";
            $updateStmt = $this->db->prepare($updateSql);
            $updateStmt->execute([':id' => $imageId]);
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Imagen establecida como portada exitosamente'
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error setting primary image: " . $e->getMessage());
            sendError('Error al establecer imagen primaria', 500);
        }
    }
    
    /**
     * Crear miniatura de imagen
     */
    private function createThumbnail($source, $destination, $maxWidth, $maxHeight) {
        $imageInfo = getimagesize($source);
        $mime = $imageInfo['mime'];
        
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($source);
                break;
            default:
                return false;
        }
        
        $width = imagesx($image);
        $height = imagesy($image);
        
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = round($width * $ratio);
        $newHeight = round($height * $ratio);
        
        $thumbnail = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preservar transparencia para PNG y GIF
        if ($mime === 'image/png' || $mime === 'image/gif') {
            imagealphablending($thumbnail, false);
            imagesavealpha($thumbnail, true);
            $transparent = imagecolorallocatealpha($thumbnail, 255, 255, 255, 127);
            imagefilledrectangle($thumbnail, 0, 0, $newWidth, $newHeight, $transparent);
        }
        
        imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        
        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($thumbnail, $destination, 85);
                break;
            case 'image/png':
                imagepng($thumbnail, $destination, 8);
                break;
            case 'image/gif':
                imagegif($thumbnail, $destination);
                break;
            case 'image/webp':
                imagewebp($thumbnail, $destination, 85);
                break;
        }
        
        imagedestroy($image);
        imagedestroy($thumbnail);
        
        return true;
    }
    
    // ... [resto de métodos existentes: create, update, delete, etc.]
    // Por brevedad, mantengo solo los métodos nuevos relacionados con imágenes
    // El resto del código permanece igual
    
    /**
     * Formatear propiedad para respuesta
     */
    private function formatProperty($property, $detailed = false) {
        $fixImageUrl = function($url) {
            if (empty($url)) return null;
            if (strpos($url, 'http') === 0) return $url;
            if (strpos($url, '/uploads') === 0) {
                $scriptPath = dirname($_SERVER['SCRIPT_NAME']);
                $basePrefix = str_replace('/api', '', $scriptPath);
                return $basePrefix . $url;
            }
            return $url;
        };
        
        $formatted = [
            'id' => (int)$property['id'],
            'title' => $property['title'],
            'slug' => $property['slug'],
            'description' => $property['description'],
            'type' => [
                'id' => (int)$property['property_type_id'],
                'name' => $property['type_name'] ?? '',
                'icon' => $property['type_icon'] ?? 'home'
            ],
            'location' => [
                'address' => $property['address'],
                'neighborhood' => $property['neighborhood'],
                'city' => $property['city'],
                'state' => $property['state'],
                'country' => $property['country'],
                'latitude' => $property['latitude'] ? (float)$property['latitude'] : null,
                'longitude' => $property['longitude'] ? (float)$property['longitude'] : null
            ],
            'features' => [
                'surface_m2' => $property['surface_m2'] ? (float)$property['surface_m2'] : null,
                'bedrooms' => (int)$property['bedrooms'],
                'bathrooms' => (float)$property['bathrooms'],
                'half_bathrooms' => (int)$property['half_bathrooms'],
                'garage_spaces' => (int)$property['garage_spaces'],
                'max_guests' => (int)$property['max_guests']
            ],
            'pricing' => [
                'price_per_night' => (float)$property['price_per_night'],
                'price_range' => (int)$property['price_range'],
                'cleaning_fee' => (float)$property['cleaning_fee'],
                'minimum_nights' => (int)$property['minimum_nights'],
                'maximum_nights' => (int)$property['maximum_nights']
            ],
            'policies' => [
                'check_in_time' => substr($property['check_in_time'], 0, 5),
                'check_out_time' => substr($property['check_out_time'], 0, 5),
                'pets_allowed' => (bool)$property['pets_allowed'],
                'smoking_allowed' => (bool)$property['smoking_allowed'],
                'events_allowed' => (bool)$property['events_allowed'],
                'cancellation_policy' => $property['cancellation_policy']
            ],
            'status' => $property['status'],
            'featured' => (bool)$property['featured'],
            'verified' => (bool)$property['verified'],
            'stats' => [
                'average_rating' => (float)$property['average_rating'],
                'reviews_count' => (int)$property['reviews_count'],
                'views_count' => (int)$property['views_count'],
                'bookings_count' => (int)$property['bookings_count']
            ],
            'images_count' => isset($property['images_count']) ? (int)$property['images_count'] : 0,
            'primary_image' => $fixImageUrl($property['primary_image'] ?? null),
            'created_at' => $property['created_at'],
            'updated_at' => $property['updated_at']
        ];
        
        if ($detailed) {
            $formatted['amenities'] = $property['amenities'] ?? [];
            if (isset($property['images']) && is_array($property['images'])) {
                $formatted['images'] = array_map(function($img) use ($fixImageUrl) {
                    if (isset($img['url'])) {
                        $img['url'] = $fixImageUrl($img['url']);
                    }
                    if (isset($img['thumbnail_url'])) {
                        $img['thumbnail_url'] = $fixImageUrl($img['thumbnail_url']);
                    }
                    return $img;
                }, $property['images']);
            } else {
                $formatted['images'] = [];
            }
            $formatted['reviews'] = $property['reviews'] ?? [];
        }
        
        return $formatted;
    }
}