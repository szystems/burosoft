<?php
// REPARACIÓN CRÍTICA SESIONES - fix-session.php
// Subir como /szystems/buro-v2/public/fix-session.php

echo "<h1>🚨 REPARACIÓN CRÍTICA: SESSION CONTAINER</h1>";

// Cambiar al directorio raíz
chdir('..');

echo "<h2>1. DIAGNÓSTICO SESSION PROBLEM:</h2>";

try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    
    echo "✅ App bootstrap OK<br>";
    
    // Verificar providers
    echo "<h3>Verificando Service Providers:</h3>";
    
    $providers = $app->getLoadedProviders();
    $sessionProvider = 'Illuminate\Session\SessionServiceProvider';
    
    if(isset($providers[$sessionProvider])) {
        echo "✅ SessionServiceProvider está cargado<br>";
    } else {
        echo "❌ SessionServiceProvider NO está cargado<br>";
    }
    
    // Listar providers cargados
    echo "<h4>Providers críticos:</h4>";
    $criticalProviders = [
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\View\ViewServiceProvider', 
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider'
    ];
    
    foreach($criticalProviders as $provider) {
        $status = isset($providers[$provider]) ? "✅" : "❌";
        echo "$status $provider<br>";
    }
    
} catch(Exception $e) {
    echo "❌ Error en providers: " . $e->getMessage() . "<br>";
}

echo "<h2>2. VERIFICANDO CONFIG/APP.PHP:</h2>";

if(file_exists('config/app.php')) {
    $configContent = file_get_contents('config/app.php');
    
    // Buscar SessionServiceProvider
    if(strpos($configContent, 'SessionServiceProvider') !== false) {
        echo "✅ SessionServiceProvider está en config/app.php<br>";
    } else {
        echo "❌ SessionServiceProvider NO está en config/app.php<br>";
    }
    
    // Verificar si está comentado
    if(strpos($configContent, '// Illuminate\Session\SessionServiceProvider') !== false) {
        echo "⚠️ SessionServiceProvider está COMENTADO<br>";
    }
    
} else {
    echo "❌ config/app.php no encontrado<br>";
}

echo "<h2>3. FORZANDO REGISTRO DE PROVIDERS:</h2>";

try {
    // Forzar registro manual de providers críticos
    $app->register('Illuminate\Session\SessionServiceProvider');
    echo "✅ SessionServiceProvider registrado manualmente<br>";
    
    $app->register('Illuminate\View\ViewServiceProvider');
    echo "✅ ViewServiceProvider registrado<br>";
    
    $app->register('Illuminate\Cookie\CookieServiceProvider');
    echo "✅ CookieServiceProvider registrado<br>";
    
    // Boot providers
    $app->boot();
    echo "✅ Providers booted<br>";
    
} catch(Exception $e) {
    echo "❌ Error registrando providers: " . $e->getMessage() . "<br>";
}

echo "<h2>4. TEST SESSION DESPUÉS DE REGISTRO:</h2>";

try {
    // Test session después del registro manual
    $session = $app->make('session');
    echo "✅ Session container funcionando<br>";
    
    $csrf = $app->make('Illuminate\Foundation\Http\Middleware\VerifyCsrfToken');
    echo "✅ CSRF Middleware funcionando<br>";
    
    // Test session driver
    $sessionDriver = $session->getDefaultDriver();
    echo "Session Driver: <strong>$sessionDriver</strong><br>";
    
} catch(Exception $e) {
    echo "❌ Session aún con problemas: " . $e->getMessage() . "<br>";
}

echo "<h2>5. LIMPIEZA COMPLETA Y REGENERACIÓN:</h2>";

try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    // Limpieza profunda
    echo "Ejecutando limpieza completa...<br>";
    
    $kernel->call('config:clear');
    $kernel->call('cache:clear');
    $kernel->call('route:clear');
    $kernel->call('view:clear');
    $kernel->call('optimize:clear');
    
    echo "✅ Limpieza completa realizada<br>";
    
    // Regenerar todo
    $kernel->call('config:cache');
    $kernel->call('route:cache');
    
    echo "✅ Cache regenerado completamente<br>";
    
} catch(Exception $e) {
    echo "❌ Error en cache: " . $e->getMessage() . "<br>";
}

echo "<h2>6. VERIFICACIÓN FINAL:</h2>";

try {
    // Test final completo
    $session = $app->make('session');
    $request = $app->make('request');
    $router = $app->make('router');
    
    echo "✅ Session: OK<br>";
    echo "✅ Request: OK<br>";
    echo "✅ Router: OK<br>";
    
    // Test CSRF token generation
    $token = $session->token();
    echo "✅ CSRF Token generado: " . substr($token, 0, 10) . "...<br>";
    
} catch(Exception $e) {
    echo "❌ Test final falló: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h2>🚀 APLICACIÓN REPARADA</h2>";
echo "<p><strong>Ahora prueba el login:</strong></p>";
echo "<a href='../login'>🔑 IR AL LOGIN</a><br>";
echo "<a href='../'>🏠 IR AL INICIO</a><br>";
echo "<br>";
echo "<p><em>Si aún hay problemas, el issue está en config/app.php</em></p>";
?>
