<?php
// SCRIPT DE REPARACIÓN - fix.php
// Subir como /szystems/buro-v2/public/fix.php

echo "<h1>🔧 REPARACIÓN AUTOMÁTICA BURO</h1>";

// Cambiar al directorio raíz del proyecto
chdir('..');

echo "<h2>1. VERIFICANDO ESTRUCTURA:</h2>";
echo "Directorio actual: " . getcwd() . "<br>";
echo "Archivos en directorio:<br>";
$files = scandir('.');
foreach($files as $file) {
    if($file != '.' && $file != '..') {
        echo "- $file<br>";
    }
}

echo "<h2>2. VERIFICANDO .ENV:</h2>";
if(!file_exists('.env')) {
    if(file_exists('.env.produccion-ipage')) {
        copy('.env.produccion-ipage', '.env');
        echo "✅ .env creado desde .env.produccion-ipage<br>";
    } else {
        echo "❌ NO existe .env ni .env.produccion-ipage<br>";
    }
} else {
    echo "✅ .env existe<br>";
}

echo "<h2>3. VERIFICANDO PERMISOS:</h2>";
$dirs = ['storage', 'storage/logs', 'storage/framework', 'storage/framework/sessions', 'bootstrap/cache'];
foreach($dirs as $dir) {
    if(is_dir($dir)) {
        chmod($dir, 0755);
        echo "✅ Permisos actualizados: $dir<br>";
    } else {
        echo "❌ Directorio no existe: $dir<br>";
    }
}

echo "<h2>4. LIMPIANDO CACHE:</h2>";
try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    
    echo "Limpiando cache...<br>";
    $kernel->call('cache:clear');
    $kernel->call('config:clear');
    $kernel->call('route:clear');
    $kernel->call('view:clear');
    
    echo "Regenerando cache...<br>";
    $kernel->call('config:cache');
    
    echo "✅ Cache limpiado y regenerado<br>";
    
} catch(Exception $e) {
    echo "❌ Error en cache: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<p><strong>🚀 Reparación completada. Ahora prueba: <a href='../'>IR A LA APLICACIÓN</a></strong></p>";
?>
