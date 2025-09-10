-- ===================================================================
-- PASO 3: ACTUALIZAR ESTRUCTURA EXISTENTE aceptacions_pa
-- ===================================================================

-- Verificar estructura actual
DESCRIBE aceptacions_pa;

-- 1. Agregar columnas faltantes a aceptacions_pa
ALTER TABLE `aceptacions_pa` ADD COLUMN `fecha_hora_presentacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `id`;
ALTER TABLE `aceptacions_pa` ADD COLUMN `numero_documento` varchar(191) NOT NULL DEFAULT '' AFTER `fecha_hora_presentacion`;
ALTER TABLE `aceptacions_pa` ADD COLUMN `usuario_id` bigint(20) unsigned NOT NULL DEFAULT 1 AFTER `numero_documento`;
ALTER TABLE `aceptacions_pa` ADD COLUMN `audiencia_pa_id` bigint(20) unsigned NOT NULL DEFAULT 1 AFTER `usuario_id`;
ALTER TABLE `aceptacions_pa` ADD COLUMN `archivo` varchar(191) NULL AFTER `audiencia_pa_id`;
ALTER TABLE `aceptacions_pa` ADD COLUMN `tipo_archivo` varchar(191) NULL AFTER `archivo`;
ALTER TABLE `aceptacions_pa` ADD COLUMN `observaciones` text NULL AFTER `tipo_archivo`;
ALTER TABLE `aceptacions_pa` ADD COLUMN `oficina_presentacion` varchar(191) NULL AFTER `observaciones`;
ALTER TABLE `aceptacions_pa` ADD COLUMN `numero_folios` int(11) NULL AFTER `oficina_presentacion`;
ALTER TABLE `aceptacions_pa` ADD COLUMN `created_at` timestamp NULL DEFAULT NULL AFTER `numero_folios`;

-- 2. Agregar índices
ALTER TABLE `aceptacions_pa` ADD KEY `aceptacions_pa_usuario_id_foreign` (`usuario_id`);
ALTER TABLE `aceptacions_pa` ADD KEY `aceptacions_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`);

-- 3. Agregar foreign keys
ALTER TABLE `aceptacions_pa` 
ADD CONSTRAINT `aceptacions_pa_usuario_id_foreign` 
FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `aceptacions_pa` 
ADD CONSTRAINT `aceptacions_pa_audiencia_pa_id_foreign` 
FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE;

-- Verificar estructura final
DESCRIBE aceptacions_pa;
