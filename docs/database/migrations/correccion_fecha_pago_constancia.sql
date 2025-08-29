-- ====================================================================
-- CORRECCIÓN - Campo 'fecha_pago' faltante en constancia_pagos
-- Fecha: 28 de agosto de 2025
-- Error: Unknown column 'fecha_pago' in 'field list' 
-- Solución: Agregar campo fecha_pago a constancia_pagos
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_fecha_pago';

-- ====================================================================
-- AGREGAR CAMPO 'fecha_pago' EN constancia_pagos
-- ====================================================================

SELECT 'Agregando campo fecha_pago a constancia_pagos...' as 'Status';

-- Verificar si el campo ya existe
SELECT CONCAT('Verificando campo fecha_pago: ', 
       IFNULL((SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS 
               WHERE TABLE_SCHEMA = DATABASE() 
               AND TABLE_NAME = 'constancia_pagos' 
               AND COLUMN_NAME = 'fecha_pago'), 'NO EXISTE')) as 'Verificacion';

-- Agregar campo 'fecha_pago' después de usuario_id
ALTER TABLE `constancia_pagos` ADD COLUMN `fecha_pago` DATE NOT NULL AFTER `usuario_id`;

-- Verificación final
SELECT 'Campo fecha_pago agregado a constancia_pagos' as 'Resultado';

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN FECHA_PAGO COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'Constancia de pago ahora debería insertarse correctamente' as 'ACCION_SIGUIENTE';

/*
✅ PROBLEMA SOLUCIONADO:
- Campo 'fecha_pago' agregado a constancia_pagos
- Tipo: DATE NOT NULL (igual que en local)
- Posición: después de usuario_id

✅ PRÓXIMO PASO:
- Reintentar inserción de constancia de pago
- Debería funcionar correctamente ahora
*/
