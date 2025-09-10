-- ===================================================================
-- DIAGNÓSTICO: VERIFICAR PROBLEMA PA DESPUÉS DE ACTUALIZACIÓN DB
-- ===================================================================

-- 1. Verificar que todas las tablas PA existen
SELECT 'VERIFICANDO EXISTENCIA DE TABLAS PA:' as 'Diagnostico';

SELECT 
    TABLE_NAME,
    ENGINE,
    TABLE_ROWS
FROM information_schema.TABLES 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME IN ('audiencias_pa', 'dpmrs_pa', 'aceptacions_pa', 'resolucins_pa')
ORDER BY TABLE_NAME;

-- 2. Verificar foreign keys de audiencias_pa
SELECT 'FOREIGN KEYS audiencias_pa:' as 'Diagnostico';
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_NAME = 'audiencias_pa' 
AND TABLE_SCHEMA = 'dbburonuevo'
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- 3. Verificar foreign keys de dpmrs_pa
SELECT 'FOREIGN KEYS dpmrs_pa:' as 'Diagnostico';
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_NAME = 'dpmrs_pa' 
AND TABLE_SCHEMA = 'dbburonuevo'
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- 4. Verificar foreign keys de resolucins_pa
SELECT 'FOREIGN KEYS resolucins_pa:' as 'Diagnostico';
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_NAME = 'resolucins_pa' 
AND TABLE_SCHEMA = 'dbburonuevo'
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- 5. Probar consulta básica en audiencias_pa
SELECT 'PRUEBA CONSULTA audiencias_pa:' as 'Test';
SELECT COUNT(*) as 'total_audiencias_pa' FROM audiencias_pa;

-- 6. Verificar si hay problemas con ENUMs
SELECT 'VERIFICANDO ENUMs:' as 'Test';
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'audiencias_pa'
AND COLUMN_NAME IN ('tipo_audiencia', 'plazo_evacuar');

-- 7. Verificar tabla users (para foreign keys)
SELECT 'VERIFICANDO TABLA users:' as 'Test';
SELECT COUNT(*) as 'total_users' FROM users LIMIT 1;

-- 8. Verificar tabla empresas (para foreign keys)
SELECT 'VERIFICANDO TABLA empresas:' as 'Test';
SELECT COUNT(*) as 'total_empresas' FROM empresas LIMIT 1;
