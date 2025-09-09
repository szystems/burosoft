<?php
// REPARACIÓN CRÍTICA - repair.php
// Subir como /szystems/buro-v2/public/repair.php

echo "<h1>🚀 REPARACIÓN CRÍTICA CONFIG CONTAINER</h1>";

// Cambiar al directorio raíz
chdir('..');

echo "<h2>1. LIMPIANDO CACHE COMPLETAMENTE:</h2>";

// Limpiar manualmente archivos de cache
$cacheFiles = [
    'bootstrap/cache/config.php',
    'bootstrap/cache/routes.php',
    'bootstrap/cache/services.php',
    'bootstrap/cache/packages.php'
];

foreach($cacheFiles as $file) {
    if(file_exists($file)) {
        unlink($file);
        echo "✅ Eliminado: $file<br>";
    } else {
        echo "ℹ️ No existe: $file<br>";
    }
}

// Limpiar storage/framework/cache
$storageCache = 'storage/framework/cache';
if(is_dir($storageCache)) {
    $files = glob($storageCache . '/*');
    foreach($files as $file) {
        if(is_file($file)) {
            unlink($file);
        }
    }
    echo "✅ Cache storage limpiado<br>";
}

echo "<h2>2. REGENERANDO AUTOLOAD:</h2>";
try {
    // Forzar regeneración de autoload
    require_once 'vendor/autoload.php';
    echo "✅ Autoload cargado<br>";
    
    // Test bootstrap básico
    $app = require_once 'bootstrap/app.php';
    echo "✅ App bootstrap OK<br>";
    
    // Verificar kernel
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    echo "✅ Kernel creado<br>";
    
    echo "<h3>Ejecutando comandos Artisan:</h3>";
    
    // Cache clear
    $kernel->call('config:clear');
    echo "✅ config:clear ejecutado<br>";
    
    $kernel->call('cache:clear');
    echo "✅ cache:clear ejecutado<br>";
    
    $kernel->call('route:clear');
    echo "✅ route:clear ejecutado<br>";
    
    $kernel->call('view:clear');
    echo "✅ view:clear ejecutado<br>";
    
    // Regenerar cache
    $kernel->call('config:cache');
    echo "✅ config:cache regenerado<br>";
    
} catch(Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "Stacktrace: " . $e->getTraceAsString() . "<br>";
}

echo "<h2>3. VERIFICANDO CONFIGURACIÓN:</h2>";
try {
    // Test config después de limpieza
    $config = $app->make('config');
    echo "✅ Config container funcionando<br>";
    
    $appEnv = $config->get('app.env');
    $appUrl = $config->get('app.url');
    $sessionDriver = $config->get('session.driver');
    
    echo "APP_ENV: $appEnv<br>";
    echo "APP_URL: $appUrl<br>";
    echo "SESSION_DRIVER: $sessionDriver<br>";
    
} catch(Exception $e) {
    echo "❌ Config aún con problemas: " . $e->getMessage() . "<br>";
}

echo "<h2>4. TEST FINAL:</h2>";
try {
    // Test ruteo básico
    $router = $app->make('router');
    echo "✅ Router funcionando<br>";
    
    // Test request
    $request = $app->make('request');
    echo "✅ Request funcionando<br>";
    
} catch(Exception $e) {
    echo "❌ Error en componentes: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h2>🚀 SIGUIENTE PASO:</h2>";
echo "<p><strong>Ahora prueba la aplicación:</strong></p>";
echo "<a href='../'>🔗 IR A LA APLICACIÓN PRINCIPAL</a><br>";
echo "<a href='../login'>🔑 IR AL LOGIN</a><br>";
echo "<br>";
echo "<p>Si aún hay errores, ejecutar también <a href='fix.php'>fix.php</a></p>";
?>
