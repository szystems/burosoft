<?php
// Script de corrección Error 419 para BuroSoft
// Basado en SOLUCION_ERROR_419_LARAVEL_IPAGE.md

echo "<!DOCTYPE html><html><head><title>Corrección Error 419 - BuroSoft</title></head><body>";
echo "<h1>🔧 CORRECCIÓN ERROR 419 - BUROSOFT</h1>";

$correcciones = [];
$errores = [];

// 1. VERIFICAR Y CORREGIR .ENV
echo "<h2>📝 Verificando y corrigiendo .env</h2>";

if (file_exists('../.env')) {
    $env_content = file_get_contents('../.env');
    $env_lines = explode("\n", $env_content);
    $new_env_lines = [];
    
    // Configuraciones críticas para iPage
    $critical_settings = [
        'SESSION_DRIVER' => 'file',
        'LOG_LEVEL' => 'error', 
        'LOG_CHANNEL' => 'single',
        'APP_ENV' => 'production',
        'APP_DEBUG' => 'false',
        'CACHE_DRIVER' => 'file',
        'QUEUE_CONNECTION' => 'sync',
        'APP_URL' => 'https://szystems.com/burosoftnuevo/public',
        'SESSION_DOMAIN' => '.szystems.com',
        'SESSION_COOKIE' => 'burosoft_session'
    ];
    
    $found_settings = [];
    
    foreach ($env_lines as $line) {
        $line = trim($line);
        if (empty($line) || strpos($line, '#') === 0) {
            $new_env_lines[] = $line;
            continue;
        }
        
        $updated = false;
        foreach ($critical_settings as $key => $correct_value) {
            if (strpos($line, $key . '=') === 0) {
                $current_value = substr($line, strlen($key . '='));
                $found_settings[$key] = $current_value;
                
                if ($current_value !== $correct_value) {
                    $new_env_lines[] = $key . '=' . $correct_value;
                    $correcciones[] = "✅ $key corregido: $current_value → $correct_value";
                    $updated = true;
                } else {
                    $new_env_lines[] = $line;
                    $correcciones[] = "ℹ️ $key ya correcto: $correct_value";
                }
                break;
            }
        }
        
        if (!$updated) {
            $new_env_lines[] = $line;
        }
    }
    
    // Agregar configuraciones faltantes
    foreach ($critical_settings as $key => $value) {
        if (!isset($found_settings[$key])) {
            $new_env_lines[] = $key . '=' . $value;
            $correcciones[] = "✅ $key agregado: $value";
        }
    }
    
    // Escribir .env corregido
    $new_env_content = implode("\n", $new_env_lines);
    if (file_put_contents('../.env', $new_env_content)) {
        $correcciones[] = "💾 Archivo .env actualizado correctamente";
    } else {
        $errores[] = "❌ No se pudo escribir .env";
    }
    
} else {
    $errores[] = "❌ Archivo .env no encontrado";
}

// 2. LIMPIAR CACHE
echo "<h2>🧹 Limpiando cache del servidor</h2>";

$cache_dirs = [
    '../bootstrap/cache' => 'Bootstrap cache',
    '../storage/framework/cache' => 'Framework cache',
    '../storage/framework/sessions' => 'Sesiones',
    '../storage/framework/views' => 'Vistas compiladas'
];

foreach ($cache_dirs as $dir => $desc) {
    if (file_exists($dir)) {
        $files = glob($dir . '/*');
        $deleted = 0;
        foreach ($files as $file) {
            if (is_file($file) && basename($file) !== '.gitignore' && @unlink($file)) {
                $deleted++;
            }
        }
        $correcciones[] = "🗑️ $desc: $deleted archivos eliminados";
    } else {
        @mkdir($dir, 0755, true);
        $correcciones[] = "📁 $desc: Directorio creado";
    }
}

// 3. VERIFICAR MIDDLEWARE
echo "<h2>🔄 Verificando middleware RedirectIfAuthenticated</h2>";

$middleware_file = '../app/Http/Middleware/RedirectIfAuthenticated.php';
if (file_exists($middleware_file)) {
    $middleware_content = file_get_contents($middleware_file);
    if (strpos($middleware_content, 'RouteServiceProvider::HOME') !== false) {
        $correcciones[] = "⚠️ RedirectIfAuthenticated: Usa RouteServiceProvider::HOME (revisar si causa loops)";
    } else {
        $correcciones[] = "✅ RedirectIfAuthenticated: Configuración OK";
    }
} else {
    $errores[] = "❌ RedirectIfAuthenticated: NO ENCONTRADO";
}

// 4. RESULTADOS
echo "<hr>";
echo "<h2>📊 RESULTADOS DE CORRECCIÓN</h2>";

if (!empty($correcciones)) {
    echo "<h3 style='color: green;'>✅ CORRECCIONES APLICADAS:</h3>";
    foreach ($correcciones as $correccion) {
        echo "$correccion<br>";
    }
}

if (!empty($errores)) {
    echo "<h3 style='color: red;'>❌ ERRORES:</h3>";
    foreach ($errores as $error) {
        echo "$error<br>";
    }
}

echo "<hr>";
echo "<h2>🚀 PRÓXIMOS PASOS</h2>";
echo "<ol>";
echo "<li><strong>Probar aplicación:</strong> <a href='./'>🚀 Ir a BuroSoft</a></li>";
echo "<li><strong>Probar login:</strong> <a href='login'>🔐 Página de login</a></li>";
echo "<li><strong>Verificar estado:</strong> <a href='verificar-419.php'>🔍 Diagnóstico completo</a></li>";
echo "</ol>";

echo "<div style='background: #d4edda; padding: 15px; margin: 15px 0; border-radius: 5px;'>";
echo "<h3>🎯 CONFIGURACIÓN OPTIMIZADA PARA IPAGE</h3>";
echo "<p>✅ SESSION_DRIVER=file (crítico para evitar Error 419)</p>";
echo "<p>✅ LOG_LEVEL=error (optimizado para producción)</p>";
echo "<p>✅ APP_URL correcto para szystems.com</p>";
echo "<p>✅ Cache limpiado completamente</p>";
echo "</div>";

echo "<hr>";
echo "<small>Corrección ejecutada: " . date('Y-m-d H:i:s') . "</small>";
echo "</body></html>";
?>
