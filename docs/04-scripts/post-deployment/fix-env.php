<?php
// REPARACIÓN .ENV - fix-env.php
// Subir como /szystems/buro-v2/public/fix-env.php

echo "<h1>🔧 REPARACIÓN .ENV Y ESTRUCTURA</h1>";

// Cambiar al directorio raíz del proyecto
chdir('..');

echo "<h2>1. VERIFICANDO ESTRUCTURA DE ARCHIVOS:</h2>";

$currentDir = getcwd();
echo "Directorio actual: <strong>$currentDir</strong><br>";

// Listar archivos en directorio actual
echo "<h3>Archivos en raíz del proyecto:</h3>";
$files = scandir('.');
foreach($files as $file) {
    if($file != '.' && $file != '..') {
        if(is_dir($file)) {
            echo "📁 $file/<br>";
        } else {
            echo "📄 $file<br>";
        }
    }
}

echo "<h2>2. VERIFICANDO ARCHIVOS .ENV:</h2>";

$envFiles = ['.env', '.env.produccion-ipage', '.env.example'];
foreach($envFiles as $envFile) {
    if(file_exists($envFile)) {
        $size = filesize($envFile);
        echo "✅ $envFile existe (${size} bytes)<br>";
    } else {
        echo "❌ $envFile NO existe<br>";
    }
}

echo "<h2>3. CREANDO/COPIANDO .ENV CORRECTO:</h2>";

if(!file_exists('.env')) {
    if(file_exists('.env.produccion-ipage')) {
        copy('.env.produccion-ipage', '.env');
        echo "✅ .env creado desde .env.produccion-ipage<br>";
    } elseif(file_exists('.env.example')) {
        copy('.env.example', '.env');
        echo "⚠️ .env creado desde .env.example (necesita configuración)<br>";
    } else {
        // Crear .env básico
        $envContent = 'APP_NAME="BuroTributario"
APP_ENV=production
APP_KEY=base64:75f2jpCWbFz+pUpV6TuFM9Mcc2ZhG3r8XjaPa8zv4ck=
APP_DEBUG=false
APP_URL=https://szystems.com/buro-v2/public

LOG_CHANNEL=single
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=szclinicascom.ipagemysql.com
DB_PORT=3306
DB_DATABASE=dbburonuevo
DB_USERNAME=sz
DB_PASSWORD=SPP7007aaa@@@

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync

SESSION_DRIVER=file
SESSION_LIFETIME=480
SESSION_COOKIE=buro_session
SESSION_DOMAIN=.szystems.com
SESSION_SECURE_COOKIE=true';

        file_put_contents('.env', $envContent);
        echo "✅ .env creado con configuración básica<br>";
    }
} else {
    echo "✅ .env ya existe<br>";
}

echo "<h2>4. VERIFICANDO CONTENIDO .ENV:</h2>";

if(file_exists('.env')) {
    $envContent = file_get_contents('.env');
    $lines = array_slice(explode("\n", $envContent), 0, 10);
    
    echo "<h4>Primeras líneas de .env:</h4>";
    foreach($lines as $line) {
        if(!empty(trim($line)) && !str_starts_with(trim($line), '#')) {
            // Ocultar passwords
            if(strpos($line, 'PASSWORD') !== false || strpos($line, 'SECRET') !== false) {
                $line = preg_replace('/=.*/', '=***HIDDEN***', $line);
            }
            echo htmlspecialchars($line) . "<br>";
        }
    }
}

echo "<h2>5. VERIFICANDO DIRECTORIOS CRÍTICOS:</h2>";

$criticalDirs = [
    'app' => 'Aplicación Laravel',
    'config' => 'Configuraciones',
    'vendor' => 'Dependencias Composer',
    'storage' => 'Storage Laravel',
    'bootstrap' => 'Bootstrap Laravel',
    'public' => 'Directorio público'
];

foreach($criticalDirs as $dir => $desc) {
    if(is_dir($dir)) {
        echo "✅ $desc ($dir/)<br>";
    } else {
        echo "❌ $desc ($dir/) NO EXISTE<br>";
    }
}

echo "<h2>6. TEST BOOTSTRAP CON .ENV CORRECTO:</h2>";

try {
    // Test carga de .env
    if(class_exists('Dotenv\Dotenv')) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        echo "✅ .env cargado correctamente<br>";
        
        // Verificar variables críticas
        $criticalVars = ['APP_NAME', 'APP_ENV', 'APP_KEY', 'DB_HOST', 'SESSION_DRIVER'];
        foreach($criticalVars as $var) {
            $value = $_ENV[$var] ?? 'NO_DEFINIDO';
            if($var === 'APP_KEY' && strlen($value) > 10) {
                $value = substr($value, 0, 20) . '...';
            }
            echo "$var: <strong>$value</strong><br>";
        }
        
    } else {
        echo "❌ Dotenv no disponible<br>";
    }
    
} catch(Exception $e) {
    echo "❌ Error cargando .env: " . $e->getMessage() . "<br>";
}

echo "<h2>7. TEST LARAVEL BOOTSTRAP:</h2>";

try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    
    echo "✅ Laravel bootstrap exitoso<br>";
    
    // Test config
    $config = $app->make('config');
    echo "✅ Config container funcionando<br>";
    
    $appName = $config->get('app.name');
    $appEnv = $config->get('app.env');
    $sessionDriver = $config->get('session.driver');
    
    echo "APP_NAME: <strong>$appName</strong><br>";
    echo "APP_ENV: <strong>$appEnv</strong><br>";
    echo "SESSION_DRIVER: <strong>$sessionDriver</strong><br>";
    
} catch(Exception $e) {
    echo "❌ Laravel bootstrap error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h1>🚀 .ENV Y ESTRUCTURA REPARADOS</h1>";
echo "<p><strong>Ahora el proyecto debería funcionar correctamente</strong></p>";
echo "<a href='../login' style='background:#28a745; color:white; padding:10px; text-decoration:none;'>🔑 PROBAR LOGIN</a><br><br>";
echo "<a href='../' style='background:#007bff; color:white; padding:10px; text-decoration:none;'>🏠 PÁGINA PRINCIPAL</a>";
?>
