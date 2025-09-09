<?php
// CORRECCIÓN APP_URL - fix-app-url.php
// Subir como /szystems/buro-v2/public/fix-app-url.php

echo "<h1>🔧 CORRECCIÓN APP_URL</h1>";

// Cambiar al directorio raíz
chdir('..');

echo "<h2>1. VERIFICANDO APP_URL ACTUAL:</h2>";

if(file_exists('.env')) {
    $content = file_get_contents('.env');
    
    if(preg_match('/APP_URL=(.+)/', $content, $matches)) {
        $currentUrl = trim($matches[1]);
        echo "APP_URL actual: <strong>$currentUrl</strong><br>";
        
        $correctUrl = 'https://szystems.com/buro-v2/public';
        
        if($currentUrl === $correctUrl) {
            echo "✅ APP_URL está correcto<br>";
        } else {
            echo "❌ APP_URL incorrecto. Debe ser: <strong>$correctUrl</strong><br>";
        }
    } else {
        echo "❌ APP_URL no encontrado en .env<br>";
    }
} else {
    echo "❌ .env no existe<br>";
}

echo "<h2>2. CORRIGIENDO APP_URL:</h2>";

if(file_exists('.env')) {
    $content = file_get_contents('.env');
    
    // Hacer backup
    copy('.env', '.env.backup.url');
    echo "✅ Backup creado (.env.backup.url)<br>";
    
    // Corregir APP_URL
    $newContent = preg_replace(
        '/APP_URL=.*/',
        'APP_URL=https://szystems.com/buro-v2/public',
        $content
    );
    
    // También corregir SESSION_DOMAIN
    $newContent = preg_replace(
        '/SESSION_DOMAIN=.*/',
        'SESSION_DOMAIN=.szystems.com',
        $newContent
    );
    
    if(file_put_contents('.env', $newContent)) {
        echo "✅ APP_URL corregido<br>";
        echo "✅ SESSION_DOMAIN corregido<br>";
    } else {
        echo "❌ Error escribiendo .env<br>";
    }
}

echo "<h2>3. VERIFICANDO CAMBIOS:</h2>";

if(file_exists('.env')) {
    $content = file_get_contents('.env');
    
    if(preg_match('/APP_URL=(.+)/', $content, $matches)) {
        $newUrl = trim($matches[1]);
        echo "Nuevo APP_URL: <strong>$newUrl</strong><br>";
    }
    
    if(preg_match('/SESSION_DOMAIN=(.+)/', $content, $matches)) {
        $sessionDomain = trim($matches[1]);
        echo "SESSION_DOMAIN: <strong>$sessionDomain</strong><br>";
    }
}

echo "<h2>4. LIMPIANDO CACHE CON NUEVA CONFIGURACIÓN:</h2>";

try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    
    echo "✅ Laravel bootstrap OK<br>";
    
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    // Limpiar todo el cache
    $kernel->call('config:clear');
    $kernel->call('cache:clear');
    $kernel->call('route:clear');
    $kernel->call('view:clear');
    
    echo "✅ Cache limpiado<br>";
    
    // Regenerar cache con nueva configuración
    $kernel->call('config:cache');
    
    echo "✅ Config cache regenerado<br>";
    
} catch(Exception $e) {
    echo "❌ Error en cache: " . $e->getMessage() . "<br>";
}

echo "<h2>5. TEST FINAL CONFIGURACIÓN:</h2>";

try {
    $config = $app->make('config');
    $session = $app->make('session');
    
    $appUrl = $config->get('app.url');
    $sessionDomain = $config->get('session.domain');
    $sessionDriver = $config->get('session.driver');
    
    echo "✅ Config container funcionando<br>";
    echo "APP_URL: <strong>$appUrl</strong><br>";
    echo "SESSION_DOMAIN: <strong>$sessionDomain</strong><br>";
    echo "SESSION_DRIVER: <strong>$sessionDriver</strong><br>";
    
    // Test CSRF token
    $session->start();
    $token = $session->token();
    echo "✅ CSRF Token: " . substr($token, 0, 12) . "...<br>";
    
} catch(Exception $e) {
    echo "❌ Test error: " . $e->getMessage() . "<br>";
}

echo "<h2>6. TEST RUTA LOGIN:</h2>";

try {
    $router = $app->make('router');
    
    // Test ruta GET login
    $getRequest = Illuminate\Http\Request::create('/login', 'GET');
    $getRoute = $router->getRoutes()->match($getRequest);
    echo "✅ GET /login: " . $getRoute->getActionName() . "<br>";
    
    // Test ruta POST login
    $postRequest = Illuminate\Http\Request::create('/login', 'POST', [
        '_token' => $session->token(),
        'email' => 'test@test.com',
        'password' => 'test123'
    ]);
    
    $postRoute = $router->getRoutes()->match($postRequest);
    echo "✅ POST /login: " . $postRoute->getActionName() . "<br>";
    
} catch(Exception $e) {
    echo "❌ Route test error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h1>🚀 APP_URL CORREGIDO - LOGIN LISTO</h1>";

echo "<div style='background:#e8f5e8; padding:20px; border-radius:5px; margin:20px 0;'>";
echo "<h2>✅ CORRECCIÓN COMPLETADA</h2>";
echo "<p><strong>APP_URL y SESSION_DOMAIN han sido corregidos para funcionar con la URL actual.</strong></p>";
echo "<p>El Error 500 en login debería estar resuelto.</p>";
echo "</div>";

echo "<div style='margin: 20px 0;'>";
echo "<a href='../login' style='background:#28a745; color:white; padding:15px 25px; text-decoration:none; border-radius:5px; margin-right:10px;'>🔑 PROBAR LOGIN AHORA</a>";
echo "<a href='../' style='background:#007bff; color:white; padding:15px 25px; text-decoration:none; border-radius:5px;'>🏠 PÁGINA PRINCIPAL</a>";
echo "</div>";

echo "<p><em>Si aún hay problemas, revisar logs en storage/logs/laravel.log</em></p>";
?>
