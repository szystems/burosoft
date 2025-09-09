<?php
// Script de verificación de seguridad
// Archivo: security-check.php

echo "<h1>🛡️ VERIFICACIÓN DE SEGURIDAD</h1>";
echo "<hr>";

// 1. Verificar accesos recientes
echo "<h2>👥 Información de Acceso Actual</h2>";
echo "<strong>Tu IP:</strong> " . $_SERVER['REMOTE_ADDR'] . "<br>";
echo "<strong>User Agent:</strong> " . $_SERVER['HTTP_USER_AGENT'] . "<br>";
echo "<strong>Referrer:</strong> " . ($_SERVER['HTTP_REFERER'] ?? 'Directo') . "<br>";
echo "<strong>Hora:</strong> " . date('Y-m-d H:i:s') . "<br>";

// 2. Verificar archivos sospechosos
echo "<h2>🔍 Archivos Sospechosos en Public</h2>";
$suspicious_patterns = ['shell', 'backdoor', 'hack', 'exploit', 'payload', 'c99', 'r57', 'wso'];
$public_files = glob('./*');

foreach ($public_files as $file) {
    $filename = basename($file);
    $is_suspicious = false;
    
    foreach ($suspicious_patterns as $pattern) {
        if (stripos($filename, $pattern) !== false) {
            $is_suspicious = true;
            break;
        }
    }
    
    if ($is_suspicious) {
        echo "🚨 SOSPECHOSO: $filename<br>";
    }
}

// 3. Verificar archivos PHP modificados recientemente
echo "<h2>📅 Archivos PHP Modificados Recientemente</h2>";
$php_files = glob('./*.php');
foreach ($php_files as $file) {
    $mod_time = filemtime($file);
    $hours_ago = (time() - $mod_time) / 3600;
    
    if ($hours_ago < 24) { // Modificados en últimas 24 horas
        echo "<strong>" . basename($file) . ":</strong> " . date('Y-m-d H:i:s', $mod_time) . " (" . round($hours_ago, 1) . " horas atrás)<br>";
    }
}

// 4. Verificar permisos inusuales
echo "<h2>🔐 Permisos de Archivos</h2>";
foreach ($php_files as $file) {
    $perms = substr(sprintf('%o', fileperms($file)), -4);
    if ($perms == '0777' || $perms == '0666') {
        echo "⚠️ PERMISOS PELIGROSOS: " . basename($file) . " ($perms)<br>";
    }
}

// 5. Verificar .htaccess
echo "<h2>⚙️ Verificar .htaccess</h2>";
if (file_exists('.htaccess')) {
    $htaccess_content = file_get_contents('.htaccess');
    $suspicious_htaccess = ['eval', 'base64_decode', 'gzinflate', 'FilesMatch', 'auto_prepend_file'];
    
    foreach ($suspicious_htaccess as $pattern) {
        if (stripos($htaccess_content, $pattern) !== false) {
            echo "🚨 CONTENIDO SOSPECHOSO en .htaccess: $pattern<br>";
        }
    }
    echo "✅ .htaccess verificado<br>";
} else {
    echo "❌ .htaccess no encontrado<br>";
}

echo "<hr>";
echo "<h2>🎯 RECOMENDACIONES INMEDIATAS</h2>";
echo "<ol>";
echo "<li><strong>Cambiar credenciales de iPage INMEDIATAMENTE</strong></li>";
echo "<li><strong>Escanear todos los archivos</strong> en busca de código malicioso</li>";
echo "<li><strong>Contactar soporte iPage</strong> sobre los accesos no autorizados</li>";
echo "<li><strong>Revisar todos los dominios</strong> en tu cuenta de hosting</li>";
echo "</ol>";

echo "<hr>";
echo "<small>Verificación ejecutada: " . date('Y-m-d H:i:s') . "</small>";
?>
