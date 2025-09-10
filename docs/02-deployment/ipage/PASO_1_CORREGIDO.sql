-- ===================================================================
-- PASO 1 CORREGIDO: RECREAR audiencias_pa (CON FOREIGN KEY FIX)
-- ===================================================================

-- Desactivar verificación de foreign keys temporalmente
SET FOREIGN_KEY_CHECKS = 0;

-- Eliminar tabla existente
DROP TABLE IF EXISTS `audiencias_pa`;

-- Crear tabla audiencias_pa con estructura completa
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

-- Reactivar verificación de foreign keys
SET FOREIGN_KEY_CHECKS = 1;

-- Verificar que se creó correctamente
DESCRIBE audiencias_pa;
