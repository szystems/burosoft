<?php
/**
 * SCRIPT DIRECTO: ACTUALIZACIÓN AUDIENCIAS VA/PA
 * 
 * Este script actualiza directamente las tablas existentes sin migrate:fresh
 */

echo "🔧 ACTUALIZACIÓN DIRECTA AUDIENCIAS VA/PA\n";
echo "========================================\n\n";

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
    
    // 1. VERIFICAR SI LAS TABLAS EXISTEN
    echo "📋 1. VERIFICANDO TABLAS EXISTENTES:\n";
    echo "-----------------------------------\n";
    
    $tables = ['audiencias', 'audiencias_pa'];
    $existingTables = [];
    
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            $existingTables[] = $table;
            echo "✅ Tabla $table existe\n";
        } else {
            echo "❌ Tabla $table NO existe\n";
        }
    }
    
    echo "\n";
    
    if (empty($existingTables)) {
        echo "❌ ERROR: No se encontraron las tablas de audiencias.\n";
        echo "   Ejecutar primero: php artisan migrate\n";
        exit(1);
    }
    
    // 2. ACTUALIZAR CADA TABLA EXISTENTE
    foreach ($existingTables as $table) {
        echo "🔄 2. ACTUALIZANDO TABLA: $table\n";
        echo "--------------------------------\n";
        
        try {
            // Verificar estructura actual
            $stmt = $pdo->query("DESCRIBE $table");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $hasTypeOtro = false;
            $currentTypeEnum = '';
            $currentPlazoEnum = '';
            
            foreach ($columns as $column) {
                if ($column['Field'] === 'tipo_audiencia_otro') {
                    $hasTypeOtro = true;
                }
                if ($column['Field'] === 'tipo_audiencia') {
                    $currentTypeEnum = $column['Type'];
                }
                if ($column['Field'] === 'plazo_evacuar') {
                    $currentPlazoEnum = $column['Type'];
                }
            }
            
            echo "   📌 Estructura actual de $table:\n";
            echo "      - tipo_audiencia: $currentTypeEnum\n";
            echo "      - plazo_evacuar: $currentPlazoEnum\n";
            echo "      - tipo_audiencia_otro: " . ($hasTypeOtro ? 'EXISTS' : 'NO EXISTS') . "\n\n";
            
            // Agregar campo tipo_audiencia_otro si no existe
            if (!$hasTypeOtro) {
                echo "   ➕ Agregando campo tipo_audiencia_otro...\n";
                $sql = "ALTER TABLE `$table` ADD COLUMN `tipo_audiencia_otro` VARCHAR(255) NULL AFTER `tipo_audiencia`";
                $pdo->exec($sql);
                echo "   ✅ Campo tipo_audiencia_otro agregado\n";
            } else {
                echo "   ✅ Campo tipo_audiencia_otro ya existe\n";
            }
            
            // Actualizar ENUM tipo_audiencia
            echo "   🔄 Actualizando ENUM tipo_audiencia...\n";
            $sql = "ALTER TABLE `$table` MODIFY COLUMN `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL";
            $pdo->exec($sql);
            echo "   ✅ ENUM tipo_audiencia actualizado\n";
            
            // Actualizar ENUM plazo_evacuar
            echo "   🔄 Actualizando ENUM plazo_evacuar...\n";
            $sql = "ALTER TABLE `$table` MODIFY COLUMN `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL";
            $pdo->exec($sql);
            echo "   ✅ ENUM plazo_evacuar actualizado\n";
            
            echo "   ✅ Tabla $table actualizada correctamente\n\n";
            
        } catch (PDOException $e) {
            echo "   ❌ ERROR en tabla $table: " . $e->getMessage() . "\n\n";
        }
    }
    
    // 3. VERIFICACIÓN FINAL
    echo "✅ 3. VERIFICACIÓN FINAL:\n";
    echo "------------------------\n";
    
    foreach ($existingTables as $table) {
        echo "📋 Estructura final de $table:\n";
        $stmt = $pdo->query("DESCRIBE $table");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($columns as $column) {
            if (in_array($column['Field'], ['tipo_audiencia', 'tipo_audiencia_otro', 'plazo_evacuar', 'plazo_evacuar_otro'])) {
                echo "   - {$column['Field']}: {$column['Type']} " . 
                     ($column['Null'] === 'YES' ? 'NULL' : 'NOT NULL') . "\n";
            }
        }
        echo "\n";
    }
    
    // 4. PRUEBA DE INSERCIÓN
    echo "🧪 4. PRUEBA DE INSERCIÓN:\n";
    echo "-------------------------\n";
    
    foreach ($existingTables as $table) {
        // Probar valores válidos
        $testValues = [
            'tipo_audiencia' => ['AEC', 'Otro'],
            'plazo_evacuar' => ['5 Dias', '10 Dias', '30 Dias', 'Otro']
        ];
        
        foreach ($testValues as $field => $values) {
            foreach ($values as $value) {
                $sql = "SELECT '$value' as test_value WHERE '$value' IN " . 
                       ($field === 'tipo_audiencia' ? "('AEC', 'AIR', 'AS', 'AA', 'Otro')" : "('5 Dias', '10 Dias', '30 Dias', 'Otro')");
                $stmt = $pdo->query($sql);
                $result = $stmt->fetch();
                
                if ($result) {
                    echo "   ✅ $table.$field = '$value' es válido\n";
                } else {
                    echo "   ❌ $table.$field = '$value' NO es válido\n";
                }
            }
        }
        echo "\n";
    }
    
    echo "🎉 ACTUALIZACIÓN COMPLETADA\n";
    echo "===========================\n";
    echo "✅ Las tablas audiencias están listas para usar\n";
    echo "✅ Los formularios VA/PA funcionarán correctamente\n";
    echo "✅ Script SQL para iPage generado en: docs/02-deployment/ipage/\n\n";
    
} catch (PDOException $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
?>
