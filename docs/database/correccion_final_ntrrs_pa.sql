-- CORRECCIÓN ESPECÍFICA PARA ntrrs_pa
-- Fecha: 29 de agosto de 2025
-- Ejecutar estos comandos uno por uno:

-- 1. Agregar fecha_hora_notificacion (REQUERIDO por el formulario)
ALTER TABLE `ntrrs_pa` 
ADD COLUMN `fecha_hora_notificacion` DATETIME NOT NULL 
AFTER `id`;

-- 2. Agregar fecha_resolucion (OPCIONAL, para completar funcionalidad)
ALTER TABLE `ntrrs_pa` 
ADD COLUMN `fecha_resolucion` DATE NULL 
AFTER `numero_resolucion`;

-- 3. Migrar datos existentes del campo fecha a fecha_hora_notificacion
UPDATE `ntrrs_pa` 
SET `fecha_hora_notificacion` = TIMESTAMP(fecha, '00:00:00') 
WHERE `fecha_hora_notificacion` IS NULL OR `fecha_hora_notificacion` = '0000-00-00 00:00:00';

-- 4. Verificar que se agregaron correctamente
DESCRIBE `ntrrs_pa`;

-- 5. Confirmar que los nuevos campos están presentes
SELECT 'NUEVOS CAMPOS EN NTRRS_PA:' AS info;
SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'ntrrs_pa' 
  AND COLUMN_NAME IN ('fecha_hora_notificacion', 'fecha_resolucion')
ORDER BY ORDINAL_POSITION;
