-- ===================================================================
-- DIAGNÓSTICO ESPECÍFICO: TABLA audiencias_pa
-- ===================================================================

SELECT '🔍 DIAGNOSTICANDO TABLA audiencias_pa' as 'Status';

-- 1. Verificar estructura de audiencias_pa
SELECT 'ESTRUCTURA audiencias_pa:' as 'Info';
DESCRIBE audiencias_pa;

-- 2. Verificar foreign keys de audiencias_pa
SELECT 'FOREIGN KEYS audiencias_pa:' as 'Info';
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_NAME = 'audiencias_pa' 
AND TABLE_SCHEMA = 'dbburonuevo'
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- 3. Verificar campos críticos y ENUMs
SELECT 'CAMPOS CRÍTICOS audiencias_pa:' as 'Info';
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    IS_NULLABLE,
    COLUMN_TYPE,
    COLUMN_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'audiencias_pa'
AND (DATA_TYPE = 'enum' OR COLUMN_NAME LIKE '%tipo%' OR COLUMN_NAME LIKE '%estado%')
ORDER BY ORDINAL_POSITION;

-- 4. Contar registros en audiencias_pa
SELECT 'REGISTROS EN audiencias_pa:' as 'Info';
SELECT COUNT(*) as 'total_audiencias_pa' FROM audiencias_pa;

-- 5. Verificar si hay registros con datos problemáticos
SELECT 'MUESTRA DE DATOS audiencias_pa:' as 'Info';
SELECT 
    id,
    numero_expediente,
    fecha_audiencia,
    hora_audiencia,
    estado,
    tipo_audiencia,
    usuario_id
FROM audiencias_pa 
LIMIT 5;

-- 6. Verificar relación con tabla padre (si existe)
SELECT 'VERIFICANDO RELACIÓN CON TABLA PADRE:' as 'Info';
SELECT 
    ap.id as audiencia_pa_id,
    ap.numero_expediente,
    ap.estado,
    u.name as usuario_nombre
FROM audiencias_pa ap
LEFT JOIN users u ON ap.usuario_id = u.id
LIMIT 3;

-- 7. Buscar campos ENUM con valores problemáticos
SELECT 'VERIFICANDO ENUMs PROBLEMÁTICOS:' as 'Info';
SELECT DISTINCT estado FROM audiencias_pa WHERE estado IS NOT NULL;
SELECT DISTINCT tipo_audiencia FROM audiencias_pa WHERE tipo_audiencia IS NOT NULL;

SELECT '✅ DIAGNÓSTICO audiencias_pa COMPLETADO' as 'Status';
