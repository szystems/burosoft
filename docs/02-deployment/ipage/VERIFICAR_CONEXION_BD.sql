-- ===================================================================
-- VERIFICAR CONEXIÓN Y PERMISOS DE BASE DE DATOS
-- ===================================================================

SELECT '🔍 VERIFICANDO CONEXIÓN Y PERMISOS' as 'Status';

-- PASO 1: Verificar base de datos actual
SELECT 'BASE DE DATOS ACTUAL:' as 'Info';
SELECT DATABASE() as 'base_datos_actual';

-- PASO 2: Verificar usuario actual
SELECT 'USUARIO ACTUAL:' as 'Info';
SELECT USER() as 'usuario_actual';

-- PASO 3: Verificar todas las tablas PA
SELECT 'TODAS LAS TABLAS PA EXISTENTES:' as 'Info';
SHOW TABLES LIKE '%_pa';

-- PASO 4: Verificar permisos en resolucins_pa
SELECT 'PERMISOS EN resolucins_pa:' as 'Info';
SHOW GRANTS FOR CURRENT_USER();

-- PASO 5: Verificar si podemos hacer SELECT
SELECT 'PROBANDO SELECT EN resolucins_pa:' as 'Info';
SELECT 'ACCESO_OK' as 'resultado' FROM resolucins_pa LIMIT 1;

-- PASO 6: Verificar tabla audiencias_pa también
SELECT 'PROBANDO SELECT EN audiencias_pa:' as 'Info';
SELECT COUNT(*) as 'total_audiencias_pa' FROM audiencias_pa;

SELECT '✅ VERIFICACIÓN DE CONEXIÓN COMPLETADA' as 'Status';
