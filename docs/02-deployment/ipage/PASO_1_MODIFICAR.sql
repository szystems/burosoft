-- ===================================================================
-- PASO 1 ALTERNATIVO: MODIFICAR audiencias_pa SIN RECREARLA
-- ===================================================================

-- En lugar de DROP TABLE, modificamos la estructura existente
-- Esto evita el problema de foreign keys

-- 1. Agregar columnas faltantes una por una
ALTER TABLE `audiencias_pa` ADD COLUMN `numero_resolucion` varchar(191) NOT NULL DEFAULT '';
ALTER TABLE `audiencias_pa` ADD COLUMN `fecha_hora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `audiencias_pa` ADD COLUMN `tipo_audiencia` ENUM('AEC', 'AIR', 'AS', 'AA', 'Otro') NOT NULL DEFAULT 'AEC';
ALTER TABLE `audiencias_pa` ADD COLUMN `tipo_audiencia_otro` VARCHAR(255) NULL;
ALTER TABLE `audiencias_pa` ADD COLUMN `plazo_evacuar` ENUM('5 Dias', '10 Dias', '30 Dias', 'Otro') NULL;
ALTER TABLE `audiencias_pa` ADD COLUMN `plazo_evacuar_otro` VARCHAR(255) NULL;
ALTER TABLE `audiencias_pa` ADD COLUMN `usuario_id` bigint(20) unsigned NOT NULL DEFAULT 1;
ALTER TABLE `audiencias_pa` ADD COLUMN `empresa_id` bigint(20) unsigned NOT NULL DEFAULT 1;
ALTER TABLE `audiencias_pa` ADD COLUMN `archivo` varchar(191) DEFAULT NULL;
ALTER TABLE `audiencias_pa` ADD COLUMN `tipo_archivo` varchar(191) DEFAULT NULL;
ALTER TABLE `audiencias_pa` ADD COLUMN `observaciones` text DEFAULT NULL;
ALTER TABLE `audiencias_pa` ADD COLUMN `numero_folios` int(11) DEFAULT NULL;
ALTER TABLE `audiencias_pa` ADD COLUMN `estado` varchar(50) DEFAULT 'Activo';
ALTER TABLE `audiencias_pa` ADD COLUMN `created_at` timestamp NULL DEFAULT NULL;

-- 2. Agregar índices y foreign keys
ALTER TABLE `audiencias_pa` ADD KEY `audiencias_pa_usuario_id_foreign` (`usuario_id`);
ALTER TABLE `audiencias_pa` ADD KEY `audiencias_pa_empresa_id_foreign` (`empresa_id`);

-- 3. Agregar constraints (si no existen)
ALTER TABLE `audiencias_pa` 
ADD CONSTRAINT `audiencias_pa_usuario_id_foreign` 
FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `audiencias_pa` 
ADD CONSTRAINT `audiencias_pa_empresa_id_foreign` 
FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

-- Verificar estructura final
DESCRIBE audiencias_pa;
