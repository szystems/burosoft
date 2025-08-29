-- VERSIÓN SÚPER SIMPLE - SOLO ALTER TABLE para ntrrs_pa
-- Ejecutar estos comandos UNO POR UNO en phpMyAdmin

ALTER TABLE `ntrrs_pa` 
ADD COLUMN `fecha_hora_notificacion` DATETIME NOT NULL 
AFTER `id`;

ALTER TABLE `ntrrs_pa` 
ADD COLUMN `fecha_resolucion` DATE NULL 
AFTER `numero_resolucion`;

UPDATE `ntrrs_pa` 
SET `fecha_hora_notificacion` = TIMESTAMP(fecha, '00:00:00');

DESCRIBE `ntrrs_pa`;
