<?php
// CORRECCIÓN URLs - fix-urls.php
// Subir como /szystems/buro-v2/public/fix-urls.php

echo "<h1>🔧 CORRECCIÓN DE URLs BASE</h1>";

// Cambiar al directorio raíz
chdir('..');

echo "<h2>1. VERIFICANDO CONFIGURACIÓN APP_URL:</h2>";

try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $config = $app->make('config');
    
    $currentUrl = $config->get('app.url');
    echo "APP_URL actual: <strong>$currentUrl</strong><br>";
    
    // Verificar si está correcto
    $expectedUrl = 'https://szystems.com/buro-v2/public';
    if($currentUrl !== $expectedUrl) {
        echo "⚠️ APP_URL debería ser: <strong>$expectedUrl</strong><br>";
    } else {
        echo "✅ APP_URL está correcto<br>";
    }
    
} catch(Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<h2>2. VERIFICANDO .ENV:</h2>";
if(file_exists('.env')) {
    $envContent = file_get_contents('.env');
    
    // Buscar APP_URL
    if(preg_match('/APP_URL=(.+)/', $envContent, $matches)) {
        $envUrl = trim($matches[1]);
        echo "APP_URL en .env: <strong>$envUrl</strong><br>";
        
        // Verificar si necesita corrección
        if($envUrl === 'https://appburo.burotributario.com') {
            echo "⚠️ Usando subdomain, pero probando desde /buro-v2/public/<br>";
            echo "💡 Para pruebas usa: https://szystems.com/buro-v2/public<br>";
        }
    }
} else {
    echo "❌ Archivo .env no encontrado<br>";
}

echo "<h2>3. REGENERANDO CACHE CON URL CORRECTA:</h2>";
try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    // Limpiar cache
    $kernel->call('config:clear');
    $kernel->call('cache:clear');
    $kernel->call('route:clear');
    
    echo "✅ Cache limpiado<br>";
    
    // Regenerar cache
    $kernel->call('config:cache');
    
    echo "✅ Config cache regenerado<br>";
    
} catch(Exception $e) {
    echo "❌ Error en cache: " . $e->getMessage() . "<br>";
}

echo "<h2>4. CREANDO .ENV TEMPORAL PARA PRUEBAS:</h2>";

// Crear .env con URL correcta para pruebas
$envForTesting = 'APP_NAME="BuroTributario"
APP_ENV=production
APP_KEY=base64:75f2jpCWbFz+pUpV6TuFM9Mcc2ZhG3r8XjaPa8zv4ck=
APP_DEBUG=false
APP_URL=https://szystems.com/buro-v2/public

# LOGS OPTIMIZADOS PARA IPAGE (CRÍTICO)
LOG_CHANNEL=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# BASE DE DATOS
DB_CONNECTION=mysql
DB_HOST=szclinicascom.ipagemysql.com 
DB_PORT=3306
DB_DATABASE=dbburonuevo
DB_USERNAME=sz
DB_PASSWORD=SPP7007aaa@@@

# CONFIGURACIÓN CRÍTICA PARA IPAGE - EVITAR ERROR 419
BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync

# SESIONES EN ARCHIVO (CRÍTICO PARA IPAGE - NO DATABASE)
SESSION_DRIVER=file
SESSION_LIFETIME=480
SESSION_COOKIE=buro_session
SESSION_DOMAIN=.szystems.com
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
SESSION_ENCRYPT=false
SESSION_EXPIRE_ON_CLOSE=false
SESSION_COOKIE_HTTPONLY=true';

file_put_contents('.env.testing', $envForTesting);
echo "✅ Creado .env.testing con APP_URL para /buro-v2/public/<br>";

echo "<h2>5. INSTRUCCIONES:</h2>";
echo "<ol>";
echo "<li><strong>Para usar subdomain:</strong> Mantén .env actual</li>";
echo "<li><strong>Para usar /buro-v2/public/:</strong> Copia .env.testing como .env</li>";
echo "</ol>";

echo "<h3>Comando para cambiar a URL de prueba:</h3>";
echo "<code>cp .env.testing .env</code><br>";

echo "<hr>";
echo "<p><strong>Después de elegir, ejecutar repair.php de nuevo</strong></p>";
?>
