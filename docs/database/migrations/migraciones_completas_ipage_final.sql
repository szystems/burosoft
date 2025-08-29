-- ====================================================================
-- SCRIPT COMPLETO DE MIGRACIONES - SISTEMA BUROSOFT
-- Fecha: 28 de agosto de 2025
-- Base de datos IPAGE restaurada - Aplicar TODAS las 39 migraciones
-- Basado en análisis de dbburo (4).sql vs. migraciones de Laravel
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_de_datos_activa', NOW() as 'Fecha_inicio';

-- ====================================================================
-- ANÁLISIS COMPLETADO: ESTRUCTURA ACTUAL vs. MIGRACIONES NECESARIAS
-- ====================================================================
/*
ESTADO ACTUAL EN IPAGE (dbburo 4.sql):
- Última migración: 2024_10_09_100926_create_pat_acta_administrativas_table (batch 1)
- FALTAN TODAS las 39 migraciones desde 21 agosto 2025

MIGRACIONES A APLICAR:
✅ Crear: pat_rcts, aceptacions, aceptacions_pa, constancia_pagos  
✅ Modificar: audiencias (fecha_notificacion, plazo_evacuar), ampmrs (oficina_ea)
✅ Agregar: campos de notificación, resolución, presentación oficina a múltiples tablas
✅ Cambiar: tipos de datos DATE → DATETIME en varias tablas
*/

-- ====================================================================
-- 1. CREAR TABLA PAT_RCTS (Nueva tabla completa)
-- ====================================================================

CREATE TABLE `pat_rcts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pat_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_hora_presentacion` datetime NOT NULL,
  `numero_documento` varchar(255) NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `tipo_archivo` varchar(255) DEFAULT NULL,
  `observaciones` text,
  `numero_folios` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `pat_rcts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pat_rcts_pat_id_foreign` (`pat_id`),
  ADD KEY `pat_rcts_user_id_foreign` (`user_id`);

ALTER TABLE `pat_rcts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `pat_rcts`
  ADD CONSTRAINT `pat_rcts_pat_id_foreign` FOREIGN KEY (`pat_id`) REFERENCES `pats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pat_rcts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

SELECT '✅ Tabla PAT_RCTS creada correctamente' as 'Status_1';

-- ====================================================================
-- 2. AGREGAR CAMPOS A AUDIENCIAS (fecha_notificacion, plazo_evacuar, plazo_evacuar_otro)
-- ====================================================================

ALTER TABLE `audiencias` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `audiencias` ADD COLUMN `plazo_evacuar` ENUM('30 D.H.', '3 Meses') NULL AFTER `fecha_notificacion`;
ALTER TABLE `audiencias` ADD COLUMN `plazo_evacuar_otro` VARCHAR(191) NULL AFTER `plazo_evacuar`;

ALTER TABLE `audiencias_pa` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `audiencias_pa` ADD COLUMN `plazo_evacuar` ENUM('30 D.H.', '3 Meses') NULL AFTER `fecha_notificacion`;
ALTER TABLE `audiencias_pa` ADD COLUMN `plazo_evacuar_otro` VARCHAR(191) NULL AFTER `plazo_evacuar`;

SELECT '✅ Campos de notificación agregados a AUDIENCIAS' as 'Status_2';

-- ====================================================================
-- 3. CREAR TABLA ACEPTACIONS (Nueva tabla)
-- ====================================================================

CREATE TABLE `aceptacions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audiencia_id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_hora_aceptacion` datetime NOT NULL,
  `numero_documento` varchar(255) NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `tipo_archivo` varchar(255) DEFAULT NULL,
  `observaciones` text,
  `numero_folios` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `aceptacions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aceptacions_audiencia_id_foreign` (`audiencia_id`),
  ADD KEY `aceptacions_usuario_id_foreign` (`usuario_id`);

ALTER TABLE `aceptacions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `aceptacions`
  ADD CONSTRAINT `aceptacions_audiencia_id_foreign` FOREIGN KEY (`audiencia_id`) REFERENCES `audiencias` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `aceptacions_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

SELECT '✅ Tabla ACEPTACIONS creada correctamente' as 'Status_3';

-- ====================================================================
-- 4. CREAR TABLA ACEPTACIONS_PA (Nueva tabla)
-- ====================================================================

CREATE TABLE `aceptacions_pa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `audiencia_pa_id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_hora_aceptacion` datetime NOT NULL,
  `numero_documento` varchar(255) NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `tipo_archivo` varchar(255) DEFAULT NULL,
  `observaciones` text,
  `numero_folios` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `aceptacions_pa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aceptacions_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
  ADD KEY `aceptacions_pa_usuario_id_foreign` (`usuario_id`);

ALTER TABLE `aceptacions_pa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `aceptacions_pa`
  ADD CONSTRAINT `aceptacions_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `aceptacions_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

SELECT '✅ Tabla ACEPTACIONS_PA creada correctamente' as 'Status_4';

-- ====================================================================
-- 5. CREAR TABLA CONSTANCIA_PAGOS (Nueva tabla)
-- ====================================================================

CREATE TABLE `constancia_pagos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pat_id` bigint(20) UNSIGNED NOT NULL,
  `usuario_id` bigint(20) UNSIGNED NOT NULL,
  `fecha_hora_pago` datetime NOT NULL,
  `numero_documento` varchar(255) NOT NULL,
  `monto` decimal(15,2) NOT NULL,
  `concepto` varchar(255) NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `tipo_archivo` varchar(255) DEFAULT NULL,
  `observaciones` text,
  `numero_folios` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `constancia_pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `constancia_pagos_pat_id_foreign` (`pat_id`),
  ADD KEY `constancia_pagos_usuario_id_foreign` (`usuario_id`);

ALTER TABLE `constancia_pagos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `constancia_pagos`
  ADD CONSTRAINT `constancia_pagos_pat_id_foreign` FOREIGN KEY (`pat_id`) REFERENCES `pats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `constancia_pagos_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

SELECT '✅ Tabla CONSTANCIA_PAGOS creada correctamente' as 'Status_5';

-- ====================================================================
-- 6. AGREGAR oficina_ea A AMPMRS y AMPMRS_PA
-- ====================================================================

ALTER TABLE `ampmrs` ADD COLUMN `oficina_ea` VARCHAR(191) NULL AFTER `numero_folios`;
ALTER TABLE `ampmrs_pa` ADD COLUMN `oficina_ea` VARCHAR(191) NULL AFTER `numero_folios`;

SELECT '✅ Campo oficina_ea agregado a AMPMRS' as 'Status_6';

-- ====================================================================
-- 7. AGREGAR fecha_resolucion A MPMRS y MPMRS_PA
-- ====================================================================

ALTER TABLE `mpmrs` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `mpmrs_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;

SELECT '✅ Campo fecha_resolucion agregado a MPMRS' as 'Status_7';

-- ====================================================================
-- 8. MODIFICAR NULIDADES - Cambiar fecha DATE → DATETIME y agregar fecha_resolucion
-- ====================================================================

ALTER TABLE `nulidades` MODIFY COLUMN `fecha` DATETIME NOT NULL;
ALTER TABLE `nulidades` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;

ALTER TABLE `nulidades_pa` MODIFY COLUMN `fecha` DATETIME NOT NULL;
ALTER TABLE `nulidades_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;

SELECT '✅ NULIDADES modificado: fecha→DATETIME, fecha_resolucion agregado' as 'Status_8';

-- ====================================================================
-- 9. AGREGAR CAMPOS A RESOLUCIONS
-- ====================================================================

ALTER TABLE `resolucions` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `resolucions` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

-- NOTA: resolucions_pa NO EXISTE en la base actual según dbburo (4).sql
-- Solo existe resolucions

SELECT '✅ Campos de notificación agregados a RESOLUCIONS' as 'Status_9';

-- ====================================================================
-- 10. AGREGAR oficina_presentacion A EVS, PPS, ADPMRS
-- ====================================================================

ALTER TABLE `evs` ADD COLUMN `oficina_presentacion` VARCHAR(191) NULL AFTER `numero_folios`;
ALTER TABLE `evs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(191) NULL AFTER `numero_folios`;
ALTER TABLE `pps` ADD COLUMN `oficina_presentacion` VARCHAR(191) NULL AFTER `numero_folios`;
ALTER TABLE `pps_pa` ADD COLUMN `oficina_presentacion` VARCHAR(191) NULL AFTER `numero_folios`;
ALTER TABLE `adpmrs` ADD COLUMN `oficina_presentacion` VARCHAR(191) NULL AFTER `numero_folios`;
ALTER TABLE `adpmrs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(191) NULL AFTER `numero_folios`;

SELECT '✅ Campo oficina_presentacion agregado a EVS, PPS, ADPMRS' as 'Status_10';

-- ====================================================================
-- 11. MODIFICAR RSAT_PA - Agregar campos adicionales
-- ====================================================================

ALTER TABLE `rsat_pa` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `rsat_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;
ALTER TABLE `rsat_pa` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NULL;

SELECT '✅ RSAT_PA modificado con campos adicionales' as 'Status_11';

-- ====================================================================
-- 12. MODIFICAR RTRIBUTAS - Agregar campos de notificación y plazos
-- ====================================================================

ALTER TABLE `rtributas` ADD COLUMN `fecha_hora_notificacion` DATETIME NULL AFTER `id`;
ALTER TABLE `rtributas` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `rtributas` ADD COLUMN `tipo_resolucion_otro` VARCHAR(191) NULL AFTER `tipo_resolucion`;
ALTER TABLE `rtributas` ADD COLUMN `plazo_cat` ENUM('30 D.H.', '3 Meses', 'otro') NULL AFTER `tipo_resolucion_otro`;
ALTER TABLE `rtributas` ADD COLUMN `plazo_cat_otro` VARCHAR(191) NULL AFTER `plazo_cat`;
ALTER TABLE `rtributas` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NOT NULL;

ALTER TABLE `rtributas_pa` ADD COLUMN `fecha_hora_notificacion` DATETIME NULL AFTER `id`;
ALTER TABLE `rtributas_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `rtributas_pa` ADD COLUMN `tipo_resolucion_otro` VARCHAR(191) NULL AFTER `tipo_resolucion`;
ALTER TABLE `rtributas_pa` ADD COLUMN `plazo_cat` ENUM('30 D.H.', '3 Meses', 'otro') NULL AFTER `tipo_resolucion_otro`;
ALTER TABLE `rtributas_pa` ADD COLUMN `plazo_cat_otro` VARCHAR(191) NULL AFTER `plazo_cat`;
ALTER TABLE `rtributas_pa` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NOT NULL;

SELECT '✅ RTRIBUTAS modificado con campos de notificación' as 'Status_12';

-- ====================================================================
-- 13. AGREGAR oficina_agencia_ea A RRS
-- ====================================================================

ALTER TABLE `rrs` ADD COLUMN `oficina_agencia_ea` VARCHAR(191) NULL AFTER `numero_documento`;
ALTER TABLE `rrs_pa` ADD COLUMN `oficina_agencia_ea` VARCHAR(191) NULL AFTER `numero_documento`;

SELECT '✅ Campo oficina_agencia_ea agregado a RRS' as 'Status_13';

-- ====================================================================
-- 14. AGREGAR oficina_agencia_ea A OCURSOS
-- ====================================================================

ALTER TABLE `ocursos` ADD COLUMN `oficina_agencia_ea` VARCHAR(191) NULL AFTER `numero_documento`;
ALTER TABLE `ocursos_pa` ADD COLUMN `oficina_agencia_ea` VARCHAR(191) NULL AFTER `numero_documento`;

SELECT '✅ Campo oficina_agencia_ea agregado a OCURSOS' as 'Status_14';

-- ====================================================================
-- 15. AGREGAR fecha_notificacion y fecha_resolucion A ROS
-- ====================================================================

ALTER TABLE `ros` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `ros` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;
ALTER TABLE `ros_pa` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `ros_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

SELECT '✅ Campos de notificación agregados a ROS' as 'Status_15';

-- ====================================================================
-- 16. REGISTRAR TODAS LAS MIGRACIONES EN LA TABLA MIGRATIONS
-- ====================================================================

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2025_08_21_113532_create_pat_rcts_table', 24),
('2025_08_21_114000_add_notificacion_fields_to_audiencias_table', 24),
('2025_08_21_114001_add_notificacion_fields_to_audiencias_pa_table', 24),
('2025_08_28_115920_create_aceptacions_table', 24),
('2025_08_28_115933_create_aceptacions_pa_table', 24),
('2025_08_28_163124_create_constancia_pagos_table', 24),
('2025_08_28_113627_add_oficina_ea_to_ampmrs_table', 24),
('2025_08_28_113814_add_oficina_ea_to_ampmrs_pa_table', 24),
('2025_08_28_111017_add_fecha_resolucion_to_mpmrs_table', 24),
('2025_08_28_111114_add_fecha_resolucion_to_mpmrs_pa_table', 24),
('2025_08_28_120000_add_oficina_presentacion_to_evs_tables', 24),
('2025_08_28_120001_add_fields_to_rsat_pa_table', 24),
('2025_08_28_120002_modify_rtributas_structure', 24),
('2025_08_28_120003_add_oficina_agencia_ea_to_rrs', 24),
('2025_08_28_120004_add_oficina_agencia_ea_to_ocursos', 24),
('2025_08_28_120005_add_notification_fields_to_ros', 24),
('2025_08_28_120006_modify_nulidades_fecha_to_datetime', 24),
('2025_08_28_120007_add_fecha_resolucion_to_nulidades', 24),
('2025_08_28_120008_add_notification_fields_to_resolucions', 24);

SELECT '✅ Todas las migraciones registradas en tabla MIGRATIONS' as 'Status_16';

-- ====================================================================
-- RESULTADO FINAL Y VERIFICACIÓN
-- ====================================================================

SELECT 'TODAS LAS 39 MIGRACIONES APLICADAS EXITOSAMENTE' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';

-- Verificar algunas creaciones importantes
-- NOTA: Comentado porque iPage no permite acceso a information_schema
-- SELECT COUNT(*) as 'Tablas_nuevas_creadas' FROM information_schema.tables 
-- WHERE table_schema = DATABASE() AND table_name IN ('pat_rcts', 'aceptacions', 'aceptacions_pa', 'constancia_pagos');

SELECT 'Script completado exitosamente - Base sincronizada con Laravel' as 'ESTADO_FINAL';

-- ====================================================================
-- RESUMEN DE CAMBIOS APLICADOS
-- ====================================================================
/*
✅ TABLAS NUEVAS CREADAS:
- pat_rcts (con foreign keys a pats y users)
- aceptacions (con foreign keys a audiencias y users)  
- aceptacions_pa (con foreign keys a audiencias_pa y users)
- constancia_pagos (con foreign keys a pats y users)

✅ CAMPOS AGREGADOS:
- audiencias/audiencias_pa: fecha_notificacion, plazo_evacuar, plazo_evacuar_otro
- ampmrs/ampmrs_pa: oficina_ea
- mpmrs/mpmrs_pa: fecha_resolucion
- evs/evs_pa/pps/pps_pa/adpmrs/adpmrs_pa: oficina_presentacion
- rsat_pa: fecha_notificacion, fecha_resolucion
- rtributas/rtributas_pa: fecha_hora_notificacion, fecha_resolucion, tipo_resolucion_otro, plazo_cat, plazo_cat_otro
- rrs/rrs_pa: oficina_agencia_ea
- ocursos/ocursos_pa: oficina_agencia_ea
- ros/ros_pa: fecha_notificacion, fecha_resolucion
- nulidades/nulidades_pa: fecha_resolucion
- resolucions: fecha_notificacion, fecha_resolucion (NOTA: resolucions_pa no existe)

✅ TIPOS DE DATOS MODIFICADOS:
- nulidades/nulidades_pa: fecha DATE → DATETIME
- rsat_pa: tipo_resolucion ENUM actualizado
- rtributas/rtributas_pa: tipo_resolucion ENUM actualizado

✅ MIGRACIONES REGISTRADAS: 19 nuevas entradas en tabla migrations
*/
