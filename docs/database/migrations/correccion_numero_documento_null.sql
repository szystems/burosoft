-- ====================================================================
-- CORRECCIÓN - Campo numero_documento incompatible en constancia_pagos
-- Fecha: 28 de agosto de 2025
-- Problema: Campo numero_documento es NOT NULL en iPage pero no se envía
-- Solución: Cambiar a NULL para compatibilidad
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_numero_documento';

-- ====================================================================
-- HACER numero_documento COMPATIBLE (NULL)
-- ====================================================================

SELECT 'Corrigiendo compatibilidad de numero_documento...' as 'Status';

-- Cambiar numero_documento de NOT NULL a NULL
ALTER TABLE `constancia_pagos` MODIFY COLUMN `numero_documento` VARCHAR(191) NULL;

-- Mensaje final
SELECT 'Campo numero_documento ahora permite NULL - Compatible con aplicación' as 'Resultado';

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN numero_documento COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'Constancia de pago debería funcionar completamente ahora' as 'ACCION_SIGUIENTE';

/*
✅ PROBLEMA SOLUCIONADO:
- numero_documento ahora permite NULL
- Compatible con aplicación que no envía este campo
- Local no tiene numero_documento, iPage sí

✅ PATRÓN IDENTIFICADO:
iPage tiene campos adicionales NOT NULL que local no tiene:
- fecha_hora_pago → SOLUCIONADO (NULL)
- numero_documento → EN PROCESO (NULL)

✅ PRÓXIMO PASO:
- Reintentar inserción de constancia de pago
- Si hay más campos similares, aplicar el mismo patrón
*/
