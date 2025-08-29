-- ====================================================================
-- SCRIPT SQL PARA MIGRACIONES PENDIENTES - SISTEMA BUROSOFT
-- Fecha: 28 de agosto de 2025
-- Descripción: Solo las migraciones que faltan por aplicar
-- IMPORTANTE: Ejecutar solo las secciones necesarias según el estado actual
-- ====================================================================

-- Verificar conexión y base de datos activa
SELECT DATABASE() as 'Base_de_datos_activa', NOW() as 'Fecha_ejecucion';

-- ====================================================================
-- VERIFICAR QUE COLUMNAS YA EXISTEN
-- ====================================================================
SELECT 'VERIFICANDO ESTADO ACTUAL DE LA BASE DE DATOS' as 'ESTADO';

-- Verificar audiencias
SELECT 
    'audiencias' as tabla,
    COLUMN_NAME,
    DATA_TYPE
FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'audiencias' 
AND COLUMN_NAME IN ('fecha_notificacion', 'plazo_evacuar', 'plazo_evacuar_otro')
AND TABLE_SCHEMA = DATABASE();

-- Verificar audiencias_pa
SELECT 
    'audiencias_pa' as tabla,
    COLUMN_NAME,
    DATA_TYPE
FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'audiencias_pa' 
AND COLUMN_NAME IN ('fecha_notificacion', 'plazo_evacuar', 'plazo_evacuar_otro')
AND TABLE_SCHEMA = DATABASE();

-- Verificar tablas principales
SELECT 
    CASE 
        WHEN TABLE_NAME = 'pat_rcts' THEN 'pat_rcts EXISTE'
        WHEN TABLE_NAME = 'aceptacions' THEN 'aceptacions EXISTE'
        WHEN TABLE_NAME = 'aceptacions_pa' THEN 'aceptacions_pa EXISTE'
        WHEN TABLE_NAME = 'constancia_pagos' THEN 'constancia_pagos EXISTE'
        WHEN TABLE_NAME = 'resolucions_pa' THEN 'resolucions_pa EXISTE'
    END as estado
FROM information_schema.TABLES 
WHERE TABLE_NAME IN ('pat_rcts', 'aceptacions', 'aceptacions_pa', 'constancia_pagos', 'resolucions_pa')
AND TABLE_SCHEMA = DATABASE();

-- ====================================================================
-- SECCIONES CONDICIONALES - EJECUTAR SOLO LO QUE FALTA
-- ====================================================================

-- ====================================================================
-- SECCIÓN A: SI FALTA TABLA PAT_RCTS
-- ====================================================================
/*
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
*/

-- ====================================================================
-- SECCIÓN B: SI FALTAN CAMPOS EN AUDIENCIAS (DESCOMENTA SI ES NECESARIO)
-- ====================================================================
/*
-- Solo ejecutar estos si las columnas NO existen
ALTER TABLE `audiencias` ADD COLUMN `fecha_notificacion` DATE NULL AFTER `tipo_archivo`;
ALTER TABLE `audiencias` ADD COLUMN `plazo_evacuar` VARCHAR(255) NULL AFTER `fecha_notificacion`;
ALTER TABLE `audiencias` ADD COLUMN `plazo_evacuar_otro` VARCHAR(255) NULL AFTER `plazo_evacuar`;
*/

-- ====================================================================
-- SECCIÓN C: SI FALTAN CAMPOS EN AUDIENCIAS_PA (DESCOMENTA SI ES NECESARIO)
-- ====================================================================
/*
-- Solo ejecutar estos si las columnas NO existen
ALTER TABLE `audiencias_pa` ADD COLUMN `fecha_notificacion` DATE NULL AFTER `tipo_archivo`;
ALTER TABLE `audiencias_pa` ADD COLUMN `plazo_evacuar` VARCHAR(255) NULL AFTER `fecha_notificacion`;
ALTER TABLE `audiencias_pa` ADD COLUMN `plazo_evacuar_otro` VARCHAR(255) NULL AFTER `plazo_evacuar`;
*/

-- ====================================================================
-- SECCIÓN D: OFICINA_PRESENTACION (DESCOMENTA SI ES NECESARIO)
-- ====================================================================
/*
ALTER TABLE `evs` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `evs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `pps` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `pps_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `adpmrs` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `adpmrs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
*/

-- ====================================================================
-- SECCIÓN E: CAMPOS NUMERO_RESOLUCION Y FECHA (DESCOMENTA SI ES NECESARIO)
-- ====================================================================
/*
ALTER TABLE `resolucions` ADD COLUMN `numero_resolucion` VARCHAR(255) NULL AFTER `tipo_resolucion`;
ALTER TABLE `resolucions` ADD COLUMN `fecha` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `rsat_pa` ADD COLUMN `numero_resolucion` VARCHAR(255) NULL AFTER `tipo_resolucion`;
ALTER TABLE `rsat_pa` ADD COLUMN `fecha` DATE NULL AFTER `numero_resolucion`;
*/

-- ====================================================================
-- SECCIÓN F: NUEVAS TABLAS PRINCIPALES (DESCOMENTA LO QUE FALTE)
-- ====================================================================
/*
-- TABLA ACEPTACIONS
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

-- TABLA ACEPTACIONS_PA
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

-- TABLA CONSTANCIA_PAGOS
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
*/

-- ====================================================================
-- INSTRUCCIONES DE USO
-- ====================================================================
/*
INSTRUCCIONES:
1. Ejecuta primero la sección de verificación
2. Basándote en los resultados, descomenta solo las secciones que necesites
3. Ejecuta las secciones descomentadas una por una
4. Verifica que no hay errores antes de continuar

EJEMPLO:
Si ves que "fecha_notificacion" NO existe en audiencias, descomenta la SECCIÓN B
Si ves que la tabla "aceptacions" NO existe, descomenta esa parte de la SECCIÓN F
*/

SELECT 'SCRIPT DE MIGRACIONES PENDIENTES LISTO' as 'RESULTADO';
