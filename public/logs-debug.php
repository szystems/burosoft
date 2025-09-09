<?php
// Script de diagnóstico completo para Error 500
// Archivo: logs-debug.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🚨 DIAGNÓSTICO ERROR 500 - BUROSOFT</h1>";
echo "<hr>";

// 1. INFORMACIÓN BÁSICA
echo "<h2>📍 Información del Servidor</h2>";
echo "<strong>PHP Version:</strong> " . phpversion() . "<br>";
echo "<strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>Script Path:</strong> " . __FILE__ . "<br>";
echo "<strong>Current Directory:</strong> " . getcwd() . "<br>";
echo "<strong>Date/Time:</strong> " . date('Y-m-d H:i:s') . "<br>";
echo "<hr>";

// 2. BUSCAR LOGS DE ERROR
echo "<h2>📄 BÚSQUEDA DE LOGS</h2>";

$possible_logs = [
    '/home/users/web/b2263/ipg.szclinicascom/szystems/burosoftnuevo/storage/logs/laravel.log',
    '../storage/logs/laravel.log',
    '../../storage/logs/laravel.log', 
    '/home/users/web/b2263/ipg.szclinicascom/szystems/error_log',
    '/home/users/web/b2263/ipg.szclinicascom/error_log',
    './error_log',
    '../error_log',
    '../../error_log',
    ini_get('error_log'),
    '/var/log/apache2/error.log'
];

foreach ($possible_logs as $log_path) {
    if ($log_path && file_exists($log_path) && is_readable($log_path)) {
        echo "<h3>✅ LOG ENCONTRADO: $log_path</h3>";
        echo "<div style='background:#f0f0f0; padding:10px; max-height:300px; overflow:auto; font-family:monospace; font-size:12px;'>";
        
        // Leer últimas líneas del log
        $lines = file($log_path);
        $last_lines = array_slice($lines, -50); // Últimas 50 líneas
        
        foreach ($last_lines as $line) {
            // Resaltar errores críticos
            if (stripos($line, 'fatal') !== false || stripos($line, 'error') !== false) {
                echo "<span style='color:red; font-weight:bold;'>" . htmlspecialchars($line) . "</span>";
            } else if (stripos($line, 'warning') !== false) {
                echo "<span style='color:orange;'>" . htmlspecialchars($line) . "</span>";
            } else {
                echo htmlspecialchars($line);
            }
        }
        echo "</div><br>";
    } else {
        echo "❌ No encontrado: $log_path<br>";
    }
}

// 3. TEST DE ARCHIVOS CRÍTICOS
echo "<hr>";
echo "<h2>📁 VERIFICACIÓN ARCHIVOS CRÍTICOS</h2>";

$critical_files = [
    '../.env' => 'Configuración de entorno',
    '../bootstrap/app.php' => 'Bootstrap Laravel',
    '../vendor/autoload.php' => 'Autoloader Composer',
    '../config/app.php' => 'Configuración de aplicación',
    '../storage/logs/' => 'Directorio de logs',
    '../storage/framework/cache/' => 'Cache framework',
    '../storage/framework/sessions/' => 'Sesiones',
    '../storage/framework/views/' => 'Vistas compiladas'
];

foreach ($critical_files as $file => $description) {
    $exists = file_exists($file);
    $readable = $exists ? is_readable($file) : false;
    $writable = $exists ? is_writable($file) : false;
    
    echo "<strong>$description ($file):</strong> ";
    if ($exists) {
        echo "✅ Existe ";
        echo $readable ? "✅ Legible " : "❌ No legible ";
        echo $writable ? "✅ Escribible" : "❌ No escribible";
    } else {
        echo "❌ NO EXISTE";
    }
    echo "<br>";
}

// 4. PERMISOS
echo "<hr>";
echo "<h2>🔐 VERIFICACIÓN PERMISOS</h2>";

$storage_path = '../storage';
if (file_exists($storage_path)) {
    echo "<strong>Storage permissions:</strong> " . substr(sprintf('%o', fileperms($storage_path)), -4) . "<br>";
}

// 5. TEST SIMPLE DE LARAVEL
echo "<hr>";
echo "<h2>🧪 TEST LARAVEL BÁSICO</h2>";

try {
    // Intentar cargar el autoloader
    if (file_exists('../vendor/autoload.php')) {
        require_once '../vendor/autoload.php';
        echo "✅ Autoloader cargado<br>";
        
        // Intentar cargar la app
        if (file_exists('../bootstrap/app.php')) {
            $app = require_once '../bootstrap/app.php';
            echo "✅ Bootstrap cargado<br>";
            
            // Test básico de configuración
            if (file_exists('../.env')) {
                echo "✅ Archivo .env presente<br>";
            } else {
                echo "❌ Archivo .env FALTANTE - ERROR CRÍTICO<br>";
            }
        } else {
            echo "❌ Bootstrap no encontrado<br>";
        }
    } else {
        echo "❌ Vendor/autoload.php no encontrado<br>";
    }
} catch (Exception $e) {
    echo "<span style='color:red;'><strong>❌ ERROR AL CARGAR LARAVEL:</strong><br>";
    echo "Mensaje: " . $e->getMessage() . "<br>";
    echo "Archivo: " . $e->getFile() . "<br>";
    echo "Línea: " . $e->getLine() . "<br>";
    echo "</span>";
}

echo "<hr>";
echo "<h2>📝 PRÓXIMOS PASOS</h2>";
echo "1. Revisar los logs mostrados arriba<br>";
echo "2. Verificar permisos en /storage<br>";
echo "3. Confirmar que .env existe y es válido<br>";
echo "4. Verificar que todas las dependencias estén instaladas<br>";

echo "<hr>";
echo "<small>Diagnóstico generado: " . date('Y-m-d H:i:s') . "</small>";
?>
