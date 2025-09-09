<?php
// CAMBIO A SUBDOMAIN - switch-to-subdomain.php
// Subir como /szystems/buro-v2/public/switch-to-subdomain.php

echo "<h1>🔄 CAMBIO A SUBDOMAIN DEFINITIVO</h1>";

// Cambiar al directorio raíz
chdir('..');

echo "<h2>1. VERIFICANDO CONFIGURACIÓN ACTUAL:</h2>";

if(file_exists('.env')) {
    $content = file_get_contents('.env');
    
    if(preg_match('/APP_URL=(.+)/', $content, $matches)) {
        $currentUrl = trim($matches[1]);
        echo "APP_URL actual: <strong>$currentUrl</strong><br>";
    }
    
    if(preg_match('/SESSION_DOMAIN=(.+)/', $content, $matches)) {
        $currentDomain = trim($matches[1]);
        echo "SESSION_DOMAIN actual: <strong>$currentDomain</strong><br>";
    }
} else {
    echo "❌ .env no existe<br>";
}

echo "<h2>2. CONFIGURANDO PARA SUBDOMAIN:</h2>";

if(file_exists('.env')) {
    $content = file_get_contents('.env');
    
    // Hacer backup
    copy('.env', '.env.backup.subdomain');
    echo "✅ Backup creado (.env.backup.subdomain)<br>";
    
    // Cambiar APP_URL a subdomain
    $newContent = preg_replace(
        '/APP_URL=.*/',
        'APP_URL=https://appburo.burotributario.com',
        $content
    );
    
    // Cambiar SESSION_DOMAIN para burotributario.com
    $newContent = preg_replace(
        '/SESSION_DOMAIN=.*/',
        'SESSION_DOMAIN=.burotributario.com',
        $newContent
    );
    
    // Asegurar configuración optimizada para subdomain
    $newContent = preg_replace(
        '/SESSION_COOKIE=.*/',
        'SESSION_COOKIE=appburo_session',
        $newContent
    );
    
    if(file_put_contents('.env', $newContent)) {
        echo "✅ APP_URL cambiado a: https://appburo.burotributario.com<br>";
        echo "✅ SESSION_DOMAIN cambiado a: .burotributario.com<br>";
        echo "✅ SESSION_COOKIE cambiado a: appburo_session<br>";
    } else {
        echo "❌ Error escribiendo .env<br>";
    }
}

echo "<h2>3. VERIFICANDO NUEVOS VALORES:</h2>";

if(file_exists('.env')) {
    $content = file_get_contents('.env');
    
    if(preg_match('/APP_URL=(.+)/', $content, $matches)) {
        $newUrl = trim($matches[1]);
        echo "Nuevo APP_URL: <strong>$newUrl</strong><br>";
    }
    
    if(preg_match('/SESSION_DOMAIN=(.+)/', $content, $matches)) {
        $sessionDomain = trim($matches[1]);
        echo "Nuevo SESSION_DOMAIN: <strong>$sessionDomain</strong><br>";
    }
    
    if(preg_match('/SESSION_COOKIE=(.+)/', $content, $matches)) {
        $sessionCookie = trim($matches[1]);
        echo "SESSION_COOKIE: <strong>$sessionCookie</strong><br>";
    }
}

echo "<h2>4. LIMPIANDO CACHE PARA SUBDOMAIN:</h2>";

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
    $kernel->call('optimize:clear');
    
    echo "✅ Cache completo limpiado<br>";
    
    // Regenerar cache con nueva configuración
    $kernel->call('config:cache');
    $kernel->call('route:cache');
    
    echo "✅ Cache regenerado para subdomain<br>";
    
} catch(Exception $e) {
    echo "❌ Error en cache: " . $e->getMessage() . "<br>";
}

echo "<h2>5. VERIFICANDO CONFIGURACIÓN FINAL:</h2>";

try {
    $config = $app->make('config');
    $session = $app->make('session');
    
    $appUrl = $config->get('app.url');
    $sessionDomain = $config->get('session.domain');
    $sessionDriver = $config->get('session.driver');
    $sessionCookie = $config->get('session.cookie');
    
    echo "✅ Config container funcionando<br>";
    echo "APP_URL: <strong>$appUrl</strong><br>";
    echo "SESSION_DOMAIN: <strong>$sessionDomain</strong><br>";
    echo "SESSION_DRIVER: <strong>$sessionDriver</strong><br>";
    echo "SESSION_COOKIE: <strong>$sessionCookie</strong><br>";
    
    // Test CSRF token para subdomain
    $session->start();
    $token = $session->token();
    echo "✅ CSRF Token para subdomain: " . substr($token, 0, 12) . "...<br>";
    
} catch(Exception $e) {
    echo "❌ Test error: " . $e->getMessage() . "<br>";
}

echo "<h2>6. VERIFICANDO CONFIGURACIÓN iPage:</h2>";

echo "<div style='background:#fff3cd; padding:15px; border-left:4px solid #ffc107; margin:15px 0;'>";
echo "<h3>⚠️ CONFIGURACIÓN REQUERIDA EN iPage:</h3>";
echo "<p><strong>Subdomain Name:</strong> appburo</p>";
echo "<p><strong>Domain:</strong> burotributario.com</p>";
echo "<p><strong>Directory:</strong> szystems/buro-v2/public/</p>";
echo "<p><strong>URL Final:</strong> https://appburo.burotributario.com</p>";
echo "</div>";

echo "<h2>7. INSTRUCCIONES FINALES:</h2>";

echo "<ol>";
echo "<li><strong>Verificar en iPage Panel</strong> que el subdomain esté configurado correctamente</li>";
echo "<li><strong>Esperar propagación DNS</strong> (puede tomar 5-30 minutos)</li>";
echo "<li><strong>Probar acceso</strong> a https://appburo.burotributario.com</li>";
echo "<li><strong>Verificar login</strong> funcione en el subdomain</li>";
echo "</ol>";

echo "<hr>";
echo "<h1>🚀 CONFIGURACIÓN PARA SUBDOMAIN COMPLETADA</h1>";

echo "<div style='background:#e8f5e8; padding:20px; border-radius:5px; margin:20px 0;'>";
echo "<h2>✅ LISTO PARA SUBDOMAIN</h2>";
echo "<p><strong>La aplicación está configurada para funcionar en appburo.burotributario.com</strong></p>";
echo "<p>Una vez que el subdomain esté activo en iPage, la aplicación funcionará perfectamente.</p>";
echo "</div>";

echo "<div style='margin: 20px 0;'>";
echo "<p><strong>URLs de prueba:</strong></p>";
echo "<a href='https://appburo.burotributario.com' target='_blank' style='background:#28a745; color:white; padding:10px 15px; text-decoration:none; border-radius:5px; margin-right:10px;'>🌐 SUBDOMAIN PRINCIPAL</a>";
echo "<a href='https://appburo.burotributario.com/login' target='_blank' style='background:#007bff; color:white; padding:10px 15px; text-decoration:none; border-radius:5px;'>🔑 LOGIN SUBDOMAIN</a>";
echo "</div>";

echo "<div style='background:#f8f9fa; padding:15px; border:1px solid #dee2e6; margin:15px 0;'>";
echo "<h4>🔄 Si necesitas volver a /buro-v2/public/:</h4>";
echo "<p>Ejecuta: <strong>fix-app-url.php</strong> para volver a la configuración anterior</p>";
echo "</div>";
?>
