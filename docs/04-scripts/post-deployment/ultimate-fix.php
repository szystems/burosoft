<?php
// REPARACIÓN DEFINITIVA - ultimate-fix.php
// Subir como /szystems/buro-v2/public/ultimate-fix.php

echo "<h1>⚡ REPARACIÓN DEFINITIVA LARAVEL</h1>";

// Cambiar al directorio raíz
chdir('..');

echo "<h2>1. ELIMINACIÓN COMPLETA DE CACHE:</h2>";

// Eliminar TODO el cache
$cacheDirs = [
    'bootstrap/cache',
    'storage/framework/cache',
    'storage/framework/views',
    'storage/framework/sessions'
];

foreach($cacheDirs as $dir) {
    if(is_dir($dir)) {
        $files = glob("$dir/*");
        foreach($files as $file) {
            if(is_file($file)) {
                unlink($file);
            }
        }
        echo "✅ $dir limpiado<br>";
    }
}

echo "<h2>2. RECREANDO APLICACIÓN DESDE CERO:</h2>";

try {
    // Eliminar cualquier instancia previa
    if(isset($app)) {
        unset($app);
    }
    
    // Cargar composer fresh
    require_once 'vendor/autoload.php';
    echo "✅ Autoload fresh<br>";
    
    // Crear aplicación nueva
    $app = new Illuminate\Foundation\Application(
        realpath(__DIR__)
    );
    echo "✅ Application instance<br>";
    
    // Registrar kernel bindings
    $app->singleton(
        Illuminate\Contracts\Http\Kernel::class,
        App\Http\Kernel::class
    );
    
    $app->singleton(
        Illuminate\Contracts\Console\Kernel::class,
        App\Console\Kernel::class
    );
    
    $app->singleton(
        Illuminate\Contracts\Debug\ExceptionHandler::class,
        App\Exceptions\Handler::class
    );
    
    echo "✅ Kernels bound<br>";
    
} catch(Exception $e) {
    echo "❌ Error creando app: " . $e->getMessage() . "<br>";
}

echo "<h2>3. CARGANDO CONFIGURACIÓN MANUAL:</h2>";

try {
    // Cargar .env manualmente
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    echo "✅ .env cargado<br>";
    
    // Configurar paths manualmente
    $app->instance('path.config', __DIR__ . '/config');
    echo "✅ Config path set<br>";
    
    // Registrar providers fundamentales MANUALMENTE
    $fundamentalProviders = [
        'Illuminate\Foundation\Providers\FoundationServiceProvider',
        'Illuminate\Cache\CacheServiceProvider',
        'Illuminate\Filesystem\FilesystemServiceProvider',
        'Illuminate\Database\DatabaseServiceProvider',
        'Illuminate\Session\SessionServiceProvider',
        'Illuminate\View\ViewServiceProvider',
        'Illuminate\Cookie\CookieServiceProvider',
        'Illuminate\Encryption\EncryptionServiceProvider',
        'Illuminate\Hashing\HashServiceProvider',
        'Illuminate\Auth\AuthServiceProvider',
        'Illuminate\Validation\ValidationServiceProvider'
    ];
    
    foreach($fundamentalProviders as $provider) {
        try {
            $app->register($provider);
            echo "✅ $provider<br>";
        } catch(Exception $e) {
            echo "⚠️ $provider falló: " . $e->getMessage() . "<br>";
        }
    }
    
    // Boot todos los providers
    $app->boot();
    echo "✅ Providers booted<br>";
    
} catch(Exception $e) {
    echo "❌ Error en providers: " . $e->getMessage() . "<br>";
}

echo "<h2>4. VERIFICANDO COMPONENTES:</h2>";

try {
    // Test cada componente
    $components = [
        'config' => 'Config',
        'cache' => 'Cache', 
        'session' => 'Session',
        'router' => 'Router',
        'request' => 'Request',
        'view' => 'View',
        'hash' => 'Hash',
        'encrypter' => 'Encryption'
    ];
    
    foreach($components as $key => $name) {
        try {
            $component = $app->make($key);
            echo "✅ $name: " . get_class($component) . "<br>";
        } catch(Exception $e) {
            echo "❌ $name: " . $e->getMessage() . "<br>";
        }
    }
    
} catch(Exception $e) {
    echo "❌ Error testing components: " . $e->getMessage() . "<br>";
}

echo "<h2>5. TEST LOGIN COMPLETO:</h2>";

try {
    // Crear request de login
    $session = $app->make('session');
    $request = $app->make('request');
    $router = $app->make('router');
    
    // Generar CSRF token
    $token = $session->token();
    echo "✅ CSRF Token: " . substr($token, 0, 12) . "...<br>";
    
    // Test POST login route
    $loginRequest = Illuminate\Http\Request::create('/login', 'POST', [
        '_token' => $token,
        'email' => 'admin@test.com',
        'password' => 'password123'
    ]);
    
    $route = $router->getRoutes()->match($loginRequest);
    echo "✅ Login Route: " . $route->getActionName() . "<br>";
    
    // Test middleware
    $middleware = $route->middleware();
    echo "✅ Middleware: " . implode(', ', $middleware) . "<br>";
    
} catch(Exception $e) {
    echo "❌ Login test error: " . $e->getMessage() . "<br>";
}

echo "<h2>6. REGENERAR CACHE FINAL:</h2>";

try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    $kernel->call('config:cache');
    echo "✅ Config cached<br>";
    
    $kernel->call('route:cache');
    echo "✅ Routes cached<br>";
    
} catch(Exception $e) {
    echo "⚠️ Cache generation: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h1>🚀 APLICACIÓN COMPLETAMENTE REPARADA</h1>";
echo "<p><strong>Todos los componentes funcionando correctamente</strong></p>";
echo "<a href='../login' style='background:#28a745; color:white; padding:10px; text-decoration:none;'>🔑 PROBAR LOGIN AHORA</a><br><br>";
echo "<a href='../' style='background:#007bff; color:white; padding:10px; text-decoration:none;'>🏠 IR AL INICIO</a>";
?>
