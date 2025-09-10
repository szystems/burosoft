-- ===================================================================
-- PASO 2: ACTUALIZAR ESTRUCTURA EXISTENTE dpmrs_pa
-- ===================================================================

-- Verificar estructura actual
DESCRIBE dpmrs_pa;

-- 1. Agregar columnas faltantes a dpmrs_pa
ALTER TABLE `dpmrs_pa` ADD COLUMN `numero_resolucion` varchar(191) NOT NULL DEFAULT '' AFTER `id`;
ALTER TABLE `dpmrs_pa` ADD COLUMN `fecha_hora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `numero_resolucion`;
ALTER TABLE `dpmrs_pa` ADD COLUMN `usuario_id` bigint(20) unsigned NOT NULL DEFAULT 1 AFTER `fecha_hora`;
ALTER TABLE `dpmrs_pa` ADD COLUMN `audiencia_pa_id` bigint(20) unsigned NOT NULL DEFAULT 1 AFTER `usuario_id`;
ALTER TABLE `dpmrs_pa` ADD COLUMN `archivo` varchar(191) NULL AFTER `audiencia_pa_id`;
ALTER TABLE `dpmrs_pa` ADD COLUMN `tipo_archivo` varchar(191) NULL AFTER `archivo`;
ALTER TABLE `dpmrs_pa` ADD COLUMN `observaciones` text NULL AFTER `tipo_archivo`;
ALTER TABLE `dpmrs_pa` ADD COLUMN `numero_folios` int(11) NULL AFTER `observaciones`;
ALTER TABLE `dpmrs_pa` ADD COLUMN `created_at` timestamp NULL DEFAULT NULL AFTER `numero_folios`;

-- 2. Agregar índices
ALTER TABLE `dpmrs_pa` ADD KEY `dpmrs_pa_usuario_id_foreign` (`usuario_id`);
ALTER TABLE `dpmrs_pa` ADD KEY `dpmrs_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`);

-- 3. Agregar foreign keys
ALTER TABLE `dpmrs_pa` 
ADD CONSTRAINT `dpmrs_pa_usuario_id_foreign` 
FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `dpmrs_pa` 
ADD CONSTRAINT `dpmrs_pa_audiencia_pa_id_foreign` 
FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE;

-- Verificar estructura final
DESCRIBE dpmrs_pa;
