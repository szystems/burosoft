-- Script de corrección para tabla rsat_pa - Campos faltantes para funcionalidad "Otro"
-- Fecha: 28 de agosto de 2025
-- Propósito: Agregar campos tipo_resolucion_otro, plazo_revocatoria y plazo_revocatoria_otro

USE `lnumfqhy_basetributaria`;

-- Verificar estructura actual
SELECT 'ESTRUCTURA ACTUAL:' AS info;
DESCRIBE `rsat_pa`;

-- 1. Agregar campo tipo_resolucion_otro (después de tipo_resolucion)
SELECT 'Agregando tipo_resolucion_otro...' AS info;
ALTER TABLE `rsat_pa` 
ADD COLUMN `tipo_resolucion_otro` VARCHAR(191) NULL DEFAULT NULL COMMENT 'Campo para especificar otro tipo de resolución'
AFTER `tipo_resolucion`;

-- 2. Agregar campo plazo_revocatoria (después de tipo_resolucion_otro) 
SELECT 'Agregando plazo_revocatoria...' AS info;
ALTER TABLE `rsat_pa` 
ADD COLUMN `plazo_revocatoria` VARCHAR(191) NULL DEFAULT NULL COMMENT 'Plazo para revocatoria (15 días, 30 días, otro)'
AFTER `tipo_resolucion_otro`;

-- 3. Agregar campo plazo_revocatoria_otro (después de plazo_revocatoria)
SELECT 'Agregando plazo_revocatoria_otro...' AS info;
ALTER TABLE `rsat_pa` 
ADD COLUMN `plazo_revocatoria_otro` VARCHAR(191) NULL DEFAULT NULL COMMENT 'Campo para especificar otro plazo de revocatoria'
AFTER `plazo_revocatoria`;

-- Verificar la estructura actualizada
SELECT 'ESTRUCTURA FINAL:' AS info;
DESCRIBE `rsat_pa`;

-- Query de verificación - debe mostrar los nuevos campos
SELECT 'VERIFICACIÓN DE CAMPOS NUEVOS:' AS info;
SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT, COLUMN_COMMENT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'lnumfqhy_basetributaria' 
  AND TABLE_NAME = 'rsat_pa' 
  AND COLUMN_NAME IN ('tipo_resolucion_otro', 'plazo_revocatoria', 'plazo_revocatoria_otro')
ORDER BY ORDINAL_POSITION;

-- Script completado exitosamente
SELECT 'SCRIPT COMPLETADO - Se agregaron 3 campos a la tabla rsat_pa' AS resultado;
