<?php
/**
 * SCRIPT DE LIMPIEZA PROFUNDA DE CACHÉ - LARAVEL 12
 * 
 * Este script limpia TODOS los cachés de Laravel y del navegador
 * 
 * URL: https://appburo.burotributario.com/clear-cache.php
 * 
 * ⚠️ IMPORTANTE: ELIMINAR ESTE ARCHIVO DESPUÉS DE USAR
 * 
 * Uso:
 * 1. Subir este archivo a /public/
 * 2. Visitar: https://appburo.burotributario.com/clear-cache.php
 * 3. Esperar confirmación
 * 4. ELIMINAR el archivo inmediatamente
 */

// Configuración de seguridad básica (opcional pero recomendado)
$allowed_ips = [
    '127.0.0.1',
    '::1',
    // Agregar tu IP aquí si quieres restringir acceso
    // '123.456.789.012',
];

// Verificar IP (comentar estas líneas si no quieres restricción)
// $client_ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
// if (!in_array($client_ip, $allowed_ips)) {
//     die('Acceso denegado. Tu IP: ' . htmlspecialchars($client_ip));
// }

// Timeout extendido
set_time_limit(300);
ini_set('max_execution_time', 300);

// Headers para prevenir caché del navegador
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Limpieza Profunda de Caché - BuroTributario</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            border-bottom: 3px solid #3498db;
            padding-bottom: 10px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #28a745;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #dc3545;
        }
        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #ffc107;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            border-left: 4px solid #17a2b8;
        }
        .step {
            padding: 10px;
            margin: 5px 0;
            border-left: 3px solid #3498db;
            background: #ecf0f1;
        }
        .code {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 10px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            overflow-x: auto;
        }
        .delete-warning {
            background: #dc3545;
            color: white;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        ul { line-height: 1.8; }
        .timestamp {
            color: #7f8c8d;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧹 Limpieza Profunda de Caché - Laravel 12</h1>
        
        <?php
        // Cargar Laravel
        try {
            require __DIR__.'/../vendor/autoload.php';
            $app = require_once __DIR__.'/../bootstrap/app.php';
            $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
            
            echo '<div class="success">✅ Laravel cargado correctamente</div>';
            
            $results = [];
            $errors = [];
            
            // 1. Limpiar caché de configuración
            echo '<div class="step">📝 Limpiando caché de configuración...</div>';
            try {
                \Illuminate\Support\Facades\Artisan::call('config:clear');
                $results[] = '✅ Config cache cleared';
            } catch (Exception $e) {
                $errors[] = '❌ Config clear failed: ' . $e->getMessage();
            }
            
            // 2. Limpiar caché de rutas
            echo '<div class="step">🛣️ Limpiando caché de rutas...</div>';
            try {
                \Illuminate\Support\Facades\Artisan::call('route:clear');
                $results[] = '✅ Route cache cleared';
            } catch (Exception $e) {
                $errors[] = '❌ Route clear failed: ' . $e->getMessage();
            }
            
            // 3. Limpiar caché de vistas
            echo '<div class="step">👁️ Limpiando caché de vistas...</div>';
            try {
                \Illuminate\Support\Facades\Artisan::call('view:clear');
                $results[] = '✅ View cache cleared';
            } catch (Exception $e) {
                $errors[] = '❌ View clear failed: ' . $e->getMessage();
            }
            
            // 4. Limpiar caché de aplicación
            echo '<div class="step">💾 Limpiando caché de aplicación...</div>';
            try {
                \Illuminate\Support\Facades\Artisan::call('cache:clear');
                $results[] = '✅ Application cache cleared';
            } catch (Exception $e) {
                $errors[] = '❌ Cache clear failed: ' . $e->getMessage();
            }
            
            // 5. Limpiar caché de eventos
            echo '<div class="step">📡 Limpiando caché de eventos...</div>';
            try {
                \Illuminate\Support\Facades\Artisan::call('event:clear');
                $results[] = '✅ Event cache cleared';
            } catch (Exception $e) {
                $errors[] = '❌ Event clear failed: ' . $e->getMessage();
            }
            
            // 6. Limpiar archivos compilados
            echo '<div class="step">🔧 Limpiando archivos compilados...</div>';
            try {
                \Illuminate\Support\Facades\Artisan::call('clear-compiled');
                $results[] = '✅ Compiled files cleared';
            } catch (Exception $e) {
                $errors[] = '❌ Clear compiled failed: ' . $e->getMessage();
            }
            
            // 7. Limpiar caché de optimización
            echo '<div class="step">⚡ Limpiando optimizaciones...</div>';
            try {
                \Illuminate\Support\Facades\Artisan::call('optimize:clear');
                $results[] = '✅ Optimization cache cleared';
            } catch (Exception $e) {
                $errors[] = '❌ Optimize clear failed: ' . $e->getMessage();
            }
            
            // 8. Limpiar directamente archivos de caché del filesystem
            echo '<div class="step">📂 Limpiando archivos físicos de caché...</div>';
            $cache_paths = [
                __DIR__.'/../storage/framework/cache/data/*',
                __DIR__.'/../storage/framework/views/*',
                __DIR__.'/../storage/framework/sessions/*',
                __DIR__.'/../bootstrap/cache/*.php',
            ];
            
            foreach ($cache_paths as $path) {
                $files = glob($path);
                if ($files) {
                    foreach ($files as $file) {
                        if (is_file($file) && basename($file) !== '.gitignore') {
                            try {
                                @unlink($file);
                            } catch (Exception $e) {
                                // Silenciar errores de permisos
                            }
                        }
                    }
                    $results[] = '✅ Archivos limpiados en: ' . dirname($path);
                }
            }
            
            // 9. Regenerar caché de configuración
            echo '<div class="step">🔄 Regenerando caché de configuración...</div>';
            try {
                \Illuminate\Support\Facades\Artisan::call('config:cache');
                $results[] = '✅ Config cache regenerated';
            } catch (Exception $e) {
                $errors[] = '❌ Config cache failed: ' . $e->getMessage();
            }
            
            // 10. Optimizar autoloader
            echo '<div class="step">🚀 Optimizando autoloader...</div>';
            try {
                $output = shell_exec('cd ' . escapeshellarg(__DIR__ . '/..') . ' && composer dump-autoload --optimize 2>&1');
                $results[] = '✅ Autoloader optimized';
            } catch (Exception $e) {
                $errors[] = '⚠️ Autoloader optimization skipped (no composer access)';
            }
            
            // Mostrar resultados
            echo '<h2>📊 Resultados</h2>';
            
            if (!empty($results)) {
                echo '<div class="success">';
                echo '<strong>Operaciones exitosas:</strong><ul>';
                foreach ($results as $result) {
                    echo '<li>' . htmlspecialchars($result) . '</li>';
                }
                echo '</ul></div>';
            }
            
            if (!empty($errors)) {
                echo '<div class="error">';
                echo '<strong>Errores encontrados:</strong><ul>';
                foreach ($errors as $error) {
                    echo '<li>' . htmlspecialchars($error) . '</li>';
                }
                echo '</ul></div>';
            }
            
            // Instrucciones post-limpieza
            echo '<h2>📋 Pasos Siguientes</h2>';
            echo '<div class="info">';
            echo '<strong>Ahora debes:</strong>';
            echo '<ol>';
            echo '<li><strong>Limpiar caché del navegador:</strong> Presiona Ctrl + F5 (Windows) o Cmd + Shift + R (Mac)</li>';
            echo '<li><strong>Probar en modo incógnito:</strong> Abre una ventana de incógnito para verificar sin caché</li>';
            echo '<li><strong>Verificar consola del navegador:</strong> Presiona F12 y revisa la pestaña Console</li>';
            echo '<li><strong>Verificar que no hay errores JavaScript</strong></li>';
            echo '</ol>';
            echo '</div>';
            
            // Headers adicionales para forzar limpieza de caché del navegador
            echo '<script>';
            echo 'console.log("✅ Caché de Laravel limpiado correctamente");';
            echo 'console.log("🔄 Por favor limpia el caché de tu navegador: Ctrl + F5");';
            echo '</script>';
            
        } catch (Exception $e) {
            echo '<div class="error">';
            echo '<h3>❌ Error Crítico</h3>';
            echo '<p><strong>No se pudo cargar Laravel:</strong></p>';
            echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
            echo '<p><strong>Trace:</strong></p>';
            echo '<pre>' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
            echo '</div>';
        }
        ?>
        
        <div class="delete-warning">
            ⚠️ ¡ELIMINA ESTE ARCHIVO AHORA POR SEGURIDAD! ⚠️
        </div>
        
        <div class="warning">
            <strong>🔒 Importante - Seguridad:</strong>
            <ol>
                <li>Este archivo expone información del servidor</li>
                <li>Debe ser eliminado inmediatamente después de usar</li>
                <li>Para eliminar via FTP:
                    <div class="code">Eliminar: /public/clear-cache.php</div>
                </li>
                <li>O via SSH:
                    <div class="code">rm public/clear-cache.php</div>
                </li>
            </ol>
        </div>
        
        <div class="timestamp">
            <strong>Timestamp:</strong> <?php echo date('Y-m-d H:i:s'); ?><br>
            <strong>Servidor:</strong> <?php echo htmlspecialchars($_SERVER['SERVER_NAME'] ?? 'unknown'); ?><br>
            <strong>PHP Version:</strong> <?php echo phpversion(); ?><br>
            <strong>Laravel Version:</strong> <?php 
            try {
                echo class_exists('Illuminate\Foundation\Application') ? app()->version() : 'No detectada';
            } catch (Exception $e) {
                echo 'No detectada';
            }
            ?>
        </div>
    </div>
</body>
</html>
