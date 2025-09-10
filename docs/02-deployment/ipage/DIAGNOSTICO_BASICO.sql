-- ===================================================================
-- DIAGNÓSTICO BÁSICO: VERIFICAR EXISTENCIA DE TABLAS PA
-- ===================================================================

-- 1. Ver todas las tablas que contienen 'pa' en el nombre
SHOW TABLES LIKE '%pa%';

-- 2. Ver todas las tablas en la base de datos
SHOW TABLES;

-- 3. Intentar describir directamente la tabla
DESCRIBE audiencias_pa;

-- 4. Verificar si existe en information_schema
SELECT 
    TABLE_NAME,
    ENGINE,
    TABLE_ROWS,
    CREATE_TIME
FROM 
    information_schema.TABLES 
WHERE 
    TABLE_SCHEMA = 'dbburonuevo' 
    AND TABLE_NAME LIKE '%pa%';

-- 5. Ver si la tabla existe pero tiene otro nombre
SELECT 
    TABLE_NAME
FROM 
    information_schema.TABLES 
WHERE 
    TABLE_SCHEMA = 'dbburonuevo' 
    AND TABLE_NAME LIKE '%audiencia%';

-- 6. Verificar base de datos actual
SELECT DATABASE();
