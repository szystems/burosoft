<?php
/**
 * Script de Optimización Temporal para Servidor
 * 
 * Subir este archivo a public/ y ejecutar vía navegador:
 * https://appburo.burotributario.com/optimize-server.php
 * 
 * ⚠️ IMPORTANTE: ELIMINAR ESTE ARCHIVO DESPUÉS DE USAR
 */

// Verificar que estamos en el directorio correcto
if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    die('Error: vendor/autoload.php no encontrado. Asegúrate de que este archivo está en el directorio public/');
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo '<!DOCTYPE html>
<html>
<head>
    <title>Optimización de Servidor</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
        .command { background: #f9f9f9; padding: 15px; margin: 10px 0; border-left: 4px solid #4CAF50; }
        .success { color: #4CAF50; font-weight: bold; }
        .warning { color: #ff9800; font-weight: bold; }
        .error { color: #f44336; font-weight: bold; }
        .info { color: #2196F3; }
        pre { background: #263238; color: #aed581; padding: 15px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Optimización de Laravel en Producción</h1>
        <p class="info">Ejecutando comandos de optimización...</p>
';

$commands = [
    'config:clear' => 'Limpiando caché de configuración',
    'cache:clear' => 'Limpiando caché de aplicación',
    'route:clear' => 'Limpiando caché de rutas',
    'view:clear' => 'Limpiando vistas compiladas',
    'event:clear' => 'Limpiando eventos cacheados',
    'config:cache' => 'Cacheando configuración',
    'route:cache' => 'Cacheando rutas',
    'view:cache' => 'Cacheando vistas',
    'event:cache' => 'Cacheando eventos',
    'optimize' => 'Optimizando aplicación',
];

foreach ($commands as $command => $description) {
    echo '<div class="command">';
    echo '<strong>' . htmlspecialchars($description) . '</strong><br>';
    
    try {
        $exitCode = $kernel->call($command);
        
        if ($exitCode === 0) {
            echo '<span class="success">✓ Completado exitosamente</span>';
        } else {
            echo '<span class="warning">⚠ Completado con código: ' . $exitCode . '</span>';
        }
        
        $output = $kernel->output();
        if (!empty($output)) {
            echo '<pre>' . htmlspecialchars($output) . '</pre>';
        }
    } catch (\Exception $e) {
        echo '<span class="error">✗ Error: ' . htmlspecialchars($e->getMessage()) . '</span>';
    }
    
    echo '</div>';
}

echo '
        <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border-left: 4px solid #ff9800; border-radius: 4px;">
            <h3 style="margin-top: 0;">⚠️ IMPORTANTE - SEGURIDAD</h3>
            <p><strong>DEBES ELIMINAR ESTE ARCHIVO INMEDIATAMENTE</strong></p>
            <p>Este archivo es solo para uso temporal. Elimínalo del servidor para evitar riesgos de seguridad:</p>
            <pre style="background: #263238; color: #f44336;">rm ' . __FILE__ . '</pre>
            <p>O elimínalo via FTP desde: <code>public/optimize-server.php</code></p>
        </div>
        
        <div style="margin-top: 20px; padding: 20px; background: #e8f5e9; border-left: 4px solid #4CAF50; border-radius: 4px;">
            <h3 style="margin-top: 0; color: #4CAF50;">✓ Optimización Completada</h3>
            <p>Verifica que tu aplicación funcione correctamente:</p>
            <ul>
                <li>Navega por diferentes secciones</li>
                <li>Prueba el login/logout</li>
                <li>Genera un PDF de prueba</li>
                <li>Verifica los logs en storage/logs/laravel.log</li>
            </ul>
        </div>
        
        <div style="margin-top: 20px; text-align: center; color: #666;">
            <p>Laravel ' . app()->version() . ' | PHP ' . PHP_VERSION . '</p>
        </div>
    </div>
</body>
</html>';

$kernel->terminate(
    Illuminate\Http\Request::capture(),
    new Illuminate\Http\Response()
);
