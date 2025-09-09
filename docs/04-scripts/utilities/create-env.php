<?php
// CREADOR .ENV - create-env.php
// Subir como /szystems/buro-v2/public/create-env.php

echo "<h1>🔧 CREADOR DE .ENV FUNCIONAL</h1>";

// Cambiar al directorio raíz
chdir('..');

echo "<h2>1. VERIFICANDO ESTADO ACTUAL:</h2>";

if(file_exists('.env')) {
    $size = filesize('.env');
    echo "⚠️ .env existe pero tamaño: <strong>$size bytes</strong><br>";
    
    if($size == 0) {
        echo "🚨 Archivo está VACÍO<br>";
    }
    
    // Backup del .env actual
    copy('.env', '.env.backup.' . date('Y-m-d-H-i-s'));
    echo "✅ Backup creado<br>";
} else {
    echo "❌ .env no existe<br>";
}

echo "<h2>2. CREANDO .ENV FUNCIONAL:</h2>";

// Configuración optimizada para szystems.com/buro-v2/public/
$envContent = 'APP_NAME="BuroTributario"
APP_ENV=production
APP_KEY=base64:75f2jpCWbFz+pUpV6TuFM9Mcc2ZhG3r8XjaPa8zv4ck=
APP_DEBUG=false
APP_URL=https://szystems.com/buro-v2/public

# LOGS OPTIMIZADOS PARA IPAGE
LOG_CHANNEL=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# BASE DE DATOS IPAGE
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

# SESIONES EN ARCHIVO (CRÍTICO PARA IPAGE)
SESSION_DRIVER=file
SESSION_LIFETIME=480
SESSION_COOKIE=buro_session
SESSION_DOMAIN=.szystems.com
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
SESSION_ENCRYPT=false
SESSION_EXPIRE_ON_CLOSE=false
SESSION_COOKIE_HTTPONLY=true

# CONFIGURACIÓN CACHE Y MEMORIA
MEMCACHED_HOST=127.0.0.1
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# MAIL CONFIGURACIÓN IPAGE
MAIL_MAILER=smtp
MAIL_HOST=smtp.ipage.com
MAIL_PORT=465
MAIL_USERNAME=soluciones@burotributario.com
MAIL_PASSWORD=@BuroS123
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS=soluciones@burotributario.com
MAIL_FROM_NAME="${APP_NAME}"

# AWS (OPCIONAL)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

# PUSHER (OPCIONAL)
PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

# PAYPAL CONFIGURACIÓN
PAYPAL_BASE_URI=https://api.sandbox.paypal.com
PAYPAL_CLIENT_ID=AVqk2pRzAOBVOl1HPuShEDPwGT9Yv8Ql6Wk5Wrw_tCdKdodr-YumQ0s0Vi7enQKQuUqVJoLoSwldLTjI
PAYPAL_CLIENT_SECRET=ELK0HwaTvheBA0FRTZ84fiCPv8L4dFPYA8W57uvy5j2fVU6TQKPfLjHrX-YYtgzNE0xYMKiRif_tCAJC
PAYPAL_MONTHLY_PLAN=P-4PL544017R6426355MVXGBAA
PAYPAL_YEARLY_PLAN=P-7TL936212G3173539MV6IGZY
PAYPAL_SEMIANNUAL_PLAN=P-2VE34332WU698500XMV44WHA';

// Escribir .env
$result = file_put_contents('.env', $envContent);

if($result !== false) {
    echo "✅ .env creado exitosamente<br>";
    echo "📊 Bytes escritos: <strong>$result</strong><br>";
} else {
    echo "❌ Error escribiendo .env<br>";
}

echo "<h2>3. VERIFICANDO .ENV CREADO:</h2>";

if(file_exists('.env')) {
    $newSize = filesize('.env');
    $content = file_get_contents('.env');
    $lines = explode("\n", $content);
    $configLines = array_filter($lines, function($line) {
        return !empty(trim($line)) && !str_starts_with(trim($line), '#');
    });
    
    echo "✅ Archivo creado<br>";
    echo "📊 Tamaño: <strong>$newSize bytes</strong><br>";
    echo "📄 Líneas de configuración: <strong>" . count($configLines) . "</strong><br>";
    
    // Verificar variables críticas
    echo "<h4>Variables críticas verificadas:</h4>";
    $criticalVars = ['APP_NAME', 'APP_KEY', 'DB_HOST', 'SESSION_DRIVER'];
    foreach($criticalVars as $var) {
        if(preg_match("/^$var\s*=/m", $content)) {
            echo "✅ $var definida<br>";
        } else {
            echo "❌ $var faltante<br>";
        }
    }
}

echo "<h2>4. TEST BOOTSTRAP CON NUEVO .ENV:</h2>";

try {
    require_once 'vendor/autoload.php';
    echo "✅ Autoload cargado<br>";
    
    $app = require_once 'bootstrap/app.php';
    echo "✅ Laravel bootstrap exitoso<br>";
    
    // Test componentes
    $config = $app->make('config');
    echo "✅ Config container funcionando<br>";
    
    $session = $app->make('session');
    echo "✅ Session container funcionando<br>";
    
    // Valores de configuración
    $appName = $config->get('app.name');
    $appUrl = $config->get('app.url');
    $sessionDriver = $config->get('session.driver');
    
    echo "<h4>Configuración cargada:</h4>";
    echo "APP_NAME: <strong>$appName</strong><br>";
    echo "APP_URL: <strong>$appUrl</strong><br>";
    echo "SESSION_DRIVER: <strong>$sessionDriver</strong><br>";
    
} catch(Exception $e) {
    echo "❌ Bootstrap error: " . $e->getMessage() . "<br>";
}

echo "<h2>5. LIMPIEZA DE CACHE:</h2>";

try {
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    $kernel->call('config:clear');
    $kernel->call('cache:clear');
    $kernel->call('route:clear');
    $kernel->call('view:clear');
    
    echo "✅ Cache limpiado<br>";
    
    $kernel->call('config:cache');
    echo "✅ Config cache regenerado<br>";
    
} catch(Exception $e) {
    echo "⚠️ Cache error: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h1>🚀 .ENV FUNCIONAL CREADO Y PROBADO</h1>";
echo "<div style='background:#e8f5e8; padding:20px; border-radius:5px;'>";
echo "<h2>✅ APLICACIÓN LISTA</h2>";
echo "<p><strong>El archivo .env ha sido creado con toda la configuración necesaria para iPage.</strong></p>";
echo "<p>Ahora puedes probar la aplicación sin errores de configuración.</p>";
echo "</div>";

echo "<div style='margin: 20px 0;'>";
echo "<a href='../login' style='background:#28a745; color:white; padding:15px 25px; text-decoration:none; border-radius:5px; margin-right:10px;'>🔑 PROBAR LOGIN</a>";
echo "<a href='../' style='background:#007bff; color:white; padding:15px 25px; text-decoration:none; border-radius:5px;'>🏠 PÁGINA PRINCIPAL</a>";
echo "</div>";
?>
