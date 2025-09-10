-- ===================================================================
-- PASO 2 SIMPLE: AGREGAR SOLO COLUMNAS FALTANTES EN dpmrs_pa
-- ===================================================================

-- EJECUTAR SOLO LAS LÍNEAS QUE NO DEN ERROR
-- Si una columna ya existe, salta a la siguiente

-- 1. Intentar agregar cada columna individualmente:

-- Solo ejecutar si no existe:
-- ALTER TABLE `dpmrs_pa` ADD COLUMN `numero_resolucion` varchar(191) NOT NULL DEFAULT '' AFTER `id`;

-- Solo ejecutar si no existe:
-- ALTER TABLE `dpmrs_pa` ADD COLUMN `fecha_hora` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `numero_resolucion`;

-- Solo ejecutar si no existe:
-- ALTER TABLE `dpmrs_pa` ADD COLUMN `usuario_id` bigint(20) unsigned NOT NULL DEFAULT 1 AFTER `fecha_hora`;

-- Solo ejecutar si no existe:
-- ALTER TABLE `dpmrs_pa` ADD COLUMN `audiencia_pa_id` bigint(20) unsigned NOT NULL DEFAULT 1 AFTER `usuario_id`;

-- Estas probablemente no existen:
ALTER TABLE `dpmrs_pa` ADD COLUMN `archivo` varchar(191) NULL;
ALTER TABLE `dpmrs_pa` ADD COLUMN `tipo_archivo` varchar(191) NULL;
ALTER TABLE `dpmrs_pa` ADD COLUMN `observaciones` text NULL;
ALTER TABLE `dpmrs_pa` ADD COLUMN `numero_folios` int(11) NULL;
ALTER TABLE `dpmrs_pa` ADD COLUMN `created_at` timestamp NULL DEFAULT NULL;

-- 2. Agregar índices (solo si no existen)
-- ALTER TABLE `dpmrs_pa` ADD KEY `dpmrs_pa_usuario_id_foreign` (`usuario_id`);
-- ALTER TABLE `dpmrs_pa` ADD KEY `dpmrs_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`);

-- 3. Verificar estructura final
DESCRIBE dpmrs_pa;
