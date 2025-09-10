-- ===================================================================
-- AGREGAR SOLO CAMPOS FALTANTES A resolucions_pa
-- ===================================================================

SELECT '🔧 AGREGANDO SOLO CAMPOS FALTANTES' as 'Status';

-- PASO 1: Agregar fecha_resolucion
SELECT 'AGREGANDO fecha_resolucion...' as 'Info';
ALTER TABLE resolucions_pa 
ADD COLUMN fecha_resolucion date NULL 
AFTER fecha_notificacion;

-- PASO 2: Agregar fecha (campo legacy)
SELECT 'AGREGANDO fecha...' as 'Info';
ALTER TABLE resolucions_pa 
ADD COLUMN fecha date NULL 
AFTER fecha_resolucion;

-- PASO 3: Agregar plazo_revocatoria
SELECT 'AGREGANDO plazo_revocatoria...' as 'Info';
ALTER TABLE resolucions_pa 
ADD COLUMN plazo_revocatoria varchar(191) NULL 
AFTER tipo_resolucion_otro;

-- PASO 4: Agregar plazo_revocatoria_otro
SELECT 'AGREGANDO plazo_revocatoria_otro...' as 'Info';
ALTER TABLE resolucions_pa 
ADD COLUMN plazo_revocatoria_otro varchar(191) NULL 
AFTER plazo_revocatoria;

-- PASO 5: Verificar estructura final
SELECT 'ESTRUCTURA FINAL resolucions_pa:' as 'Info';
DESCRIBE resolucions_pa;

-- PASO 6: Verificar todos los campos necesarios están presentes
SELECT 'VERIFICANDO CAMPOS REQUERIDOS:' as 'Info';
SELECT 
    COLUMN_NAME,
    DATA_TYPE
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'resolucions_pa'
AND COLUMN_NAME IN (
    'fecha_notificacion',
    'fecha_resolucion', 
    'fecha',
    'plazo_revocatoria',
    'plazo_revocatoria_otro',
    'numero_resolucion',
    'tipo_resolucion',
    'tipo_resolucion_otro',
    'audiencia_pa_id',
    'observaciones',
    'numero_folios',
    'archivo',
    'usuario_id',
    'tipo_archivo'
)
ORDER BY ORDINAL_POSITION;

SELECT '✅ TODOS LOS CAMPOS AGREGADOS - RSAT PA FUNCIONARÁ' as 'Status';
