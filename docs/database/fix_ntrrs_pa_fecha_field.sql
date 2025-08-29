-- CORRECCIÓN PARA EL CAMPO fecha en ntrrs_pa
-- El campo fecha es NOT NULL pero no tiene valor por defecto
-- Opción 1: Hacer el campo fecha NULLABLE (recomendado)

ALTER TABLE `ntrrs_pa` 
MODIFY COLUMN `fecha` DATE NULL DEFAULT NULL;

-- Opción 2: Dar un valor por defecto al campo fecha (alternativa)
-- ALTER TABLE `ntrrs_pa` 
-- MODIFY COLUMN `fecha` DATE NOT NULL DEFAULT '2025-01-01';

-- Verificar el cambio
DESCRIBE `ntrrs_pa`;
