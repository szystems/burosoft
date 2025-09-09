<?php
// Script de limpieza específico para Error 419
// Basado en SOLUCION_ERROR_419_LARAVEL_IPAGE.md

echo "<!DOCTYPE html><html><head><title>Limpiar Cache Error 419</title></head><body>";
echo "<h1>🧹 Limpieza Cache Error 419 - BuroSoft</h1>";

$cleared = [];
$errors = [];

// 1. Limpiar directorios de sesiones y cache
$cache_dirs = [
    '../storage/framework/sessions' => 'Sesiones Laravel',
    '../storage/framework/cache' => 'Cache framework', 
    '../storage/framework/views' => 'Vistas compiladas',
    '../bootstrap/cache' => 'Cache bootstrap'
];

foreach ($cache_dirs as $dir => $desc) {
    echo "<h3>🔄 Limpiando $desc</h3>";
    
    if (!file_exists($dir)) {
        @mkdir($dir, 0755, true);
        $cleared[] = "📁 $desc: Directorio creado";
        continue;
    }
    
    $files = glob($dir . '/*');
    $deleted_count = 0;
    
    foreach ($files as $file) {
        if (is_file($file) && basename($file) !== '.gitignore') {
            if (@unlink($file)) {
                $deleted_count++;
            } else {
                $errors[] = "❌ No se pudo eliminar: " . basename($file);
            }
        }
    }
    
    if ($deleted_count > 0) {
        $cleared[] = "✅ $desc: $deleted_count archivos eliminados";
    } else {
        $cleared[] = "ℹ️ $desc: Sin archivos para limpiar";
    }
}

// 2. Crear archivos de configuración necesarios si faltan
$required_files = [
    '../storage/logs/.gitignore' => "*\n!.gitignore",
    '../storage/framework/sessions/.gitignore' => "*\n!.gitignore", 
    '../storage/framework/cache/.gitignore' => "*\n!.gitignore",
    '../storage/framework/views/.gitignore' => "*\n!.gitignore"
];

echo "<h3>📄 Verificando archivos .gitignore</h3>";
foreach ($required_files as $file => $content) {
    if (!file_exists($file)) {
        $dir = dirname($file);
        if (!file_exists($dir)) {
            @mkdir($dir, 0755, true);
        }
        if (@file_put_contents($file, $content)) {
            $cleared[] = "✅ Creado: " . basename($file);
        } else {
            $errors[] = "❌ No se pudo crear: " . basename($file);
        }
    }
}

// 3. Verificar y corregir permisos
echo "<h3>🔐 Verificando permisos</h3>";
$permission_dirs = [
    '../storage' => 'Storage principal',
    '../storage/logs' => 'Logs',
    '../storage/framework' => 'Framework',
    '../bootstrap/cache' => 'Bootstrap cache'
];

foreach ($permission_dirs as $dir => $desc) {
    if (file_exists($dir)) {
        $perms = substr(sprintf('%o', fileperms($dir)), -4);
        if ($perms >= '0755') {
            $cleared[] = "✅ $desc: Permisos OK ($perms)";
        } else {
            $errors[] = "⚠️ $desc: Permisos insuficientes ($perms)";
        }
    }
}

// 4. Resultados
echo "<hr>";
echo "<h2>📊 RESULTADOS</h2>";

if (!empty($cleared)) {
    echo "<h3 style='color: green;'>✅ ACCIONES EXITOSAS:</h3>";
    foreach ($cleared as $success) {
        echo "$success<br>";
    }
}

if (!empty($errors)) {
    echo "<h3 style='color: red;'>❌ ERRORES:</h3>";
    foreach ($errors as $error) {
        echo "$error<br>";
    }
}

echo "<hr>";
echo "<h2>🎯 PRÓXIMOS PASOS</h2>";
echo "<ol>";
echo "<li><strong>Probar la aplicación:</strong> <a href='./'>🚀 Ir a BuroSoft</a></li>";
echo "<li><strong>Si persiste Error 419:</strong> <a href='verificar-419.php'>🔍 Ejecutar diagnóstico</a></li>";
echo "<li><strong>Verificar sesiones:</strong> Intentar login</li>";
echo "</ol>";

echo "<hr>";
echo "<small>Limpieza ejecutada: " . date('Y-m-d H:i:s') . "</small>";
echo "</body></html>";
?>
