-- ====================================================================
-- CORRECCIÓN FINAL - Agregar campo numero_folios faltante
-- Fecha: 28 de agosto de 2025
-- Problema: Falta campo numero_folios en tabla nulidades
-- Solución: Agregar campo faltante de la migración original
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_nulidades_numero_folios';

-- ====================================================================
-- AGREGAR CAMPO FALTANTE nulidades
-- ====================================================================

SELECT 'Agregando campo numero_folios a nulidades...' as 'Status';

-- Agregar campo numero_folios que falta de la migración original
ALTER TABLE `nulidades` ADD COLUMN `numero_folios` INT(11) NULL AFTER `tipo_nulidad`;

SELECT 'Campo numero_folios agregado a nulidades' as 'Resultado';

-- Verificar estructura final
SELECT 'Verificando estructura final...' as 'Status_final';
DESCRIBE `nulidades`;

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN nulidades COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'Nulidades debería funcionar correctamente ahora' as 'ACCION_SIGUIENTE';

/*
✅ CAMPO AGREGADO A nulidades:
- numero_folios: INT(11) NULL (después de tipo_nulidad)

✅ ESTRUCTURA FINAL COMPLETA:
- id ✅
- audiencia_id ✅
- usuario_id ✅
- fecha_hora_notificacion ✅
- numero_resolucion ✅
- fecha_resolucion ✅
- archivo ✅
- tipo_archivo ✅
- observaciones ✅
- tipo_nulidad ✅
- numero_folios ✅ (recién agregado)
- created_at ✅
- updated_at ✅

✅ PRÓXIMO PASO:
- Ejecutar: ALTER TABLE `nulidades` ADD COLUMN `numero_folios` INT(11) NULL AFTER `tipo_nulidad`;
- Reintentar inserción de Nulidad
- Ahora debería funcionar perfectamente

✅ NOTA:
- Este campo faltaba de la migración original 2025_05_26_000001
- Era el último campo faltante
- Después de esto la tabla estará completamente sincronizada
*/
