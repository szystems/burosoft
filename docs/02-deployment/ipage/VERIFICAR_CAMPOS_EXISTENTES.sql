-- ===================================================================
-- VERIFICAR CAMPOS EXISTENTES EN resolucions_pa
-- ===================================================================

SELECT '🔍 VERIFICANDO CAMPOS EXISTENTES' as 'Status';

-- Ver estructura completa actual
SELECT 'ESTRUCTURA ACTUAL resolucions_pa:' as 'Info';
DESCRIBE resolucions_pa;

-- Verificar campos específicos que necesitamos
SELECT 'VERIFICANDO CAMPOS ESPECÍFICOS:' as 'Info';
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    IS_NULLABLE
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'resolucions_pa'
AND COLUMN_NAME IN (
    'fecha_notificacion',
    'fecha_resolucion', 
    'fecha',
    'plazo_revocatoria',
    'plazo_revocatoria_otro'
)
ORDER BY ORDINAL_POSITION;

SELECT '✅ VERIFICACIÓN COMPLETADA' as 'Status';
