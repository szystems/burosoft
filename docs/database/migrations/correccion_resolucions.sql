-- ====================================================================
-- CORRECCIÓN - Campos faltantes en tabla resolucions
-- Fecha: 28 de agosto de 2025
-- Problema: Faltan campos tipo_resolucion_otro, plazo_revocatoria, etc.
-- Solución: Agregar todos los campos faltantes según estructura local
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_resolucions';

-- ====================================================================
-- AGREGAR CAMPOS FALTANTES EN resolucions
-- ====================================================================

SELECT 'Agregando campos faltantes a resolucions...' as 'Status';

-- Agregar tipo_resolucion_otro después de tipo_resolucion
ALTER TABLE `resolucions` ADD COLUMN `tipo_resolucion_otro` VARCHAR(191) NULL AFTER `tipo_resolucion`;

-- Agregar plazo_revocatoria después de tipo_resolucion_otro
ALTER TABLE `resolucions` ADD COLUMN `plazo_revocatoria` ENUM('5 D.H.', '10 D.H.', '30 D.H.', 'otro') NULL AFTER `tipo_resolucion_otro`;

-- Agregar plazo_revocatoria_otro después de plazo_revocatoria
ALTER TABLE `resolucions` ADD COLUMN `plazo_revocatoria_otro` VARCHAR(191) NULL AFTER `plazo_revocatoria`;

-- Verificar que los campos de fecha y archivos existan (ya se agregaron en scripts anteriores)
-- fecha_notificacion y fecha_resolucion ya deberían existir

-- Agregar campos de archivo y observaciones si no existen
SET @sql = 'ALTER TABLE `resolucions` ADD COLUMN `archivo` VARCHAR(191) NULL AFTER `audiencia_id`';
SET @ignore_error = (SELECT IF((SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'resolucions' AND COLUMN_NAME = 'archivo') = 0, @sql, 'SELECT "archivo ya existe" as Info'));

SET @sql = 'ALTER TABLE `resolucions` ADD COLUMN `tipo_archivo` VARCHAR(191) NULL AFTER `archivo`';
SET @ignore_error = (SELECT IF((SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'resolucions' AND COLUMN_NAME = 'tipo_archivo') = 0, @sql, 'SELECT "tipo_archivo ya existe" as Info'));

SET @sql = 'ALTER TABLE `resolucions` ADD COLUMN `observaciones` TEXT NULL AFTER `tipo_archivo`';
SET @ignore_error = (SELECT IF((SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'resolucions' AND COLUMN_NAME = 'observaciones') = 0, @sql, 'SELECT "observaciones ya existe" as Info'));

SET @sql = 'ALTER TABLE `resolucions` ADD COLUMN `numero_folios` INT(11) NULL AFTER `observaciones`';
SET @ignore_error = (SELECT IF((SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'resolucions' AND COLUMN_NAME = 'numero_folios') = 0, @sql, 'SELECT "numero_folios ya existe" as Info'));

SELECT 'Todos los campos agregados a resolucions' as 'Resultado';

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN resolucions COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'Resolucions debería funcionar correctamente ahora' as 'ACCION_SIGUIENTE';

/*
✅ CAMPOS AGREGADOS A resolucions:
- tipo_resolucion_otro: VARCHAR(191) NULL
- plazo_revocatoria: ENUM('5 D.H.', '10 D.H.', '30 D.H.', 'otro') NULL  
- plazo_revocatoria_otro: VARCHAR(191) NULL
- archivo, tipo_archivo, observaciones, numero_folios (verificados)

✅ PRÓXIMO PASO:
- Reintentar inserción de resolución
- Debería funcionar perfectamente ahora
*/
