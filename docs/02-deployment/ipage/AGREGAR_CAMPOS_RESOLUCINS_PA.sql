-- ===================================================================
-- AGREGAR CAMPOS FALTANTES A resolucions_pa
-- ===================================================================

SELECT '🔧 AGREGANDO CAMPOS FALTANTES A resolucions_pa' as 'Status';

-- PASO 1: Agregar fecha_notificacion
SELECT 'AGREGANDO fecha_notificacion...' as 'Info';
ALTER TABLE resolucions_pa 
ADD COLUMN fecha_notificacion datetime NULL 
AFTER fecha_hora;

-- PASO 2: Agregar fecha_resolucion
SELECT 'AGREGANDO fecha_resolucion...' as 'Info';
ALTER TABLE resolucions_pa 
ADD COLUMN fecha_resolucion date NULL 
AFTER fecha_notificacion;

-- PASO 3: Agregar fecha (campo legacy)
SELECT 'AGREGANDO fecha...' as 'Info';
ALTER TABLE resolucions_pa 
ADD COLUMN fecha date NULL 
AFTER fecha_resolucion;

-- PASO 4: Agregar plazo_revocatoria
SELECT 'AGREGANDO plazo_revocatoria...' as 'Info';
ALTER TABLE resolucions_pa 
ADD COLUMN plazo_revocatoria varchar(191) NULL 
AFTER tipo_resolucion_otro;

-- PASO 5: Agregar plazo_revocatoria_otro
SELECT 'AGREGANDO plazo_revocatoria_otro...' as 'Info';
ALTER TABLE resolucions_pa 
ADD COLUMN plazo_revocatoria_otro varchar(191) NULL 
AFTER plazo_revocatoria;

-- PASO 6: Verificar estructura final
SELECT 'ESTRUCTURA FINAL resolucions_pa:' as 'Info';
DESCRIBE resolucions_pa;

-- PASO 7: Probar inserción de prueba
SELECT 'PROBANDO INSERCIÓN BÁSICA:' as 'Info';
INSERT INTO resolucions_pa (
    numero_resolucion,
    fecha_hora,
    tipo_resolucion,
    usuario_id,
    audiencia_pa_id
) VALUES (
    'TEST-001',
    NOW(),
    'R-SAT',
    1,
    1
);

-- PASO 8: Verificar inserción
SELECT 'VERIFICANDO INSERCIÓN:' as 'Info';
SELECT * FROM resolucions_pa WHERE numero_resolucion = 'TEST-001';

-- PASO 9: Limpiar registro de prueba
SELECT 'LIMPIANDO REGISTRO DE PRUEBA:' as 'Info';
DELETE FROM resolucions_pa WHERE numero_resolucion = 'TEST-001';

SELECT '✅ CAMPOS AGREGADOS - RSAT PA DEBERÍA FUNCIONAR' as 'Status';
