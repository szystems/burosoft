<?php
// DIAGNÓSTICO INMEDIATO - BURO PROJECT
// Subir este archivo como diagnostico.php en /szystems/buro-v2/public/

echo "<h1>🔧 DIAGNÓSTICO BURO PROJECT</h1>";

// 1. VERIFICAR PHP
echo "<h2>1. PHP VERSION:</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server: " . $_SERVER['SERVER_SOFTWARE'] . "<br><br>";

// 2. VERIFICAR ARCHIVOS CRÍTICOS
echo "<h2>2. ARCHIVOS CRÍTICOS:</h2>";
$files = [
    '../.env' => 'Archivo .env',
    '../vendor/autoload.php' => 'Composer autoload',
    'index.php' => 'Index Laravel',
    '.htaccess' => 'Archivo .htaccess'
];

foreach($files as $file => $desc) {
    echo $desc . ": " . (file_exists($file) ? "✅ EXISTE" : "❌ NO EXISTE") . "<br>";
}
echo "<br>";

// 3. PERMISOS
echo "<h2>3. PERMISOS:</h2>";
$dirs = [
    '../storage' => 'Storage',
    '../storage/logs' => 'Logs',
    '../storage/framework' => 'Framework',
    '../storage/framework/sessions' => 'Sessions',
    '../bootstrap/cache' => 'Bootstrap Cache'
];

foreach($dirs as $dir => $name) {
    if(is_dir($dir)) {
        $perms = substr(sprintf('%o', fileperms($dir)), -4);
        echo "$name: ✅ EXISTE (Permisos: $perms)<br>";
    } else {
        echo "$name: ❌ NO EXISTE<br>";
    }
}
echo "<br>";

// 4. VERIFICAR .ENV
echo "<h2>4. CONTENIDO .ENV:</h2>";
if(file_exists('../.env')) {
    $env = file_get_contents('../.env');
    $lines = explode("\n", $env);
    foreach($lines as $line) {
        if(strpos($line, 'APP_') === 0 || strpos($line, 'DB_') === 0 || strpos($line, 'SESSION_') === 0) {
            // Ocultar passwords
            if(strpos($line, 'PASSWORD') !== false) {
                $line = preg_replace('/=.*/', '=***HIDDEN***', $line);
            }
            echo htmlspecialchars($line) . "<br>";
        }
    }
} else {
    echo "❌ ARCHIVO .ENV NO ENCONTRADO<br>";
}
echo "<br>";

// 5. TEST AUTOLOAD
echo "<h2>5. TEST COMPOSER AUTOLOAD:</h2>";
try {
    require_once '../vendor/autoload.php';
    echo "✅ Composer autoload funciona<br>";
    
    // Test Laravel bootstrap
    try {
        $app = require_once '../bootstrap/app.php';
        echo "✅ Laravel bootstrap funciona<br>";
        
        // Test config
        try {
            $config = $app->make('config');
            echo "✅ Config container funciona<br>";
            echo "APP_ENV: " . $config->get('app.env', 'NO_DEFINIDO') . "<br>";
            echo "APP_URL: " . $config->get('app.url', 'NO_DEFINIDO') . "<br>";
            echo "SESSION_DRIVER: " . $config->get('session.driver', 'NO_DEFINIDO') . "<br>";
        } catch(Exception $e) {
            echo "❌ Error en config: " . $e->getMessage() . "<br>";
        }
        
    } catch(Exception $e) {
        echo "❌ Error en Laravel bootstrap: " . $e->getMessage() . "<br>";
    }
    
} catch(Exception $e) {
    echo "❌ Error en autoload: " . $e->getMessage() . "<br>";
}
echo "<br>";

// 6. VERIFICAR .HTACCESS
echo "<h2>6. CONTENIDO .HTACCESS:</h2>";
if(file_exists('.htaccess')) {
    echo "<pre>" . htmlspecialchars(file_get_contents('.htaccess')) . "</pre>";
} else {
    echo "❌ ARCHIVO .HTACCESS NO ENCONTRADO<br>";
}

echo "<hr>";
echo "<p><strong>🔧 Ejecutar este diagnóstico y reportar resultados</strong></p>";
?>
