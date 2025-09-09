<?php
// Script de limpieza de cache para Laravel en servidores compartidos
// Archivo: clear-cache.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🧹 LIMPIEZA DE CACHE - LARAVEL</h1>";
echo "<hr>";

$cleared = [];
$errors = [];

// 1. LIMPIAR OPCACHE (muy común en servidores compartidos)
echo "<h2>🔄 Limpiando OPcache...</h2>";
if (function_exists('opcache_reset')) {
    if (opcache_reset()) {
        $cleared[] = "✅ OPcache limpiado exitosamente";
    } else {
        $errors[] = "❌ Error al limpiar OPcache";
    }
} else {
    $cleared[] = "ℹ️ OPcache no está disponible";
}

// 2. LIMPIAR CACHE DE LARAVEL
echo "<h2>🗂️ Limpiando cache de Laravel...</h2>";

$cache_paths = [
    '../bootstrap/cache/' => 'Bootstrap Cache',
    '../storage/framework/cache/data/' => 'Application Cache',
    '../storage/framework/sessions/' => 'Sessions',
    '../storage/framework/views/' => 'Compiled Views',
    '../storage/logs/' => 'Log Files (opcional)'
];

foreach ($cache_paths as $path => $description) {
    echo "<h3>🔍 $description ($path)</h3>";
    
    if (file_exists($path) && is_dir($path)) {
        $files = glob($path . '*');
        $deleted_count = 0;
        
        foreach ($files as $file) {
            if (is_file($file) && basename($file) !== '.gitignore') {
                if (unlink($file)) {
                    $deleted_count++;
                } else {
                    $errors[] = "❌ No se pudo eliminar: " . basename($file);
                }
            }
        }
        
        if ($deleted_count > 0) {
            $cleared[] = "✅ $description: $deleted_count archivos eliminados";
        } else {
            $cleared[] = "ℹ️ $description: No había archivos para limpiar";
        }
    } else {
        $errors[] = "❌ Directorio no encontrado: $path";
    }
}

// 3. LIMPIAR ARCHIVOS ESPECÍFICOS PROBLEMÁTICOS
echo "<h2>🎯 Limpiando archivos específicos...</h2>";

$specific_files = [
    '../bootstrap/cache/config.php' => 'Config Cache',
    '../bootstrap/cache/routes.php' => 'Routes Cache', 
    '../bootstrap/cache/services.php' => 'Services Cache',
    '../storage/framework/cache/data/.gitignore' => false, // No eliminar .gitignore
];

foreach ($specific_files as $file => $description) {
    if ($description === false) continue; // Skip .gitignore
    
    if (file_exists($file)) {
        if (unlink($file)) {
            $cleared[] = "✅ $description eliminado";
        } else {
            $errors[] = "❌ Error eliminando $description";
        }
    } else {
        $cleared[] = "ℹ️ $description no existía";
    }
}

// 4. VERIFICAR PERMISOS
echo "<h2>🔐 Verificando permisos...</h2>";

$permission_paths = [
    '../storage/' => 'Storage principal',
    '../storage/logs/' => 'Logs',
    '../bootstrap/cache/' => 'Bootstrap cache'
];

foreach ($permission_paths as $path => $desc) {
    if (file_exists($path)) {
        $perms = substr(sprintf('%o', fileperms($path)), -4);
        if ($perms >= '0755') {
            $cleared[] = "✅ $desc: Permisos OK ($perms)";
        } else {
            $errors[] = "⚠️ $desc: Permisos insuficientes ($perms)";
        }
    }
}

// 5. RESULTADOS
echo "<hr>";
echo "<h2>📊 RESULTADOS DE LIMPIEZA</h2>";

echo "<h3 style='color: green;'>✅ EXITOSO:</h3>";
foreach ($cleared as $success) {
    echo "$success<br>";
}

if (!empty($errors)) {
    echo "<h3 style='color: red;'>❌ ERRORES:</h3>";
    foreach ($errors as $error) {
        echo "$error<br>";
    }
}

// 6. INSTRUCCIONES POST-LIMPIEZA
echo "<hr>";
echo "<h2>🚀 PRÓXIMOS PASOS:</h2>";
echo "<ol>";
echo "<li><strong>Restaurar index.php normal</strong> (si estás usando el de debug)</li>";
echo "<li><strong>Probar la aplicación</strong>: <a href='./'>Ir a inicio</a></li>";
echo "<li><strong>Si persiste el error</strong>: <a href='logs-debug.php'>Ver diagnóstico completo</a></li>";
echo "</ol>";

echo "<hr>";
echo "<p><strong>🔄 <a href='javascript:location.reload()'>EJECUTAR LIMPIEZA NUEVAMENTE</a></strong></p>";
echo "<small>Limpieza ejecutada: " . date('Y-m-d H:i:s') . "</small>";
?>
