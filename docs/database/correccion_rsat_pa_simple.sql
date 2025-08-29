-- VERSIÓN SIMPLE - Solo comandos ALTER TABLE
-- Ejecutar estos comandos uno por uno en phpMyAdmin de iPage

-- 1. Agregar campo tipo_resolucion_otro
ALTER TABLE `rsat_pa` 
ADD COLUMN `tipo_resolucion_otro` VARCHAR(191) NULL DEFAULT NULL 
AFTER `tipo_resolucion`;

-- 2. Agregar campo plazo_revocatoria  
ALTER TABLE `rsat_pa` 
ADD COLUMN `plazo_revocatoria` VARCHAR(191) NULL DEFAULT NULL 
AFTER `tipo_resolucion_otro`;

-- 3. Agregar campo plazo_revocatoria_otro
ALTER TABLE `rsat_pa` 
ADD COLUMN `plazo_revocatoria_otro` VARCHAR(191) NULL DEFAULT NULL 
AFTER `plazo_revocatoria`;

-- Verificar que se agregaron correctamente
DESCRIBE `rsat_pa`;
