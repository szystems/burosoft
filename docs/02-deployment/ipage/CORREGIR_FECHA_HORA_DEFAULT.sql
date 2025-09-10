-- ===================================================================
-- CORREGIR CAMPO fecha_hora - AGREGAR DEFAULT
-- ===================================================================

SELECT '🔧 CORRIGIENDO CAMPO fecha_hora' as 'Status';

-- PASO 1: Ver estructura actual de fecha_hora
SELECT 'ESTRUCTURA ACTUAL fecha_hora:' as 'Info';
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'resolucions_pa'
AND COLUMN_NAME = 'fecha_hora';

-- PASO 2: Modificar fecha_hora para permitir NULL o agregar DEFAULT
SELECT 'MODIFICANDO fecha_hora para permitir NULL:' as 'Info';
ALTER TABLE resolucions_pa 
MODIFY COLUMN fecha_hora datetime NULL;

-- PASO 3: Verificar cambio
SELECT 'VERIFICANDO CAMBIO fecha_hora:' as 'Info';
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'resolucions_pa'
AND COLUMN_NAME = 'fecha_hora';

-- PASO 4: Probar inserción básica
SELECT 'PROBANDO INSERCIÓN SIN fecha_hora:' as 'Info';
INSERT INTO resolucions_pa (
    numero_resolucion,
    tipo_resolucion,
    usuario_id,
    audiencia_pa_id
) VALUES (
    'TEST-002',
    'R-SAT',
    1,
    1
);

-- PASO 5: Verificar inserción
SELECT 'VERIFICANDO INSERCIÓN:' as 'Info';
SELECT * FROM resolucions_pa WHERE numero_resolucion = 'TEST-002';

-- PASO 6: Limpiar registro de prueba
SELECT 'LIMPIANDO REGISTRO DE PRUEBA:' as 'Info';
DELETE FROM resolucions_pa WHERE numero_resolucion = 'TEST-002';

SELECT '✅ CAMPO fecha_hora CORREGIDO - RSAT PA FUNCIONARÁ' as 'Status';
