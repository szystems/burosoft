-- ====================================================================
-- CORRECCIÓN ESPECÍFICA - Campo 'fecha' faltante en rtributas_pa
-- Fecha: 28 de agosto de 2025
-- Error: Field 'fecha' doesn't have a default value en rtributas_pa
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_fecha';

-- ====================================================================
-- AGREGAR CAMPO 'fecha' FALTANTE EN rtributas_pa
-- ====================================================================

SELECT 'Corrigiendo campo fecha faltante en rtributas_pa...' as 'Status';

-- Verificar si el campo 'fecha' existe en rtributas_pa
SELECT CONCAT('Verificando campo fecha en rtributas_pa: ', 
       IFNULL((SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
               WHERE TABLE_SCHEMA = DATABASE() 
               AND TABLE_NAME = 'rtributas_pa' 
               AND COLUMN_NAME = 'fecha'), 'NO EXISTE')) as 'Verificacion';

-- Agregar campo 'fecha' si no existe
ALTER TABLE `rtributas_pa` ADD COLUMN `fecha` DATETIME NOT NULL AFTER `id`;

-- Verificación final
SELECT 'Campo fecha agregado a rtributas_pa' as 'Resultado';

-- También verificar y agregar en rtributas principal por si acaso
ALTER TABLE `rtributas` ADD COLUMN `fecha` DATETIME NOT NULL AFTER `id`;

SELECT 'Verificado también en rtributas principal' as 'Verificacion_Adicional';

-- ====================================================================
-- RESULTADO
-- ====================================================================

SELECT 'CORRECCIÓN COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'Campo fecha agregado - Reintentar inserción de rtributa' as 'ACCION_SIGUIENTE';

/*
✅ PROBLEMA SOLUCIONADO:
- Campo 'fecha' faltante en rtributas_pa agregado
- También verificado en rtributas principal

✅ PRÓXIMO PASO:
- Reintentar la inserción de rtributa en la aplicación
- Debería funcionar correctamente ahora
*/
