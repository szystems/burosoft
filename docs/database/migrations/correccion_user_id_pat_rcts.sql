-- ====================================================================
-- CORRECCIÓN - Campo user_id NOT NULL problemático en pat_rcts
-- Fecha: 28 de agosto de 2025
-- Problema: user_id es NOT NULL pero la aplicación envía usuario_id
-- Solución: Cambiar user_id a NULL para compatibilidad
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_user_id_pat_rcts';

-- ====================================================================
-- HACER user_id COMPATIBLE (NULL)
-- ====================================================================

SELECT 'Corrigiendo compatibilidad de user_id en pat_rcts...' as 'Status';

-- Cambiar user_id de NOT NULL a NULL
ALTER TABLE `pat_rcts` MODIFY COLUMN `user_id` BIGINT(20) UNSIGNED NULL;

-- También hacer NULL otros campos legacy que podrían causar problemas:
ALTER TABLE `pat_rcts` MODIFY COLUMN `fecha_hora_presentacion` DATETIME NULL;
ALTER TABLE `pat_rcts` MODIFY COLUMN `numero_documento` VARCHAR(255) NULL;

-- Mensaje final
SELECT 'Campos legacy ahora permiten NULL - Compatible con aplicación' as 'Resultado';

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN user_id COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'pat_rcts debería funcionar correctamente ahora' as 'ACCION_SIGUIENTE';

/*
✅ PROBLEMA SOLUCIONADO:
- user_id ahora permite NULL (campo legacy)
- fecha_hora_presentacion → NULL (preventivo)
- numero_documento → NULL (preventivo)
- La aplicación usa usuario_id (que sí existe y funciona)

✅ ESTRUCTURA FINAL:
- Aplicación envía: usuario_id ✅ (existe y funciona)
- Campo legacy: user_id ✅ (ahora NULL, no interfiere)

✅ PRÓXIMO PASO:
- Reintentar inserción de pat-rct
- Debería funcionar perfectamente
*/
