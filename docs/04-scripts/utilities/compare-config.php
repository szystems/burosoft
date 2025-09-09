<?php
// Comparación de configuraciones entre proyectos
// Archivo: compare-config.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 COMPARACIÓN CONFIGURACIÓN - BUROSOFTNUEVO vs ASONATANUEVO</h1>";
echo "<hr>";

// 1. Información del entorno actual
echo "<h2>📍 Entorno Actual (burosoftnuevo)</h2>";
echo "<strong>PHP Version:</strong> " . phpversion() . "<br>";
echo "<strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>Script Path:</strong> " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "<strong>Working Directory:</strong> " . getcwd() . "<br>";

// 2. Comparar extensiones PHP
echo "<h2>🔧 Extensiones PHP</h2>";
$extensions = ['ctype', 'json', 'mbstring', 'openssl', 'pdo', 'tokenizer', 'xml'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    echo "<strong>$ext:</strong> " . ($loaded ? '✅ Cargada' : '❌ NO cargada') . "<br>";
}

// 3. Verificar archivos críticos de BuroSoft
echo "<h2>📁 Archivos BuroSoft</h2>";
$critical_files = [
    '../.env' => 'Variables de entorno',
    '../bootstrap/app.php' => 'Bootstrap Laravel',
    '../vendor/autoload.php' => 'Autoloader',
    '../config/app.php' => 'Config aplicación',
    '.htaccess' => 'Rewrite rules',
    'index.php' => 'Entry point'
];

foreach ($critical_files as $file => $desc) {
    if (file_exists($file)) {
        $size = filesize($file);
        $perms = substr(sprintf('%o', fileperms($file)), -4);
        echo "✅ <strong>$desc:</strong> $file (${size} bytes, permisos: $perms)<br>";
    } else {
        echo "❌ <strong>$desc:</strong> $file NO ENCONTRADO<br>";
    }
}

// 4. Test de carga de dependencias
echo "<h2>🧪 Test de Dependencias</h2>";

try {
    if (file_exists('../vendor/autoload.php')) {
        echo "🔄 Intentando cargar autoloader...<br>";
        require_once '../vendor/autoload.php';
        echo "✅ Autoloader cargado exitosamente<br>";
        
        if (file_exists('../bootstrap/app.php')) {
            echo "🔄 Intentando cargar Laravel app...<br>";
            $app = require_once '../bootstrap/app.php';
            echo "✅ Laravel app cargada exitosamente<br>";
        }
    }
} catch (Error $e) {
    echo "❌ <strong>ERROR FATAL:</strong> " . $e->getMessage() . "<br>";
    echo "<strong>Archivo:</strong> " . $e->getFile() . " línea " . $e->getLine() . "<br>";
} catch (Exception $e) {
    echo "❌ <strong>EXCEPCIÓN:</strong> " . $e->getMessage() . "<br>";
    echo "<strong>Archivo:</strong> " . $e->getFile() . " línea " . $e->getLine() . "<br>";
}

// 5. Verificar .env
echo "<h2>⚙️ Configuración .env</h2>";
if (file_exists('../.env')) {
    $env_content = file_get_contents('../.env');
    $env_lines = explode("\n", $env_content);
    $important_vars = ['APP_NAME', 'APP_ENV', 'APP_KEY', 'APP_DEBUG', 'APP_URL', 'DB_CONNECTION'];
    
    foreach ($important_vars as $var) {
        $found = false;
        foreach ($env_lines as $line) {
            if (strpos($line, $var . '=') === 0) {
                echo "✅ <strong>$var:</strong> " . substr($line, 0, 50) . "...<br>";
                $found = true;
                break;
            }
        }
        if (!$found) {
            echo "❌ <strong>$var:</strong> NO ENCONTRADO<br>";
        }
    }
} else {
    echo "❌ Archivo .env NO ENCONTRADO<br>";
}

// 6. Test de permisos en storage
echo "<h2>🔐 Permisos Storage</h2>";
$storage_paths = ['../storage/logs', '../storage/framework/cache', '../storage/framework/sessions', '../storage/framework/views'];
foreach ($storage_paths as $path) {
    if (file_exists($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        $writable = is_writable($path);
        echo "<strong>$path:</strong> Permisos $perms " . ($writable ? '✅ Escribible' : '❌ No escribible') . "<br>";
    } else {
        echo "❌ <strong>$path:</strong> NO EXISTE<br>";
    }
}

echo "<hr>";
echo "<h2>🎯 COMPARAR CON ASONATANUEVO</h2>";
echo "<p>Si este diagnóstico funciona, compara con la estructura de asonatanuevo para encontrar diferencias.</p>";
echo "<p><strong>Próximo paso:</strong> Revisar configuraciones específicas que diffieren entre proyectos.</p>";

echo "<hr>";
echo "<small>Diagnóstico generado: " . date('Y-m-d H:i:s') . "</small>";
?>
