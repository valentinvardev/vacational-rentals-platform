<?php
// Archivo de verificación DENTRO de /api/
header('Content-Type: text/plain; charset=UTF-8');

echo "=== VERIFICACIÓN DENTRO DE /api/ ===\n\n";
echo "Directorio actual: " . __DIR__ . "\n\n";

echo "Archivos en esta carpeta:\n";
$files = scandir(__DIR__);
foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;
    $path = __DIR__ . '/' . $file;
    $size = filesize($path);
    $type = is_dir($path) ? '[DIR]' : '[FILE]';
    $perms = substr(sprintf('%o', fileperms($path)), -4);
    echo "$type $file (" . number_format($size) . " bytes) [$perms]\n";
}

echo "\n=== CONTENIDO DE .htaccess ===\n";
if (file_exists(__DIR__ . '/.htaccess')) {
    echo file_get_contents(__DIR__ . '/.htaccess');
} else {
    echo ".htaccess NO EXISTE\n";
}

echo "\n=== FIN ===\n";
?>