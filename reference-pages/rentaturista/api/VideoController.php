<?php
/**
 * VideoController
 * 
 * Controlador para gestión de videos de propiedades (YouTube, Vimeo, directos)
 */

class VideoController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Obtener videos de una propiedad
     */
    public function getByPropertyId($propertyId) {
        $sql = "
            SELECT *
            FROM property_videos
            WHERE property_id = :property_id
            ORDER BY is_primary DESC, sort_order ASC, created_at DESC
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $videos = $stmt->fetchAll();
        
        sendResponse([
            'success' => true,
            'data' => array_map([$this, 'formatVideo'], $videos)
        ]);
    }
    
    /**
     * Agregar video
     */
    public function add($propertyId) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input || empty($input['url'])) {
            sendError('URL del video es requerida', 400);
        }
        
        try {
            $this->db->beginTransaction();
            
            // Detectar tipo de video y extraer ID
            $videoData = $this->parseVideoUrl($input['url']);
            
            // Si es el primer video o se marca como principal, desmarcar otros
            if (!empty($input['is_primary']) || empty($this->getVideoCount($propertyId))) {
                $this->db->prepare("UPDATE property_videos SET is_primary = 0 WHERE property_id = :property_id")
                    ->execute([':property_id' => $propertyId]);
            }
            
            $sql = "
                INSERT INTO property_videos (
                    property_id, url, type, title, description, 
                    thumbnail_url, is_primary, sort_order
                ) VALUES (
                    :property_id, :url, :type, :title, :description,
                    :thumbnail_url, :is_primary, :sort_order
                )
            ";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':property_id' => $propertyId,
                ':url' => $videoData['url'],
                ':type' => $videoData['type'],
                ':title' => $input['title'] ?? null,
                ':description' => $input['description'] ?? null,
                ':thumbnail_url' => $videoData['thumbnail'] ?? null,
                ':is_primary' => $input['is_primary'] ?? 0,
                ':sort_order' => $this->getNextSortOrder($propertyId)
            ]);
            
            $videoId = $this->db->lastInsertId();
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Video agregado exitosamente',
                'data' => ['id' => $videoId]
            ], 201);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error adding video: " . $e->getMessage());
            sendError('Error al agregar video', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Actualizar video
     */
    public function update($id) {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!$input) {
            sendError('Datos inválidos', 400);
        }
        
        try {
            $updates = [];
            $params = [':id' => $id];
            
            if (isset($input['title'])) {
                $updates[] = "title = :title";
                $params[':title'] = $input['title'];
            }
            
            if (isset($input['description'])) {
                $updates[] = "description = :description";
                $params[':description'] = $input['description'];
            }
            
            if (isset($input['sort_order'])) {
                $updates[] = "sort_order = :sort_order";
                $params[':sort_order'] = $input['sort_order'];
            }
            
            if (!empty($updates)) {
                $sql = "UPDATE property_videos SET " . implode(', ', $updates) . " WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute($params);
            }
            
            sendResponse([
                'success' => true,
                'message' => 'Video actualizado exitosamente'
            ]);
            
        } catch (Exception $e) {
            error_log("Error updating video: " . $e->getMessage());
            sendError('Error al actualizar video', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Marcar como principal
     */
    public function setPrimary($id) {
        try {
            // Obtener property_id del video
            $checkSql = "SELECT property_id FROM property_videos WHERE id = :id";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->execute([':id' => $id]);
            $video = $checkStmt->fetch();
            
            if (!$video) {
                sendError('Video no encontrado', 404);
            }
            
            $this->db->beginTransaction();
            
            // Desmarcar todos los videos de esta propiedad
            $sql1 = "UPDATE property_videos SET is_primary = 0 WHERE property_id = :property_id";
            $stmt1 = $this->db->prepare($sql1);
            $stmt1->execute([':property_id' => $video['property_id']]);
            
            // Marcar este como principal
            $sql2 = "UPDATE property_videos SET is_primary = 1 WHERE id = :id";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->execute([':id' => $id]);
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Video marcado como principal'
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error setting primary video: " . $e->getMessage());
            sendError('Error al marcar video como principal', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Eliminar video
     */
    public function delete($id) {
        try {
            $sql = "DELETE FROM property_videos WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            if ($stmt->rowCount() === 0) {
                sendError('Video no encontrado', 404);
            }
            
            sendResponse([
                'success' => true,
                'message' => 'Video eliminado exitosamente'
            ]);
            
        } catch (Exception $e) {
            error_log("Error deleting video: " . $e->getMessage());
            sendError('Error al eliminar video', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Parsear URL de video y extraer información
     */
    private function parseVideoUrl($url) {
        $result = [
            'url' => $url,
            'type' => 'direct',
            'thumbnail' => null
        ];
        
        // YouTube
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches)) {
            $videoId = $matches[1];
            $result['type'] = 'youtube';
            $result['url'] = 'https://www.youtube.com/embed/' . $videoId;
            $result['thumbnail'] = 'https://img.youtube.com/vi/' . $videoId . '/maxresdefault.jpg';
        }
        // Vimeo
        elseif (preg_match('/vimeo\.com\/(\d+)/', $url, $matches)) {
            $videoId = $matches[1];
            $result['type'] = 'vimeo';
            $result['url'] = 'https://player.vimeo.com/video/' . $videoId;
            // Vimeo thumbnail requires API call, skip for now
        }
        
        return $result;
    }
    
    /**
     * Obtener siguiente sort_order
     */
    private function getNextSortOrder($propertyId) {
        $sql = "SELECT MAX(sort_order) as max_order FROM property_videos WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $result = $stmt->fetch();
        
        return ($result['max_order'] ?? 0) + 1;
    }
    
    /**
     * Obtener conteo de videos
     */
    private function getVideoCount($propertyId) {
        $sql = "SELECT COUNT(*) as count FROM property_videos WHERE property_id = :property_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':property_id' => $propertyId]);
        $result = $stmt->fetch();
        
        return $result['count'] ?? 0;
    }
    
    /**
     * Formatear video para respuesta
     */
    private function formatVideo($video) {
        return [
            'id' => (int)$video['id'],
            'property_id' => (int)$video['property_id'],
            'url' => $video['url'],
            'type' => $video['type'],
            'title' => $video['title'],
            'description' => $video['description'],
            'thumbnail_url' => $video['thumbnail_url'],
            'duration' => $video['duration'] ? (int)$video['duration'] : null,
            'is_primary' => (bool)$video['is_primary'],
            'sort_order' => (int)$video['sort_order'],
            'created_at' => $video['created_at'],
            'updated_at' => $video['updated_at']
        ];
    }
}