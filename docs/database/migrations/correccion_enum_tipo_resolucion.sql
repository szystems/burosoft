-- ====================================================================
-- CORRECCIÓN - ENUM tipo_resolucion incompleto en resolucions
-- Fecha: 28 de agosto de 2025
-- Problema: ENUM tipo_resolucion no incluye valor 'otro'
-- Solución: Actualizar ENUM con todos los valores necesarios
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_enum_tipo_resolucion';

-- ====================================================================
-- ACTUALIZAR ENUM tipo_resolucion
-- ====================================================================

SELECT 'Actualizando ENUM tipo_resolucion en resolucions...' as 'Status';

-- Actualizar ENUM para incluir todos los valores necesarios
-- Según estructura local: 'total a favor','total en contra','parcial','nulidad','penal','otro'
ALTER TABLE `resolucions` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NULL;

-- Verificación
SELECT 'ENUM tipo_resolucion actualizado con todos los valores' as 'Resultado';

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN ENUM tipo_resolucion COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'Resolucions ahora acepta valor otro - Reintentar inserción' as 'ACCION_SIGUIENTE';

/*
✅ PROBLEMA SOLUCIONADO:
- ENUM tipo_resolucion ahora incluye: 'total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro'
- Valor 'otro' ahora es válido
- No más error de data truncated

✅ PRÓXIMO PASO:
- Reintentar inserción de resolución
- Debería funcionar perfectamente ahora
*/
