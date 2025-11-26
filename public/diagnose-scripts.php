<?php
/**
 * DIAGNÓSTICO AVANZADO - BÚSQUEDA DE SCRIPTS EXTERNOS
 * 
 * Detecta scripts de terceros (Google Ads, etc.) que pueden estar
 * causando problemas de Tracking Prevention
 * 
 * URL: https://appburo.burotributario.com/diagnose-scripts.php
 * 
 * ⚠️ ELIMINAR DESPUÉS DE USAR
 */

set_time_limit(300);

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnóstico de Scripts - BuroTributario</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #2c3e50; border-bottom: 3px solid #e74c3c; padding-bottom: 10px; }
        h2 { color: #34495e; margin-top: 30px; border-left: 4px solid #3498db; padding-left: 10px; }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
        }
        .danger { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
        .warning { background: #fff3cd; color: #856404; border-left: 4px solid #ffc107; }
        .success { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .info { background: #d1ecf1; color: #0c5460; border-left: 4px solid #17a2b8; }
        .code {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
            font-size: 13px;
            line-height: 1.6;
            margin: 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th {
            background: #34495e;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:hover { background: #f8f9fa; }
        .file-path {
            color: #7f8c8d;
            font-size: 12px;
            word-break: break-all;
        }
        .delete-warning {
            background: #dc3545;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Diagnóstico de Scripts Externos</h1>
        
        <?php
        $base_dir = __DIR__ . '/..';
        $results = [];
        $suspicious_patterns = [
            'googleads' => 'Google Ads',
            'doubleclick' => 'DoubleClick',
            'adsbygoogle' => 'Google AdSense',
            'ca-pub-' => 'Google Publisher ID',
            'googlesyndication' => 'Google Syndication',
            'google-analytics' => 'Google Analytics',
            'gtag' => 'Google Tag Manager',
            'facebook.net' => 'Facebook Pixel',
            'connect.facebook' => 'Facebook SDK',
        ];
        
        // Función para buscar en archivos
        function searchInFile($file, $patterns) {
            $content = @file_get_contents($file);
            if ($content === false) return [];
            
            $found = [];
            foreach ($patterns as $pattern => $name) {
                if (stripos($content, $pattern) !== false) {
                    // Contar ocurrencias
                    $count = substr_count(strtolower($content), strtolower($pattern));
                    $found[$pattern] = [
                        'name' => $name,
                        'count' => $count,
                        'file' => $file
                    ];
                }
            }
            return $found;
        }
        
        // Directorios a buscar
        $search_dirs = [
            $base_dir . '/resources/views',
            $base_dir . '/public',
        ];
        
        $extensions = ['php', 'blade.php', 'html', 'js'];
        
        echo '<h2>📂 Buscando scripts sospechosos...</h2>';
        echo '<div class="info">Analizando archivos en busca de scripts de terceros...</div>';
        
        foreach ($search_dirs as $dir) {
            if (!is_dir($dir)) continue;
            
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
            );
            
            foreach ($iterator as $file) {
                if (!$file->isFile()) continue;
                
                $extension = $file->getExtension();
                if (!in_array($extension, $extensions)) continue;
                
                // Saltar vendor y node_modules
                if (strpos($file->getPathname(), '/vendor/') !== false) continue;
                if (strpos($file->getPathname(), '/node_modules/') !== false) continue;
                
                $found = searchInFile($file->getPathname(), $suspicious_patterns);
                if (!empty($found)) {
                    foreach ($found as $pattern => $data) {
                        $results[] = [
                            'pattern' => $pattern,
                            'name' => $data['name'],
                            'file' => str_replace($base_dir, '', $file->getPathname()),
                            'count' => $data['count'],
                            'full_path' => $file->getPathname()
                        ];
                    }
                }
            }
        }
        
        // Mostrar resultados
        if (empty($results)) {
            echo '<div class="success">';
            echo '<strong>✅ No se encontraron scripts externos sospechosos</strong>';
            echo '<p>Tu aplicación no contiene referencias a Google Ads, Facebook Pixel, u otros scripts de terceros comunes.</p>';
            echo '</div>';
        } else {
            echo '<div class="danger">';
            echo '<strong>⚠️ Se encontraron ' . count($results) . ' referencias a scripts externos</strong>';
            echo '</div>';
            
            echo '<table>';
            echo '<thead><tr>';
            echo '<th>Tipo de Script</th>';
            echo '<th>Pattern Encontrado</th>';
            echo '<th>Archivo</th>';
            echo '<th>Ocurrencias</th>';
            echo '</tr></thead>';
            echo '<tbody>';
            
            foreach ($results as $result) {
                echo '<tr>';
                echo '<td><strong>' . htmlspecialchars($result['name']) . '</strong></td>';
                echo '<td><code>' . htmlspecialchars($result['pattern']) . '</code></td>';
                echo '<td class="file-path">' . htmlspecialchars($result['file']) . '</td>';
                echo '<td>' . $result['count'] . '</td>';
                echo '</tr>';
            }
            
            echo '</tbody></table>';
            
            // Mostrar extractos de código
            echo '<h2>📝 Extractos de Código</h2>';
            
            $processed = [];
            foreach ($results as $result) {
                if (in_array($result['file'], $processed)) continue;
                $processed[] = $result['file'];
                
                echo '<h3>' . htmlspecialchars($result['file']) . '</h3>';
                
                $content = @file_get_contents($result['full_path']);
                if ($content) {
                    $lines = explode("\n", $content);
                    $relevant_lines = [];
                    
                    foreach ($lines as $num => $line) {
                        foreach ($suspicious_patterns as $pattern => $name) {
                            if (stripos($line, $pattern) !== false) {
                                $start = max(0, $num - 2);
                                $end = min(count($lines) - 1, $num + 2);
                                
                                for ($i = $start; $i <= $end; $i++) {
                                    if (!isset($relevant_lines[$i])) {
                                        $relevant_lines[$i] = $lines[$i];
                                    }
                                }
                            }
                        }
                    }
                    
                    if (!empty($relevant_lines)) {
                        ksort($relevant_lines);
                        echo '<div class="code">';
                        foreach ($relevant_lines as $num => $line) {
                            $line_num = str_pad($num + 1, 4, ' ', STR_PAD_LEFT);
                            echo htmlspecialchars($line_num . ': ' . $line) . "\n";
                        }
                        echo '</div>';
                    }
                }
            }
        }
        
        // Verificar archivos de configuración de iPage
        echo '<h2>🔍 Verificación de Archivos iPage</h2>';
        
        $ipage_files = [
            $base_dir . '/.htaccess',
            __DIR__ . '/.htaccess',
            $base_dir . '/index.php',
            __DIR__ . '/index.php',
        ];
        
        foreach ($ipage_files as $file) {
            if (file_exists($file)) {
                echo '<h3>' . basename($file) . ' en ' . dirname($file) . '</h3>';
                $content = file_get_contents($file);
                
                $has_suspicious = false;
                foreach ($suspicious_patterns as $pattern => $name) {
                    if (stripos($content, $pattern) !== false) {
                        $has_suspicious = true;
                        echo '<div class="warning">⚠️ Contiene: ' . htmlspecialchars($name) . '</div>';
                    }
                }
                
                if (!$has_suspicious) {
                    echo '<div class="success">✅ Limpio</div>';
                }
                
                // Mostrar primeras 50 líneas
                $lines = explode("\n", $content);
                $preview = array_slice($lines, 0, 50);
                echo '<div class="code">';
                foreach ($preview as $num => $line) {
                    echo htmlspecialchars(($num + 1) . ': ' . $line) . "\n";
                }
                if (count($lines) > 50) {
                    echo "\n... (" . (count($lines) - 50) . " líneas más)";
                }
                echo '</div>';
            }
        }
        
        // Información del servidor
        echo '<h2>ℹ️ Información del Servidor</h2>';
        echo '<div class="info">';
        echo '<strong>PHP Version:</strong> ' . phpversion() . '<br>';
        echo '<strong>Document Root:</strong> ' . $_SERVER['DOCUMENT_ROOT'] . '<br>';
        echo '<strong>Script Path:</strong> ' . __FILE__ . '<br>';
        echo '<strong>Server Software:</strong> ' . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . '<br>';
        echo '<strong>Server Name:</strong> ' . ($_SERVER['SERVER_NAME'] ?? 'Unknown') . '<br>';
        echo '</div>';
        
        // Soluciones recomendadas
        echo '<h2>💡 Soluciones Recomendadas</h2>';
        
        if (!empty($results)) {
            echo '<div class="warning">';
            echo '<strong>Acciones a tomar:</strong>';
            echo '<ol>';
            echo '<li><strong>Eliminar o comentar</strong> todos los scripts externos encontrados</li>';
            echo '<li><strong>Verificar</strong> si iPage está inyectando scripts automáticamente</li>';
            echo '<li><strong>Contactar soporte de iPage</strong> para deshabilitar inyección de ads si aplica</li>';
            echo '<li><strong>Agregar Content Security Policy</strong> para bloquear scripts no autorizados</li>';
            echo '</ol>';
            echo '</div>';
            
            echo '<h3>Agregar Content Security Policy (.htaccess)</h3>';
            echo '<div class="code">';
            echo htmlspecialchars('<IfModule mod_headers.c>
    # Bloquear scripts de terceros no autorizados
    Header set Content-Security-Policy "default-src \'self\'; script-src \'self\' \'unsafe-inline\' \'unsafe-eval\' cdn.jsdelivr.net cdnjs.cloudflare.com unpkg.com; style-src \'self\' \'unsafe-inline\' cdn.jsdelivr.net cdnjs.cloudflare.com; img-src \'self\' data: https:; font-src \'self\' data: cdnjs.cloudflare.com;"
</IfModule>');
            echo '</div>';
        } else {
            echo '<div class="info">';
            echo '<p>Si los errores de Google Ads persisten pero no encontramos el código:</p>';
            echo '<ol>';
            echo '<li><strong>iPage puede estar inyectando ads automáticamente</strong> - Contactar soporte</li>';
            echo '<li><strong>Verificar extensiones del navegador</strong> que puedan inyectar scripts</li>';
            echo '<li><strong>Revisar Network tab en DevTools</strong> para ver de dónde viene la petición</li>';
            echo '</ol>';
            echo '</div>';
        }
        ?>
        
        <div class="delete-warning">
            ⚠️ ELIMINAR ESTE ARCHIVO DESPUÉS DE REVISAR ⚠️
        </div>
        
        <div class="info">
            <strong>Para eliminar:</strong>
            <div class="code">rm public/diagnose-scripts.php</div>
            O via FTP: Eliminar /public/diagnose-scripts.php
        </div>
        
        <div style="margin-top: 20px; color: #7f8c8d; font-size: 14px;">
            <strong>Generado:</strong> <?php echo date('Y-m-d H:i:s'); ?>
        </div>
    </div>
</body>
</html>
