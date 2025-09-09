<?php
// Script simple para mostrar solo logs
// Archivo: show-logs.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>📄 LOGS DE ERROR - RÁPIDO</h1>";
echo "<hr>";

// Laravel Log
$laravel_log = '../storage/logs/laravel.log';
if (file_exists($laravel_log)) {
    echo "<h2>🚨 LARAVEL LOG (últimas 30 líneas)</h2>";
    echo "<div style='background:#000; color:#fff; padding:15px; overflow:auto; max-height:400px; font-family:monospace;'>";
    
    $lines = file($laravel_log);
    $recent_lines = array_slice($lines, -30);
    
    foreach ($recent_lines as $line) {
        if (stripos($line, 'error') !== false || stripos($line, 'fatal') !== false || stripos($line, 'exception') !== false) {
            echo "<span style='color:#ff4444; font-weight:bold;'>" . htmlspecialchars($line) . "</span>";
        } else {
            echo htmlspecialchars($line);
        }
    }
    echo "</div>";
} else {
    echo "❌ Laravel log no encontrado en: $laravel_log<br>";
}

echo "<hr>";

// PHP Error Log  
$php_logs = [
    '../error_log',
    './error_log', 
    '/home/users/web/b2263/ipg.szclinicascom/szystems/error_log',
    ini_get('error_log')
];

foreach ($php_logs as $error_log) {
    if ($error_log && file_exists($error_log)) {
        echo "<h2>🚨 PHP ERROR LOG: $error_log</h2>";
        echo "<div style='background:#440000; color:#ffcccc; padding:15px; overflow:auto; max-height:300px; font-family:monospace;'>";
        
        $lines = file($error_log);
        $recent_lines = array_slice($lines, -20);
        
        foreach ($recent_lines as $line) {
            echo htmlspecialchars($line);
        }
        echo "</div><hr>";
        break; // Solo mostrar el primero que encuentre
    }
}

echo "<p><strong>🔄 <a href='javascript:location.reload()'>RECARGAR LOGS</a></strong></p>";
echo "<p><a href='logs-debug.php'>🔍 DIAGNÓSTICO COMPLETO</a></p>";
?>
