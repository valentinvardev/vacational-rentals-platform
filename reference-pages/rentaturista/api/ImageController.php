<?php
/**
 * ImageController
 * 
 * Controlador para gestión de imágenes de propiedades
 */

class ImageController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    /**
     * Obtener imágenes de una propiedad
     */
    public function getByPropertyId($propertyId) {
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
    }
    
    /**
     * Subir imágenes
     */
    public function upload($propertyId) {
        // Verificar que la propiedad existe
        $checkSql = "SELECT id FROM properties WHERE id = :id";
        $checkStmt = $this->db->prepare($checkSql);
        $checkStmt->execute([':id' => $propertyId]);
        
        if (!$checkStmt->fetch()) {
            sendError('Propiedad no encontrada', 404);
        }
        
        // Verificar que se enviaron archivos
        if (empty($_FILES['images'])) {
            sendError('No se enviaron imágenes', 400);
        }
        
        $uploadedImages = [];
        $errors = [];
        
        try {
            $this->db->beginTransaction();
            
            // Procesar cada archivo
            $files = $_FILES['images'];
            $fileCount = is_array($files['name']) ? count($files['name']) : 1;
            
            for ($i = 0; $i < $fileCount; $i++) {
                // Obtener información del archivo
                $fileName = is_array($files['name']) ? $files['name'][$i] : $files['name'];
                $fileTmpName = is_array($files['tmp_name']) ? $files['tmp_name'][$i] : $files['tmp_name'];
                $fileSize = is_array($files['size']) ? $files['size'][$i] : $files['size'];
                $fileError = is_array($files['error']) ? $files['error'][$i] : $files['error'];
                $fileType = is_array($files['type']) ? $files['type'][$i] : $files['type'];
                
                // Validar errores de upload
                if ($fileError !== UPLOAD_ERR_OK) {
                    $errors[] = "Error al subir $fileName";
                    continue;
                }
                
                // Validar tamaño
                if ($fileSize > MAX_UPLOAD_SIZE) {
                    $errors[] = "$fileName excede el tamaño máximo permitido";
                    continue;
                }
                
                // Validar tipo de archivo
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $fileTmpName);
                finfo_close($finfo);
                
                if (!in_array($mimeType, ALLOWED_IMAGE_TYPES)) {
                    $errors[] = "$fileName no es un tipo de imagen válido";
                    continue;
                }
                
                // Generar nombre único
                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = 'property_' . $propertyId . '_' . uniqid() . '.' . $extension;
                $destination = PROPERTY_IMAGES_PATH . '/' . $newFileName;
                
                // Mover archivo
                if (!move_uploaded_file($fileTmpName, $destination)) {
                    $errors[] = "Error al guardar $fileName";
                    continue;
                }
                
                // Generar thumbnail (opcional - simplificado)
                $thumbnailPath = $this->createThumbnail($destination, $newFileName);
                
                // Obtener metadata adicional
                $title = $_POST['title'][$i] ?? null;
                $altText = $_POST['alt_text'][$i] ?? $fileName;
                $type = $_POST['type'][$i] ?? 'other';
                
                // Determinar si es la primera imagen (marcarla como principal)
                $isPrimary = 0;
                $countSql = "SELECT COUNT(*) as count FROM property_images WHERE property_id = :property_id";
                $countStmt = $this->db->prepare($countSql);
                $countStmt->execute([':property_id' => $propertyId]);
                $count = $countStmt->fetch()['count'];
                
                if ($count == 0) {
                    $isPrimary = 1;
                }
                
                // Insertar en base de datos
                $insertSql = "
                    INSERT INTO property_images (
                        property_id, url, thumbnail_url, title, alt_text, type, is_primary, sort_order
                    ) VALUES (
                        :property_id, :url, :thumbnail_url, :title, :alt_text, :type, :is_primary, :sort_order
                    )
                ";
                
                $insertStmt = $this->db->prepare($insertSql);
                $insertStmt->execute([
                    ':property_id' => $propertyId,
                    ':url' => '/uploads/properties/' . $newFileName,
                    ':thumbnail_url' => $thumbnailPath,
                    ':title' => $title,
                    ':alt_text' => $altText,
                    ':type' => $type,
                    ':is_primary' => $isPrimary,
                    ':sort_order' => $count
                ]);
                
                $uploadedImages[] = [
                    'id' => $this->db->lastInsertId(),
                    'url' => '/uploads/properties/' . $newFileName,
                    'thumbnail_url' => $thumbnailPath,
                    'is_primary' => $isPrimary
                ];
            }
            
            $this->db->commit();
            
            if (!empty($uploadedImages)) {
                sendResponse([
                    'success' => true,
                    'message' => count($uploadedImages) . ' imagen(es) subida(s) exitosamente',
                    'data' => $uploadedImages,
                    'errors' => $errors
                ], 201);
            } else {
                $this->db->rollBack();
                sendError('No se pudieron subir las imágenes', 400, ['errors' => $errors]);
            }
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error uploading images: " . $e->getMessage());
            sendError('Error al subir las imágenes', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Eliminar imagen
     */
    public function delete($id) {
        // Obtener información de la imagen
        $sql = "SELECT * FROM property_images WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $image = $stmt->fetch();
        
        if (!$image) {
            sendError('Imagen no encontrada', 404);
        }
        
        try {
            $this->db->beginTransaction();
            
            // Eliminar archivo físico
            $filePath = PROPERTY_IMAGES_PATH . '/' . basename($image['url']);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Eliminar thumbnail si existe
            if ($image['thumbnail_url']) {
                $thumbnailPath = PROPERTY_IMAGES_PATH . '/' . basename($image['thumbnail_url']);
                if (file_exists($thumbnailPath)) {
                    unlink($thumbnailPath);
                }
            }
            
            // Si era la imagen principal, asignar otra como principal
            if ($image['is_primary']) {
                $newPrimarySql = "
                    UPDATE property_images
                    SET is_primary = 1
                    WHERE property_id = :property_id
                    AND id != :id
                    ORDER BY sort_order ASC
                    LIMIT 1
                ";
                $newPrimaryStmt = $this->db->prepare($newPrimarySql);
                $newPrimaryStmt->execute([
                    ':property_id' => $image['property_id'],
                    ':id' => $id
                ]);
            }
            
            // Eliminar de base de datos
            $deleteSql = "DELETE FROM property_images WHERE id = :id";
            $deleteStmt = $this->db->prepare($deleteSql);
            $deleteStmt->execute([':id' => $id]);
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Imagen eliminada exitosamente'
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error deleting image: " . $e->getMessage());
            sendError('Error al eliminar la imagen', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Marcar imagen como principal
     */
    public function setPrimary($id) {
        // Obtener información de la imagen
        $sql = "SELECT * FROM property_images WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $image = $stmt->fetch();
        
        if (!$image) {
            sendError('Imagen no encontrada', 404);
        }
        
        try {
            $this->db->beginTransaction();
            
            // Quitar el flag de primary de todas las imágenes de la propiedad
            $updateSql = "UPDATE property_images SET is_primary = 0 WHERE property_id = :property_id";
            $updateStmt = $this->db->prepare($updateSql);
            $updateStmt->execute([':property_id' => $image['property_id']]);
            
            // Marcar esta imagen como principal
            $setPrimarySql = "UPDATE property_images SET is_primary = 1 WHERE id = :id";
            $setPrimaryStmt = $this->db->prepare($setPrimarySql);
            $setPrimaryStmt->execute([':id' => $id]);
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Imagen marcada como principal'
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error setting primary image: " . $e->getMessage());
            sendError('Error al marcar la imagen como principal', 500, ['message' => $e->getMessage()]);
        }
    }
    
    /**
     * Crear thumbnail de una imagen
     */
    private function createThumbnail($sourcePath, $fileName) {
        // Esta es una implementación simplificada
        // En producción, podrías usar bibliotecas como Intervention Image o GD
        
        $thumbnailName = 'thumb_' . $fileName;
        $thumbnailPath = PROPERTY_IMAGES_PATH . '/' . $thumbnailName;
        
        // Por ahora, solo copiamos la imagen
        // En producción, aquí redimensionarías la imagen
        if (copy($sourcePath, $thumbnailPath)) {
            return '/uploads/properties/' . $thumbnailName;
        }
        
        return null;
    }
    
    /**
     * Reordenar imágenes
     */
    public function reorder() {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($input['images']) || !is_array($input['images'])) {
            sendError('Datos inválidos', 400);
        }
        
        try {
            $this->db->beginTransaction();
            
            $updateSql = "UPDATE property_images SET sort_order = :sort_order WHERE id = :id";
            $updateStmt = $this->db->prepare($updateSql);
            
            foreach ($input['images'] as $index => $imageId) {
                $updateStmt->execute([
                    ':id' => $imageId,
                    ':sort_order' => $index
                ]);
            }
            
            $this->db->commit();
            
            sendResponse([
                'success' => true,
                'message' => 'Orden de imágenes actualizado'
            ]);
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error reordering images: " . $e->getMessage());
            sendError('Error al reordenar las imágenes', 500, ['message' => $e->getMessage()]);
        }
    }
}