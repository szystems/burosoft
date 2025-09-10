<?php
/**
 * DIAGNÓSTICO RÁPIDO DE BASE DE DATOS
 */

echo "🔍 DIAGNÓSTICO MIGRATE:FRESH COLGADO\n";
echo "===================================\n\n";

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

echo "📋 CONFIGURACIÓN ACTUAL:\n";
echo "  Host: $host\n";
echo "  Database: $database\n";
echo "  Username: $username\n\n";

// 1. PROBAR CONEXIÓN
try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password, [
        PDO::ATTR_TIMEOUT => 5,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    echo "✅ Conexión a base de datos: OK\n\n";
    
    // 2. VERIFICAR TABLAS PROBLEMÁTICAS
    echo "📋 VERIFICANDO TABLAS PROBLEMÁTICAS:\n";
    echo "-----------------------------------\n";
    
    $problematicTables = ['migrations', 'users', 'audiencias', 'audiencias_pa'];
    
    foreach ($problematicTables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "✅ Tabla $table: EXISTE\n";
            
            // Verificar si tiene registros
            $stmt = $pdo->query("SELECT COUNT(*) as count FROM $table");
            $count = $stmt->fetch()['count'];
            echo "   └─ Registros: $count\n";
        } else {
            echo "❌ Tabla $table: NO EXISTE\n";
        }
    }
    
    echo "\n";
    
    // 3. VERIFICAR PROCESOS BLOQUEANTES
    echo "🔍 VERIFICANDO PROCESOS BLOQUEANTES:\n";
    echo "-----------------------------------\n";
    
    $stmt = $pdo->query("SHOW PROCESSLIST");
    $processes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $activeProcesses = 0;
    foreach ($processes as $process) {
        if ($process['State'] && $process['State'] !== 'Sleep') {
            echo "⚠️  Proceso activo: {$process['Id']} - {$process['State']} - {$process['Info']}\n";
            $activeProcesses++;
        }
    }
    
    if ($activeProcesses === 0) {
        echo "✅ No hay procesos bloqueantes\n";
    }
    
    echo "\n";
    
    // 4. VERIFICAR LOCKS
    echo "🔒 VERIFICANDO LOCKS DE TABLAS:\n";
    echo "------------------------------\n";
    
    try {
        $stmt = $pdo->query("SHOW OPEN TABLES WHERE In_use > 0");
        $locks = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($locks)) {
            echo "✅ No hay tablas bloqueadas\n";
        } else {
            foreach ($locks as $lock) {
                echo "⚠️  Tabla bloqueada: {$lock['Table']} en base {$lock['Database']}\n";
            }
        }
    } catch (Exception $e) {
        echo "⚠️  No se pudo verificar locks: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
    
    // 5. VERIFICAR FOREIGN KEYS
    echo "🔗 VERIFICANDO FOREIGN KEYS PROBLEMÁTICAS:\n";
    echo "-----------------------------------------\n";
    
    $stmt = $pdo->query("
        SELECT 
            TABLE_NAME,
            CONSTRAINT_NAME,
            REFERENCED_TABLE_NAME
        FROM information_schema.KEY_COLUMN_USAGE 
        WHERE REFERENCED_TABLE_SCHEMA = '$database'
        AND REFERENCED_TABLE_NAME IS NOT NULL
        ORDER BY TABLE_NAME
    ");
    
    $foreignKeys = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "📊 Total Foreign Keys: " . count($foreignKeys) . "\n";
    
    if (count($foreignKeys) > 50) {
        echo "⚠️  MUCHAS Foreign Keys - esto puede causar lentitud en migrate:fresh\n";
    }
    
    echo "\n";
    
    // RECOMENDACIONES
    echo "💡 RECOMENDACIONES:\n";
    echo "==================\n";
    
    if ($activeProcesses > 0) {
        echo "🔴 HAY PROCESOS ACTIVOS - Esto puede bloquear migrate:fresh\n";
        echo "   Solución: Reiniciar servidor MySQL/MariaDB\n\n";
    }
    
    if (!empty($locks)) {
        echo "🔴 HAY TABLAS BLOQUEADAS\n";
        echo "   Solución: UNLOCK TABLES;\n\n";
    }
    
    if (count($foreignKeys) > 50) {
        echo "🟡 MUCHAS FOREIGN KEYS\n";
        echo "   Solución: Usar migrate:fresh --drop-views --drop-types\n\n";
    }
    
    echo "🔧 COMANDOS ALTERNATIVOS A PROBAR:\n";
    echo "1. php artisan migrate:reset\n";
    echo "2. php artisan migrate:install\n";
    echo "3. php artisan migrate --step\n";
    echo "4. php artisan db:wipe\n";
    echo "5. Luego: php artisan migrate --seed\n\n";
    
} catch (PDOException $e) {
    echo "❌ ERROR DE CONEXIÓN: " . $e->getMessage() . "\n\n";
    
    echo "💡 POSIBLES CAUSAS:\n";
    echo "- Servidor MySQL/MariaDB no está ejecutándose\n";
    echo "- Credenciales incorrectas en .env\n";
    echo "- Base de datos '$database' no existe\n";
    echo "- Timeout de conexión\n";
}
?>
