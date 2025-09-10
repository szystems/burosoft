-- ===================================================================
-- CONSULTA DIAGNÓSTICA: VER ESTRUCTURA ACTUAL DE audiencias_pa
-- ===================================================================

-- Ejecutar PRIMERO para ver qué columnas ya existen
DESCRIBE audiencias_pa;

-- Ver qué foreign keys ya existen
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM 
    information_schema.KEY_COLUMN_USAGE 
WHERE 
    TABLE_NAME = 'audiencias_pa' 
    AND TABLE_SCHEMA = 'dbburonuevo'
    AND REFERENCED_TABLE_NAME IS NOT NULL;

-- Ver qué tablas referencian a audiencias_pa (esto causa el error)
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME
FROM 
    information_schema.KEY_COLUMN_USAGE 
WHERE 
    REFERENCED_TABLE_NAME = 'audiencias_pa'
    AND TABLE_SCHEMA = 'dbburonuevo';

-- Ver todas las columnas existentes
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT,
    COLUMN_TYPE
FROM 
    information_schema.COLUMNS 
WHERE 
    TABLE_NAME = 'audiencias_pa' 
    AND TABLE_SCHEMA = 'dbburonuevo'
ORDER BY 
    ORDINAL_POSITION;
