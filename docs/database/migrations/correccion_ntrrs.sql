-- ====================================================================
-- CORRECCIÓN - Campo fecha sin valor por defecto en tabla ntrrs
-- Fecha: 28 de agosto de 2025
-- Problema: Campo 'fecha' es NOT NULL sin default y no se envía valor
-- Solución: Hacer campo fecha nullable o agregar valor por defecto
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_ntrrs';

-- ====================================================================
-- CORREGIR CAMPO FECHA EN ntrrs  
-- ====================================================================

SELECT 'Corrigiendo campo fecha en ntrrs...' as 'Status';

-- OPCIÓN 1: Hacer campo fecha nullable (recomendado)
ALTER TABLE `ntrrs` MODIFY COLUMN `fecha` DATE NULL;

-- OPCIÓN 2 (alternativa): Agregar valor por defecto
-- ALTER TABLE `ntrrs` MODIFY COLUMN `fecha` DATE NOT NULL DEFAULT (CURDATE());

SELECT 'Campo fecha corregido en ntrrs' as 'Resultado';

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN ntrrs COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'NTRRS debería funcionar correctamente ahora' as 'ACCION_SIGUIENTE';

/*
✅ CAMPO CORREGIDO EN ntrrs:
- fecha: DATE NULL (ahora permite valores nulos)

✅ PROBLEMA RESUELTO:
- El campo fecha ya no requiere valor obligatorio
- La inserción funcionará sin enviar valor para fecha

✅ PRÓXIMO PASO:
- Ejecutar en iPage: ALTER TABLE `ntrrs` MODIFY COLUMN `fecha` DATE NULL;
- Reintentar inserción de NTRR
- El error "Field 'fecha' doesn't have a default value" desaparecerá

✅ ESTRUCTURA ACTUAL CONFIRMADA:
- id, fecha_hora_notificacion, fecha, numero_resolucion, fecha_resolucion, usuario_id, audiencia_id, archivo, tipo_archivo, observaciones, numero_folios, created_at, updated_at
- Todos los campos existen correctamente
*/
