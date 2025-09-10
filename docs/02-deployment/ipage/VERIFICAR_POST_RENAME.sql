-- ===================================================================
-- VERIFICAR ESTADO DESPUÉS DEL RENAME
-- ===================================================================

SELECT '🔍 VERIFICANDO ESTADO POST-RENAME' as 'Status';

-- PASO 1: Confirmar que la tabla existe con el nombre correcto
SELECT 'TABLA resolucions_pa EXISTE:' as 'Info';
SHOW TABLES LIKE 'resolucions_pa';

-- PASO 2: Verificar estructura
SELECT 'ESTRUCTURA resolucions_pa:' as 'Info';
DESCRIBE resolucions_pa;

-- PASO 3: Contar registros totales
SELECT 'TOTAL REGISTROS:' as 'Info';
SELECT COUNT(*) as 'total_registros' FROM resolucions_pa;

-- PASO 4: Ver TODOS los registros (si los hay)
SELECT 'TODOS LOS REGISTROS resolucions_pa:' as 'Info';
SELECT * FROM resolucions_pa;

-- PASO 5: Verificar si audiencia_pa_id = 2 existe en audiencias_pa
SELECT 'VERIFICANDO audiencia_pa_id = 2:' as 'Info';
SELECT COUNT(*) as 'existe_audiencia_2' FROM audiencias_pa WHERE id = 2;

-- PASO 6: Ver todas las audiencias_pa disponibles
SELECT 'AUDIENCIAS PA DISPONIBLES:' as 'Info';
SELECT id, numero_audiencia, usuario_id FROM audiencias_pa ORDER BY id;

-- PASO 7: Probar consulta simple sin WHERE
SELECT 'PROBANDO SELECT SIN WHERE:' as 'Info';
SELECT 'TEST_OK' as 'resultado' FROM resolucions_pa LIMIT 1;

-- PASO 8: Si hay registros, probar con audiencia_pa_id existente
SELECT 'PROBANDO CON AUDIENCIA_PA_ID VÁLIDO:' as 'Info';
SELECT * FROM resolucions_pa 
WHERE audiencia_pa_id IN (SELECT id FROM audiencias_pa LIMIT 1);

SELECT '✅ VERIFICACIÓN POST-RENAME COMPLETADA' as 'Status';
