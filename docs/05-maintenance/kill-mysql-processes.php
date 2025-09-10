<?php
/**
 * SCRIPT PARA MATAR PROCESOS COLGADOS DE MYSQL
 */

echo "🔪 MATANDO PROCESOS COLGADOS DE MYSQL\n";
echo "====================================\n\n";

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

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Conectado a MySQL\n\n";
    
    // 1. LISTAR PROCESOS PROBLEMÁTICOS
    echo "📋 PROCESOS ACTIVOS:\n";
    echo "------------------\n";
    
    $stmt = $pdo->query("SHOW PROCESSLIST");
    $processes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $problematicProcesses = [];
    
    foreach ($processes as $process) {
        $state = $process['State'] ?? '';
        $info = $process['Info'] ?? '';
        
        // Buscar procesos relacionados con DROP TABLE o metadata locks
        if (
            strpos($state, 'metadata lock') !== false ||
            strpos($info, 'drop table') !== false ||
            strpos($info, 'DROP TABLE') !== false ||
            ($state && $state !== 'Sleep' && $process['Time'] > 10)
        ) {
            $problematicProcesses[] = $process;
            echo "⚠️  ID: {$process['Id']} - Usuario: {$process['User']} - Estado: $state\n";
            echo "   Tiempo: {$process['Time']}s - Comando: " . substr($info, 0, 80) . "\n\n";
        }
    }
    
    if (empty($problematicProcesses)) {
        echo "✅ No se encontraron procesos problemáticos\n";
    } else {
        echo "🔪 MATANDO PROCESOS PROBLEMÁTICOS:\n";
        echo "--------------------------------\n";
        
        foreach ($problematicProcesses as $process) {
            try {
                // No matar nuestro propio proceso
                if ($process['Command'] === 'Query' && $process['User'] === $username) {
                    continue;
                }
                
                $pdo->exec("KILL {$process['Id']}");
                echo "✅ Proceso {$process['Id']} eliminado\n";
            } catch (Exception $e) {
                echo "❌ No se pudo matar proceso {$process['Id']}: " . $e->getMessage() . "\n";
            }
        }
    }
    
    echo "\n";
    
    // 2. LIBERAR LOCKS
    echo "🔓 LIBERANDO LOCKS:\n";
    echo "-----------------\n";
    
    try {
        $pdo->exec("UNLOCK TABLES");
        echo "✅ Locks liberados\n";
    } catch (Exception $e) {
        echo "⚠️  No se pudieron liberar locks: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
    
    // 3. VERIFICAR ESTADO FINAL
    echo "✅ VERIFICACIÓN FINAL:\n";
    echo "--------------------\n";
    
    $stmt = $pdo->query("SHOW PROCESSLIST");
    $processes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $activeCount = 0;
    foreach ($processes as $process) {
        if ($process['State'] && $process['State'] !== 'Sleep') {
            $activeCount++;
        }
    }
    
    echo "📊 Procesos activos restantes: $activeCount\n";
    
    if ($activeCount === 0) {
        echo "🎉 ¡MySQL limpio! Ahora se puede ejecutar migrate:fresh\n";
    } else {
        echo "⚠️  Aún hay procesos activos - considerar reiniciar MySQL\n";
    }
    
} catch (PDOException $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
}
?>
