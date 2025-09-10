-- ===================================================================
-- VERIFICACIÓN RÁPIDA: ESTADO DE TODAS LAS TABLAS PA
-- ===================================================================

SELECT '🔍 VERIFICANDO ESTADO DE TODAS LAS TABLAS PA' as 'Status';

-- 1. audiencias_pa (ya actualizada)
SELECT 'ESTRUCTURA audiencias_pa:' as 'Tabla';
DESCRIBE audiencias_pa;

-- 2. dpmrs_pa (ya completa)
SELECT 'ESTRUCTURA dpmrs_pa:' as 'Tabla';
DESCRIBE dpmrs_pa;

-- 3. aceptacions_pa (verificar si necesita actualización)
SELECT 'ESTRUCTURA aceptacions_pa:' as 'Tabla';
DESCRIBE aceptacions_pa;

-- 4. resolucins_pa (verificar si existe)
SELECT 'ESTRUCTURA resolucins_pa:' as 'Tabla';
DESCRIBE resolucins_pa;

-- 5. Verificar si resolucins_pa existe
SELECT COUNT(*) as 'resolucins_pa_existe' 
FROM information_schema.tables 
WHERE table_schema = 'dbburonuevo' 
AND table_name = 'resolucins_pa';

-- 6. Verificar ENUMs en audiencias VA
SELECT 'ENUMs AUDIENCIAS VA:' as 'Verificacion';
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'audiencias'
AND COLUMN_NAME IN ('tipo_audiencia', 'plazo_evacuar');

SELECT '📋 RESUMEN DE VERIFICACIÓN COMPLETADO' as 'Status_Final';
