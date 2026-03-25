<?php
/**
 * RentaTurista - Configuración General
 * 
 * Configuraciones globales de la aplicación
 */

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1); // Cambiar a 1 en desarrollo
ini_set('log_errors', 1);
define('DEBUG_MODE', true);
ini_set('error_log', __DIR__ . '/../logs/php-errors.log');

// Zona horaria
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Configuración de sesión
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Cambiar a 1 si usas HTTPS

// NOTA: Los headers CORS se configuran en index.php de la API
// No los configuramos aquí para evitar duplicados

// Constantes de la aplicación
define('BASE_PATH', dirname(__DIR__));
define('UPLOAD_PATH', BASE_PATH . '/uploads');
define('PROPERTY_IMAGES_PATH', UPLOAD_PATH . '/properties');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/webp']);

// Crear directorios si no existen
if (!file_exists(PROPERTY_IMAGES_PATH)) {
    mkdir(PROPERTY_IMAGES_PATH, 0755, true);
}

// JWT Secret Key (cambiar en producción)
define('JWT_SECRET_KEY', 'your-secret-key-change-this-in-production');
define('JWT_EXPIRATION', 86400); // 24 horas

// Configuración de paginación
define('DEFAULT_PAGE_SIZE', 20);
define('MAX_PAGE_SIZE', 100);
?>