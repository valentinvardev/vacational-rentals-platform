<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Verificación de Estructura de Archivos</h1>";

echo "<h2>📍 Información del Servidor</h2>";
echo "<p><strong>Directorio actual:</strong> " . __DIR__ . "</p>";
echo "<p><strong>Archivo actual:</strong> " . __FILE__ . "</p>";

echo "<h2>📂 Estructura de Carpetas</h2>";

$baseDir = __DIR__;

// Verificar carpetas principales
$folders = ['config', 'models', 'controllers', 'utils', 'api', 'uploads', 'logs', 'examples'];

echo "<table border='1' cellpadding='10' style='border-collapse: collapse; font-family: monospace;'>";
echo "<tr><th>Carpeta</th><th>Estado</th><th>Ruta Completa</th></tr>";

foreach ($folders as $folder) {
    $path = $baseDir . '/' . $folder;
    $exists = is_dir($path);
    $status = $exists ? '✅ Existe' : '❌ No existe';
    $color = $exists ? '#d4edda' : '#f8d7da';
    
    echo "<tr style='background-color: $color;'>";
    echo "<td><strong>/$folder</strong></td>";
    echo "<td>$status</td>";
    echo "<td>$path</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h2>📄 Archivos Críticos</h2>";

$files = [
    'config/Database.php',
    'config/config.php',
    'models/Property.php',
    'models/Amenity.php',
    'models/PropertyType.php',
    'api/properties.php',
    'examples/api-client.js'
];

echo "<table border='1' cellpadding='10' style='border-collapse: collapse; font-family: monospace;'>";
echo "<tr><th>Archivo</th><th>Estado</th><th>Tamaño</th><th>Ruta Completa</th></tr>";

foreach ($files as $file) {
    $path = $baseDir . '/' . $file;
    $exists = file_exists($path);
    $status = $exists ? '✅ Existe' : '❌ No existe';
    $size = $exists ? filesize($path) . ' bytes' : '-';
    $color = $exists ? '#d4edda' : '#f8d7da';
    
    echo "<tr style='background-color: $color;'>";
    echo "<td><strong>$file</strong></td>";
    echo "<td>$status</td>";
    echo "<td>$size</td>";
    echo "<td style='font-size: 11px;'>$path</td>";
    echo "</tr>";
}

echo "</table>";

echo "<h2>🔍 Contenido de las Carpetas</h2>";

foreach ($folders as $folder) {
    $path = $baseDir . '/' . $folder;
    if (is_dir($path)) {
        echo "<h3>📁 /$folder</h3>";
        echo "<ul style='font-family: monospace;'>";
        $items = scandir($path);
        foreach ($items as $item) {
            if ($item != '.' && $item != '..') {
                $itemPath = $path . '/' . $item;
                $isDir = is_dir($itemPath);
                $icon = $isDir ? '📁' : '📄';
                $size = $isDir ? '' : ' (' . filesize($itemPath) . ' bytes)';
                echo "<li>$icon $item$size</li>";
            }
        }
        echo "</ul>";
    }
}

echo "<h2>🧪 Test de Carga de Archivos</h2>";

// Test 1: Intentar cargar Database.php
echo "<h3>Test 1: Cargar config/Database.php</h3>";
$dbPath = $baseDir . '/config/Database.php';
if (file_exists($dbPath)) {
    try {
        require_once $dbPath;
        if (class_exists('Database')) {
            echo "<p style='color: green;'>✅ Archivo cargado correctamente y clase Database existe</p>";
            
            // Intentar crear instancia
            try {
                $db = Database::getInstance();
                echo "<p style='color: green;'>✅ Instancia de Database creada correctamente</p>";
            } catch (Exception $e) {
                echo "<p style='color: red;'>❌ Error al crear instancia: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Archivo cargado pero clase Database NO existe</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Error al cargar: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ El archivo no existe en: $dbPath</p>";
}

// Test 2: Intentar cargar config.php
echo "<h3>Test 2: Cargar config/config.php</h3>";
$configPath = $baseDir . '/config/config.php';
if (file_exists($configPath)) {
    try {
        require_once $configPath;
        echo "<p style='color: green;'>✅ Archivo config.php cargado correctamente</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Error al cargar: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>❌ El archivo no existe en: $configPath</p>";
}

echo "<hr>";
echo "<h2>💡 Diagnóstico</h2>";
echo "<p>Si todos los archivos existen pero la clase Database no se encuentra:</p>";
echo "<ol>";
echo "<li>Verifica que el archivo Database.php contenga la clase Database</li>";
echo "<li>Verifica que no haya errores de sintaxis en Database.php</li>";
echo "<li>Verifica que el namespace esté correcto (no debería tener namespace)</li>";
echo "</ol>";
?>