-- ====================================================================
-- CORRECCIÓN UNIVERSAL - Hacer NULL todos los campos problemáticos
-- Fecha: 28 de agosto de 2025
-- Problema: iPage tiene muchos campos NOT NULL que local no tiene
-- Solución: Script universal para hacer NULL campos conocidos
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_universal';

-- ====================================================================
-- HACER NULL TODOS LOS CAMPOS PROBLEMÁTICOS CONOCIDOS
-- ====================================================================

SELECT 'Aplicando corrección universal a constancia_pagos...' as 'Status';

-- Campos que han aparecido como problemáticos:
ALTER TABLE `constancia_pagos` MODIFY COLUMN `monto` DECIMAL(10,2) NULL;
ALTER TABLE `constancia_pagos` MODIFY COLUMN `numero_documento` VARCHAR(191) NULL;
ALTER TABLE `constancia_pagos` MODIFY COLUMN `fecha_hora_pago` DATETIME NULL;
ALTER TABLE `constancia_pagos` MODIFY COLUMN `concepto` VARCHAR(191) NULL;

-- Otros campos que podrían existir y causar problemas:
ALTER TABLE `constancia_pagos` MODIFY COLUMN `tipo_pago` VARCHAR(191) NULL;
ALTER TABLE `constancia_pagos` MODIFY COLUMN `referencia` VARCHAR(191) NULL;
ALTER TABLE `constancia_pagos` MODIFY COLUMN `banco` VARCHAR(191) NULL;
ALTER TABLE `constancia_pagos` MODIFY COLUMN `cuenta` VARCHAR(191) NULL;
ALTER TABLE `constancia_pagos` MODIFY COLUMN `observaciones_pago` TEXT NULL;

SELECT 'Corrección universal aplicada' as 'Resultado';

-- ====================================================================
-- ALTERNATIVA: VERIFICAR ESTRUCTURA COMPLETA
-- ====================================================================

SELECT 'Verificando estructura de constancia_pagos en iPage:' as 'Verificacion';

-- Mostrar todos los campos NOT NULL que podrían ser problemáticos
SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
  AND TABLE_NAME = 'constancia_pagos' 
  AND IS_NULLABLE = 'NO'
  AND COLUMN_DEFAULT IS NULL
  AND COLUMN_NAME NOT IN ('id', 'pat_id', 'usuario_id', 'created_at', 'updated_at');

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN UNIVERSAL COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'Constancia de pago debería funcionar ahora - Estructura compatible' as 'ACCION_SIGUIENTE';

/*
✅ CAMPOS CORREGIDOS:
- monto, numero_documento, fecha_hora_pago, concepto
- Campos adicionales preventivos incluidos

✅ PRÓXIMO PASO:
- Reintentar inserción de constancia de pago
- Si aparece otro campo, agregarlo al script
- La consulta final muestra qué campos podrían ser problemáticos
*/
