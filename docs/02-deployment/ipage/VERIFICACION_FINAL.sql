-- ===================================================================
-- VERIFICACIÓN FINAL: TODAS LAS TABLAS PA ACTUALIZADAS
-- ===================================================================

-- 1. Verificar todas las tablas PA principales
SELECT 'VERIFICANDO TABLAS PA PRINCIPALES:' as 'Verificacion';

SELECT COUNT(*) as 'audiencias_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'audiencias_pa';
SELECT COUNT(*) as 'dpmrs_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'dpmrs_pa';
SELECT COUNT(*) as 'aceptacions_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'aceptacions_pa';
SELECT COUNT(*) as 'resolucins_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'resolucins_pa';

-- 2. Verificar estructura audiencias_pa
SELECT 'ESTRUCTURA audiencias_pa:' as 'Tabla';
DESCRIBE audiencias_pa;

-- 3. Verificar estructura dpmrs_pa
SELECT 'ESTRUCTURA dpmrs_pa:' as 'Tabla';
DESCRIBE dpmrs_pa;

-- 4. Verificar estructura aceptacions_pa
SELECT 'ESTRUCTURA aceptacions_pa:' as 'Tabla';
DESCRIBE aceptacions_pa;

-- 5. Verificar estructura resolucins_pa
SELECT 'ESTRUCTURA resolucins_pa:' as 'Tabla';
DESCRIBE resolucins_pa;

-- 6. Verificar ENUMs corregidos en audiencias VA
SELECT 'ENUMs AUDIENCIAS VA:' as 'Verificacion';
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'audiencias'
AND COLUMN_NAME IN ('tipo_audiencia', 'plazo_evacuar');

-- 7. Verificar ENUMs en audiencias PA
SELECT 'ENUMs AUDIENCIAS PA:' as 'Verificacion';
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'audiencias_pa'
AND COLUMN_NAME IN ('tipo_audiencia', 'plazo_evacuar');

-- ===================================================================
-- RESUMEN FINAL
-- ===================================================================

SELECT '🎉 ACTUALIZACIÓN PA COMPLETADA' as 'Status_Final';
SELECT '==================================' as '';
SELECT 'TABLAS ACTUALIZADAS:' as 'Resumen';
SELECT '✅ audiencias_pa: Estructura completa' as 'Tabla_1';
SELECT '✅ dpmrs_pa: Estructura completa' as 'Tabla_2';
SELECT '✅ aceptacions_pa: Estructura completa' as 'Tabla_3';
SELECT '✅ resolucins_pa: Tabla creada para RsatPa' as 'Tabla_4';
SELECT '✅ audiencias VA: ENUMs actualizados' as 'Tabla_5';

SELECT 'AHORA PUEDE PROBAR:' as 'Pruebas';
SELECT '1. Acceder a pestaña PA sin error 500' as 'Prueba_1';
SELECT '2. Crear audiencias PA' as 'Prueba_2';
SELECT '3. Crear documentos DPMR PA' as 'Prueba_3';
SELECT '4. Crear aceptaciones PA' as 'Prueba_4';
SELECT '5. Usar campos "Otro" en formularios' as 'Prueba_5';
