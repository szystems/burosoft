<?php
/**
 * SCRIPT ROBUSTO: ACTUALIZACIÓN AUDIENCIAS CON RETRY Y DEADLOCK HANDLING
 */

echo "🔧 ACTUALIZACIÓN ROBUSTA AUDIENCIAS VA/PA\n";
echo "=========================================\n\n";

// Configuración desde .env
$config = [];
if (file_exists('.env')) {
    $lines = file('.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && substr($line, 0, 1) !== '#') {
            [$key, $value] = explode('=', $line, 2);
            $config[trim($key)] = trim($value);
        }
    }
}

$host = $config['DB_HOST'] ?? 'localhost';
$database = $config['DB_DATABASE'] ?? 'burosoft'; 
$username = $config['DB_USERNAME'] ?? 'root';
$password = $config['DB_PASSWORD'] ?? '';

echo "📋 CONFIGURACIÓN:\n";
echo "  Host: $host\n";
echo "  Database: $database\n";
echo "  Username: $username\n\n";

function executeWithRetry($pdo, $sql, $description, $maxRetries = 3) {
    for ($i = 0; $i < $maxRetries; $i++) {
        try {
            $pdo->exec($sql);
            echo "   ✅ $description\n";
            return true;
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Deadlock') !== false && $i < $maxRetries - 1) {
                echo "   ⚠️  Deadlock detectado, reintentando... (" . ($i + 1) . "/$maxRetries)\n";
                sleep(1); // Esperar 1 segundo antes del retry
                continue;
            } else {
                echo "   ❌ ERROR en $description: " . $e->getMessage() . "\n";
                return false;
            }
        }
    }
    return false;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode=''"
    ]);
    
    echo "✅ Conectado a base de datos: $database\n\n";
    
    // 1. LISTAR TODAS LAS TABLAS
    echo "📋 1. LISTANDO TODAS LAS TABLAS:\n";
    echo "-------------------------------\n";
    
    $stmt = $pdo->query("SHOW TABLES");
    $allTables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $audienciaTables = array_filter($allTables, function($table) {
        return strpos($table, 'audiencia') !== false;
    });
    
    if (empty($audienciaTables)) {
        echo "❌ No se encontraron tablas de audiencias\n";
        echo "Tablas disponibles: " . implode(', ', $allTables) . "\n\n";
    } else {
        echo "✅ Tablas de audiencias encontradas:\n";
        foreach ($audienciaTables as $table) {
            echo "   - $table\n";
        }
        echo "\n";
    }
    
    // 2. CREAR TABLAS SI NO EXISTEN (usando migraciones)
    if (!in_array('audiencias', $allTables)) {
        echo "🔄 2. CREANDO TABLA audiencias...\n";
        $createAudiencias = "
        CREATE TABLE `audiencias` (
            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
            `pat_id` bigint unsigned NOT NULL,
            `usuario_id` bigint unsigned NOT NULL,
            `numero_audiencia` varchar(191) NOT NULL,
            `tipo_audiencia` enum('AEC','AIR','AS','AA','Otro') NOT NULL,
            `tipo_audiencia_otro` varchar(255) DEFAULT NULL,
            `fecha` datetime NOT NULL,
            `impuestos` decimal(15,2) NOT NULL,
            `archivo` varchar(191) DEFAULT NULL,
            `tipo_archivo` varchar(191) DEFAULT NULL,
            `fecha_notificacion` date DEFAULT NULL,
            `plazo_evacuar` enum('5 Dias','10 Dias','30 Dias','Otro') DEFAULT NULL,
            `plazo_evacuar_otro` varchar(255) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `audiencias_usuario_id_foreign` (`usuario_id`),
            CONSTRAINT `audiencias_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        executeWithRetry($pdo, $createAudiencias, "Tabla audiencias creada");
    }
    
    if (!in_array('audiencias_pa', $allTables)) {
        echo "🔄 2. CREANDO TABLA audiencias_pa...\n";
        $createAudienciasPa = "
        CREATE TABLE `audiencias_pa` (
            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
            `pat_id` bigint unsigned NOT NULL,
            `usuario_id` bigint unsigned NOT NULL,
            `numero_audiencia` varchar(191) NOT NULL,
            `tipo_audiencia` enum('AEC','AIR','AS','AA','Otro') NOT NULL,
            `tipo_audiencia_otro` varchar(255) DEFAULT NULL,
            `fecha` datetime NOT NULL,
            `impuestos` decimal(15,2) NOT NULL,
            `archivo` varchar(191) DEFAULT NULL,
            `tipo_archivo` varchar(191) DEFAULT NULL,
            `fecha_notificacion` date DEFAULT NULL,
            `plazo_evacuar` enum('5 Dias','10 Dias','30 Dias','Otro') DEFAULT NULL,
            `plazo_evacuar_otro` varchar(255) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `audiencias_pa_pat_id_foreign` (`pat_id`),
            KEY `audiencias_pa_usuario_id_foreign` (`usuario_id`),
            CONSTRAINT `audiencias_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
        
        executeWithRetry($pdo, $createAudienciasPa, "Tabla audiencias_pa creada");
    }
    
    // 3. ACTUALIZAR TABLAS EXISTENTES
    $tablesToUpdate = ['audiencias', 'audiencias_pa'];
    
    foreach ($tablesToUpdate as $table) {
        // Verificar que la tabla existe ahora
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() === 0) {
            echo "⚠️  Tabla $table no existe, saltando...\n\n";
            continue;
        }
        
        echo "🔄 3. ACTUALIZANDO TABLA: $table\n";
        echo "--------------------------------\n";
        
        // Verificar estructura actual
        $stmt = $pdo->query("DESCRIBE $table");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $hasTypeOtro = false;
        foreach ($columns as $column) {
            if ($column['Field'] === 'tipo_audiencia_otro') {
                $hasTypeOtro = true;
                break;
            }
        }
        
        // Agregar campo si no existe
        if (!$hasTypeOtro) {
            $sql = "ALTER TABLE `$table` ADD COLUMN `tipo_audiencia_otro` VARCHAR(255) NULL AFTER `tipo_audiencia`";
            executeWithRetry($pdo, $sql, "Campo tipo_audiencia_otro agregado a $table");
        }
        
        // Actualizar ENUMs
        $sql = "ALTER TABLE `$table` MODIFY COLUMN `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL";
        executeWithRetry($pdo, $sql, "ENUM tipo_audiencia actualizado en $table");
        
        $sql = "ALTER TABLE `$table` MODIFY COLUMN `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL";
        executeWithRetry($pdo, $sql, "ENUM plazo_evacuar actualizado en $table");
        
        echo "\n";
    }
    
    // 4. VERIFICACIÓN FINAL
    echo "✅ 4. VERIFICACIÓN FINAL:\n";
    echo "------------------------\n";
    
    foreach ($tablesToUpdate as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "📋 Estructura de $table:\n";
            $stmt = $pdo->query("DESCRIBE $table");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($columns as $column) {
                if (in_array($column['Field'], ['tipo_audiencia', 'tipo_audiencia_otro', 'plazo_evacuar', 'plazo_evacuar_otro'])) {
                    echo "   - {$column['Field']}: {$column['Type']}\n";
                }
            }
            echo "\n";
        }
    }
    
    echo "🎉 ACTUALIZACIÓN COMPLETADA\n";
    echo "===========================\n";
    echo "✅ Tablas de audiencias actualizadas\n";
    echo "✅ Formularios VA/PA listos para usar\n\n";
    
} catch (PDOException $e) {
    echo "❌ ERROR FATAL: " . $e->getMessage() . "\n";
    exit(1);
}
?>
