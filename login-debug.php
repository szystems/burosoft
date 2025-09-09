<?php
// DIAGNÓSTICO LOGIN - login-debug.php
// Subir como /szystems/buro-v2/public/login-debug.php

echo "<h1>🔍 DIAGNÓSTICO LOGIN ERROR 500</h1>";

// Cambiar al directorio raíz
chdir('..');

echo "<h2>1. VERIFICANDO RUTA DE LOGIN:</h2>";

try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    
    // Test del kernel y routing
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "✅ HTTP Kernel OK<br>";
    
    // Verificar rutas
    $router = $app->make('router');
    $routes = $router->getRoutes();
    
    echo "<h3>Rutas relacionadas con login:</h3>";
    foreach($routes as $route) {
        $uri = $route->uri();
        $methods = implode(', ', $route->methods());
        if(strpos($uri, 'login') !== false || strpos($uri, 'auth') !== false) {
            echo "- <strong>$methods</strong> $uri → " . $route->getActionName() . "<br>";
        }
    }
    
} catch(Exception $e) {
    echo "❌ Error en routing: " . $e->getMessage() . "<br>";
}

echo "<h2>2. VERIFICANDO MIDDLEWARE CSRF:</h2>";
try {
    // Verificar CSRF token
    $session = $app->make('session');
    echo "✅ Session manager OK<br>";
    
    // Test CSRF
    $csrf = $app->make('Illuminate\Foundation\Http\Middleware\VerifyCsrfToken');
    echo "✅ CSRF Middleware existe<br>";
    
} catch(Exception $e) {
    echo "❌ Error en CSRF: " . $e->getMessage() . "<br>";
}

echo "<h2>3. VERIFICANDO BASE_URL EN ASSETS:</h2>";
$config = $app->make('config');
$appUrl = $config->get('app.url');
echo "APP_URL configurado: <strong>$appUrl</strong><br>";

// Verificar si hay asset() helpers con URL incorrecta
echo "<h3>URLs base esperadas:</h3>";
echo "- APP_URL: $appUrl<br>";
echo "- Base para assets: $appUrl<br>";
echo "- Base para AJAX: $appUrl<br>";

echo "<h2>4. SIMULANDO REQUEST LOGIN POST:</h2>";
try {
    // Crear request simulado
    $request = \Illuminate\Http\Request::create('/login', 'POST', [
        '_token' => 'test-token',
        'email' => 'test@test.com',
        'password' => 'test123'
    ]);
    
    echo "✅ Request POST simulado creado<br>";
    
    // Verificar que la ruta existe
    $route = $router->getRoutes()->match($request);
    echo "✅ Ruta POST /login encontrada: " . $route->getActionName() . "<br>";
    
} catch(Exception $e) {
    echo "❌ Error en ruta POST login: " . $e->getMessage() . "<br>";
}

echo "<h2>5. VERIFICANDO LOGS:</h2>";
$logFile = 'storage/logs/laravel.log';
if(file_exists($logFile)) {
    $logs = file_get_contents($logFile);
    $recentLogs = substr($logs, -2000); // Últimos 2000 caracteres
    echo "<pre style='background:#f0f0f0; padding:10px; max-height:300px; overflow:auto;'>";
    echo htmlspecialchars($recentLogs);
    echo "</pre>";
} else {
    echo "❌ No se encontró archivo de logs<br>";
}

echo "<hr>";
echo "<h2>🔧 PRÓXIMOS PASOS:</h2>";
echo "<ol>";
echo "<li>Verificar que APP_URL esté correcto en .env</li>";
echo "<li>Revisar si hay URLs hardcodeadas en JavaScript</li>";
echo "<li>Confirmar que CSRF token se genere correctamente</li>";
echo "<li>Verificar logs para error específico del login</li>";
echo "</ol>";
?>
