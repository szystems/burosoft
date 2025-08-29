-- ====================================================================
-- CORRECCIÓN ADICIONAL - IPAGE 
-- Fecha: 28 de agosto de 2025
-- Error: Field 'fecha_hora_aceptacion' doesn't have a default value
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_2';

-- ====================================================================
-- CORRECCIÓN: PERMITIR NULL EN fecha_hora_aceptacion
-- ====================================================================

SELECT 'APLICANDO CORRECCIÓN ADICIONAL...' as 'Status';

-- Cambiar fecha_hora_aceptacion para permitir NULL
ALTER TABLE `aceptacions` MODIFY COLUMN `fecha_hora_aceptacion` DATETIME NULL;
ALTER TABLE `aceptacions_pa` MODIFY COLUMN `fecha_hora_aceptacion` DATETIME NULL;

SELECT '✅ fecha_hora_aceptacion ahora permite NULL' as 'Status_1';

-- ====================================================================
-- VERIFICACIÓN FINAL
-- ====================================================================

DESCRIBE `aceptacions`;

SELECT 'SEGUNDA CORRECCIÓN COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';

/*
✅ PROBLEMA ADICIONAL SOLUCIONADO:
- Error: Field 'fecha_hora_aceptacion' doesn't have a default value
- Solución: Permitir NULL en fecha_hora_aceptacion

✅ AHORA LA APLICACIÓN DEBERÍA FUNCIONAR:
- fecha_hora_presentacion: Se envía desde la aplicación ✅
- fecha_hora_aceptacion: Ahora puede ser NULL ✅
*/
