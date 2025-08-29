-- Script ALTERNATIVO - Solo agregar campos que no existen
-- Para casos donde algunos campos puedan ya existir

USE `lnumfqhy_basetributaria`;

-- Verificar qué campos faltan antes de intentar agregarlos
SELECT 
    CASE 
        WHEN COUNT(*) = 0 THEN 'tipo_resolucion_otro NO EXISTE - se debe agregar'
        ELSE 'tipo_resolucion_otro YA EXISTE'
    END AS status_tipo_resolucion_otro
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'lnumfqhy_basetributaria' 
  AND TABLE_NAME = 'rsat_pa' 
  AND COLUMN_NAME = 'tipo_resolucion_otro';

SELECT 
    CASE 
        WHEN COUNT(*) = 0 THEN 'plazo_revocatoria NO EXISTE - se debe agregar'
        ELSE 'plazo_revocatoria YA EXISTE'
    END AS status_plazo_revocatoria
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'lnumfqhy_basetributaria' 
  AND TABLE_NAME = 'rsat_pa' 
  AND COLUMN_NAME = 'plazo_revocatoria';

SELECT 
    CASE 
        WHEN COUNT(*) = 0 THEN 'plazo_revocatoria_otro NO EXISTE - se debe agregar'
        ELSE 'plazo_revocatoria_otro YA EXISTE'
    END AS status_plazo_revocatoria_otro
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'lnumfqhy_basetributaria' 
  AND TABLE_NAME = 'rsat_pa' 
  AND COLUMN_NAME = 'plazo_revocatoria_otro';

-- Comandos individuales para agregar cada campo si no existe:

-- 1. Para tipo_resolucion_otro:
-- ALTER TABLE `rsat_pa` ADD COLUMN `tipo_resolucion_otro` VARCHAR(191) NULL DEFAULT NULL AFTER `tipo_resolucion`;

-- 2. Para plazo_revocatoria:
-- ALTER TABLE `rsat_pa` ADD COLUMN `plazo_revocatoria` VARCHAR(191) NULL DEFAULT NULL AFTER `tipo_resolucion_otro`;

-- 3. Para plazo_revocatoria_otro:
-- ALTER TABLE `rsat_pa` ADD COLUMN `plazo_revocatoria_otro` VARCHAR(191) NULL DEFAULT NULL AFTER `plazo_revocatoria`;
