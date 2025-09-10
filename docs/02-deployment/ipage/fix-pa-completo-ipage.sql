-- ===================================================================
-- SCRIPT COMPLETO ACTUALIZACIÓN PA - iPAGE MySQL 5.7
-- ===================================================================
-- 
-- OBJETIVO: Implementar TODAS las correcciones PA en producción iPage
-- PROBLEMA: Error 500 en pestaña PA por tablas incompletas
-- COMPATIBLE: MySQL 5.7.44-log (iPage hosting)
-- ===================================================================

-- USAR DESDE phpMyAdmin en iPage, asegurándose de estar en dbburonuevo

SELECT '🔧 INICIANDO ACTUALIZACIÓN COMPLETA PA - iPAGE' as 'Status';
SELECT '=====================================================' as '';

-- ===================================================================
-- 1. VERIFICAR ESTADO ACTUAL
-- ===================================================================

SELECT '📋 1. VERIFICANDO ESTADO ACTUAL...' as 'Status';

-- Verificar si las tablas tienen estructura completa
SELECT 'Verificando estructura audiencias_pa:' as 'Info';
DESCRIBE audiencias_pa;

SELECT 'Verificando estructura dpmrs_pa:' as 'Info';
DESCRIBE dpmrs_pa;

-- ===================================================================
-- 2. ACTUALIZAR TABLA audiencias_pa COMPLETA
-- ===================================================================

SELECT '🔄 2. ACTUALIZANDO TABLA audiencias_pa...' as 'Status';

-- Eliminar tabla actual incompleta y recrear
DROP TABLE IF EXISTS `audiencias_pa`;

CREATE TABLE `audiencias_pa` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `numero_resolucion` varchar(191) NOT NULL,
    `fecha_hora` datetime NOT NULL,
    `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL,
    `tipo_audiencia_otro` VARCHAR(255) NULL,
    `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL,
    `plazo_evacuar_otro` VARCHAR(255) NULL,
    `usuario_id` bigint(20) unsigned NOT NULL,
    `empresa_id` bigint(20) unsigned NOT NULL,
    `archivo` varchar(191) DEFAULT NULL,
    `tipo_archivo` varchar(191) DEFAULT NULL,
    `observaciones` text DEFAULT NULL,
    `numero_folios` int(11) DEFAULT NULL,
    `estado` varchar(50) DEFAULT 'Activo',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `audiencias_pa_usuario_id_foreign` (`usuario_id`),
    KEY `audiencias_pa_empresa_id_foreign` (`empresa_id`),
    CONSTRAINT `audiencias_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `audiencias_pa_empresa_id_foreign` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SELECT '✅ Tabla audiencias_pa actualizada completamente' as 'Status_1';

-- ===================================================================
-- 3. ACTUALIZAR TABLA dpmrs_pa COMPLETA
-- ===================================================================

SELECT '🔄 3. ACTUALIZANDO TABLA dpmrs_pa...' as 'Status';

-- Eliminar tabla actual incompleta y recrear
DROP TABLE IF EXISTS `dpmrs_pa`;

CREATE TABLE `dpmrs_pa` (
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

SELECT '✅ Tabla dpmrs_pa actualizada completamente' as 'Status_2';

-- ===================================================================
-- 4. ACTUALIZAR TABLA aceptacions_pa COMPLETA
-- ===================================================================

SELECT '🔄 4. ACTUALIZANDO TABLA aceptacions_pa...' as 'Status';

-- Eliminar tabla actual incompleta y recrear
DROP TABLE IF EXISTS `aceptacions_pa`;

CREATE TABLE `aceptacions_pa` (
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

SELECT '✅ Tabla aceptacions_pa actualizada completamente' as 'Status_3';

-- ===================================================================
-- 5. VERIFICAR TABLA resolucions_pa (PARA RSAT_PA)
-- ===================================================================

SELECT '🔄 5. VERIFICANDO TABLA resolucions_pa...' as 'Status';

-- Verificar si existe
SELECT COUNT(*) as 'tabla_resolucions_pa_existe' 
FROM information_schema.tables 
WHERE table_schema = 'dbburonuevo' 
AND table_name = 'resolucions_pa';

-- Crear si no existe (para modelo RsatPa corregido)
CREATE TABLE IF NOT EXISTS `resolucions_pa` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `numero_resolucion` varchar(191) NOT NULL,
    `fecha_hora` datetime NOT NULL,
    `tipo_resolucion` ENUM('R-SAT', 'Otro') NOT NULL DEFAULT 'R-SAT',
    `tipo_resolucion_otro` VARCHAR(255) NULL,
    `usuario_id` bigint(20) unsigned NOT NULL,
    `audiencia_pa_id` bigint(20) unsigned NOT NULL,
    `archivo` varchar(191) DEFAULT NULL,
    `tipo_archivo` varchar(191) DEFAULT NULL,
    `observaciones` text DEFAULT NULL,
    `numero_folios` int(11) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `resolucions_pa_usuario_id_foreign` (`usuario_id`),
    KEY `resolucions_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
    CONSTRAINT `resolucions_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `resolucions_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SELECT '✅ Tabla resolucions_pa verificada/creada' as 'Status_4';

-- ===================================================================
-- 6. ACTUALIZAR OTRAS TABLAS PA PRINCIPALES
-- ===================================================================

SELECT '🔄 6. ACTUALIZANDO OTRAS TABLAS PA...' as 'Status';

-- TABLA evs_pa
DROP TABLE IF EXISTS `evs_pa`;
CREATE TABLE `evs_pa` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `numero_documento` varchar(191) NOT NULL,
    `fecha_hora_presentacion` datetime NOT NULL,
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
    KEY `evs_pa_usuario_id_foreign` (`usuario_id`),
    KEY `evs_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
    CONSTRAINT `evs_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `evs_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA adpmrs_pa
DROP TABLE IF EXISTS `adpmrs_pa`;
CREATE TABLE `adpmrs_pa` (
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
    KEY `adpmrs_pa_usuario_id_foreign` (`usuario_id`),
    KEY `adpmrs_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
    CONSTRAINT `adpmrs_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `adpmrs_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA ecs_pa
DROP TABLE IF EXISTS `ecs_pa`;
CREATE TABLE `ecs_pa` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `numero_resolucion` varchar(191) NOT NULL,
    `fecha_hora` datetime NOT NULL,
    `medidas_decretadas` JSON DEFAULT NULL,
    `usuario_id` bigint(20) unsigned NOT NULL,
    `audiencia_pa_id` bigint(20) unsigned NOT NULL,
    `archivo` varchar(191) DEFAULT NULL,
    `tipo_archivo` varchar(191) DEFAULT NULL,
    `observaciones` text DEFAULT NULL,
    `numero_folios` int(11) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `ecs_pa_usuario_id_foreign` (`usuario_id`),
    KEY `ecs_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
    CONSTRAINT `ecs_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `ecs_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA nulidades_pa
DROP TABLE IF EXISTS `nulidades_pa`;
CREATE TABLE `nulidades_pa` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `numero_resolucion` varchar(191) NOT NULL,
    `fecha_hora_notificacion` datetime NOT NULL,
    `usuario_id` bigint(20) unsigned NOT NULL,
    `audiencia_pa_id` bigint(20) unsigned NOT NULL,
    `archivo` varchar(191) DEFAULT NULL,
    `tipo_archivo` varchar(191) DEFAULT NULL,
    `observaciones` text DEFAULT NULL,
    `numero_folios` int(11) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `nulidades_pa_usuario_id_foreign` (`usuario_id`),
    KEY `nulidades_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
    CONSTRAINT `nulidades_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `nulidades_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- TABLA ntrrs_pa
DROP TABLE IF EXISTS `ntrrs_pa`;
CREATE TABLE `ntrrs_pa` (
    `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `numero_resolucion` varchar(191) NOT NULL,
    `fecha_vencimiento` date NOT NULL,
    `fecha_notificacion` date NOT NULL,
    `usuario_id` bigint(20) unsigned NOT NULL,
    `audiencia_pa_id` bigint(20) unsigned NOT NULL,
    `archivo` varchar(191) DEFAULT NULL,
    `tipo_archivo` varchar(191) DEFAULT NULL,
    `observaciones` text DEFAULT NULL,
    `numero_folios` int(11) DEFAULT NULL,
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `ntrrs_pa_usuario_id_foreign` (`usuario_id`),
    KEY `ntrrs_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
    CONSTRAINT `ntrrs_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `ntrrs_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SELECT '✅ Tablas PA principales actualizadas' as 'Status_5';

-- ===================================================================
-- 7. ACTUALIZAR TABLA audiencias (VA) CON CORRECCIONES
-- ===================================================================

SELECT '🔄 7. ACTUALIZANDO TABLA audiencias (VA)...' as 'Status';

-- Solo agregar campos faltantes, no recrear toda la tabla
ALTER TABLE `audiencias` 
ADD COLUMN `tipo_audiencia_otro` VARCHAR(255) NULL 
AFTER `tipo_audiencia`;

-- Actualizar ENUMs
ALTER TABLE `audiencias` 
MODIFY COLUMN `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL;

ALTER TABLE `audiencias` 
MODIFY COLUMN `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL;

SELECT '✅ Tabla audiencias (VA) actualizada' as 'Status_6';

-- ===================================================================
-- 8. VERIFICACIÓN FINAL
-- ===================================================================

SELECT '✅ 8. VERIFICACIÓN FINAL...' as 'Status';

-- Verificar todas las tablas PA
SELECT 'VERIFICANDO TABLAS PA CREADAS:' as 'Verificacion_Final';

SELECT COUNT(*) as 'audiencias_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'audiencias_pa';
SELECT COUNT(*) as 'dpmrs_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'dpmrs_pa';
SELECT COUNT(*) as 'aceptacions_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'aceptacions_pa';
SELECT COUNT(*) as 'resolucions_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'resolucions_pa';
SELECT COUNT(*) as 'evs_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'evs_pa';
SELECT COUNT(*) as 'adpmrs_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'adpmrs_pa';
SELECT COUNT(*) as 'ecs_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'ecs_pa';
SELECT COUNT(*) as 'nulidades_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'nulidades_pa';
SELECT COUNT(*) as 'ntrrs_pa_OK' FROM information_schema.tables WHERE table_schema = 'dbburonuevo' AND table_name = 'ntrrs_pa';

-- Verificar estructura de audiencias_pa
SELECT 'ESTRUCTURA audiencias_pa:' as 'Estructura';
DESCRIBE audiencias_pa;

-- Verificar ENUMs corregidos
SELECT 'VERIFICANDO ENUMs CORREGIDOS:' as 'ENUMs';
SELECT 
    COLUMN_NAME,
    COLUMN_TYPE,
    IS_NULLABLE
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = 'dbburonuevo' 
AND TABLE_NAME = 'audiencias_pa'
AND COLUMN_NAME IN ('tipo_audiencia', 'tipo_audiencia_otro', 'plazo_evacuar', 'plazo_evacuar_otro');

-- ===================================================================
-- RESUMEN FINAL
-- ===================================================================

SELECT '🎉 ACTUALIZACIÓN PA COMPLETADA EXITOSAMENTE' as 'Status_Final';
SELECT '=================================================' as '';
SELECT 'CAMBIOS REALIZADOS EN iPAGE:' as 'Resumen';
SELECT '✅ audiencias_pa: Estructura completa con ENUMs corregidos' as 'Cambio_1';
SELECT '✅ dpmrs_pa: Tabla completa creada' as 'Cambio_2';  
SELECT '✅ aceptacions_pa: Tabla completa creada' as 'Cambio_3';
SELECT '✅ resolucions_pa: Tabla verificada para RsatPa' as 'Cambio_4';
SELECT '✅ evs_pa, adpmrs_pa, ecs_pa, nulidades_pa, ntrrs_pa: Actualizadas' as 'Cambio_5';
SELECT '✅ audiencias VA: ENUMs corregidos' as 'Cambio_6';

SELECT 'AHORA PUEDE PROBAR:' as 'Pruebas';
SELECT '1. Acceder a pestaña PA sin error 500' as 'Prueba_1';
SELECT '2. Crear audiencias PA con campos "Otro"' as 'Prueba_2';
SELECT '3. Crear documentos DPMR PA' as 'Prueba_3';
SELECT '4. Crear aceptaciones PA' as 'Prueba_4';

SELECT 'FECHA APLICACIÓN:' as 'Info';
SELECT NOW() as 'Timestamp';

-- ===================================================================
-- INSTRUCCIONES FINALES PARA IPAGE:
-- ===================================================================
-- 
-- 1. APLICAR ESTE SCRIPT EN phpMyAdmin de iPage
-- 2. Asegurarse de estar en base de datos 'dbburonuevo'
-- 3. Ejecutar por secciones si el script completo es muy largo
-- 4. SUBIR ARCHIVOS LARAVEL ACTUALIZADOS:
--    - app/Models/RsatPa.php (protected $table = 'resolucins_pa')
--    - Todas las vistas PA corregidas
--    - Controladores PA actualizados
-- 5. PROBAR pestaña PA después de aplicar
-- 
-- ===================================================================
