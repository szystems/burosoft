<?php
// Verificación específica para Error 419 - BuroSoft
// Basado en SOLUCION_ERROR_419_LARAVEL_IPAGE.md

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!DOCTYPE html><html><head><title>Verificación Error 419 - BuroSoft</title></head><body>";
echo "<h1>🔧 Verificación Error 419 - BuroSoft</h1>";

// 1. Test SessionServiceProvider
echo "<h2>📍 Test SessionServiceProvider</h2>";
try {
    if (file_exists('../vendor/autoload.php')) {
        require_once '../vendor/autoload.php';
        echo "✅ Autoload cargado<br>";
        
        if (class_exists('Illuminate\\Session\\SessionServiceProvider')) {
            echo "✅ SessionServiceProvider: DISPONIBLE<br>";
        } else {
            echo "❌ SessionServiceProvider: FALTANTE - PROBLEMA IDENTIFICADO<br>";
        }
        
        if (class_exists('Illuminate\\Foundation\\Application')) {
            echo "✅ Laravel Foundation: DISPONIBLE<br>";
        } else {
            echo "❌ Laravel Foundation: FALTANTE<br>";
        }
        
    } else {
        echo "❌ vendor/autoload.php: FALTA - CRÍTICO<br>";
    }
} catch (Exception $e) {
    echo "❌ Error cargando: " . htmlspecialchars($e->getMessage()) . "<br>";
}

// 2. Verificar versión Laravel
echo "<h2>📋 Versión Laravel</h2>";
try {
    if (file_exists('../bootstrap/app.php')) {
        $app = require_once '../bootstrap/app.php';
        echo "✅ Bootstrap cargado<br>";
        
        if (defined('LARAVEL_VERSION')) {
            echo "✅ Laravel Version: " . LARAVEL_VERSION . "<br>";
        } else {
            echo "⚠️ Laravel Version: No definida<br>";
        }
    }
} catch (Exception $e) {
    echo "❌ Error bootstrap: " . htmlspecialchars($e->getMessage()) . "<br>";
}

// 3. Verificar configuración .env crítica
echo "<h2>⚙️ Configuración .env</h2>";
if (file_exists('../.env')) {
    $env_content = file_get_contents('../.env');
    
    // Variables críticas para Error 419
    $critical_vars = [
        'APP_KEY' => 'Clave de aplicación',
        'SESSION_DRIVER' => 'Driver de sesiones',
        'SESSION_LIFETIME' => 'Tiempo de vida sesión',
        'APP_ENV' => 'Entorno aplicación'
    ];
    
    foreach ($critical_vars as $var => $desc) {
        if (preg_match("/^$var=(.*)$/m", $env_content, $matches)) {
            $value = trim($matches[1]);
            if ($var === 'SESSION_DRIVER') {
                if ($value === 'file') {
                    echo "✅ $desc ($var): $value (CORRECTO para iPage)<br>";
                } else {
                    echo "⚠️ $desc ($var): $value (Recomendado: file para iPage)<br>";
                }
            } else {
                echo "✅ $desc ($var): " . (strlen($value) > 20 ? substr($value, 0, 20) . '...' : $value) . "<br>";
            }
        } else {
            echo "❌ $desc ($var): NO ENCONTRADO<br>";
        }
    }
} else {
    echo "❌ Archivo .env: NO ENCONTRADO<br>";
}

// 4. Verificar directorios de sesiones
echo "<h2>📁 Directorios de Sesiones</h2>";
$session_dirs = [
    '../storage/framework/sessions' => 'Directorio sesiones',
    '../storage/framework/cache' => 'Directorio cache',
    '../storage/logs' => 'Directorio logs'
];

foreach ($session_dirs as $dir => $desc) {
    if (file_exists($dir)) {
        $perms = substr(sprintf('%o', fileperms($dir)), -4);
        $writable = is_writable($dir);
        echo "✅ $desc: Existe, permisos $perms " . ($writable ? '(Escribible)' : '(No escribible)') . "<br>";
    } else {
        echo "❌ $desc: NO EXISTE<br>";
    }
}

// 5. Test de middleware problemático
echo "<h2>🔄 Verificar Middleware</h2>";
$middleware_file = '../app/Http/Middleware/RedirectIfAuthenticated.php';
if (file_exists($middleware_file)) {
    $middleware_content = file_get_contents($middleware_file);
    if (strpos($middleware_content, 'RouteServiceProvider::HOME') !== false) {
        echo "⚠️ RedirectIfAuthenticated: Usa RouteServiceProvider::HOME (puede causar loops)<br>";
        echo "💡 RECOMENDACIÓN: Simplificar a redirect('/')<br>";
    } else {
        echo "✅ RedirectIfAuthenticated: Configuración OK<br>";
    }
} else {
    echo "❌ RedirectIfAuthenticated: NO ENCONTRADO<br>";
}

echo "<hr>";
echo "<h2>🎯 RECOMENDACIONES</h2>";
echo "<p>Si hay errores arriba, aplicar las correcciones de SOLUCION_ERROR_419_LARAVEL_IPAGE.md</p>";
echo "<p><a href='./'>🚀 Probar aplicación</a> | <a href='limpiar-cache-servidor.php'>🧹 Limpiar Cache</a></p>";

echo "</body></html>";
?>
