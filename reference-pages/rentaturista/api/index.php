<?php
/**
 * RentaTurista Admin API
 * 
 * API REST para el panel de administración de propiedades
 * VERSION 2.2 - With Videos, Availability Calendar, Places Management & Property Types
 */

// Activar reporte de errores PRIMERO
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Función para enviar respuesta JSON
function sendResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

// Función para manejar errores
function sendError($message, $statusCode = 400, $details = null) {
    $response = [
        'success' => false,
        'error' => $message
    ];
    
    if ($details !== null && (defined('DEBUG_MODE') && DEBUG_MODE)) {
        $response['details'] = $details;
    }
    
    sendResponse($response, $statusCode);
}

// Manejador de errores global
set_exception_handler(function($exception) {
    error_log("API Exception: " . $exception->getMessage() . " in " . $exception->getFile() . ":" . $exception->getLine());
    sendError(
        'Error interno del servidor',
        500,
        [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine()
        ]
    );
});

// Manejador de errores fatales
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        header('Content-Type: application/json; charset=UTF-8');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Error fatal del servidor',
            'details' => [
                'message' => $error['message'],
                'file' => $error['file'],
                'line' => $error['line']
            ]
        ], JSON_UNESCAPED_UNICODE);
    }
});

// Manejar peticiones OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Content-Type: application/json; charset=UTF-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    http_response_code(200);
    exit();
}

// Intentar incluir archivos con manejo de errores
try {
    $requiredFiles = [
        'Database' => __DIR__ . '/../config/Database.php',
        'Config' => __DIR__ . '/../config/config.php',
        'PropertyController' => __DIR__ . '//PropertyController.php',
        'ReviewController' => __DIR__ . '//ReviewController.php',
        'ImageController' => __DIR__ . '/ImageController.php',
        'StatsController' => __DIR__ . '/StatsController.php',
        'AvailabilityController' => __DIR__ . '/AvailabilityController.php',
        'PlacesController' => __DIR__ . '/PlacesController.php',
        'VideoController' => __DIR__ . '/VideoController.php',
        'PropertyTypesController' => __DIR__ . '/PropertyTypesController.php'
    ];
    
    foreach ($requiredFiles as $name => $file) {
        if (!file_exists($file)) {
            throw new Exception("Archivo requerido no encontrado: $name ($file)");
        }
    }
    
    require_once $requiredFiles['Database'];
    require_once $requiredFiles['Config'];
    require_once $requiredFiles['PropertyController'];
    require_once $requiredFiles['ReviewController'];
    require_once $requiredFiles['ImageController'];
    require_once $requiredFiles['StatsController'];
    require_once $requiredFiles['AvailabilityController'];
    require_once $requiredFiles['PlacesController'];
    require_once $requiredFiles['VideoController'];
    require_once $requiredFiles['PropertyTypesController'];
    
} catch (Exception $e) {
    error_log("Error loading required files: " . $e->getMessage());
    sendError('Error al cargar archivos requeridos: ' . $e->getMessage(), 500);
}

// Conectar a la base de datos usando getInstance() (Singleton pattern)
try {
    $database = Database::getInstance();
    $db = $database->getConnection();
    
    if ($db === null) {
        throw new Exception("No se pudo establecer conexión con la base de datos");
    }
} catch (Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    sendError('Error de conexión a la base de datos', 500, ['message' => $e->getMessage()]);
}

// Inicializar controladores
try {
    $propertyController = new PropertyController($db);
    $reviewController = new ReviewController($db);
    $imageController = new ImageController($db);
    $statsController = new StatsController($db);
    $availabilityController = new AvailabilityController($db);
    $placesController = new PlacesController($db);
    $videoController = new VideoController($db);
    $propertyTypesController = new PropertyTypesController($db);
} catch (Exception $e) {
    error_log("Controller initialization error: " . $e->getMessage());
    sendError('Error al inicializar controladores', 500, ['message' => $e->getMessage()]);
}

// Función auxiliar para extraer ID de segmentos
function extractId($segments, $index) {
    if (!isset($segments[$index])) {
        return null;
    }
    
    $id = filter_var($segments[$index], FILTER_VALIDATE_INT);
    return $id !== false && $id > 0 ? $id : null;
}

// Obtener método y ruta
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? $_SERVER['REQUEST_URI'] ?? '/';

// Limpiar la ruta - remover /rentaturista/api y cualquier query string
$path = parse_url($path, PHP_URL_PATH);
$path = str_replace('/rentaturista/api', '', $path);
$path = str_replace('/index.php', '', $path);
$path = trim($path, '/');

// Si la ruta está vacía, mostrar información de la API
if (empty($path)) {
    sendResponse([
        'success' => true,
        'message' => 'RentaTurista API v2.2',
        'endpoints' => [
            'properties' => '/api/properties',
            'property-types' => '/api/property-types',
            'reviews' => '/api/reviews',
            'images' => '/api/images',
            'videos' => '/api/videos',
            'availability' => '/api/properties/:id/availability',
            'places' => '/api/places',
            'stats' => '/api/stats/dashboard'
        ],
        'documentation' => 'https://docs.rentaturista.com'
    ]);
}

// Dividir en segmentos
$segments = explode('/', $path);

// Enrutamiento
try {
    
    // RUTAS DE ESTADÍSTICAS
    if ($segments[0] === 'stats') {
        
        // GET /api/stats/dashboard - Estadísticas del dashboard
        if ($method === 'GET' && count($segments) === 2 && $segments[1] === 'dashboard') {
            $statsController->getDashboard();
        }
        
        else {
            sendError('Ruta no encontrada', 404);
        }
    }
    
    // RUTAS DE TIPOS DE PROPIEDADES
    elseif ($segments[0] === 'property-types') {
        
        // GET /api/property-types - Listar tipos de propiedades
        if ($method === 'GET' && count($segments) === 1) {
            $propertyTypesController->getAll();
        }
        
        // POST /api/property-types - Crear tipo de propiedad
        elseif ($method === 'POST' && count($segments) === 1) {
            $propertyTypesController->create();
        }
        
        // GET /api/property-types/:id - Obtener tipo por ID
        elseif ($method === 'GET' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $propertyTypesController->getById($id);
        }
        
        // PUT /api/property-types/:id - Actualizar tipo
        elseif ($method === 'PUT' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $propertyTypesController->update($id);
        }
        
        // DELETE /api/property-types/:id - Eliminar tipo
        elseif ($method === 'DELETE' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $propertyTypesController->delete($id);
        }
        
        else {
            sendError('Ruta no encontrada', 404);
        }
    }
    
    // RUTAS DE TIPOS DE PROPIEDADES
    elseif ($segments[0] === 'property-types') {
        
        // GET /api/property-types - Listar tipos de propiedades
        if ($method === 'GET' && count($segments) === 1) {
            $propertyTypesController->getAll();
        }
        
        // POST /api/property-types - Crear tipo de propiedad
        elseif ($method === 'POST' && count($segments) === 1) {
            $propertyTypesController->create();
        }
        
        // GET /api/property-types/:id - Obtener tipo por ID
        elseif ($method === 'GET' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $propertyTypesController->getById($id);
        }
        
        // PUT /api/property-types/:id - Actualizar tipo
        elseif ($method === 'PUT' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $propertyTypesController->update($id);
        }
        
        // DELETE /api/property-types/:id - Eliminar tipo
        elseif ($method === 'DELETE' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $propertyTypesController->delete($id);
        }
        
        else {
            sendError('Ruta no encontrada', 404);
        }
    }
    
    // RUTAS DE LUGARES
    elseif ($segments[0] === 'places') {
        
        // GET /api/places - Listar lugares
        if ($method === 'GET' && count($segments) === 1) {
            $placesController->getAll();
        }
        
        // GET /api/places/categories - Obtener categorías
        elseif ($method === 'GET' && count($segments) === 2 && $segments[1] === 'categories') {
            $placesController->getCategories();
        }
        
        // POST /api/places - Crear lugar
        elseif ($method === 'POST' && count($segments) === 1) {
            $placesController->create();
        }
        
        // GET /api/places/:id - Obtener lugar por ID
        elseif ($method === 'GET' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $placesController->getById($id);
        }
        
        // PUT /api/places/:id - Actualizar lugar
        elseif ($method === 'PUT' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $placesController->update($id);
        }
        
        // DELETE /api/places/:id - Eliminar lugar
        elseif ($method === 'DELETE' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $placesController->delete($id);
        }
        
        else {
            sendError('Ruta no encontrada', 404);
        }
    }
    
    // RUTAS DE PROPIEDADES
    elseif ($segments[0] === 'properties') {
        
        // GET /api/properties - Listar propiedades
        if ($method === 'GET' && count($segments) === 1) {
            $propertyController->getAll();
        }
        
        // POST /api/properties - Crear propiedad
        elseif ($method === 'POST' && count($segments) === 1) {
            $propertyController->create();
        }
        
        // GET /api/properties/:id - Obtener propiedad por ID
        elseif ($method === 'GET' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $propertyController->getById($id);
        }
        
        // PUT /api/properties/:id - Actualizar propiedad
        elseif ($method === 'PUT' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $propertyController->update($id);
        }
        
        // DELETE /api/properties/:id - Eliminar propiedad
        elseif ($method === 'DELETE' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $propertyController->delete($id);
        }
        
        // GET /api/properties/:id/reviews - Listar reseñas de propiedad
        elseif ($method === 'GET' && count($segments) === 3 && $segments[2] === 'reviews') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $reviewController->getByPropertyId($id);
        }
        
        // POST /api/properties/:id/reviews - Crear reseña
        elseif ($method === 'POST' && count($segments) === 3 && $segments[2] === 'reviews') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $reviewController->create($id);
        }
        
        // GET /api/properties/:id/images - Listar imágenes de propiedad
        elseif ($method === 'GET' && count($segments) === 3 && $segments[2] === 'images') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $imageController->getByPropertyId($id);
        }
        
        // POST /api/properties/:id/images - Subir imagen
        elseif ($method === 'POST' && count($segments) === 3 && $segments[2] === 'images') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $imageController->upload($id);
        }
        
        // GET /api/properties/:id/availability - Calendario de disponibilidad
        elseif ($method === 'GET' && count($segments) === 3 && $segments[2] === 'availability') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $availabilityController->getByPropertyId($id);
        }
        
        // POST /api/properties/:id/availability - Establecer disponibilidad
        elseif ($method === 'POST' && count($segments) === 3 && $segments[2] === 'availability') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $availabilityController->setAvailability($id);
        }
        
        // POST /api/properties/:id/availability/block - Bloquear fechas
        elseif ($method === 'POST' && count($segments) === 4 && $segments[2] === 'availability' && $segments[3] === 'block') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $availabilityController->blockDates($id);
        }
        
        // POST /api/properties/:id/availability/unblock - Desbloquear fechas
        elseif ($method === 'POST' && count($segments) === 4 && $segments[2] === 'availability' && $segments[3] === 'unblock') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $availabilityController->unblockDates($id);
        }
        
        // POST /api/properties/:id/availability/special-pricing - Precios especiales
        elseif ($method === 'POST' && count($segments) === 4 && $segments[2] === 'availability' && $segments[3] === 'special-pricing') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $availabilityController->setSpecialPricing($id);
        }
        
        // GET /api/properties/:id/availability/summary - Resumen de disponibilidad
        elseif ($method === 'GET' && count($segments) === 4 && $segments[2] === 'availability' && $segments[3] === 'summary') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $availabilityController->getSummary($id);
        }
        
        // GET /api/properties/:id/nearby-places - Lugares cercanos
        elseif ($method === 'GET' && count($segments) === 3 && $segments[2] === 'nearby-places') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $placesController->getNearbyPlaces($id);
        }
        
        // POST /api/properties/:property_id/nearby-places/:place_id - Vincular lugar
        elseif ($method === 'POST' && count($segments) === 4 && $segments[2] === 'nearby-places') {
            $propertyId = extractId($segments, 1);
            $placeId = extractId($segments, 3);
            if (!$propertyId || !$placeId) sendError('IDs inválidos', 400);
            $placesController->linkToProperty($propertyId, $placeId);
        }
        
        // GET /api/properties/:id/videos - Listar videos de propiedad
        elseif ($method === 'GET' && count($segments) === 3 && $segments[2] === 'videos') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $videoController->getByPropertyId($id);
        }
        
        // POST /api/properties/:id/videos - Agregar video
        elseif ($method === 'POST' && count($segments) === 3 && $segments[2] === 'videos') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $videoController->add($id);
        }
        
        else {
            sendError('Ruta no encontrada', 404);
        }
    }
    
    // RUTAS DE IMÁGENES
    elseif ($segments[0] === 'images') {
        
        // DELETE /api/images/:id - Eliminar imagen
        if ($method === 'DELETE' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $imageController->delete($id);
        }
        
        // PUT /api/images/:id/primary - Marcar como principal
        elseif ($method === 'PUT' && count($segments) === 3 && $segments[2] === 'primary') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $imageController->setPrimary($id);
        }
        
        else {
            sendError('Ruta no encontrada', 404);
        }
    }
    
    // RUTAS DE VIDEOS
    elseif ($segments[0] === 'videos') {
        
        // PUT /api/videos/:id - Actualizar video
        if ($method === 'PUT' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $videoController->update($id);
        }
        
        // DELETE /api/videos/:id - Eliminar video
        elseif ($method === 'DELETE' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $videoController->delete($id);
        }
        
        // PUT /api/videos/:id/primary - Marcar como principal
        elseif ($method === 'PUT' && count($segments) === 3 && $segments[2] === 'primary') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $videoController->setPrimary($id);
        }
        
        else {
            sendError('Ruta no encontrada', 404);
        }
    }
    
    // RUTAS DE RESEÑAS
    elseif ($segments[0] === 'reviews') {
        
        // PUT /api/reviews/:id - Actualizar reseña
        if ($method === 'PUT' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $reviewController->update($id);
        }
        
        // DELETE /api/reviews/:id - Eliminar reseña
        elseif ($method === 'DELETE' && count($segments) === 2) {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $reviewController->delete($id);
        }
        
        // PUT /api/reviews/:id/approve - Aprobar reseña
        elseif ($method === 'PUT' && count($segments) === 3 && $segments[2] === 'approve') {
            $id = extractId($segments, 1);
            if (!$id) sendError('ID inválido', 400);
            $reviewController->approve($id);
        }
        
        else {
            sendError('Ruta no encontrada', 404);
        }
    }
    
    // Ruta no encontrada
    else {
        sendError('Ruta no encontrada: ' . $path, 404);
    }
    
} catch (Exception $e) {
    error_log("Routing error: " . $e->getMessage());
    sendError('Error en el enrutamiento', 500, ['message' => $e->getMessage()]);
}