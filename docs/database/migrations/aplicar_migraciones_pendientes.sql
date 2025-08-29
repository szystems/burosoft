-- ====================================================================
-- APLICAR MIGRACIONES PENDIENTES - SISTEMA BUROSOFT
-- Fecha: 28 de agosto de 2025
-- Descripción: Solo las migraciones verificadas que faltan
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_de_datos_activa', NOW() as 'Fecha_inicio';

-- ====================================================================
-- 1. AGREGAR oficina_presentacion a EVS, PPS, ADPMRS (FALTA - resultado: 0)
-- ====================================================================

ALTER TABLE `evs` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `evs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `pps` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `pps_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `adpmrs` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `adpmrs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

SELECT '✅ Campos oficina_presentacion agregados a EVS, PPS, ADPMRS' as 'Status';

-- ====================================================================
-- 2. AGREGAR campos adicionales a RSAT_PA (FALTA - resultado: 0)
-- ====================================================================

ALTER TABLE `rsat_pa` ADD COLUMN `numero_resolucion` VARCHAR(255) NULL AFTER `tipo_resolucion`;
ALTER TABLE `rsat_pa` ADD COLUMN `fecha` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `rsat_pa` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `rsat_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

SELECT '✅ Campos adicionales agregados a RSAT_PA' as 'Status';

-- ====================================================================
-- 3. MODIFICAR RTRIBUTAS - cambios estructurales importantes (FALTA - resultado: 0)
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

SELECT '✅ RTRIBUTAS modificado con nuevos campos y ENUM actualizado' as 'Status';

-- ====================================================================
-- 4. AGREGAR oficina_agencia_ea a RRS (FALTA - resultado: 0)
-- ====================================================================

ALTER TABLE `rrs` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;
ALTER TABLE `rrs_pa` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;

SELECT '✅ Campo oficina_agencia_ea agregado a RRS' as 'Status';

-- ====================================================================
-- 5. AGREGAR oficina_agencia_ea a OCURSOS (FALTA - resultado: 0)
-- ====================================================================

ALTER TABLE `ocursos` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;
ALTER TABLE `ocursos_pa` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;

SELECT '✅ Campo oficina_agencia_ea agregado a OCURSOS' as 'Status';

-- ====================================================================
-- 6. AGREGAR fecha_notificacion y fecha_resolucion a ROS (FALTA - resultado: 0)
-- ====================================================================

ALTER TABLE `ros` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `ros` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;
ALTER TABLE `ros_pa` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `ros_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

SELECT '✅ Campos de notificación y resolución agregados a ROS' as 'Status';

-- ====================================================================
-- NOTA: ECS y NTRRS no se modifican porque no existen (resultado vacío)
-- Las tablas 'ecs' y 'ntrrs' no fueron encontradas en tu base de datos actual.
-- ====================================================================

-- ====================================================================
-- 7. AGREGAR ENTRADAS FALTANTES EN MIGRATIONS
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

SELECT '✅ Entradas de migrations agregadas correctamente' as 'Status';

-- ====================================================================
-- VERIFICACIÓN FINAL
-- ====================================================================

SELECT 'MIGRACIONES APLICADAS EXITOSAMENTE' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';

-- Verificar algunas tablas modificadas
SELECT 'Verificando EVS...' as verificacion, COUNT(*) as campos_oficina_presentacion
FROM information_schema.COLUMNS 
WHERE TABLE_NAME IN ('evs', 'evs_pa') AND COLUMN_NAME = 'oficina_presentacion' AND TABLE_SCHEMA = DATABASE();

SELECT 'Verificando RSAT_PA...' as verificacion, COUNT(*) as campos_nuevos
FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'rsat_pa' AND COLUMN_NAME IN ('numero_resolucion', 'fecha_notificacion', 'fecha_resolucion') AND TABLE_SCHEMA = DATABASE();

SELECT 'Verificando RRS...' as verificacion, COUNT(*) as campos_oficina_agencia
FROM information_schema.COLUMNS 
WHERE TABLE_NAME IN ('rrs', 'rrs_pa') AND COLUMN_NAME = 'oficina_agencia_ea' AND TABLE_SCHEMA = DATABASE();
