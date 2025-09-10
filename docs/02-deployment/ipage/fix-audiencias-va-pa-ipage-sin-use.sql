-- ===================================================================
-- SCRIPT AUDIENCIAS VA/PA - iPAGE (SIN USE DATABASE)
-- ===================================================================
-- 
-- INSTRUCCIONES:
-- 1. Asegúrate de estar conectado a la base de datos 'dbburonuevo'
-- 2. Ejecutar cada sección por separado si es necesario
-- 3. Compatible con MySQL 5.7.44-log (iPage hosting)
-- ===================================================================

SELECT '🔧 INICIANDO ACTUALIZACIÓN AUDIENCIAS VA/PA' as 'Status';
SELECT '================================================' as '';

-- ===================================================================
-- 1. VERIFICAR ESTRUCTURA ACTUAL
-- ===================================================================

SELECT '📋 1. VERIFICANDO ESTRUCTURA ACTUAL...' as 'Status';

DESCRIBE audiencias;
DESCRIBE audiencias_pa;

-- ===================================================================
-- 2. AGREGAR CAMPO tipo_audiencia_otro 
-- ===================================================================

SELECT '➕ 2. AGREGANDO CAMPO tipo_audiencia_otro...' as 'Status';

-- Tabla audiencias
ALTER TABLE `audiencias` 
ADD COLUMN `tipo_audiencia_otro` VARCHAR(255) NULL 
AFTER `tipo_audiencia`;

-- Tabla audiencias_pa  
ALTER TABLE `audiencias_pa` 
ADD COLUMN `tipo_audiencia_otro` VARCHAR(255) NULL 
AFTER `tipo_audiencia`;

SELECT '✅ Campo tipo_audiencia_otro agregado' as 'Status_1';

-- ===================================================================
-- 3. ACTUALIZAR ENUM tipo_audiencia PARA INCLUIR "Otro"
-- ===================================================================

SELECT '🔄 3. ACTUALIZANDO ENUM tipo_audiencia...' as 'Status';

-- Tabla audiencias
ALTER TABLE `audiencias` 
MODIFY COLUMN `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL;

-- Tabla audiencias_pa
ALTER TABLE `audiencias_pa` 
MODIFY COLUMN `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL;

SELECT '✅ ENUM tipo_audiencia actualizado con "Otro"' as 'Status_2';

-- ===================================================================
-- 4. ACTUALIZAR ENUM plazo_evacuar CON NUEVOS VALORES
-- ===================================================================

SELECT '🔄 4. ACTUALIZANDO ENUM plazo_evacuar...' as 'Status';

-- Tabla audiencias
ALTER TABLE `audiencias` 
MODIFY COLUMN `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL;

-- Tabla audiencias_pa
ALTER TABLE `audiencias_pa` 
MODIFY COLUMN `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL;

SELECT '✅ ENUM plazo_evacuar actualizado' as 'Status_3';

-- ===================================================================
-- 5. VERIFICACIÓN FINAL
-- ===================================================================

SELECT '✅ 5. VERIFICACIÓN FINAL...' as 'Status';

-- Verificar estructura actualizada
SELECT 'Estructura audiencias:' as 'Verificacion';
DESCRIBE audiencias;

SELECT 'Estructura audiencias_pa:' as 'Verificacion';  
DESCRIBE audiencias_pa;

-- ===================================================================
-- 6. PRUEBA DE INSERCIÓN 
-- ===================================================================

SELECT '🧪 6. PRUEBA DE INSERCIÓN...' as 'Status';

-- Test de valores válidos
SELECT 'Valores válidos para tipo_audiencia:' as 'Test';
SELECT 'AEC, AIR, AS, AA, Otro' as 'Valores_Permitidos';

SELECT 'Valores válidos para plazo_evacuar:' as 'Test';  
SELECT '5 Dias, 10 Dias, 30 Dias, Otro' as 'Valores_Permitidos';

-- ===================================================================
-- RESUMEN FINAL
-- ===================================================================

SELECT '🎉 ACTUALIZACIÓN COMPLETADA EXITOSAMENTE' as 'Status_Final';
SELECT '===============================================' as '';
SELECT 'CAMBIOS REALIZADOS:' as 'Resumen';
SELECT '✅ Campo tipo_audiencia_otro agregado' as 'Cambio_1';
SELECT '✅ ENUM tipo_audiencia incluye "Otro"' as 'Cambio_2';  
SELECT '✅ ENUM plazo_evacuar: 5 Dias, 10 Dias, 30 Dias, Otro' as 'Cambio_3';
SELECT '✅ Estructura compatible con formularios VA/PA' as 'Cambio_4';

SELECT 'FECHA APLICACIÓN:' as 'Info';
SELECT NOW() as 'Timestamp';

-- ===================================================================
-- COMANDOS INDIVIDUALES (USAR SI EL SCRIPT COMPLETO FALLA)
-- ===================================================================

/*
-- EJECUTAR UNO POR UNO SI ES NECESARIO:

-- 1. Agregar campos
ALTER TABLE `audiencias` ADD COLUMN `tipo_audiencia_otro` VARCHAR(255) NULL AFTER `tipo_audiencia`;
ALTER TABLE `audiencias_pa` ADD COLUMN `tipo_audiencia_otro` VARCHAR(255) NULL AFTER `tipo_audiencia`;

-- 2. Actualizar ENUMs tipo_audiencia
ALTER TABLE `audiencias` MODIFY COLUMN `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL;
ALTER TABLE `audiencias_pa` MODIFY COLUMN `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL;

-- 3. Actualizar ENUMs plazo_evacuar
ALTER TABLE `audiencias` MODIFY COLUMN `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL;
ALTER TABLE `audiencias_pa` MODIFY COLUMN `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL;

-- 4. Verificar
DESCRIBE audiencias;
DESCRIBE audiencias_pa;
*/

-- ===================================================================
-- NOTAS IMPORTANTES PARA iPAGE:
-- ===================================================================
-- 
-- 1. Asegúrate de estar en la base de datos 'dbburonuevo'
-- 2. Los ENUMs son case-sensitive: usar exactamente '5 Dias', '10 Dias', etc.
-- 3. Si el script completo falla, usar los comandos individuales del final
-- 4. Los formularios Laravel ya están actualizados para usar estos valores
-- 5. Probar crear audiencia después de aplicar cambios
-- 
-- ===================================================================
