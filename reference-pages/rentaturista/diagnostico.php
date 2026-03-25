<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Debug Completo - RentaTurista API</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #1e1e1e; color: #d4d4d4; }
        .section { background: #2d2d2d; padding: 15px; margin: 10px 0; border-left: 4px solid #FF6B35; }
        .success { color: #10B981; }
        .error { color: #EF4444; }
        .warning { color: #F59E0B; }
        pre { background: #1a1a1a; padding: 10px; overflow-x: auto; }
        button { background: #FF6B35; color: white; border: none; padding: 10px 20px; margin: 5px; cursor: pointer; }
        #result { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>🔍 Debug Completo - RentaTurista API</h1>

    <div class="section">
        <h2>Paso 1: Verificar Archivos</h2>
        <?php
        $apiDir = __DIR__ . '/api';
        echo "<p><strong>Directorio API:</strong> $apiDir</p>";
        
        if (!is_dir($apiDir)) {
            echo "<p class='error'>❌ La carpeta /api/ NO EXISTE</p>";
        } else {
            echo "<p class='success'>✅ La carpeta /api/ existe</p>";
            
            echo "<h3>Archivos en /api/:</h3>";
            $files = scandir($apiDir);
            echo "<ul>";
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $path = $apiDir . '/' . $file;
                $size = number_format(filesize($path));
                $color = is_dir($path) ? 'warning' : 'success';
                echo "<li class='$color'>$file ($size bytes)</li>";
            }
            echo "</ul>";
            
            // Verificar archivos críticos
            $criticalFiles = [
                '.htaccess' => $apiDir . '/.htaccess',
                'index.php' => $apiDir . '/index.php',
                'PropertyController.php' => $apiDir . '/PropertyController.php',
            ];
            
            echo "<h3>Archivos Críticos:</h3>";
            foreach ($criticalFiles as $name => $path) {
                if (file_exists($path)) {
                    echo "<p class='success'>✅ $name existe (" . filesize($path) . " bytes)</p>";
                } else {
                    echo "<p class='error'>❌ $name NO EXISTE</p>";
                }
            }
        }
        ?>
    </div>

    <div class="section">
        <h2>Paso 2: Verificar Database.php y config.php</h2>
        <?php
        $configDir = __DIR__ . '/config';
        $dbFile = $configDir . '/Database.php';
        $configFile = $configDir . '/config.php';
        
        if (file_exists($dbFile)) {
            echo "<p class='success'>✅ Database.php existe</p>";
        } else {
            echo "<p class='error'>❌ Database.php NO EXISTE en $dbFile</p>";
        }
        
        if (file_exists($configFile)) {
            echo "<p class='success'>✅ config.php existe</p>";
        } else {
            echo "<p class='error'>❌ config.php NO EXISTE en $configFile</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>Paso 3: Probar Includes</h2>
        <?php
        try {
            require_once $dbFile;
            echo "<p class='success'>✅ Database.php se incluyó correctamente</p>";
        } catch (Exception $e) {
            echo "<p class='error'>❌ Error al incluir Database.php: " . $e->getMessage() . "</p>";
        }
        
        try {
            require_once $configFile;
            echo "<p class='success'>✅ config.php se incluyó correctamente</p>";
        } catch (Exception $e) {
            echo "<p class='error'>❌ Error al incluir config.php: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>Paso 4: Probar Conexión a Base de Datos</h2>
        <?php
        try {
            $db = Database::getInstance()->getConnection();
            echo "<p class='success'>✅ Conexión a base de datos exitosa</p>";
            
            // Probar consulta simple
            $stmt = $db->query("SELECT COUNT(*) as total FROM properties");
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<p class='success'>✅ Hay {$result['total']} propiedades en la base de datos</p>";
            
        } catch (Exception $e) {
            echo "<p class='error'>❌ Error de base de datos: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>

    <div class="section">
        <h2>Paso 5: Probar API con JavaScript</h2>
        <button onclick="testAPI()">Probar GET /api/</button>
        <button onclick="testProperties()">Probar GET /api/properties</button>
        <button onclick="testDirectIndexPHP()">Probar /api/index.php directo</button>
        <button onclick="testWithRoute()">Probar /api/index.php?route=properties</button>
        <div id="result"></div>
    </div>

    <div class="section">
        <h2>Paso 6: Información del Sistema</h2>
        <ul>
            <li><strong>PHP Version:</strong> <?php echo PHP_VERSION; ?></li>
            <li><strong>Server Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'N/A'; ?></li>
            <li><strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'N/A'; ?></li>
            <li><strong>Script Filename:</strong> <?php echo __FILE__; ?></li>
            <li><strong>mod_rewrite:</strong> 
                <?php 
                if (function_exists('apache_get_modules')) {
                    echo in_array('mod_rewrite', apache_get_modules()) ? 
                        "<span class='success'>✅ Habilitado</span>" : 
                        "<span class='error'>❌ Deshabilitado</span>";
                } else {
                    echo "<span class='warning'>⚠️ No se puede verificar (no es Apache o no hay acceso)</span>";
                }
                ?>
            </li>
        </ul>
    </div>

    <script>
        async function testAPI() {
            const result = document.getElementById('result');
            result.innerHTML = '<p>⏳ Probando...</p>';
            
            try {
                const response = await fetch('./api/');
                const contentType = response.headers.get('content-type');
                const text = await response.text();
                
                result.innerHTML = `
                    <h3>Resultado de GET /api/</h3>
                    <p><strong>Status:</strong> ${response.status} ${response.statusText}</p>
                    <p><strong>Content-Type:</strong> ${contentType}</p>
                    <p><strong>Es JSON:</strong> ${contentType && contentType.includes('application/json') ? '✅ SÍ' : '❌ NO'}</p>
                    <pre>${text.substring(0, 1000)}</pre>
                `;
            } catch (error) {
                result.innerHTML = `<p class="error">❌ Error: ${error.message}</p>`;
            }
        }

        async function testProperties() {
            const result = document.getElementById('result');
            result.innerHTML = '<p>⏳ Probando...</p>';
            
            try {
                const response = await fetch('./api/properties');
                const contentType = response.headers.get('content-type');
                const text = await response.text();
                
                result.innerHTML = `
                    <h3>Resultado de GET /api/properties</h3>
                    <p><strong>Status:</strong> ${response.status} ${response.statusText}</p>
                    <p><strong>Content-Type:</strong> ${contentType}</p>
                    <p><strong>Es JSON:</strong> ${contentType && contentType.includes('application/json') ? '✅ SÍ' : '❌ NO'}</p>
                    <pre>${text.substring(0, 1000)}</pre>
                `;
            } catch (error) {
                result.innerHTML = `<p class="error">❌ Error: ${error.message}</p>`;
            }
        }

        async function testDirectIndexPHP() {
            const result = document.getElementById('result');
            result.innerHTML = '<p>⏳ Probando...</p>';
            
            try {
                const response = await fetch('./api/index.php');
                const contentType = response.headers.get('content-type');
                const text = await response.text();
                
                result.innerHTML = `
                    <h3>Resultado de GET /api/index.php</h3>
                    <p><strong>Status:</strong> ${response.status} ${response.statusText}</p>
                    <p><strong>Content-Type:</strong> ${contentType}</p>
                    <p><strong>Es JSON:</strong> ${contentType && contentType.includes('application/json') ? '✅ SÍ' : '❌ NO'}</p>
                    <pre>${text.substring(0, 1000)}</pre>
                `;
            } catch (error) {
                result.innerHTML = `<p class="error">❌ Error: ${error.message}</p>`;
            }
        }

        async function testWithRoute() {
            const result = document.getElementById('result');
            result.innerHTML = '<p>⏳ Probando...</p>';
            
            try {
                const response = await fetch('./api/index.php?route=properties');
                const contentType = response.headers.get('content-type');
                const text = await response.text();
                
                result.innerHTML = `
                    <h3>Resultado de GET /api/index.php?route=properties</h3>
                    <p><strong>Status:</strong> ${response.status} ${response.statusText}</p>
                    <p><strong>Content-Type:</strong> ${contentType}</p>
                    <p><strong>Es JSON:</strong> ${contentType && contentType.includes('application/json') ? '✅ SÍ' : '❌ NO'}</p>
                    <pre>${text.substring(0, 1000)}</pre>
                `;
            } catch (error) {
                result.innerHTML = `<p class="error">❌ Error: ${error.message}</p>`;
            }
        }
    </script>
</body>
</html>