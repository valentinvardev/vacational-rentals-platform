<?php
/**
 * ReviewController
 * 
 * Controlador para gestión de reseñas
 */

class ReviewController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Obtener reseñas de una propiedad
     */
    public function getByPropertyId($propertyId) {
        $sql = "
            SELECT *
            FROM reviews
            WHERE property_id = :property_id
            ORDER BY created_at DESC
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $reviews = $stmt->fetchAll();
        
        sendResponse([
            'success' => true,
            'data' => array_map([$this, 'formatReview'], $reviews)
        ]);
    }
    
    /**
     * Crear nueva reseña
     */
    public function create($propertyId) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            sendError('Datos inválidos', 400);
        }
        
        // Validar campos requeridos
        if (empty($input['reviewer_name']) || empty($input['comment']) || !isset($input['rating'])) {
            sendError('Faltan campos requeridos: reviewer_name, comment, rating', 400);
        }
        
        // Validar rating
        $rating = (int)$input['rating'];
        if ($rating < 1 || $rating > 5) {
            sendError('El rating debe estar entre 1 y 5', 400);
        }
        
        try {
            $this->db->beginTransaction();
            
            // Insertar reseña
            $sql = "
                INSERT INTO reviews (
                    property_id, booking_id, user_id, rating, title, comment,
                    reviewer_name, stay_date, status, is_verified_stay
                ) VALUES (
                    :property_id, :booking_id, :user_id, :rating, :title, :comment,
                    :reviewer_name, :stay_date, :status, :is_verified_stay
                )
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':property_id' => $propertyId,
                ':booking_id' => $input['booking_id'] ?? 1, // Valor por defecto temporal
                ':user_id' => $input['user_id'] ?? 1, // Valor por defecto temporal
                ':rating' => $rating,
                ':title' => $input['title'] ?? null,
                ':comment' => $input['comment'],
                ':reviewer_name' => $input['reviewer_name'],
                ':stay_date' => $input['stay_date'] ?? date('Y-m-d'),
                ':status' => $input['status'] ?? 'approved', // Por defecto aprobada en admin
                ':is_verified_stay' => $input['is_verified_stay'] ?? 1
            ]);
            
            $reviewId = $this->db->lastInsertId();
            
            // El trigger after_review_insert actualizará automáticamente el rating de la propiedad
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Reseña creada exitosamente',
                'data' => ['id' => $reviewId]
            ], 201);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error creating review: " . $e->getMessage());
            sendError('Error al crear la reseña', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Actualizar reseña
     */
    public function update($id) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            sendError('Datos inválidos', 400);
        }
        
        // Verificar que la reseña existe
        $checkSql = "SELECT id, property_id FROM reviews WHERE id = :id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([':id' => $id]);
        $review = $checkStmt->fetch();
        
        if (!$review) {
            sendError('Reseña no encontrada', 404);
        }
        
        try {
            $this->db->beginTransaction();
            
            // Construir query de actualización dinámicamente
            $updates = [];
            $params = [':id' => $id];
            
            $allowedFields = [
                'rating', 'title', 'comment', 'reviewer_name', 'stay_date',
                'status', 'owner_response'
            ];
            
            foreach ($allowedFields as $field) {
                if (array_key_exists($field, $input)) {
                    $updates[] = "$field = :$field";
                    $params[":$field"] = $input[$field];
                    
                    // Si es owner_response, también actualizar la fecha
                    if ($field === 'owner_response' && !empty($input[$field])) {
                        $updates[] = "owner_response_date = NOW()";
                    }
                }
            }
            
            // Validar rating si está presente
            if (isset($input['rating'])) {
                $rating = (int)$input['rating'];
                if ($rating < 1 || $rating > 5) {
                    sendError('El rating debe estar entre 1 y 5', 400);
                }
            }
            
            if (!empty($updates)) {
                $sql = "UPDATE reviews SET " . implode(', ', $updates) . " WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute($params);
            }
            
            // El trigger after_review_update actualizará el rating si cambió
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Reseña actualizada exitosamente'
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error updating review: " . $e->getMessage());
            sendError('Error al actualizar la reseña', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Eliminar reseña
     */
    public function delete($id) {
        // Verificar que la reseña existe
        $checkSql = "SELECT id, property_id FROM reviews WHERE id = :id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([':id' => $id]);
        $review = $checkStmt->fetch();
        
        if (!$review) {
            sendError('Reseña no encontrada', 404);
        }
        
        try {
            $this->db->beginTransaction();
            
            // Eliminar reseña
            $sql = "DELETE FROM reviews WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            // El trigger after_review_delete actualizará automáticamente el rating de la propiedad
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Reseña eliminada exitosamente'
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error deleting review: " . $e->getMessage());
            sendError('Error al eliminar la reseña', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Formatear reseña para respuesta
     */
    private function formatReview($review) {
        return [
            'id' => (int)$review['id'],
            'property_id' => (int)$review['property_id'],
            'rating' => (int)$review['rating'],
            'title' => $review['title'],
            'comment' => $review['comment'],
            'reviewer_name' => $review['reviewer_name'],
            'stay_date' => $review['stay_date'],
            'status' => $review['status'],
            'is_verified_stay' => (bool)$review['is_verified_stay'],
            'owner_response' => $review['owner_response'],
            'owner_response_date' => $review['owner_response_date'],
            'created_at' => $review['created_at'],
            'updated_at' => $review['updated_at']
        ];
    }
}