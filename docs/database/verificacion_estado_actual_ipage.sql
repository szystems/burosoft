-- SCRIPT INTELIGENTE PARA IPAGE - VERIFICACIÓN Y CORRECCIÓN
-- Fecha: 29 de agosto de 2025
-- Propósito: Verificar qué campos existen antes de agregarlos
-- INSTRUCCIONES: Ejecutar PRIMERO estas consultas para ver el estado actual

-- ========================================
-- VERIFICACIÓN DE ESTADO ACTUAL
-- ========================================

-- Ver estructura completa de rsat_pa
SELECT 'ESTRUCTURA ACTUAL DE RSAT_PA:' AS info;
DESCRIBE `rsat_pa`;

-- Ver estructura completa de ntrrs_pa
SELECT 'ESTRUCTURA ACTUAL DE NTRRS_PA:' AS info;
DESCRIBE `ntrrs_pa`;

-- Verificar qué campos específicos ya existen en rsat_pa
SELECT 'CAMPOS EXISTENTES EN RSAT_PA:' AS info;
SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'rsat_pa' 
  AND COLUMN_NAME IN ('tipo_resolucion', 'tipo_resolucion_otro', 'plazo_revocatoria', 'plazo_revocatoria_otro')
ORDER BY ORDINAL_POSITION;

-- Verificar qué campos específicos ya existen en ntrrs_pa
SELECT 'CAMPOS EXISTENTES EN NTRRS_PA:' AS info;
SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'ntrrs_pa' 
  AND COLUMN_NAME IN ('fecha', 'fecha_hora_notificacion', 'fecha_resolucion')
ORDER BY ORDINAL_POSITION;

-- ========================================
-- INFORMACIÓN PARA DIAGNÓSTICO
-- ========================================

SELECT 'DIAGNÓSTICO COMPLETADO' AS resultado;
SELECT 'Revisa los resultados arriba para ver qué campos ya existen' AS instrucciones;
SELECT 'Después ejecuta solo los ALTER TABLE para los campos que falten' AS siguiente_paso;
