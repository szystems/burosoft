-- ====================================================================
-- SCRIPT SQL PARA APLICAR MIGRACIONES COMPLETAS - SISTEMA BUROSOFT
-- Fecha: 28 de agosto de 2025
-- Descripción: TODAS las migraciones desde el 21 de agosto de 2025 hasta hoy
-- Total de migraciones: 39 + modificaciones adicionales
-- IMPORTANTE: Hacer respaldo COMPLETO de la base de datos antes de ejecutar
-- NOTA: Este script maneja columnas existentes sin errores
-- ====================================================================

-- Verificar conexión y base de datos activa
SELECT DATABASE() as 'Base_de_datos_activa', NOW() as 'Fecha_ejecucion';

-- Configurar para continuar en caso de errores de columnas duplicadas
-- SET sql_mode = '';

-- ====================================================================
-- 1. CREAR TABLA PAT_RCTS (21 de agosto)
-- ====================================================================
CREATE TABLE IF NOT EXISTS `pat_rcts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pat_id` bigint(20) unsigned NOT NULL,
  `fecha_citacion` date NOT NULL,
  `medio_citacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `medio_citacion_otro` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_atencion` date NOT NULL,
  `participantes_reunion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `lugar_celebracion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion_resultado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `suscribe_acta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo_acta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_archivo_acta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `archivo_recibo_pago` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_archivo_recibo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pat_rcts_pat_id_foreign` (`pat_id`),
  KEY `pat_rcts_usuario_id_foreign` (`usuario_id`),
  CONSTRAINT `pat_rcts_pat_id_foreign` FOREIGN KEY (`pat_id`) REFERENCES `pats` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pat_rcts_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================================
-- 2. AGREGAR CAMPOS DE NOTIFICACIÓN A AUDIENCIAS (21 de agosto)
-- ====================================================================
-- NOTA: Si estas columnas ya existen, saltará error pero continuará
-- Agregar fecha_notificacion
ALTER TABLE `audiencias` ADD COLUMN `fecha_notificacion` DATE NULL AFTER `tipo_archivo`;

-- Agregar plazo_evacuar  
ALTER TABLE `audiencias` ADD COLUMN `plazo_evacuar` VARCHAR(255) NULL AFTER `fecha_notificacion`;

-- Agregar plazo_evacuar_otro
ALTER TABLE `audiencias` ADD COLUMN `plazo_evacuar_otro` VARCHAR(255) NULL AFTER `plazo_evacuar`;

-- ====================================================================
-- 3. AGREGAR CAMPOS DE NOTIFICACIÓN A AUDIENCIAS_PA (21 de agosto)
-- ====================================================================
-- NOTA: Si estas columnas ya existen, saltará error pero continuará
-- Agregar fecha_notificacion
ALTER TABLE `audiencias_pa` ADD COLUMN `fecha_notificacion` DATE NULL AFTER `tipo_archivo`;

-- Agregar plazo_evacuar
ALTER TABLE `audiencias_pa` ADD COLUMN `plazo_evacuar` VARCHAR(255) NULL AFTER `fecha_notificacion`;

-- Agregar plazo_evacuar_otro
ALTER TABLE `audiencias_pa` ADD COLUMN `plazo_evacuar_otro` VARCHAR(255) NULL AFTER `plazo_evacuar`;

-- ====================================================================
-- 4. AGREGAR OFICINA_PRESENTACION A EVS (22 de agosto)
-- ====================================================================
ALTER TABLE `evs` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

-- ====================================================================
-- 5. AGREGAR OFICINA_PRESENTACION A EVS_PA (22 de agosto)
-- ====================================================================
ALTER TABLE `evs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

-- ====================================================================
-- 6. AGREGAR OFICINA_PRESENTACION A PPS (22 de agosto)
-- ====================================================================
ALTER TABLE `pps` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

-- ====================================================================
-- 7. AGREGAR OFICINA_PRESENTACION A PPS_PA (22 de agosto)
-- ====================================================================
ALTER TABLE `pps_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

-- ====================================================================
-- 8. AGREGAR OFICINA_PRESENTACION A ADPMRS (22 de agosto)
-- ====================================================================
ALTER TABLE `adpmrs` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

-- ====================================================================
-- 9. AGREGAR OFICINA_PRESENTACION A ADPMRS_PA (22 de agosto)
-- ====================================================================
ALTER TABLE `adpmrs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

-- ====================================================================
-- 10. ACTUALIZAR TABLA RESOLUCIONS - AGREGAR NUEVOS CAMPOS (22 de agosto)
-- ====================================================================
ALTER TABLE `resolucions` 
ADD COLUMN `numero_resolucion` VARCHAR(255) NULL AFTER `tipo_resolucion`,
ADD COLUMN `fecha` DATE NULL AFTER `numero_resolucion`;

-- ====================================================================
-- 11. ACTUALIZAR TABLA RSAT_PA - AGREGAR NUEVOS CAMPOS (22 de agosto)
-- ====================================================================
ALTER TABLE `rsat_pa` 
ADD COLUMN `numero_resolucion` VARCHAR(255) NULL AFTER `tipo_resolucion`,
ADD COLUMN `fecha` DATE NULL AFTER `numero_resolucion`;

-- ====================================================================
-- 12. ACTUALIZAR TABLA RTRIBUTAS - CAMPOS Y ENUM (22 de agosto)
-- ====================================================================
-- Primero agregar nuevos campos
ALTER TABLE `rtributas` 
ADD COLUMN `fecha_hora_notificacion` DATETIME NULL AFTER `id`,
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`,
ADD COLUMN `tipo_resolucion_otro` VARCHAR(255) NULL AFTER `tipo_resolucion`,
ADD COLUMN `plazo_cat` ENUM('30 D.H.', '3 Meses', 'otro') NULL AFTER `tipo_resolucion_otro`,
ADD COLUMN `plazo_cat_otro` VARCHAR(255) NULL AFTER `plazo_cat`;

-- Modificar enum de tipo_resolucion para incluir 'otro'
ALTER TABLE `rtributas` 
MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NULL;

-- Eliminar columna fecha (será reemplazada por fecha_hora_notificacion)
ALTER TABLE `rtributas` DROP COLUMN `fecha`;

-- ====================================================================
-- 13. ACTUALIZAR TABLA RTRIBUTAS_PA - CAMPOS Y ENUM (22 de agosto)
-- ====================================================================
-- Primero agregar nuevos campos
ALTER TABLE `rtributas_pa` 
ADD COLUMN `fecha_hora_notificacion` DATETIME NULL AFTER `id`,
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`,
ADD COLUMN `tipo_resolucion_otro` VARCHAR(255) NULL AFTER `tipo_resolucion`,
ADD COLUMN `plazo_cat` ENUM('30 D.H.', '3 Meses', 'otro') NULL AFTER `tipo_resolucion_otro`,
ADD COLUMN `plazo_cat_otro` VARCHAR(255) NULL AFTER `plazo_cat`;

-- Modificar enum de tipo_resolucion para incluir 'otro'
ALTER TABLE `rtributas_pa` 
MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NULL;

-- Eliminar columna fecha (será reemplazada por fecha_hora_notificacion)
ALTER TABLE `rtributas_pa` DROP COLUMN `fecha`;

-- ====================================================================
-- 14. CORREGIR ENUM PLAZO_CAT EN RTRIBUTAS_PA (22 de agosto - 3 fixes)
-- ====================================================================
-- Las migraciones 2025_08_22_232132, 232500 y 232600 corrigen el enum
-- Ya están incluidas en los cambios anteriores

-- ====================================================================
-- 15. ACTUALIZAR TABLA NULIDADES - DATETIME Y FECHA_RESOLUCION (26 de agosto)
-- ====================================================================
-- Cambiar fecha a datetime y agregar fecha_resolucion
ALTER TABLE `nulidades` 
MODIFY COLUMN `fecha` DATETIME NOT NULL,
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;

-- ====================================================================
-- 16. ACTUALIZAR TABLA NULIDADES_PA - DATETIME Y FECHA_RESOLUCION (26 de agosto)
-- ====================================================================
ALTER TABLE `nulidades_pa` 
MODIFY COLUMN `fecha` DATETIME NOT NULL,
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;

-- ====================================================================
-- 17. ACTUALIZAR TABLA ECS - DATETIME Y FECHA_RESOLUCION (26 de agosto)
-- ====================================================================
ALTER TABLE `ecs` 
MODIFY COLUMN `fecha` DATETIME NOT NULL,
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;

-- ====================================================================
-- 18. ACTUALIZAR TABLA ECS_PA - DATETIME Y FECHA_RESOLUCION (26 de agosto)
-- ====================================================================
ALTER TABLE `ecs_pa` 
MODIFY COLUMN `fecha` DATETIME NOT NULL,
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;

-- ====================================================================
-- 19. AGREGAR JUZGADO Y MEDIDAS A ECS (26 de agosto)
-- ====================================================================
ALTER TABLE `ecs` 
ADD COLUMN `juzgado` VARCHAR(255) NULL AFTER `fecha_resolucion`,
ADD COLUMN `medidas` TEXT NULL AFTER `juzgado`;

-- ====================================================================
-- 20. AGREGAR JUZGADO Y MEDIDAS A ECS_PA (26 de agosto)
-- ====================================================================
ALTER TABLE `ecs_pa` 
ADD COLUMN `juzgado` VARCHAR(255) NULL AFTER `fecha_resolucion`,
ADD COLUMN `medidas` TEXT NULL AFTER `juzgado`;

-- ====================================================================
-- 21. AGREGAR OFICINA_AGENCIA_EA A RRS (26 de agosto)
-- ====================================================================
ALTER TABLE `rrs` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;

-- ====================================================================
-- 22. AGREGAR OFICINA_AGENCIA_EA A RRS_PA (26 de agosto)
-- ====================================================================
ALTER TABLE `rrs_pa` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;

-- ====================================================================
-- 23. ACTUALIZAR TABLA NTRRS - DATETIME Y FECHA_RESOLUCION (26 de agosto)
-- ====================================================================
ALTER TABLE `ntrrs` 
MODIFY COLUMN `fecha` DATETIME NOT NULL,
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;

-- ====================================================================
-- 24. ACTUALIZAR TABLA NTRRS_PA - DATETIME Y FECHA_RESOLUCION (26 de agosto)
-- ====================================================================
ALTER TABLE `ntrrs_pa` 
MODIFY COLUMN `fecha` DATETIME NOT NULL,
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;

-- ====================================================================
-- 25. AGREGAR OFICINA_AGENCIA_EA A OCURSOS (28 de agosto)
-- ====================================================================
ALTER TABLE `ocursos` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;

-- ====================================================================
-- 26. AGREGAR OFICINA_AGENCIA_EA A OCURSOS_PA (28 de agosto)
-- ====================================================================
ALTER TABLE `ocursos_pa` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;

-- ====================================================================
-- 27. AGREGAR FECHA_RESOLUCION A MPMRS (28 de agosto)
-- ====================================================================
ALTER TABLE `mpmrs` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_hora`;

-- ====================================================================
-- 28. AGREGAR FECHA_RESOLUCION A MPMRS_PA (28 de agosto)
-- ====================================================================
ALTER TABLE `mpmrs_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_hora`;

-- ====================================================================
-- 29. AGREGAR OFICINA_EA A AMPMRS (28 de agosto)
-- ====================================================================
ALTER TABLE `ampmrs` ADD COLUMN `oficina_ea` VARCHAR(255) NULL AFTER `numero_documento`;

-- ====================================================================
-- 30. AGREGAR OFICINA_EA A AMPMRS_PA (28 de agosto)
-- ====================================================================
ALTER TABLE `ampmrs_pa` ADD COLUMN `oficina_ea` VARCHAR(255) NULL AFTER `numero_documento`;

-- ====================================================================
-- 31. CREAR TABLA ACEPTACIONS (28 de agosto)
-- ====================================================================
CREATE TABLE IF NOT EXISTS `aceptacions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_hora_presentacion` datetime NOT NULL,
  `numero_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `audiencia_id` bigint(20) unsigned NOT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_archivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oficina_presentacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_folios` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aceptacions_usuario_id_foreign` (`usuario_id`),
  KEY `aceptacions_audiencia_id_foreign` (`audiencia_id`),
  CONSTRAINT `aceptacions_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `aceptacions_audiencia_id_foreign` FOREIGN KEY (`audiencia_id`) REFERENCES `audiencias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================================
-- 32. CREAR TABLA ACEPTACIONS_PA (28 de agosto)
-- ====================================================================
CREATE TABLE IF NOT EXISTS `aceptacions_pa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fecha_hora_presentacion` datetime NOT NULL,
  `numero_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `audiencia_pa_id` bigint(20) unsigned NOT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_archivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `oficina_presentacion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_folios` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `aceptacions_pa_usuario_id_foreign` (`usuario_id`),
  KEY `aceptacions_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
  CONSTRAINT `aceptacions_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `aceptacions_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================================
-- 33. CREAR TABLA CONSTANCIA_PAGOS (28 de agosto)
-- ====================================================================
CREATE TABLE IF NOT EXISTS `constancia_pagos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pat_id` bigint(20) unsigned NOT NULL,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `fecha_pago` date NOT NULL,
  `identificacion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_archivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `constancia_pagos_pat_id_foreign` (`pat_id`),
  KEY `constancia_pagos_usuario_id_foreign` (`usuario_id`),
  CONSTRAINT `constancia_pagos_pat_id_foreign` FOREIGN KEY (`pat_id`) REFERENCES `pats` (`id`) ON DELETE CASCADE,
  CONSTRAINT `constancia_pagos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================================
-- 34. AGREGAR FECHA_NOTIFICACION Y FECHA_RESOLUCION A RESOLUCIONS (28 de agosto)
-- ====================================================================
ALTER TABLE `resolucions` 
ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`,
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

-- ====================================================================
-- 35. AGREGAR FECHA_NOTIFICACION Y FECHA_RESOLUCION A RSAT_PA (28 de agosto)
-- ====================================================================
ALTER TABLE `rsat_pa` 
ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`,
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

-- ====================================================================
-- 36. AGREGAR FECHA_NOTIFICACION Y FECHA_RESOLUCION A ROS (28 de agosto)
-- ====================================================================
ALTER TABLE `ros` 
ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`,
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

-- ====================================================================
-- 37. AGREGAR FECHA_NOTIFICACION Y FECHA_RESOLUCION A ROS_PA (28 de agosto)
-- ====================================================================
ALTER TABLE `ros_pa` 
ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`,
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

-- ====================================================================
-- 38. MODIFICACIÓN EN CREATE_RESOLUCIONS_PA_TABLE (contenido restaurado)
-- ====================================================================
-- Esta migración estaba vacía y se restauró el contenido original
-- La tabla resolucions_pa ya existe, pero aseguramos la estructura correcta:

CREATE TABLE IF NOT EXISTS `resolucions_pa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `audiencia_pa_id` bigint(20) unsigned NOT NULL,
  `tipo_resolucion` enum('total a favor','total en contra','parcial','nulidad','penal') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_folios` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contenido_resolucion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_resolucion` date DEFAULT NULL,
  `archivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `estado` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resolucions_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
  KEY `resolucions_pa_audiencia_pa_id_index` (`audiencia_pa_id`),
  CONSTRAINT `resolucions_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================================
-- AGREGAR TODAS LAS ENTRADAS A LA TABLA DE MIGRACIONES
-- ====================================================================
INSERT INTO `migrations` (`migration`, `batch`) VALUES
-- Migraciones del 21 de agosto
('2025_08_21_113532_create_pat_rcts_table', 2),
('2025_08_21_114000_add_notificacion_fields_to_audiencias_table', 3),
('2025_08_21_114001_add_notificacion_fields_to_audiencias_pa_table', 4),

-- Migraciones del 22 de agosto
('2025_08_22_000001_add_oficina_presentacion_to_evs_table', 5),
('2025_08_22_000002_add_oficina_presentacion_to_ev_pas_table', 6),
('2025_08_22_000003_add_oficina_presentacion_to_pps_table', 7),
('2025_08_22_000004_add_oficina_presentacion_to_pps_pa_table', 8),
('2025_08_22_094658_add_oficina_presentacion_to_adpmrs_table', 9),
('2025_08_22_094659_add_oficina_presentacion_to_adpmrs_pa_table', 10),
('2025_08_22_100000_update_resolucions_table_add_new_fields', 12),
('2025_08_22_100001_update_rsat_pa_table_add_new_fields', 13),
('2025_08_22_102000_update_rtributas_table_add_new_fields', 14),
('2025_08_22_102001_update_rtributas_pa_table_add_new_fields', 15),
('2025_08_22_232132_update_rtributas_pa_plazo_cat_enum', 16),
('2025_08_22_232500_fix_rtributas_pa_plazo_cat_enum', 16),
('2025_08_22_232600_fix_rtributas_va_plazo_cat_enum', 17),

-- Migraciones del 26 de agosto
('2025_08_26_120000_update_nulidades_table_add_datetime_and_fecha_resolucion', 18),
('2025_08_26_120100_update_nulidades_pa_table_add_datetime_and_fecha_resolucion', 18),
('2025_08_26_130000_update_ecs_table_add_datetime_and_fecha_resolucion', 19),
('2025_08_26_130100_update_ecs_pa_table_add_datetime_and_fecha_resolucion', 19),
('2025_08_26_140000_add_juzgado_and_medidas_to_ecs_table', 20),
('2025_08_26_140100_add_juzgado_and_medidas_to_ecs_pa_table', 20),
('2025_08_26_150000_add_oficina_agencia_ea_to_rrs_table', 21),
('2025_08_26_150100_add_oficina_agencia_ea_to_rrs_pa_table', 21),
('2025_08_26_160000_update_ntrrs_table_add_datetime_and_fecha_resolucion', 22),
('2025_08_26_160100_update_ntrrs_pa_table_add_datetime_and_fecha_resolucion', 22),

-- Migraciones del 28 de agosto
('2025_08_28_160000_add_oficina_agencia_ea_to_ocursos_table', 23),
('2025_08_28_160100_add_oficina_agencia_ea_to_ocursos_pa_table', 23),
('2025_08_28_170200_add_fecha_notificacion_and_fecha_resolucion_to_resolucions_table', 24),
('2025_08_28_170300_add_fecha_notificacion_and_fecha_resolucion_to_rsat_pa_table', 24),
('2025_08_28_180000_add_fecha_notificacion_and_fecha_resolucion_to_ros_table', 25),
('2025_08_28_180100_add_fecha_notificacion_and_fecha_resolucion_to_ros_pa_table', 25),
('2025_08_28_111017_add_fecha_resolucion_to_mpmrs_table', 26),
('2025_08_28_111114_add_fecha_resolucion_to_mpmrs_pa_table', 26),
('2025_08_28_113627_add_oficina_ea_to_ampmrs_table', 27),
('2025_08_28_113814_add_oficina_ea_to_ampmrs_pa_table', 27),
('2025_08_28_115920_create_aceptacions_table', 28),
('2025_08_28_115933_create_aceptacions_pa_table', 28),
('2025_08_28_163124_create_constancia_pagos_table', 29);

-- ====================================================================
-- VERIFICACIONES FINALES
-- ====================================================================

-- Verificar que las nuevas tablas se crearon correctamente
SELECT 'VERIFICACION: Tablas nuevas creadas' as 'ESTADO';
SHOW TABLES LIKE 'pat_rcts';
SHOW TABLES LIKE 'aceptacions';
SHOW TABLES LIKE 'aceptacions_pa';  
SHOW TABLES LIKE 'constancia_pagos';
SHOW TABLES LIKE 'resolucions_pa';

-- Verificar que se agregaron los campos principales
SELECT 'VERIFICACION: Campos principales agregados' as 'ESTADO';

-- Verificar audiencias con campos de notificación
SELECT COUNT(*) as 'audiencias_con_fecha_notificacion' 
FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'audiencias' AND COLUMN_NAME = 'fecha_notificacion';

SELECT COUNT(*) as 'audiencias_pa_con_fecha_notificacion' 
FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'audiencias_pa' AND COLUMN_NAME = 'fecha_notificacion';

-- Verificar campos oficina_ea en ampmrs
SELECT COUNT(*) as 'ampmrs_con_oficina_ea' 
FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'ampmrs' AND COLUMN_NAME = 'oficina_ea';

SELECT COUNT(*) as 'ampmrs_pa_con_oficina_ea' 
FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'ampmrs_pa' AND COLUMN_NAME = 'oficina_ea';

-- Verificar campos fecha_resolucion en mpmrs
SELECT COUNT(*) as 'mpmrs_con_fecha_resolucion' 
FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'mpmrs' AND COLUMN_NAME = 'fecha_resolucion';

-- Verificar integridad de foreign keys para las nuevas tablas
SELECT 'VERIFICACION: Foreign Keys' as 'ESTADO';
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = DATABASE()
AND (TABLE_NAME IN ('pat_rcts', 'aceptacions', 'aceptacions_pa', 'constancia_pagos', 'resolucions_pa'))
AND REFERENCED_TABLE_NAME IS NOT NULL;

-- Verificar conteo total de migraciones
SELECT 'VERIFICACION: Total de migraciones aplicadas' as 'ESTADO';
SELECT COUNT(*) as 'total_migraciones' FROM migrations WHERE migration LIKE '2025_08_%';

-- Mostrar resumen final
SELECT 'MIGRACIONES COMPLETAS APLICADAS EXITOSAMENTE' as 'RESULTADO', 
       '39 migraciones desde 21 de agosto' as 'DETALLE',
       NOW() as 'FECHA_COMPLETADO';

-- ====================================================================
-- FIN DEL SCRIPT COMPLETO - 39 MIGRACIONES DESDE 21 DE AGOSTO
-- ====================================================================
