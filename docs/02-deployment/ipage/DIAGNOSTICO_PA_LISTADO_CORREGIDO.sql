-- ===================================================================
-- DIAGNÓSTICO CORREGIDO: LISTADO PA Y CONTROLADOR
-- ===================================================================

SELECT '🔍 VERIFICANDO PROBLEMA PA LISTADO' as 'Status';

-- 1. Verificar registros en tabla principal (pats)
SELECT 'REGISTROS EN TABLA pats:' as 'Info';
SELECT COUNT(*) as 'total_pats' FROM pats;

-- 2. Verificar audiencias_pa con sus campos correctos
SELECT 'ESTRUCTURA CORRECTA audiencias_pa:' as 'Info';
SELECT 
    id,
    pat_id,
    usuario_id,
    numero_audiencia,
    tipo_audiencia,
    fecha,
    impuestos,
    estado
FROM audiencias_pa 
LIMIT 3;

-- 3. Verificar si existen PATs que deberían tener audiencias PA
SELECT 'PATS SIN AUDIENCIAS PA:' as 'Info';
SELECT 
    p.id,
    p.no_expediente,
    p.cuenta_id,
    COUNT(ap.id) as 'audiencias_pa_count'
FROM pats p
LEFT JOIN audiencias_pa ap ON p.id = ap.pat_id
GROUP BY p.id
LIMIT 5;

-- 4. Verificar tabla users (para foreign key)
SELECT 'USUARIOS DISPONIBLES:' as 'Info';
SELECT COUNT(*) as 'total_usuarios' FROM users;

-- 5. Verificar si hay problemas en relaciones
SELECT 'VERIFICANDO FOREIGN KEYS:' as 'Info';
SELECT 
    TABLE_NAME,
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_NAME = 'audiencias_pa' 
AND TABLE_SCHEMA = 'dbburonuevo'
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- 6. Probar inserción simple para verificar tabla
SELECT 'PROBANDO INSERCIÓN DE PRUEBA:' as 'Info';

-- Primero verificar si existe al menos un PAT y un usuario
SELECT 'DATOS PARA INSERCIÓN:' as 'Info';
SELECT 
    (SELECT id FROM pats LIMIT 1) as 'pat_id_disponible',
    (SELECT id FROM users LIMIT 1) as 'usuario_id_disponible';

SELECT '✅ DIAGNÓSTICO PA LISTADO COMPLETADO' as 'Status';
