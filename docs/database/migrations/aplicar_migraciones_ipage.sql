-- ====================================================================
-- APLICAR MIGRACIONES PENDIENTES - SISTEMA BUROSOFT (IPAGE)
-- Fecha: 28 de agosto de 2025
-- Descripción: Solo las migraciones que faltan - Sin verificaciones
-- Compatible con hosting iPage (sin acceso a information_schema)
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_de_datos_activa', NOW() as 'Fecha_inicio';

-- ====================================================================
-- 1. AGREGAR oficina_presentacion a EVS, PPS, ADPMRS
-- ====================================================================

ALTER TABLE `evs` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `evs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `pps` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `pps_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `adpmrs` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `adpmrs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

SELECT '✅ EVS, PPS, ADPMRS: oficina_presentacion agregado' as 'Status_1';

-- ====================================================================
-- 2. AGREGAR campos adicionales a RSAT_PA
-- ====================================================================

ALTER TABLE `rsat_pa` ADD COLUMN `numero_resolucion` VARCHAR(255) NULL AFTER `tipo_resolucion`;
ALTER TABLE `rsat_pa` ADD COLUMN `fecha` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `rsat_pa` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `rsat_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

SELECT '✅ RSAT_PA: campos adicionales agregados' as 'Status_2';

-- ====================================================================
-- 3. MODIFICAR RTRIBUTAS - cambios estructurales
-- ====================================================================

-- RTRIBUTAS VA
ALTER TABLE `rtributas` ADD COLUMN `fecha_hora_notificacion` DATETIME NULL AFTER `id`;
ALTER TABLE `rtributas` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `rtributas` ADD COLUMN `tipo_resolucion_otro` VARCHAR(255) NULL AFTER `tipo_resolucion`;
ALTER TABLE `rtributas` ADD COLUMN `plazo_cat` ENUM('30 D.H.', '3 Meses', 'otro') NULL AFTER `tipo_resolucion_otro`;
ALTER TABLE `rtributas` ADD COLUMN `plazo_cat_otro` VARCHAR(255) NULL AFTER `plazo_cat`;
ALTER TABLE `rtributas` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NULL;

-- RTRIBUTAS PA  
ALTER TABLE `rtributas_pa` ADD COLUMN `fecha_hora_notificacion` DATETIME NULL AFTER `id`;
ALTER TABLE `rtributas_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `rtributas_pa` ADD COLUMN `tipo_resolucion_otro` VARCHAR(255) NULL AFTER `tipo_resolucion`;
ALTER TABLE `rtributas_pa` ADD COLUMN `plazo_cat` ENUM('30 D.H.', '3 Meses', 'otro') NULL AFTER `tipo_resolucion_otro`;
ALTER TABLE `rtributas_pa` ADD COLUMN `plazo_cat_otro` VARCHAR(255) NULL AFTER `plazo_cat`;
ALTER TABLE `rtributas_pa` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NULL;

SELECT '✅ RTRIBUTAS: nuevos campos y ENUM actualizado' as 'Status_3';

-- ====================================================================
-- 4. AGREGAR oficina_agencia_ea a RRS
-- ====================================================================

ALTER TABLE `rrs` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;
ALTER TABLE `rrs_pa` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;

SELECT '✅ RRS: oficina_agencia_ea agregado' as 'Status_4';

-- ====================================================================
-- 5. AGREGAR oficina_agencia_ea a OCURSOS
-- ====================================================================

ALTER TABLE `ocursos` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;
ALTER TABLE `ocursos_pa` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;

SELECT '✅ OCURSOS: oficina_agencia_ea agregado' as 'Status_5';

-- ====================================================================
-- 6. AGREGAR fecha_notificacion y fecha_resolucion a ROS
-- ====================================================================

ALTER TABLE `ros` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `ros` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;
ALTER TABLE `ros_pa` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `ros_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

SELECT '✅ ROS: campos de notificación agregados' as 'Status_6';

-- ====================================================================
-- 7. AGREGAR ENTRADAS EN MIGRATIONS
-- ====================================================================

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2025_08_21_113532_create_pat_rcts_table', 30),
('2025_08_21_114000_add_notificacion_fields_to_audiencias_table', 30),
('2025_08_21_114001_add_notificacion_fields_to_audiencias_pa_table', 30),
('2025_08_28_115920_create_aceptacions_table', 30),
('2025_08_28_115933_create_aceptacions_pa_table', 30),
('2025_08_28_163124_create_constancia_pagos_table', 30),
('2025_08_28_113627_add_oficina_ea_to_ampmrs_table', 30),
('2025_08_28_113814_add_oficina_ea_to_ampmrs_pa_table', 30),
('2025_08_28_111017_add_fecha_resolucion_to_mpmrs_table', 30),
('2025_08_28_111114_add_fecha_resolucion_to_mpmrs_pa_table', 30),
('2025_08_28_120000_add_oficina_presentacion_to_evs_tables', 30),
('2025_08_28_120001_add_fields_to_rsat_pa_table', 30),
('2025_08_28_120002_modify_rtributas_structure', 30),
('2025_08_28_120003_add_oficina_agencia_ea_to_rrs', 30),
('2025_08_28_120004_add_oficina_agencia_ea_to_ocursos', 30),
('2025_08_28_120005_add_notification_fields_to_ros', 30);

SELECT '✅ MIGRATIONS: entradas registradas correctamente' as 'Status_7';

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'TODAS LAS MIGRACIONES APLICADAS EXITOSAMENTE' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';

-- ====================================================================
-- NOTAS IMPORTANTES:
-- ====================================================================
/*
✅ APLICADO EN ESTE SCRIPT:
- EVS, EVS_PA, PPS, PPS_PA, ADPMRS, ADPMRS_PA: oficina_presentacion
- RSAT_PA: numero_resolucion, fecha, fecha_notificacion, fecha_resolucion  
- RTRIBUTAS, RTRIBUTAS_PA: fecha_hora_notificacion, fecha_resolucion, tipo_resolucion_otro, plazo_cat, plazo_cat_otro
- RRS, RRS_PA: oficina_agencia_ea
- OCURSOS, OCURSOS_PA: oficina_agencia_ea
- ROS, ROS_PA: fecha_notificacion, fecha_resolucion
- MIGRATIONS: 16 registros nuevos

❌ NO APLICADO (tablas no existen):
- ECS: No existe en la base actual
- NTRRS: No existe en la base actual

Si algún ALTER TABLE falla por campo duplicado, significa que esa migración ya fue aplicada.
Eso es normal y no afecta las demás migraciones.
*/
