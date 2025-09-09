<?php
// DIAGNÓSTICO .ENV ESPECÍFICO - env-content.php
// Subir como /szystems/buro-v2/public/env-content.php

echo "<h1>🔍 DIAGNÓSTICO ESPECÍFICO .ENV</h1>";

// Cambiar al directorio raíz
chdir('..');

echo "<h2>1. INFORMACIÓN BÁSICA .ENV:</h2>";

if(file_exists('.env')) {
    $size = filesize('.env');
    $content = file_get_contents('.env');
    $lines = explode("\n", $content);
    $nonEmptyLines = array_filter($lines, function($line) {
        return !empty(trim($line));
    });
    
    echo "✅ Archivo .env existe<br>";
    echo "📊 Tamaño: <strong>$size bytes</strong><br>";
    echo "📄 Total líneas: <strong>" . count($lines) . "</strong><br>";
    echo "📝 Líneas no vacías: <strong>" . count($nonEmptyLines) . "</strong><br>";
    
    if($size == 0) {
        echo "🚨 <strong>ARCHIVO .ENV ESTÁ VACÍO!</strong><br>";
    }
    
} else {
    echo "❌ Archivo .env NO existe<br>";
}

echo "<h2>2. CONTENIDO RAW DEL .ENV:</h2>";

if(file_exists('.env') && filesize('.env') > 0) {
    $content = file_get_contents('.env');
    echo "<pre style='background:#f5f5f5; padding:10px; border:1px solid #ddd; max-height:400px; overflow:auto;'>";
    echo htmlspecialchars($content);
    echo "</pre>";
} else {
    echo "❌ No hay contenido para mostrar<br>";
}

echo "<h2>3. ANÁLISIS LÍNEA POR LÍNEA:</h2>";

if(file_exists('.env')) {
    $content = file_get_contents('.env');
    $lines = explode("\n", $content);
    
    echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
    echo "<tr><th>Línea</th><th>Contenido</th><th>Tipo</th></tr>";
    
    foreach($lines as $num => $line) {
        $lineNum = $num + 1;
        $trimmed = trim($line);
        
        if(empty($trimmed)) {
            $type = "Vacía";
            $display = "[LÍNEA VACÍA]";
        } elseif(str_starts_with($trimmed, '#')) {
            $type = "Comentario";
            $display = htmlspecialchars($line);
        } elseif(strpos($line, '=') !== false) {
            $type = "Variable";
            // Ocultar valores sensibles
            if(preg_match('/(PASSWORD|SECRET|KEY)/i', $line)) {
                $parts = explode('=', $line, 2);
                $display = htmlspecialchars($parts[0] . '=***HIDDEN***');
            } else {
                $display = htmlspecialchars($line);
            }
        } else {
            $type = "Otro";
            $display = htmlspecialchars($line);
        }
        
        echo "<tr>";
        echo "<td>$lineNum</td>";
        echo "<td>$display</td>";
        echo "<td>$type</td>";
        echo "</tr>";
    }
    
    echo "</table>";
}

echo "<h2>4. VERIFICANDO VARIABLES CRÍTICAS:</h2>";

$requiredVars = [
    'APP_NAME' => 'Nombre de la aplicación',
    'APP_ENV' => 'Ambiente (production/local)',
    'APP_KEY' => 'Clave de encriptación',
    'APP_DEBUG' => 'Modo debug',
    'APP_URL' => 'URL de la aplicación',
    'DB_HOST' => 'Host base de datos',
    'DB_DATABASE' => 'Nombre base de datos',
    'DB_USERNAME' => 'Usuario base de datos',
    'DB_PASSWORD' => 'Password base de datos',
    'SESSION_DRIVER' => 'Driver de sesiones',
    'CACHE_DRIVER' => 'Driver de cache'
];

if(file_exists('.env')) {
    $content = file_get_contents('.env');
    
    echo "<table border='1' style='border-collapse:collapse; width:100%;'>";
    echo "<tr><th>Variable</th><th>Descripción</th><th>Estado</th><th>Valor</th></tr>";
    
    foreach($requiredVars as $var => $desc) {
        if(preg_match("/^$var\s*=\s*(.*)$/m", $content, $matches)) {
            $value = trim($matches[1]);
            if(empty($value)) {
                $status = "❌ Vacía";
                $displayValue = "[VACÍO]";
            } else {
                $status = "✅ Definida";
                // Ocultar valores sensibles
                if(strpos($var, 'PASSWORD') !== false || strpos($var, 'SECRET') !== false || strpos($var, 'KEY') !== false) {
                    $displayValue = "***HIDDEN***";
                } else {
                    $displayValue = htmlspecialchars($value);
                }
            }
        } else {
            $status = "❌ No existe";
            $displayValue = "[NO DEFINIDA]";
        }
        
        echo "<tr>";
        echo "<td><strong>$var</strong></td>";
        echo "<td>$desc</td>";
        echo "<td>$status</td>";
        echo "<td>$displayValue</td>";
        echo "</tr>";
    }
    
    echo "</table>";
}

echo "<h2>5. RECOMENDACIONES:</h2>";

if(!file_exists('.env') || filesize('.env') == 0) {
    echo "<div style='background:#ffebee; padding:15px; border-left:4px solid #f44336;'>";
    echo "<h3>🚨 PROBLEMA CRÍTICO: .ENV VACÍO O INEXISTENTE</h3>";
    echo "<p><strong>Solución:</strong> Necesitas crear un archivo .env con la configuración correcta.</p>";
    echo "<p><a href='create-env.php' style='background:#f44336; color:white; padding:10px; text-decoration:none;'>🔧 CREAR .ENV</a></p>";
    echo "</div>";
} else {
    echo "<div style='background:#e8f5e8; padding:15px; border-left:4px solid #4caf50;'>";
    echo "<h3>✅ .ENV EXISTE</h3>";
    echo "<p>Verificar que todas las variables críticas estén definidas correctamente.</p>";
    echo "</div>";
}

echo "<hr>";
echo "<p><strong>Después de revisar el contenido, ejecutar el test completo</strong></p>";
?>
