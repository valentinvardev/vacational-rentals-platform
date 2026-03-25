<?php
/**
 * PlacesController
 * 
 * Controlador para gestión de lugares de interés (restaurantes, atracciones, etc.)
 */

class PlacesController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Obtener todos los lugares con filtros
     */
    public function getAll() {
        $category = $_GET['category'] ?? '';
        $featured = $_GET['featured'] ?? '';
        $search = $_GET['search'] ?? '';
        $limit = min(100, max(1, (int)($_GET['limit'] ?? 50)));
        
        $where = ["status = 'active'"];
        $params = [];
        
        if (!empty($category) && $category !== 'all') {
            $where[] = "category = :category";
            $params[':category'] = $category;
        }
        
        if (!empty($featured)) {
            $where[] = "is_featured = 1";
        }
        
        if (!empty($search)) {
            $where[] = "(name LIKE :search OR description LIKE :search OR tags LIKE :search)";
            $params[':search'] = "%$search%";
        }
        
        $whereClause = 'WHERE ' . implode(' AND ', $where);
        
        $sql = "
            SELECT *
            FROM places
            $whereClause
            ORDER BY is_featured DESC, name ASC
            LIMIT :limit
        ";
        
        $stmt = $this->db->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        $places = $stmt->fetchAll();
        
        sendResponse([
            'success' => true,
            'data' => array_map([$this, 'formatPlace'], $places)
        ]);
    }
    
    /**
     * Obtener un lugar por ID
     */
    public function getById($id) {
        $sql = "SELECT * FROM places WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $place = $stmt->fetch();
        
        if (!$place) {
            sendError('Lugar no encontrado', 404);
        }
        
        sendResponse([
            'success' => true,
            'data' => $this->formatPlace($place)
        ]);
    }
    
    /**
     * Crear nuevo lugar
     */
    public function create() {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input || empty($input['name'])) {
            sendError('Nombre del lugar es requerido', 400);
        }
        
        try {
            $this->db->beginTransaction();
            
            // Generar slug
            $slug = $this->generateSlug($input['name']);
            
            // Preparar tags como JSON
            $tags = null;
            if (isset($input['tags']) && is_array($input['tags'])) {
                $tags = json_encode($input['tags']);
            }
            
            $sql = "
                INSERT INTO places (
                    name, slug, description, category, address, city, state,
                    latitude, longitude, phone, website, email, icon,
                    image_url, price_range, is_featured, tags, distance_from_center, status
                ) VALUES (
                    :name, :slug, :description, :category, :address, :city, :state,
                    :latitude, :longitude, :phone, :website, :email, :icon,
                    :image_url, :price_range, :is_featured, :tags, :distance_from_center, :status
                )
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':name' => $input['name'],
                ':slug' => $slug,
                ':description' => $input['description'] ?? null,
                ':category' => $input['category'] ?? 'other',
                ':address' => $input['address'] ?? null,
                ':city' => $input['city'] ?? 'Villa Carlos Paz',
                ':state' => $input['state'] ?? 'Córdoba',
                ':latitude' => $input['latitude'] ?? null,
                ':longitude' => $input['longitude'] ?? null,
                ':phone' => $input['phone'] ?? null,
                ':website' => $input['website'] ?? null,
                ':email' => $input['email'] ?? null,
                ':icon' => $input['icon'] ?? 'map-pin',
                ':image_url' => $input['image_url'] ?? null,
                ':price_range' => $input['price_range'] ?? null,
                ':is_featured' => $input['is_featured'] ?? 0,
                ':tags' => $tags,
                ':distance_from_center' => $input['distance_from_center'] ?? null,
                ':status' => $input['status'] ?? 'active'
            ]);
            
            $placeId = $this->db->lastInsertId();
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Lugar creado exitosamente',
                'data' => ['id' => $placeId]
            ], 201);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error creating place: " . $e->getMessage());
            sendError('Error al crear el lugar', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Actualizar lugar
     */
    public function update($id) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            sendError('Datos inválidos', 400);
        }
        
        // Verificar que existe
        $checkSql = "SELECT id FROM places WHERE id = :id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([':id' => $id]);
        
        if (!$checkStmt->fetch()) {
            sendError('Lugar no encontrado', 404);
        }
        
        try {
            $this->db->beginTransaction();
            
            $updates = [];
            $params = [':id' => $id];
            
            $allowedFields = [
                'name', 'description', 'category', 'address', 'city', 'state',
                'latitude', 'longitude', 'phone', 'website', 'email', 'icon',
                'image_url', 'price_range', 'is_featured', 'distance_from_center', 'status'
            ];
            
            foreach ($allowedFields as $field) {
                if (array_key_exists($field, $input)) {
                    $updates[] = "$field = :$field";
                    $params[":$field"] = $input[$field];
                }
            }
            
            // Manejar tags como JSON
            if (isset($input['tags']) && is_array($input['tags'])) {
                $updates[] = "tags = :tags";
                $params[':tags'] = json_encode($input['tags']);
            }
            
            // Actualizar slug si cambió el nombre
            if (isset($input['name'])) {
                $updates[] = "slug = :slug";
                $params[':slug'] = $this->generateSlug($input['name']);
            }
            
            if (!empty($updates)) {
                $sql = "UPDATE places SET " . implode(', ', $updates) . " WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute($params);
            }
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Lugar actualizado exitosamente'
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error updating place: " . $e->getMessage());
            sendError('Error al actualizar el lugar', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Eliminar lugar
     */
    public function delete($id) {
        try {
            $sql = "DELETE FROM places WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            if ($stmt->rowCount() === 0) {
                sendError('Lugar no encontrado', 404);
            }
            
            sendResponse([
                'success' => true,
                'message' => 'Lugar eliminado exitosamente'
            ]);
            
        } catch (Exception $e) {
            error_log("Error deleting place: " . $e->getMessage());
            sendError('Error al eliminar el lugar', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Vincular lugar a una propiedad
     */
    public function linkToProperty($propertyId, $placeId) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        try {
            $sql = "
                INSERT INTO property_nearby_places (
                    property_id, place_id, distance_meters, walk_time_minutes, notes
                ) VALUES (
                    :property_id, :place_id, :distance_meters, :walk_time_minutes, :notes
                )
                ON DUPLICATE KEY UPDATE
                    distance_meters = :distance_meters,
                    walk_time_minutes = :walk_time_minutes,
                    notes = :notes
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':property_id' => $propertyId,
                ':place_id' => $placeId,
                ':distance_meters' => $input['distance_meters'] ?? null,
                ':walk_time_minutes' => $input['walk_time_minutes'] ?? null,
                ':notes' => $input['notes'] ?? null
            ]);
            
            sendResponse([
                'success' => true,
                'message' => 'Lugar vinculado a la propiedad'
            ]);
            
        } catch (Exception $e) {
            error_log("Error linking place to property: " . $e->getMessage());
            sendError('Error al vincular el lugar', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Obtener lugares cercanos a una propiedad
     */
    public function getNearbyPlaces($propertyId) {
        $sql = "
            SELECT 
                p.*,
                pnp.distance_meters,
                pnp.walk_time_minutes,
                pnp.notes as nearby_notes
            FROM places p
            INNER JOIN property_nearby_places pnp ON p.id = pnp.place_id
            WHERE pnp.property_id = :property_id
            AND p.status = 'active'
            ORDER BY pnp.distance_meters ASC
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $places = $stmt->fetchAll();
        
        sendResponse([
            'success' => true,
            'data' => array_map([$this, 'formatPlace'], $places)
        ]);
    }
    
    /**
     * Obtener categorías disponibles
     */
    public function getCategories() {
        $categories = [
            ['value' => 'restaurant', 'label' => 'Restaurantes', 'icon' => 'utensils'],
            ['value' => 'bar', 'label' => 'Bares', 'icon' => 'beer'],
            ['value' => 'nightlife', 'label' => 'Vida Nocturna', 'icon' => 'music'],
            ['value' => 'attraction', 'label' => 'Atracciones', 'icon' => 'map-pin'],
            ['value' => 'beach', 'label' => 'Playas', 'icon' => 'waves'],
            ['value' => 'hiking', 'label' => 'Trekking', 'icon' => 'mountain'],
            ['value' => 'shopping', 'label' => 'Compras', 'icon' => 'shopping-bag'],
            ['value' => 'service', 'label' => 'Servicios', 'icon' => 'info'],
            ['value' => 'transport', 'label' => 'Transporte', 'icon' => 'bus'],
            ['value' => 'other', 'label' => 'Otros', 'icon' => 'map']
        ];
        
        sendResponse([
            'success' => true,
            'data' => $categories
        ]);
    }
    
    /**
     * Formatear lugar para respuesta
     */
    private function formatPlace($place) {
        return [
            'id' => (int)$place['id'],
            'name' => $place['name'],
            'slug' => $place['slug'],
            'description' => $place['description'],
            'category' => $place['category'],
            'address' => $place['address'],
            'city' => $place['city'],
            'state' => $place['state'],
            'latitude' => $place['latitude'] ? (float)$place['latitude'] : null,
            'longitude' => $place['longitude'] ? (float)$place['longitude'] : null,
            'phone' => $place['phone'],
            'website' => $place['website'],
            'email' => $place['email'],
            'icon' => $place['icon'],
            'image_url' => $place['image_url'],
            'price_range' => $place['price_range'] ? (int)$place['price_range'] : null,
            'rating' => (float)$place['rating'],
            'is_featured' => (bool)$place['is_featured'],
            'tags' => isset($place['tags']) ? json_decode($place['tags'], true) : [],
            'distance_from_center' => $place['distance_from_center'] ? (float)$place['distance_from_center'] : null,
            'status' => $place['status'],
            'created_at' => $place['created_at'],
            'updated_at' => $place['updated_at'],
            // For nearby places
            'distance_meters' => isset($place['distance_meters']) ? (int)$place['distance_meters'] : null,
            'walk_time_minutes' => isset($place['walk_time_minutes']) ? (int)$place['walk_time_minutes'] : null,
            'nearby_notes' => $place['nearby_notes'] ?? null
        ];
    }
    
    /**
     * Generar slug único
     */
    private function generateSlug($text) {
        $slug = strtolower(trim($text));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        
        // Verificar si existe y agregar número si es necesario
        $originalSlug = $slug;
        $counter = 1;
        
        while (true) {
            $checkSql = "SELECT id FROM places WHERE slug = :slug";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([':slug' => $slug]);
            
            if (!$checkStmt->fetch()) {
                break;
            }
            
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
}