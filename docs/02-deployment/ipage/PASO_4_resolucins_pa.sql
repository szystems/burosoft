-- ===================================================================
-- PASO 4: CREAR/VERIFICAR TABLA resolucions_pa (PARA RSAT_PA)
-- ===================================================================

-- Verificar si existe
SELECT COUNT(*) as 'tabla_resolucins_pa_existe' 
FROM information_schema.tables 
WHERE table_schema = 'dbburonuevo' 
AND table_name = 'resolucins_pa';

-- Crear tabla resolucins_pa si no existe (para modelo RsatPa)
CREATE TABLE IF NOT EXISTS `resolucins_pa` (
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

-- Verificar estructura final
DESCRIBE resolucins_pa;
