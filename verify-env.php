<?php
// VERIFICACIÓN FINAL .ENV - verify-env.php
// Subir como /szystems/buro-v2/public/verify-env.php

echo "<h1>🔍 VERIFICACIÓN FINAL .ENV</h1>";

// Cambiar al directorio raíz
chdir('..');

echo "<h2>1. CONTENIDO COMPLETO .ENV:</h2>";

if(file_exists('.env')) {
    $envContent = file_get_contents('.env');
    $lines = explode("\n", $envContent);
    
    echo "<h3>Variables de .env:</h3>";
    foreach($lines as $lineNum => $line) {
        $line = trim($line);
        if(!empty($line) && !str_starts_with($line, '#')) {
            // Ocultar datos sensibles
            if(strpos($line, 'PASSWORD') !== false || strpos($line, 'SECRET') !== false || strpos($line, 'KEY') !== false) {
                $parts = explode('=', $line, 2);
                if(count($parts) == 2) {
                    $line = $parts[0] . '=***HIDDEN***';
                }
            }
            echo ($lineNum + 1) . ". " . htmlspecialchars($line) . "<br>";
        }
    }
} else {
    echo "❌ .env no encontrado<br>";
}

echo "<h2>2. TEST BOOTSTRAP LARAVEL:</h2>";

try {
    require_once 'vendor/autoload.php';
    echo "✅ Autoload OK<br>";
    
    $app = require_once 'bootstrap/app.php';
    echo "✅ App bootstrap OK<br>";
    
    // Test componentes críticos
    $components = [
        'config' => 'Configuración',
        'session' => 'Sesiones', 
        'cache' => 'Cache',
        'router' => 'Router',
        'request' => 'Request'
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
    echo "❌ Bootstrap error: " . $e->getMessage() . "<br>";
}

echo "<h2>3. VERIFICAR CONFIGURACIÓN ESPECÍFICA:</h2>";

try {
    $config = $app->make('config');
    
    $settings = [
        'app.name' => 'Nombre App',
        'app.env' => 'Ambiente',
        'app.debug' => 'Debug',
        'app.url' => 'URL App',
        'session.driver' => 'Driver Sesión',
        'session.domain' => 'Dominio Sesión',
        'database.default' => 'DB Default',
        'cache.default' => 'Cache Default'
    ];
    
    foreach($settings as $key => $desc) {
        $value = $config->get($key);
        if(is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }
        echo "$desc: <strong>$value</strong><br>";
    }
    
} catch(Exception $e) {
    echo "❌ Config error: " . $e->getMessage() . "<br>";
}

echo "<h2>4. TEST RUTAS DE LOGIN:</h2>";

try {
    $router = $app->make('router');
    $routes = $router->getRoutes();
    
    echo "<h4>Rutas de autenticación:</h4>";
    foreach($routes as $route) {
        $uri = $route->uri();
        $methods = implode(', ', $route->methods());
        
        if(strpos($uri, 'login') !== false || strpos($uri, 'auth') !== false || strpos($uri, 'logout') !== false) {
            echo "- <strong>$methods</strong> /$uri → " . $route->getActionName() . "<br>";
        }
    }
    
} catch(Exception $e) {
    echo "❌ Routes error: " . $e->getMessage() . "<br>";
}

echo "<h2>5. TEST CSRF TOKEN:</h2>";

try {
    $session = $app->make('session');
    
    // Iniciar sesión
    $session->start();
    echo "✅ Sesión iniciada<br>";
    
    // Generar token CSRF
    $token = $session->token();
    echo "✅ CSRF Token generado: " . substr($token, 0, 16) . "...<br>";
    
    // Verificar regeneración
    $session->regenerateToken();
    $newToken = $session->token();
    echo "✅ Token regenerado: " . substr($newToken, 0, 16) . "...<br>";
    
} catch(Exception $e) {
    echo "❌ CSRF error: " . $e->getMessage() . "<br>";
}

echo "<h2>6. LIMPIEZA Y CACHE FINAL:</h2>";

try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    // Comandos de limpieza
    $commands = [
        'config:clear' => 'Config Clear',
        'cache:clear' => 'Cache Clear',
        'route:clear' => 'Route Clear',
        'view:clear' => 'View Clear'
    ];
    
    foreach($commands as $command => $desc) {
        try {
            $kernel->call($command);
            echo "✅ $desc ejecutado<br>";
        } catch(Exception $e) {
            echo "⚠️ $desc: " . $e->getMessage() . "<br>";
        }
    }
    
    // Regenerar cache
    $kernel->call('config:cache');
    echo "✅ Config cache regenerado<br>";
    
} catch(Exception $e) {
    echo "❌ Artisan error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h1>🚀 VERIFICACIÓN COMPLETA FINALIZADA</h1>";
echo "<p><strong>La aplicación debería estar completamente funcional</strong></p>";

echo "<div style='margin: 20px 0;'>";
echo "<a href='../login' style='background:#28a745; color:white; padding:15px 25px; text-decoration:none; border-radius:5px; margin-right:10px;'>🔑 PROBAR LOGIN</a>";
echo "<a href='../' style='background:#007bff; color:white; padding:15px 25px; text-decoration:none; border-radius:5px;'>🏠 PÁGINA PRINCIPAL</a>";
echo "</div>";

echo "<p><em>Si aún hay errores después de esta verificación, revisar logs en storage/logs/</em></p>";
?>
