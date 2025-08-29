-- COMANDOS INDIVIDUALES PARA AGREGAR SOLO SI NO EXISTE
-- Ejecutar SOLO los comandos para campos que NO aparecieron en la verificación

-- ========================================
-- PARA RSAT_PA - Ejecutar solo los que falten:
-- ========================================

-- Solo SI tipo_resolucion_otro NO existe:
-- ALTER TABLE `rsat_pa` ADD COLUMN `tipo_resolucion_otro` VARCHAR(191) NULL DEFAULT NULL AFTER `tipo_resolucion`;

-- Solo SI plazo_revocatoria NO existe:
-- ALTER TABLE `rsat_pa` ADD COLUMN `plazo_revocatoria` VARCHAR(191) NULL DEFAULT NULL AFTER `tipo_resolucion_otro`;

-- Solo SI plazo_revocatoria_otro NO existe:
-- ALTER TABLE `rsat_pa` ADD COLUMN `plazo_revocatoria_otro` VARCHAR(191) NULL DEFAULT NULL AFTER `plazo_revocatoria`;

-- ========================================
-- PARA NTRRS_PA - Ejecutar solo los que falten:
-- ========================================

-- Solo SI fecha_hora_notificacion NO existe:
-- ALTER TABLE `ntrrs_pa` ADD COLUMN `fecha_hora_notificacion` DATETIME NOT NULL AFTER `idPrimaria`;

-- Solo SI fecha_resolucion NO existe:
-- ALTER TABLE `ntrrs_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;

-- Solo SI fecha_hora_notificacion existe PERO tiene datos NULL y campo fecha existe:
-- UPDATE `ntrrs_pa` SET `fecha_hora_notificacion` = TIMESTAMP(fecha, '00:00:00') WHERE `fecha_hora_notificacion` IS NULL;

-- ========================================
-- VERIFICACIÓN FINAL
-- ========================================

-- Ejecutar al final para confirmar:
-- DESCRIBE `rsat_pa`;
-- DESCRIBE `ntrrs_pa`;
