-- ===================================================================
-- DIAGNÓSTICO: VERIFICAR ESTRUCTURA ACTUAL dpmrs_pa
-- ===================================================================

-- Ver qué columnas ya tiene dpmrs_pa
DESCRIBE dpmrs_pa;

-- Ver todas las columnas existentes con detalles
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT,
    COLUMN_TYPE
FROM 
    information_schema.COLUMNS 
WHERE 
    TABLE_NAME = 'dpmrs_pa' 
    AND TABLE_SCHEMA = 'dbburonuevo'
ORDER BY 
    ORDINAL_POSITION;

-- Ver foreign keys existentes
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM 
    information_schema.KEY_COLUMN_USAGE 
WHERE 
    TABLE_NAME = 'dpmrs_pa' 
    AND TABLE_SCHEMA = 'dbburonuevo'
    AND REFERENCED_TABLE_NAME IS NOT NULL;
