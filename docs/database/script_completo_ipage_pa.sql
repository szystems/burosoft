-- SCRIPT COMPLETO PARA IPAGE - CORRECCIÓN DE TABLAS PA
-- Fecha: 29 de agosto de 2025
-- Propósito: Agregar todos los campos faltantes en las tablas PA de iPage
-- INSTRUCCIONES: Copiar y pegar TODO este script en phpMyAdmin de iPage

-- ========================================
-- 1. TABLA rsat_pa - Campos para funcionalidad "Otro"
-- ========================================

-- Agregar campo tipo_resolucion_otro
ALTER TABLE `rsat_pa` 
ADD COLUMN `tipo_resolucion_otro` VARCHAR(191) NULL DEFAULT NULL 
AFTER `tipo_resolucion`;

-- Agregar campo plazo_revocatoria
ALTER TABLE `rsat_pa` 
ADD COLUMN `plazo_revocatoria` VARCHAR(191) NULL DEFAULT NULL 
AFTER `tipo_resolucion_otro`;

-- Agregar campo plazo_revocatoria_otro
ALTER TABLE `rsat_pa` 
ADD COLUMN `plazo_revocatoria_otro` VARCHAR(191) NULL DEFAULT NULL 
AFTER `plazo_revocatoria`;

-- ========================================
-- 2. TABLA ntrrs_pa - Campos de migraciones del 26 de agosto
-- ========================================

-- Agregar fecha_hora_notificacion
ALTER TABLE `ntrrs_pa` 
ADD COLUMN `fecha_hora_notificacion` DATETIME NOT NULL 
AFTER `idPrimaria`;

-- Agregar fecha_resolucion
ALTER TABLE `ntrrs_pa` 
ADD COLUMN `fecha_resolucion` DATE NULL 
AFTER `numero_resolucion`;

-- Migrar datos del campo fecha existente a fecha_hora_notificacion
UPDATE `ntrrs_pa` 
SET `fecha_hora_notificacion` = TIMESTAMP(fecha, '00:00:00') 
WHERE `fecha_hora_notificacion` IS NULL OR `fecha_hora_notificacion` = '0000-00-00 00:00:00';

-- ========================================
-- 3. VERIFICACIÓN DE ESTRUCTURAS
-- ========================================

-- Verificar estructura de rsat_pa
SELECT 'ESTRUCTURA RSAT_PA ACTUALIZADA:' AS info;
DESCRIBE `rsat_pa`;

-- Verificar estructura de ntrrs_pa  
SELECT 'ESTRUCTURA NTRRS_PA ACTUALIZADA:' AS info;
DESCRIBE `ntrrs_pa`;

-- ========================================
-- 4. VERIFICACIÓN DE CAMPOS ESPECÍFICOS
-- ========================================

-- Verificar campos agregados en rsat_pa
SELECT 'CAMPOS NUEVOS EN RSAT_PA:' AS info;
SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'rsat_pa' 
  AND COLUMN_NAME IN ('tipo_resolucion_otro', 'plazo_revocatoria', 'plazo_revocatoria_otro')
ORDER BY ORDINAL_POSITION;

-- Verificar campos agregados en ntrrs_pa
SELECT 'CAMPOS NUEVOS EN NTRRS_PA:' AS info;
SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'ntrrs_pa' 
  AND COLUMN_NAME IN ('fecha_hora_notificacion', 'fecha_resolucion')
ORDER BY ORDINAL_POSITION;

-- ========================================
-- SCRIPT COMPLETADO
-- ========================================

SELECT 'SCRIPT COMPLETADO EXITOSAMENTE!' AS resultado;
SELECT 'Tablas corregidas: rsat_pa, ntrrs_pa' AS tablas;
SELECT 'Total de campos agregados: 5' AS campos_agregados;
