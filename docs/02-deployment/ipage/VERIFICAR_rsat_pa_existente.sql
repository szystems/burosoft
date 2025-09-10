-- ===================================================================
-- VERIFICAR TABLA rsat_pa EXISTENTE
-- ===================================================================

SELECT '🔍 VERIFICANDO TABLA rsat_pa EXISTENTE' as 'Status';

-- 1. Ver estructura de rsat_pa
SELECT 'ESTRUCTURA DE rsat_pa:' as 'Info';
DESCRIBE rsat_pa;

-- 2. Comparar con resolucins_pa
SELECT 'ESTRUCTURA DE resolucins_pa:' as 'Info';
DESCRIBE resolucins_pa;

-- 3. Ver foreign keys de rsat_pa
SELECT 'FOREIGN KEYS rsat_pa:' as 'Info';
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_NAME = 'rsat_pa' 
AND TABLE_SCHEMA = 'dbburonuevo'
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- 4. Contar registros en ambas tablas
SELECT 'DATOS EN TABLAS:' as 'Info';
SELECT COUNT(*) as 'registros_rsat_pa' FROM rsat_pa;
SELECT COUNT(*) as 'registros_resolucins_pa' FROM resolucins_pa;

-- 5. Verificar que rsat_pa tiene todos los campos necesarios
SELECT 'CAMPOS CRÍTICOS EN rsat_pa:' as 'Info';
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    IS_NULLABLE,
    COLUMN_TYPE
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'rsat_pa'
AND COLUMN_NAME IN ('numero_resolucion', 'fecha_hora', 'tipo_resolucion', 'tipo_resolucion_otro', 'usuario_id', 'audiencia_pa_id')
ORDER BY ORDINAL_POSITION;
