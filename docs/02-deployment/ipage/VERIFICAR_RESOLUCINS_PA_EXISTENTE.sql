-- ===================================================================
-- VERIFICAR TABLA resolucins_pa EXISTENTE
-- ===================================================================

SELECT '🔍 VERIFICANDO TABLA resolucins_pa EXISTENTE' as 'Status';

-- PASO 1: Verificar que la tabla existe
SELECT 'TABLA resolucins_pa EXISTE:' as 'Info';
SHOW TABLES LIKE 'resolucins_pa';

-- PASO 2: Ver estructura de resolucins_pa
SELECT 'ESTRUCTURA resolucins_pa:' as 'Info';
DESCRIBE resolucins_pa;

-- PASO 3: Contar registros
SELECT 'REGISTROS EN resolucins_pa:' as 'Info';
SELECT COUNT(*) as 'total_registros' FROM resolucins_pa;

-- PASO 4: Verificar foreign keys
SELECT 'FOREIGN KEYS resolucins_pa:' as 'Info';
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_NAME = 'resolucins_pa' 
AND TABLE_SCHEMA = 'dbburonuevo'
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- PASO 5: Probar la consulta específica que falla
SELECT 'PROBANDO CONSULTA QUE FALLA:' as 'Info';
SELECT * FROM resolucins_pa WHERE audiencia_pa_id = 2 LIMIT 1;

-- PASO 6: Verificar audiencia_pa_id = 2 existe
SELECT 'VERIFICANDO audiencia_pa_id = 2:' as 'Info';
SELECT id, numero_audiencia, usuario_id FROM audiencias_pa WHERE id = 2;

-- PASO 7: Ver primeros registros de resolucins_pa
SELECT 'PRIMEROS REGISTROS resolucins_pa:' as 'Info';
SELECT 
    id,
    numero_resolucion,
    fecha_hora,
    tipo_resolucion,
    audiencia_pa_id,
    usuario_id
FROM resolucins_pa 
LIMIT 3;

SELECT '✅ VERIFICACIÓN resolucins_pa COMPLETADA' as 'Status';
