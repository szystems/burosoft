-- ===================================================================
-- SOLUCIÓN DEFINITIVA: RENOMBRAR TABLA EN IPAGE
-- ===================================================================

SELECT '🔧 RENOMBRANDO TABLA EN IPAGE PARA COMPATIBILIDAD' as 'Status';

-- PASO 1: Verificar tabla actual
SELECT 'VERIFICANDO TABLA ACTUAL:' as 'Info';
SHOW TABLES LIKE '%resolu%';

-- PASO 2: Renombrar tabla de resolucins_pa a resolucions_pa
SELECT 'RENOMBRANDO TABLA:' as 'Info';
RENAME TABLE `resolucins_pa` TO `resolucions_pa`;

-- PASO 3: Verificar que el renombre funcionó
SELECT 'VERIFICANDO RENOMBRE EXITOSO:' as 'Info';
SHOW TABLES LIKE '%resolu%';

-- PASO 4: Verificar estructura de la tabla renombrada
SELECT 'ESTRUCTURA FINAL resolucions_pa:' as 'Info';
DESCRIBE resolucions_pa;

-- PASO 5: Contar registros
SELECT 'REGISTROS EN resolucions_pa:' as 'Info';
SELECT COUNT(*) as 'total_registros' FROM resolucions_pa;

-- PASO 6: Verificar foreign keys funcionan
SELECT 'FOREIGN KEYS resolucions_pa:' as 'Info';
SELECT 
    CONSTRAINT_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_NAME = 'resolucions_pa' 
AND TABLE_SCHEMA = 'dbburonuevo'
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- PASO 7: Probar consulta que antes fallaba
SELECT 'PROBANDO CONSULTA QUE ANTES FALLABA:' as 'Info';
SELECT * FROM resolucions_pa WHERE audiencia_pa_id = 2 LIMIT 1;

SELECT '✅ TABLA resolucions_pa RENOMBRADA EXITOSAMENTE' as 'Status';
SELECT '🎯 ERROR PA RESUELTO - Laravel encontrará la tabla correcta' as 'Resultado';
