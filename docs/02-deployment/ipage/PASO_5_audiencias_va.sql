-- ===================================================================
-- PASO 5: ACTUALIZAR TABLA audiencias (VA) - AGREGAR CAMPOS FALTANTES
-- ===================================================================

-- Verificar estructura actual de audiencias (VA)
DESCRIBE audiencias;

-- 1. Agregar campo tipo_audiencia_otro si no existe
ALTER TABLE `audiencias` ADD COLUMN `tipo_audiencia_otro` VARCHAR(255) NULL AFTER `tipo_audiencia`;

-- 2. Actualizar ENUM tipo_audiencia para incluir "Otro"
ALTER TABLE `audiencias` MODIFY COLUMN `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL;

-- 3. Actualizar ENUM plazo_evacuar con valores corregidos
ALTER TABLE `audiencias` MODIFY COLUMN `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL;

-- Verificar estructura final
DESCRIBE audiencias;

-- Verificar ENUMs actualizados
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE,
    IS_NULLABLE
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'audiencias'
AND COLUMN_NAME IN ('tipo_audiencia', 'tipo_audiencia_otro', 'plazo_evacuar');
