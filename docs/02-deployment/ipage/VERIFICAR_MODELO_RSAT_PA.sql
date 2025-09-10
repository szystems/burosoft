-- ===================================================================
-- VERIFICAR QUÉ TABLA ESTÁ USANDO EL MODELO RsatPa EN IPAGE
-- ===================================================================

SELECT '🔍 DIAGNOSTICANDO MODELO RsatPa EN PRODUCCIÓN' as 'Status';

-- 1. Ver datos en resolucins_pa (tabla correcta)
SELECT 'REGISTROS EN resolucins_pa (tabla correcta):' as 'Info';
SELECT COUNT(*) as 'registros_resolucins_pa' FROM resolucins_pa;

-- 2. Ver datos en rsat_pa (tabla antigua)
SELECT 'REGISTROS EN rsat_pa (tabla antigua):' as 'Info';
SELECT COUNT(*) as 'registros_rsat_pa' FROM rsat_pa;

-- 3. Crear un registro de prueba en resolucins_pa para verificar
SELECT 'INSERTANDO REGISTRO DE PRUEBA EN resolucins_pa:' as 'Info';
INSERT INTO resolucins_pa (
    numero_resolucion, 
    fecha_hora, 
    tipo_resolucion, 
    usuario_id, 
    audiencia_pa_id
) VALUES (
    'TEST-MODELO-' + CAST(UNIX_TIMESTAMP() AS CHAR),
    NOW(),
    'R-SAT',
    1,
    1
);

-- 4. Verificar que se insertó
SELECT 'VERIFICANDO INSERCIÓN EN resolucins_pa:' as 'Info';
SELECT * FROM resolucins_pa WHERE numero_resolucion LIKE 'TEST-MODELO-%' ORDER BY id DESC LIMIT 1;

-- 5. Limpiar registro de prueba
SELECT 'LIMPIANDO REGISTRO DE PRUEBA:' as 'Info';
DELETE FROM resolucins_pa WHERE numero_resolucion LIKE 'TEST-MODELO-%';

SELECT '✅ DIAGNÓSTICO COMPLETADO - Verificar si Laravel usa resolucins_pa o rsat_pa' as 'Status';
