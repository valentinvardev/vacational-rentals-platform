<?php
/**
 * PropertyTypesController
 * 
 * Controlador para gestión de tipos de propiedades
 */

class PropertyTypesController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Obtener todos los tipos de propiedades
     */
    public function getAll() {
        try {
            $sql = "
                SELECT 
                    pt.*,
                    COUNT(p.id) as properties_count
                FROM property_types pt
                LEFT JOIN properties p ON p.property_type_id = pt.id AND p.status = 'active'
                GROUP BY pt.id
                ORDER BY pt.name ASC
            ";
            
            $stmt = $this->db->query($sql);
            $types = $stmt->fetchAll();
            
            sendResponse([
                'success' => true,
                'data' => array_map([$this, 'formatPropertyType'], $types)
            ]);
            
        } catch (Exception $e) {
            error_log("Error getting property types: " . $e->getMessage());
            sendError('Error al obtener tipos de propiedades', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Obtener un tipo de propiedad por ID
     */
    public function getById($id) {
        try {
            $sql = "
                SELECT 
                    pt.*,
                    COUNT(p.id) as properties_count
                FROM property_types pt
                LEFT JOIN properties p ON p.property_type_id = pt.id AND p.status = 'active'
                WHERE pt.id = :id
                GROUP BY pt.id
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            $type = $stmt->fetch();
            
            if (!$type) {
                sendError('Tipo de propiedad no encontrado', 404);
            }
            
            sendResponse([
                'success' => true,
                'data' => $this->formatPropertyType($type)
            ]);
            
        } catch (Exception $e) {
            error_log("Error getting property type: " . $e->getMessage());
            sendError('Error al obtener tipo de propiedad', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Crear nuevo tipo de propiedad
     */
    public function create() {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input || empty($input['name'])) {
            sendError('El nombre del tipo de propiedad es requerido', 400);
        }
        
        try {
            $sql = "
                INSERT INTO property_types (name, description, icon)
                VALUES (:name, :description, :icon)
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':name' => $input['name'],
                ':description' => $input['description'] ?? null,
                ':icon' => $input['icon'] ?? 'home'
            ]);
            
            $typeId = $this->db->lastInsertId();
            
            sendResponse([
                'success' => true,
                'message' => 'Tipo de propiedad creado exitosamente',
                'data' => ['id' => $typeId]
            ], 201);
            
        } catch (Exception $e) {
            error_log("Error creating property type: " . $e->getMessage());
            sendError('Error al crear tipo de propiedad', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Actualizar tipo de propiedad
     */
    public function update($id) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            sendError('Datos inválidos', 400);
        }
        
        // Verificar que existe
        $checkSql = "SELECT id FROM property_types WHERE id = :id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([':id' => $id]);
        
        if (!$checkStmt->fetch()) {
            sendError('Tipo de propiedad no encontrado', 404);
        }
        
        try {
            $updates = [];
            $params = [':id' => $id];
            
            $allowedFields = ['name', 'description', 'icon'];
            
            foreach ($allowedFields as $field) {
                if (array_key_exists($field, $input)) {
                    $updates[] = "$field = :$field";
                    $params[":$field"] = $input[$field];
                }
            }
            
            if (!empty($updates)) {
                $sql = "UPDATE property_types SET " . implode(', ', $updates) . " WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute($params);
            }
            
            sendResponse([
                'success' => true,
                'message' => 'Tipo de propiedad actualizado exitosamente'
            ]);
            
        } catch (Exception $e) {
            error_log("Error updating property type: " . $e->getMessage());
            sendError('Error al actualizar tipo de propiedad', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Eliminar tipo de propiedad
     */
    public function delete($id) {
        // Verificar si hay propiedades usando este tipo
        $checkSql = "SELECT COUNT(*) as count FROM properties WHERE property_type_id = :id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([':id' => $id]);
        $result = $checkStmt->fetch();
        
        if ($result['count'] > 0) {
            sendError('No se puede eliminar el tipo de propiedad porque tiene propiedades asociadas', 400);
        }
        
        try {
            $sql = "DELETE FROM property_types WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            if ($stmt->rowCount() === 0) {
                sendError('Tipo de propiedad no encontrado', 404);
            }
            
            sendResponse([
                'success' => true,
                'message' => 'Tipo de propiedad eliminado exitosamente'
            ]);
            
        } catch (Exception $e) {
            error_log("Error deleting property type: " . $e->getMessage());
            sendError('Error al eliminar tipo de propiedad', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Formatear tipo de propiedad para respuesta
     */
    private function formatPropertyType($type) {
        return [
            'id' => (int)$type['id'],
            'name' => $type['name'],
            'description' => $type['description'],
            'icon' => $type['icon'],
            'properties_count' => (int)($type['properties_count'] ?? 0),
            'created_at' => $type['created_at'] ?? null,
            'updated_at' => $type['updated_at'] ?? null
        ];
    }
}