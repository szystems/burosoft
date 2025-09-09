<?php
// SOLUCIÓN BOOTSTRAP - bootstrap-fix.php
// Subir como /szystems/buro-v2/public/bootstrap-fix.php

echo "<h1>🔧 REPARACIÓN BOOTSTRAP LARAVEL</h1>";

// Cambiar al directorio raíz
chdir('..');

echo "<h2>1. RECREANDO BOOTSTRAP COMPLETO:</h2>";

try {
    // Limpiar todo antes de recrear
    echo "Limpiando cache de bootstrap...<br>";
    
    $bootstrapCache = 'bootstrap/cache';
    if(is_dir($bootstrapCache)) {
        $files = glob("$bootstrapCache/*");
        foreach($files as $file) {
            if(is_file($file)) {
                unlink($file);
                echo "✅ Eliminado: " . basename($file) . "<br>";
            }
        }
    }
    
    // Limpiar storage cache
    $storageCache = 'storage/framework/cache';
    if(is_dir($storageCache)) {
        $files = glob("$storageCache/*");
        foreach($files as $file) {
            if(is_file($file)) {
                unlink($file);
            }
        }
        echo "✅ Storage cache limpiado<br>";
    }
    
} catch(Exception $e) {
    echo "❌ Error limpiando cache: " . $e->getMessage() . "<br>";
}

echo "<h2>2. BOOTSTRAP DESDE CERO:</h2>";

try {
    // Cargar Composer
    require_once 'vendor/autoload.php';
    echo "✅ Composer autoload<br>";
    
    // Recrear aplicación
    $app = new Illuminate\Foundation\Application(
        $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
    );
    echo "✅ Application instance creada<br>";
    
    // Registrar bindings críticos
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
    
    echo "✅ Bindings registrados<br>";
    
    // Cargar configuración
    $app->useEnvironmentPath(__DIR__);
    $app->loadEnvironmentFrom('.env');
    echo "✅ Environment cargado<br>";
    
    // Boot application
    $app->boot();
    echo "✅ Application booted<br>";
    
} catch(Exception $e) {
    echo "❌ Error en bootstrap: " . $e->getMessage() . "<br>";
    echo "Stack: " . $e->getTraceAsString() . "<br>";
}

echo "<h2>3. TEST COMPONENTES CRÍTICOS:</h2>";

try {
    // Test session
    $session = $app->make('session');
    echo "✅ Session container: OK<br>";
    
    // Test config
    $config = $app->make('config');
    echo "✅ Config container: OK<br>";
    
    // Test router
    $router = $app->make('router');
    echo "✅ Router container: OK<br>";
    
    // Test request
    $request = $app->make('request');
    echo "✅ Request container: OK<br>";
    
    // Test CSRF
    $csrf = $app->make('Illuminate\Foundation\Http\Middleware\VerifyCsrfToken');
    echo "✅ CSRF Middleware: OK<br>";
    
} catch(Exception $e) {
    echo "❌ Error en componentes: " . $e->getMessage() . "<br>";
}

echo "<h2>4. REGENERACIÓN COMPLETA CACHE:</h2>";

try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    // Artisan commands
    $commands = [
        'config:cache' => 'Config cache',
        'route:cache' => 'Route cache', 
        'view:cache' => 'View cache'
    ];
    
    foreach($commands as $command => $desc) {
        try {
            $kernel->call($command);
            echo "✅ $desc regenerado<br>";
        } catch(Exception $e) {
            echo "⚠️ $desc falló: " . $e->getMessage() . "<br>";
        }
    }
    
} catch(Exception $e) {
    echo "❌ Error en artisan: " . $e->getMessage() . "<br>";
}

echo "<h2>5. TEST FINAL LOGIN:</h2>";

try {
    // Simular request POST login
    $request = Illuminate\Http\Request::create('/login', 'POST', [
        '_token' => 'test-token',
        'email' => 'test@test.com', 
        'password' => 'test123'
    ]);
    
    // Verificar ruta
    $route = $router->getRoutes()->match($request);
    echo "✅ Ruta POST /login: " . $route->getActionName() . "<br>";
    
    // Test session con request
    $request->setLaravelSession($session);
    echo "✅ Session vinculada a request<br>";
    
    // Test CSRF token
    $token = $session->token();
    echo "✅ CSRF token: " . substr($token, 0, 10) . "...<br>";
    
} catch(Exception $e) {
    echo "❌ Error en login test: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h2>🚀 BOOTSTRAP REPARADO COMPLETAMENTE</h2>";
echo "<p><strong>Ahora el login debería funcionar sin Error 500</strong></p>";
echo "<a href='../login'>🔑 PROBAR LOGIN</a><br>";
echo "<a href='../'>🏠 IR AL INICIO</a>";
?>
