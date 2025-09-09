<?php
// Debug para servidor iPage
// Archivo: debug-server.php

echo "<h2>🔍 DIAGNÓSTICO SERVIDOR iPage</h2>";
echo "<hr>";

echo "<h3>📍 Información del Servidor:</h3>";
echo "<strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<strong>Script Filename:</strong> " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "<strong>Request URI:</strong> " . $_SERVER['REQUEST_URI'] . "<br>";
echo "<strong>HTTP Host:</strong> " . $_SERVER['HTTP_HOST'] . "<br>";
echo "<strong>Server Software:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";

echo "<h3>🔧 PHP y Extensiones:</h3>";
echo "<strong>PHP Version:</strong> " . phpversion() . "<br>";
echo "<strong>mod_rewrite:</strong> " . (function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules()) ? '✅ Activo' : '❌ No detectado') . "<br>";

echo "<h3>📁 Archivos Laravel:</h3>";
$laravel_files = [
    'index.php' => file_exists('index.php'),
    '.htaccess' => file_exists('.htaccess'),
    '../bootstrap/app.php' => file_exists('../bootstrap/app.php'),
    '../.env' => file_exists('../.env'),
];

foreach ($laravel_files as $file => $exists) {
    echo "<strong>$file:</strong> " . ($exists ? '✅ Existe' : '❌ No encontrado') . "<br>";
}

echo "<h3>🌐 Variables de Entorno:</h3>";
if (file_exists('../.env')) {
    echo "✅ Archivo .env encontrado<br>";
} else {
    echo "❌ Archivo .env NO encontrado - CRÍTICO<br>";
}

echo "<h3>🔄 Test de Rutas:</h3>";
echo "<a href='./'>✅ Inicio (./)</a><br>";
echo "<a href='index.php'>✅ index.php directo</a><br>";
echo "<a href='about'>🧪 Test ruta /about</a><br>";
echo "<a href='subscribe'>🧪 Test ruta /subscribe</a><br>";

echo "<h3>🚨 SOLUCIÓN APLICADA:</h3>";
echo "<strong>Problema:</strong> mod_rewrite NO disponible<br>";
echo "<strong>Solución:</strong> .htaccess minimalista + index.php mejorado<br>";
echo "<strong>Próximo paso:</strong> Reemplazar archivos en servidor<br>";

echo "<h3>📋 ARCHIVOS A ACTUALIZAR:</h3>";
echo "1. Renombrar .htaccess.ipage → .htaccess<br>";
echo "2. Renombrar index.php.ipage → index.php<br>";
echo "3. Probar rutas después del cambio<br>";

echo "<hr>";
echo "<small>Generado: " . date('Y-m-d H:i:s') . "</small>";
?>
