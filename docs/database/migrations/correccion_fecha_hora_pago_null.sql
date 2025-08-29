-- ====================================================================
-- CORRECCIÓN - Campo fecha_hora_pago incompatible en constancia_pagos
-- Fecha: 28 de agosto de 2025
-- Problema: Campo fecha_hora_pago es NOT NULL en iPage pero no se envía
-- Solución: Cambiar a NULL para compatibilidad
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_fecha_hora_pago';

-- ====================================================================
-- HACER fecha_hora_pago COMPATIBLE (NULL)
-- ====================================================================

SELECT 'Corrigiendo compatibilidad de fecha_hora_pago...' as 'Status';

-- Cambiar fecha_hora_pago de NOT NULL a NULL
ALTER TABLE `constancia_pagos` MODIFY COLUMN `fecha_hora_pago` DATETIME NULL;

-- Mensaje final
SELECT 'Campo fecha_hora_pago ahora permite NULL - Compatible con aplicación' as 'Resultado';

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN fecha_hora_pago COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'Constancia de pago debería insertarse correctamente ahora' as 'ACCION_SIGUIENTE';

/*
✅ PROBLEMA SOLUCIONADO:
- fecha_hora_pago ahora permite NULL
- Compatible con aplicación que no envía este campo
- Local solo tiene fecha_pago, iPage tiene ambos

✅ PRÓXIMO PASO:
- Reintentar inserción de constancia de pago
- Debería funcionar perfectamente
*/
