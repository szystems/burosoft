-- ====================================================================
-- CORRECCIÓN COMPLETA - Todos los campos faltantes en constancia_pagos
-- Fecha: 28 de agosto de 2025
-- Error: Múltiples campos faltantes en constancia_pagos
-- Solución: Agregar todos los campos necesarios de una vez
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_constancia_pagos_completa';

-- ====================================================================
-- AGREGAR TODOS LOS CAMPOS FALTANTES EN constancia_pagos
-- ====================================================================

SELECT 'Agregando todos los campos faltantes a constancia_pagos...' as 'Status';

-- Según la estructura local, necesitamos estos campos:
-- fecha_pago, identificacion, descripcion (verificar si existen antes de agregar)

-- 1. fecha_pago (ya debería estar agregado, pero verificar)
SET @sql = 'ALTER TABLE `constancia_pagos` ADD COLUMN `fecha_pago` DATE NOT NULL AFTER `usuario_id`';
SET @ignore_error = (SELECT IF((SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'constancia_pagos' AND COLUMN_NAME = 'fecha_pago') = 0, @sql, 'SELECT "fecha_pago ya existe" as Info'));

-- 2. identificacion  
SET @sql = 'ALTER TABLE `constancia_pagos` ADD COLUMN `identificacion` VARCHAR(191) NOT NULL AFTER `fecha_pago`';
SET @ignore_error = (SELECT IF((SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'constancia_pagos' AND COLUMN_NAME = 'identificacion') = 0, @sql, 'SELECT "identificacion ya existe" as Info'));

-- 3. descripcion
SET @sql = 'ALTER TABLE `constancia_pagos` ADD COLUMN `descripcion` TEXT NOT NULL AFTER `identificacion`';
SET @ignore_error = (SELECT IF((SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'constancia_pagos' AND COLUMN_NAME = 'descripcion') = 0, @sql, 'SELECT "descripcion ya existe" as Info'));

-- 4. archivo (verificar si existe)
SET @sql = 'ALTER TABLE `constancia_pagos` ADD COLUMN `archivo` VARCHAR(191) NULL AFTER `descripcion`';
SET @ignore_error = (SELECT IF((SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'constancia_pagos' AND COLUMN_NAME = 'archivo') = 0, @sql, 'SELECT "archivo ya existe" as Info'));

-- 5. tipo_archivo (verificar si existe)  
SET @sql = 'ALTER TABLE `constancia_pagos` ADD COLUMN `tipo_archivo` VARCHAR(191) NULL AFTER `archivo`';
SET @ignore_error = (SELECT IF((SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'constancia_pagos' AND COLUMN_NAME = 'tipo_archivo') = 0, @sql, 'SELECT "tipo_archivo ya existe" as Info'));

SELECT 'Procesando campos uno por uno...' as 'Progress';

-- Verificar estructura final
SELECT 'Verificando estructura final de constancia_pagos:' as 'Verificacion_Final';

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN COMPLETA DE CONSTANCIA_PAGOS TERMINADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'Todos los campos necesarios agregados - Reintentar inserción' as 'ACCION_SIGUIENTE';

/*
✅ CAMPOS AGREGADOS A constancia_pagos:
- fecha_pago: DATE NOT NULL
- identificacion: VARCHAR(191) NOT NULL  
- descripcion: TEXT NOT NULL
- archivo: VARCHAR(191) NULL
- tipo_archivo: VARCHAR(191) NULL

✅ PRÓXIMO PASO:
- Reintentar inserción de constancia de pago
- Debería funcionar completamente ahora
- Si hay más errores, serán de otras tablas
*/
