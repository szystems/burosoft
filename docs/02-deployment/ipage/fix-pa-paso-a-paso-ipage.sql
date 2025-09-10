-- ===================================================================
-- SCRIPT PASO A PASO PA - iPAGE (EJECUTAR SECCIÓN POR SECCIÓN)
-- ===================================================================

-- PASO 1: RECREAR audiencias_pa
-- Desactivar foreign key checks temporalmente
SET FOREIGN_KEY_CHECKS = 0;
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
-- Reactivar foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- ===================================================================

-- PASO 2: RECREAR dpmrs_pa
-- Desactivar foreign key checks temporalmente
SET FOREIGN_KEY_CHECKS = 0;
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
-- Reactivar foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- ===================================================================

-- PASO 3: RECREAR aceptacions_pa
-- Desactivar foreign key checks temporalmente
SET FOREIGN_KEY_CHECKS = 0;
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
-- Reactivar foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- ===================================================================

-- PASO 4: CREAR resolucions_pa (para RsatPa)
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
    KEY `resolucins_pa_usuario_id_foreign` (`usuario_id`),
    KEY `resolucins_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
    CONSTRAINT `resolucins_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
    CONSTRAINT `resolucins_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================================

-- PASO 5: CORREGIR audiencias VA
ALTER TABLE `audiencias` ADD COLUMN `tipo_audiencia_otro` VARCHAR(255) NULL AFTER `tipo_audiencia`;
ALTER TABLE `audiencias` MODIFY COLUMN `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL;
ALTER TABLE `audiencias` MODIFY COLUMN `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL;

-- ===================================================================

-- VERIFICACIÓN:
DESCRIBE audiencias_pa;
DESCRIBE dpmrs_pa;
DESCRIBE aceptacions_pa;
DESCRIBE resolucins_pa;

-- FIN - YA PUEDE PROBAR PESTAÑA PA SIN ERROR 500
