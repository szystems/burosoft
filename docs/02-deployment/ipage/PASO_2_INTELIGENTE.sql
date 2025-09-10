-- ===================================================================
-- PASO 2 INTELIGENTE: ACTUALIZAR dpmrs_pa (VERIFICA ANTES DE AGREGAR)
-- ===================================================================

-- Verificar estructura actual
DESCRIBE dpmrs_pa;

-- 1. Agregar columnas SOLO si no existen (usar IF NOT EXISTS logic)

-- Verificar si numero_resolucion existe
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists 
FROM information_schema.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'dpmrs_pa' 
AND COLUMN_NAME = 'numero_resolucion';

-- Agregar numero_resolucion solo si no existe
SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE `dpmrs_pa` ADD COLUMN `numero_resolucion` varchar(191) NOT NULL DEFAULT '''' AFTER `id`', 
    'SELECT ''Columna numero_resolucion ya existe'' as Info');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Verificar si fecha_hora existe
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists 
FROM information_schema.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'dpmrs_pa' 
AND COLUMN_NAME = 'fecha_hora';

-- Agregar fecha_hora solo si no existe
SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE `dpmrs_pa` ADD COLUMN `fecha_hora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `numero_resolucion`', 
    'SELECT ''Columna fecha_hora ya existe'' as Info');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Verificar si usuario_id existe
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists 
FROM information_schema.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'dpmrs_pa' 
AND COLUMN_NAME = 'usuario_id';

-- Agregar usuario_id solo si no existe
SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE `dpmrs_pa` ADD COLUMN `usuario_id` bigint(20) unsigned NOT NULL DEFAULT 1 AFTER `fecha_hora`', 
    'SELECT ''Columna usuario_id ya existe'' as Info');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Verificar si audiencia_pa_id existe
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists 
FROM information_schema.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'dpmrs_pa' 
AND COLUMN_NAME = 'audiencia_pa_id';

-- Agregar audiencia_pa_id solo si no existe
SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE `dpmrs_pa` ADD COLUMN `audiencia_pa_id` bigint(20) unsigned NOT NULL DEFAULT 1 AFTER `usuario_id`', 
    'SELECT ''Columna audiencia_pa_id ya existe'' as Info');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Continuar con las demás columnas...
-- (Se mostrará la estructura final al final)

-- Verificar estructura final
DESCRIBE dpmrs_pa;
