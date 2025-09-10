-- ===================================================================
-- SCRIPT CREAR TABLA dpmrs_pa FALTANTE - iPAGE MySQL 5.7
-- ===================================================================
-- 
-- OBJETIVO: Crear tabla dpmrs_pa que faltaba para audiencias PA
-- COMPATIBLE: MySQL 5.7.44-log (iPage hosting)
-- ===================================================================

USE dbburonuevo;

SELECT '🔧 CREANDO TABLA dpmrs_pa FALTANTE' as 'Status';
SELECT '==========================================' as '';

-- Verificar si la tabla ya existe
SELECT COUNT(*) as 'tabla_existe' 
FROM information_schema.tables 
WHERE table_schema = 'dbburonuevo' 
AND table_name = 'dpmrs_pa';

-- Crear tabla dpmrs_pa si no existe
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

SELECT '✅ TABLA dpmrs_pa CREADA EXITOSAMENTE' as 'Status_Final';

-- Verificar estructura final
DESCRIBE dpmrs_pa;

-- ===================================================================
-- NOTAS:
-- ===================================================================
-- 
-- 1. Esta tabla es necesaria para que funcionen las vistas de audiencias PA
-- 2. Ejecutar ANTES del script principal fix-audiencias-va-pa-ipage.sql
-- 3. Compatible con MySQL 5.7.44-log (iPage)
-- 4. Usar solo si la tabla no existe en producción
-- 
-- ===================================================================
