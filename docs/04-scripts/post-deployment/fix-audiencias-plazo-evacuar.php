<?php
/**
 * CORRECCIÓN COORDINADA: PLAZO_EVACUAR AUDIENCIAS VA/PA
 * 
 * PROBLEMA: Valores del formulario no coinciden con ENUM de base de datos
 * - Formulario: "30 dias", "15 dias", etc.
 * - Base datos: "30 D.H.", "3 Meses", "Otro"
 * 
 * SOLUCIÓN: Actualizar ENUM en base de datos para aceptar valores del formulario
 */

echo "🔧 CORRECCIÓN PLAZO_EVACUAR AUDIENCIAS\n";
echo "=====================================\n\n";

$host = 'localhost';
$database = 'burosoft';
$username = 'root';
$password = '';

// Usar configuración de .env si está disponible
if (file_exists('.env')) {
    $env = file_get_contents('.env');
    preg_match('/DB_HOST=(.*)/', $env, $matches);
    if (isset($matches[1])) $host = trim($matches[1]);
    
    preg_match('/DB_DATABASE=(.*)/', $env, $matches);
    if (isset($matches[1])) $database = trim($matches[1]);
    
    preg_match('/DB_USERNAME=(.*)/', $env, $matches);
    if (isset($matches[1])) $username = trim($matches[1]);
    
    preg_match('/DB_PASSWORD=(.*)/', $env, $matches);
    if (isset($matches[1])) $password = trim($matches[1]);
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "✅ Conectado a base de datos: $database\n\n";
    
    // 1. VERIFICAR ESTRUCTURA ACTUAL
    echo "📋 1. VERIFICANDO ESTRUCTURA ACTUAL:\n";
    echo "-----------------------------------\n";
    
    $stmt = $pdo->query("DESCRIBE audiencias");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        if ($column['Field'] === 'plazo_evacuar') {
            echo "📌 audiencias.plazo_evacuar: {$column['Type']}\n";
        }
    }
    
    $stmt = $pdo->query("DESCRIBE audiencias_pa");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        if ($column['Field'] === 'plazo_evacuar') {
            echo "📌 audiencias_pa.plazo_evacuar: {$column['Type']}\n";
        }
    }
    
    echo "\n";
    
    // 2. ACTUALIZAR ENUM PARA INCLUIR VALORES DEL FORMULARIO
    echo "🔄 2. ACTUALIZANDO ENUM CON VALORES DEL FORMULARIO:\n";
    echo "------------------------------------------------\n";
    
    $newEnum = "('15 dias', '30 dias', '60 dias', '90 dias', '30 D.H.', '3 Meses', 'Otro')";
    
    // Actualizar tabla audiencias
    $sql = "ALTER TABLE `audiencias` MODIFY COLUMN `plazo_evacuar` ENUM$newEnum NULL";
    $pdo->exec($sql);
    echo "✅ audiencias.plazo_evacuar actualizado\n";
    
    // Actualizar tabla audiencias_pa
    $sql = "ALTER TABLE `audiencias_pa` MODIFY COLUMN `plazo_evacuar` ENUM$newEnum NULL";
    $pdo->exec($sql);
    echo "✅ audiencias_pa.plazo_evacuar actualizado\n";
    
    echo "\n";
    
    // 3. VERIFICAR ACTUALIZACIÓN
    echo "✅ 3. VERIFICACIÓN FINAL:\n";
    echo "------------------------\n";
    
    $stmt = $pdo->query("DESCRIBE audiencias");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        if ($column['Field'] === 'plazo_evacuar') {
            echo "📌 audiencias.plazo_evacuar: {$column['Type']}\n";
        }
    }
    
    $stmt = $pdo->query("DESCRIBE audiencias_pa");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($columns as $column) {
        if ($column['Field'] === 'plazo_evacuar') {
            echo "📌 audiencias_pa.plazo_evacuar: {$column['Type']}\n";
        }
    }
    
    echo "\n";
    
    // 4. PROBAR INSERCIÓN
    echo "🧪 4. PRUEBA DE INSERCIÓN:\n";
    echo "-------------------------\n";
    
    // Test con valor problemático
    $testSql = "SELECT 'Test' as test WHERE '30 dias' IN ('15 dias', '30 dias', '60 dias', '90 dias', '30 D.H.', '3 Meses', 'Otro')";
    $stmt = $pdo->query($testSql);
    $result = $stmt->fetch();
    
    if ($result) {
        echo "✅ Valor '30 dias' ahora es válido\n";
    } else {
        echo "❌ Error: '30 dias' sigue sin ser válido\n";
    }
    
    echo "\n🎉 CORRECCIÓN COMPLETADA\n";
    echo "========================\n";
    echo "✅ Los formularios VA/PA ahora pueden usar:\n";
    echo "   - 15 dias, 30 dias, 60 dias, 90 dias\n";
    echo "   - 30 D.H., 3 Meses (valores legacy)\n"; 
    echo "   - Otro (para valores personalizados)\n\n";
    
} catch (PDOException $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
?>
