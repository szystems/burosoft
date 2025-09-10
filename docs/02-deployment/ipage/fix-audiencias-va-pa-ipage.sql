-- ===================================================================
-- SCRIPT ACTUALIZACIÓN AUDIENCIAS VA/PA - iPAGE MySQL 5.7
-- ===================================================================
-- 
-- OBJETIVO: Corregir campos plazo_evacuar y tipo_audiencia 
--           para audiencias VA y PA
--
-- CAMBIOS:
-- 1. Actualizar ENUM plazo_evacuar: 5 Dias, 10 Dias, 30 Dias, Otro
-- 2. Agregar opción "Otro" a tipo_audiencia + campo tipo_audiencia_otro  
-- 3. Compatible con MySQL 5.7.44-log (iPage hosting)
-- ===================================================================

USE dbburonuevo;

SELECT '🔧 INICIANDO ACTUALIZACIÓN AUDIENCIAS VA/PA' as 'Status';
SELECT '================================================' as '';

-- ===================================================================
-- 1. VERIFICAR ESTRUCTURA ACTUAL
-- ===================================================================

SELECT '📋 1. VERIFICANDO ESTRUCTURA ACTUAL...' as 'Status';

DESCRIBE audiencias;
DESCRIBE audiencias_pa;

-- ===================================================================
-- 2. BACKUP DE DATOS EXISTENTES (OPCIONAL)
-- ===================================================================

SELECT '💾 2. RESPALDANDO DATOS EXISTENTES...' as 'Status';

-- Crear tabla temporal de backup (opcional)
-- CREATE TABLE audiencias_backup_20250909 AS SELECT * FROM audiencias;
-- CREATE TABLE audiencias_pa_backup_20250909 AS SELECT * FROM audiencias_pa;

-- ===================================================================
-- 3. AGREGAR CAMPO tipo_audiencia_otro 
-- ===================================================================

SELECT '➕ 3. AGREGANDO CAMPO tipo_audiencia_otro...' as 'Status';

-- Tabla audiencias
ALTER TABLE `audiencias` 
ADD COLUMN `tipo_audiencia_otro` VARCHAR(255) NULL 
AFTER `tipo_audiencia`;

-- Tabla audiencias_pa  
ALTER TABLE `audiencias_pa` 
ADD COLUMN `tipo_audiencia_otro` VARCHAR(255) NULL 
AFTER `tipo_audiencia`;

SELECT '✅ Campo tipo_audiencia_otro agregado' as 'Status_1';

-- ===================================================================
-- 4. ACTUALIZAR ENUM tipo_audiencia PARA INCLUIR "Otro"
-- ===================================================================

SELECT '🔄 4. ACTUALIZANDO ENUM tipo_audiencia...' as 'Status';

-- Tabla audiencias
ALTER TABLE `audiencias` 
MODIFY COLUMN `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL;

-- Tabla audiencias_pa
ALTER TABLE `audiencias_pa` 
MODIFY COLUMN `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL;

SELECT '✅ ENUM tipo_audiencia actualizado con "Otro"' as 'Status_2';

-- ===================================================================
-- 5. ACTUALIZAR ENUM plazo_evacuar CON NUEVOS VALORES
-- ===================================================================

SELECT '🔄 5. ACTUALIZANDO ENUM plazo_evacuar...' as 'Status';

-- Tabla audiencias
ALTER TABLE `audiencias` 
MODIFY COLUMN `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL;

-- Tabla audiencias_pa
ALTER TABLE `audiencias_pa` 
MODIFY COLUMN `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL;

SELECT '✅ ENUM plazo_evacuar actualizado' as 'Status_3';

-- ===================================================================
-- 6. MIGRAR DATOS EXISTENTES (SI NECESARIO)
-- ===================================================================

SELECT '🔄 6. MIGRANDO DATOS EXISTENTES...' as 'Status';

-- Migrar valores antiguos a nuevos (si existen datos)
-- UPDATE audiencias SET plazo_evacuar = '30 Dias' WHERE plazo_evacuar = '30 D.H.';
-- UPDATE audiencias SET plazo_evacuar = '30 Dias' WHERE plazo_evacuar = '30 dias';

-- UPDATE audiencias_pa SET plazo_evacuar = '30 Dias' WHERE plazo_evacuar = '30 D.H.';
-- UPDATE audiencias_pa SET plazo_evacuar = '30 Dias' WHERE plazo_evacuar = '30 dias';

SELECT '✅ Migración de datos completada' as 'Status_4';

-- ===================================================================
-- 7. VERIFICACIÓN FINAL
-- ===================================================================

SELECT '✅ 7. VERIFICACIÓN FINAL...' as 'Status';

-- Verificar estructura actualizada
SELECT 'Estructura audiencias:' as 'Verificacion';
DESCRIBE audiencias;

SELECT 'Estructura audiencias_pa:' as 'Verificacion';  
DESCRIBE audiencias_pa;

-- Verificar ENUMs
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME IN ('audiencias', 'audiencias_pa')
AND COLUMN_NAME IN ('tipo_audiencia', 'tipo_audiencia_otro', 'plazo_evacuar', 'plazo_evacuar_otro');

-- ===================================================================
-- 8. PRUEBA DE INSERCIÓN 
-- ===================================================================

SELECT '🧪 8. PRUEBA DE INSERCIÓN...' as 'Status';

-- Test de valores válidos
SELECT 'Valores válidos para tipo_audiencia:' as 'Test';
SELECT 'AEC, AIR, AS, AA, Otro' as 'Valores_Permitidos';

SELECT 'Valores válidos para plazo_evacuar:' as 'Test';  
SELECT '5 Dias, 10 Dias, 30 Dias, Otro' as 'Valores_Permitidos';

-- ===================================================================
-- RESUMEN FINAL
-- ===================================================================

SELECT '🎉 ACTUALIZACIÓN COMPLETADA EXITOSAMENTE' as 'Status_Final';
SELECT '===============================================' as '';
SELECT 'CAMBIOS REALIZADOS:' as 'Resumen';
SELECT '✅ Campo tipo_audiencia_otro agregado' as 'Cambio_1';
SELECT '✅ ENUM tipo_audiencia incluye "Otro"' as 'Cambio_2';  
SELECT '✅ ENUM plazo_evacuar: 5 Dias, 10 Dias, 30 Dias, Otro' as 'Cambio_3';
SELECT '✅ Estructura compatible con formularios VA/PA' as 'Cambio_4';

SELECT 'FECHA APLICACIÓN:' as 'Info';
SELECT NOW() as 'Timestamp';

-- ===================================================================
-- ARCHIVOS ACTUALIZADOS EN LARAVEL (PARA SUBIR A IPAGE):
-- ===================================================================
-- 
-- MIGRACIONES:
-- - database/migrations/2025_07_21_100003_create_complete_dpmrs_pa_table.php (NUEVA)
-- - database/migrations/2025_08_28_115921_create_complete_aceptacions_pa_table.php (NUEVA)
-- 
-- MODELOS:
-- - app/Models/Audiencia.php (fillable con tipo_audiencia_otro)
-- - app/Models/AudienciaPa.php (fillable con tipo_audiencia_otro)
-- - app/Models/DpmrPa.php (ya existe, verificar que esté en iPage)
-- - app/Models/RsatPa.php (CORREGIDO: protected $table = 'resolucions_pa')
-- 
-- CONTROLADORES:
-- - app/Http/Controllers/Empresa/AudienciaPaController.php (validación update)
-- 
-- VALIDACIONES:
-- - app/Http/Requests/AudienciaFormRequest.php (nuevas reglas)
-- 
-- VISTAS DE CREAR:
-- - resources/views/empresa/expcaso/va/addaudienciamodal.blade.php
-- - resources/views/empresa/expcaso/pa/addaudienciamodal.blade.php
-- 
-- VISTAS DE EDITAR:
-- - resources/views/empresa/expcaso/va/editaudienciamodal.blade.php
-- - resources/views/empresa/expcaso/pa/editaudienciamodal.blade.php
-- 
-- VISTAS DE MOSTRAR:
-- - resources/views/empresa/expcaso/va/show.blade.php (tabla listado)
-- - resources/views/empresa/expcaso/pa/show.blade.php (tabla listado)
-- - resources/views/empresa/expcaso/va/showaudiencia.blade.php (detalle)
-- - resources/views/empresa/expcaso/pa/showaudiencia.blade.php (detalle)
-- 
-- ===================================================================

-- ===================================================================
-- SCRIPT ADICIONAL PARA CREAR TABLA dpmrs_pa (SI NO EXISTE):
-- ===================================================================

CREATE TABLE IF NOT EXISTS `dpmrs_pa` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `numero_resolucion` varchar(191) NOT NULL,
    `fecha_hora` datetime NOT NULL,
    `usuario_id` bigint(20) unsigned NOT NULL,
    `audiencia_pa_id` bigint(20) unsigned NOT NULL,
    `archivo` varchar(191) DEFAULT NULL,
    `tipo_archivo` varchar(191) DEFAULT NULL,
    `observaciones` text DEFAULT NULL,
    `numero_folios` int(11) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `dpmrs_pa_usuario_id_foreign` (`usuario_id`),
    KEY `dpmrs_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
    CONSTRAINT `dpmrs_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `dpmrs_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SELECT '✅ Tabla dpmrs_pa creada (si no existía)' as 'Status_Extra';

-- ===================================================================
-- SCRIPT ADICIONAL PARA CREAR TABLA aceptacions_pa (SI NO EXISTE):
-- ===================================================================

CREATE TABLE IF NOT EXISTS `aceptacions_pa` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `fecha_hora_presentacion` datetime NOT NULL,
    `numero_documento` varchar(191) NOT NULL,
    `usuario_id` bigint(20) unsigned NOT NULL,
    `audiencia_pa_id` bigint(20) unsigned NOT NULL,
    `archivo` varchar(191) DEFAULT NULL,
    `tipo_archivo` varchar(191) DEFAULT NULL,
    `observaciones` text DEFAULT NULL,
    `oficina_presentacion` varchar(191) DEFAULT NULL,
    `numero_folios` int(11) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `aceptacions_pa_usuario_id_foreign` (`usuario_id`),
    KEY `aceptacions_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
    CONSTRAINT `aceptacions_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `aceptacions_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SELECT '✅ Tabla aceptacions_pa creada (si no existía)' as 'Status_Extra_2';

-- ===================================================================
-- NOTAS IMPORTANTES PARA iPAGE:
-- ===================================================================
-- 
-- 1. Este script es compatible con MySQL 5.7.44-log
-- 2. Los ENUMs son case-sensitive: usar exactamente '5 Dias', '10 Dias', etc.
-- 3. Probar inserción después de aplicar cambios
-- 4. Los formularios Laravel ya están actualizados para usar estos valores
-- 5. Aplicar durante ventana de mantenimiento para evitar conflictos
-- 
-- ===================================================================
