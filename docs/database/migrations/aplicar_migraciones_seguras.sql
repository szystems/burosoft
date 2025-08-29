-- ====================================================================
-- APLICAR MIGRACIONES SEGURAS - SISTEMA BUROSOFT (IPAGE)
-- Fecha: 28 de agosto de 2025
-- Descripción: Migraciones separadas para evitar errores de duplicados
-- Compatible con hosting iPage
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_de_datos_activa', NOW() as 'Fecha_inicio';

-- ====================================================================
-- INSTRUCCIONES: Ejecuta cada sección por separado
-- Si aparece error "Duplicate column", significa que ya existe - CONTINÚA con la siguiente
-- ====================================================================

-- SECCIÓN 1: EVS - oficina_presentacion
-- (Si da error, continúa con la siguiente sección)
ALTER TABLE `evs` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

-- SECCIÓN 2: EVS_PA - oficina_presentacion  
ALTER TABLE `evs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

-- SECCIÓN 3: PPS - oficina_presentacion
ALTER TABLE `pps` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

-- SECCIÓN 4: PPS_PA - oficina_presentacion
ALTER TABLE `pps_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

-- SECCIÓN 5: ADPMRS - oficina_presentacion
ALTER TABLE `adpmrs` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

-- SECCIÓN 6: ADPMRS_PA - oficina_presentacion
ALTER TABLE `adpmrs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;

SELECT '✅ EVS, PPS, ADPMRS: oficina_presentacion procesado' as 'Status_1';

-- ====================================================================
-- RSAT_PA - Campos adicionales
-- ====================================================================

-- SECCIÓN 7: RSAT_PA - numero_resolucion
ALTER TABLE `rsat_pa` ADD COLUMN `numero_resolucion` VARCHAR(255) NULL AFTER `tipo_resolucion`;

-- SECCIÓN 8: RSAT_PA - fecha
ALTER TABLE `rsat_pa` ADD COLUMN `fecha` DATE NULL AFTER `numero_resolucion`;

-- SECCIÓN 9: RSAT_PA - fecha_notificacion
ALTER TABLE `rsat_pa` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;

-- SECCIÓN 10: RSAT_PA - fecha_resolucion
ALTER TABLE `rsat_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

SELECT '✅ RSAT_PA: campos adicionales procesados' as 'Status_2';

-- ====================================================================
-- RTRIBUTAS VA - Campos adicionales
-- ====================================================================

-- SECCIÓN 11: RTRIBUTAS - fecha_hora_notificacion
ALTER TABLE `rtributas` ADD COLUMN `fecha_hora_notificacion` DATETIME NULL AFTER `id`;

-- SECCIÓN 12: RTRIBUTAS - fecha_resolucion
ALTER TABLE `rtributas` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;

-- SECCIÓN 13: RTRIBUTAS - tipo_resolucion_otro
ALTER TABLE `rtributas` ADD COLUMN `tipo_resolucion_otro` VARCHAR(255) NULL AFTER `tipo_resolucion`;

-- SECCIÓN 14: RTRIBUTAS - plazo_cat
ALTER TABLE `rtributas` ADD COLUMN `plazo_cat` ENUM('30 D.H.', '3 Meses', 'otro') NULL AFTER `tipo_resolucion_otro`;

-- SECCIÓN 15: RTRIBUTAS - plazo_cat_otro
ALTER TABLE `rtributas` ADD COLUMN `plazo_cat_otro` VARCHAR(255) NULL AFTER `plazo_cat`;

-- SECCIÓN 16: RTRIBUTAS - MODIFY tipo_resolucion (IMPORTANTE: Solo si no da error)
ALTER TABLE `rtributas` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NULL;

SELECT '✅ RTRIBUTAS VA: campos procesados' as 'Status_3a';

-- ====================================================================
-- RTRIBUTAS PA - Campos adicionales
-- ====================================================================

-- SECCIÓN 17: RTRIBUTAS_PA - fecha_hora_notificacion
ALTER TABLE `rtributas_pa` ADD COLUMN `fecha_hora_notificacion` DATETIME NULL AFTER `id`;

-- SECCIÓN 18: RTRIBUTAS_PA - fecha_resolucion
ALTER TABLE `rtributas_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;

-- SECCIÓN 19: RTRIBUTAS_PA - tipo_resolucion_otro
ALTER TABLE `rtributas_pa` ADD COLUMN `tipo_resolucion_otro` VARCHAR(255) NULL AFTER `tipo_resolucion`;

-- SECCIÓN 20: RTRIBUTAS_PA - plazo_cat
ALTER TABLE `rtributas_pa` ADD COLUMN `plazo_cat` ENUM('30 D.H.', '3 Meses', 'otro') NULL AFTER `tipo_resolucion_otro`;

-- SECCIÓN 21: RTRIBUTAS_PA - plazo_cat_otro
ALTER TABLE `rtributas_pa` ADD COLUMN `plazo_cat_otro` VARCHAR(255) NULL AFTER `plazo_cat`;

-- SECCIÓN 22: RTRIBUTAS_PA - MODIFY tipo_resolucion
ALTER TABLE `rtributas_pa` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NULL;

SELECT '✅ RTRIBUTAS PA: campos procesados' as 'Status_3b';

-- ====================================================================
-- RRS - oficina_agencia_ea
-- ====================================================================

-- SECCIÓN 23: RRS - oficina_agencia_ea
ALTER TABLE `rrs` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;

-- SECCIÓN 24: RRS_PA - oficina_agencia_ea
ALTER TABLE `rrs_pa` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;

SELECT '✅ RRS: oficina_agencia_ea procesado' as 'Status_4';

-- ====================================================================
-- OCURSOS - oficina_agencia_ea
-- ====================================================================

-- SECCIÓN 25: OCURSOS - oficina_agencia_ea
ALTER TABLE `ocursos` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;

-- SECCIÓN 26: OCURSOS_PA - oficina_agencia_ea
ALTER TABLE `ocursos_pa` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;

SELECT '✅ OCURSOS: oficina_agencia_ea procesado' as 'Status_5';

-- ====================================================================
-- ROS - fecha_notificacion y fecha_resolucion
-- ====================================================================

-- SECCIÓN 27: ROS - fecha_notificacion
ALTER TABLE `ros` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;

-- SECCIÓN 28: ROS - fecha_resolucion
ALTER TABLE `ros` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

-- SECCIÓN 29: ROS_PA - fecha_notificacion
ALTER TABLE `ros_pa` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;

-- SECCIÓN 30: ROS_PA - fecha_resolucion
ALTER TABLE `ros_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;

SELECT '✅ ROS: campos de notificación procesados' as 'Status_6';

-- ====================================================================
-- MIGRATIONS - Registrar migraciones aplicadas
-- ====================================================================

-- SECCIÓN 31: INSERT migrations (Si da error de duplicate, también es normal)
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

SELECT '✅ MIGRATIONS: entradas procesadas' as 'Status_7';

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'PROCESO COMPLETADO - Revisa los errores para ver qué ya existía' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';

-- ====================================================================
-- RESUMEN DE ERRORES ESPERADOS:
-- ====================================================================
/*
ERRORES NORMALES (significa que ya existía):
- #1060 - Duplicate column name 'oficina_presentacion' 
- #1060 - Duplicate column name 'numero_resolucion'
- #1060 - Duplicate column name 'fecha_notificacion'
- #1062 - Duplicate entry for key 'migrations_pkey' 

ESTO ES BUENO: Significa que algunas migraciones ya estaban aplicadas.

ERRORES A INVESTIGAR:
- #1146 - Table doesn't exist (tabla no existe)
- #1054 - Unknown column (campo de referencia no existe)

RECUENTA RESULTADOS:
- Cuenta cuántos ✅ Status aparecieron
- Si aparecieron 7 mensajes de Status, todo funcionó
- Los errores intermedios son normales
*/
