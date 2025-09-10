-- ===================================================================
-- SOLUCIÓN DEFINITIVA: SINCRONIZAR rsat_pa CON resolucins_pa
-- ===================================================================

SELECT '🔧 APLICANDO CORRECCIÓN DEFINITIVA A rsat_pa' as 'Status';

-- PASO 1: Agregar campo fecha_hora (que falta en rsat_pa)
SELECT 'PASO 1: Agregando campo fecha_hora...' as 'Info';
ALTER TABLE rsat_pa 
ADD COLUMN fecha_hora datetime NOT NULL AFTER numero_resolucion;

-- PASO 2: Migrar datos de fecha a fecha_hora
SELECT 'PASO 2: Migrando datos fecha -> fecha_hora...' as 'Info';
UPDATE rsat_pa 
SET fecha_hora = CONCAT(fecha, ' 00:00:00') 
WHERE fecha_hora IS NULL;

-- PASO 3: Eliminar campo fecha (ya no necesario)
SELECT 'PASO 3: Eliminando campo fecha obsoleto...' as 'Info';
ALTER TABLE rsat_pa DROP COLUMN fecha;

-- PASO 4: Corregir ENUM tipo_resolucion
SELECT 'PASO 4: Corrigiendo ENUM tipo_resolucion...' as 'Info';
ALTER TABLE rsat_pa 
MODIFY COLUMN tipo_resolucion enum('R-SAT','Otro') NOT NULL DEFAULT 'R-SAT';

-- PASO 5: Verificar estructura final
SELECT 'PASO 5: Verificando estructura corregida...' as 'Info';
DESCRIBE rsat_pa;

-- PASO 6: Verificar campos críticos
SELECT 'VERIFICACIÓN FINAL - Campos críticos en rsat_pa:' as 'Info';
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    IS_NULLABLE,
    COLUMN_TYPE,
    COLUMN_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'rsat_pa'
AND COLUMN_NAME IN ('numero_resolucion', 'fecha_hora', 'tipo_resolucion', 'tipo_resolucion_otro', 'usuario_id', 'audiencia_pa_id')
ORDER BY ORDINAL_POSITION;

SELECT '✅ CORRECCIÓN COMPLETADA - rsat_pa ahora compatible con RsatPa model' as 'Status';
