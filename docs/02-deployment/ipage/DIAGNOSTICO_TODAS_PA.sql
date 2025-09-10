-- ===================================================================
-- DIAGNÓSTICO BÁSICO: VERIFICAR TODAS LAS TABLAS PA
-- ===================================================================

-- 1. Ver todas las tablas PA que existen
SHOW TABLES LIKE '%pa%';

-- 2. Verificar específicamente dpmrs_pa
DESCRIBE dpmrs_pa;

-- 3. Ver si existe en information_schema
SELECT 
    TABLE_NAME,
    ENGINE,
    TABLE_ROWS,
    CREATE_TIME
FROM 
    information_schema.TABLES 
WHERE 
    TABLE_SCHEMA = 'dbburonuevo' 
    AND TABLE_NAME = 'dpmrs_pa';

-- 4. Intentar ver todas las columnas de dpmrs_pa directamente
SELECT * FROM dpmrs_pa LIMIT 1;

-- 5. Ver qué base de datos estamos usando
SELECT DATABASE();

-- 6. Ver si la tabla tiene otro problema
SHOW CREATE TABLE dpmrs_pa;
