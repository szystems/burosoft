-- ====================================================================
-- SCRIPT SQL MIGRACIONES FALTANTES - SISTEMA BUROSOFT
-- Fecha: 28 de agosto de 2025
-- Descripción: Solo las migraciones que AÚN NO se han aplicado
-- Basado en análisis del backup dbburo (5).sql
-- ====================================================================

-- Verificar conexión y base de datos activa
SELECT DATABASE() as 'Base_de_datos_activa', NOW() as 'Fecha_ejecucion';

-- ====================================================================
-- ANÁLISIS: ESTAS MIGRACIONES YA ESTÁN APLICADAS ✅
-- ====================================================================
/*
✅ COMPLETADAS:
- pat_rcts: Tabla creada
- aceptacions y aceptacions_pa: Tablas creadas
- constancia_pagos: Tabla creada  
- audiencias: fecha_notificacion, plazo_evacuar, plazo_evacuar_otro agregados
- audiencias_pa: fecha_notificacion, plazo_evacuar, plazo_evacuar_otro agregados
- ampmrs y ampmrs_pa: oficina_ea agregado
- mpmrs y mpmrs_pa: fecha_resolucion agregado
- nulidades: fecha → DATETIME, fecha_resolucion agregado
- resolucions: fecha_notificacion, fecha_resolucion agregados
*/

-- ====================================================================
-- PENDIENTES: VERIFICAR Y APLICAR SOLO LO QUE FALTA
-- ====================================================================

-- 1. VERIFICAR SI FALTAN CAMPOS oficina_presentacion EN EVS
SELECT 'VERIFICANDO: oficina_presentacion en evs' as verificacion;
SELECT COUNT(*) as tiene_campo FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'evs' AND COLUMN_NAME = 'oficina_presentacion' AND TABLE_SCHEMA = DATABASE();

-- Si el resultado anterior es 0, descomentar:
/*
ALTER TABLE `evs` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `evs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `pps` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `pps_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `adpmrs` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
ALTER TABLE `adpmrs_pa` ADD COLUMN `oficina_presentacion` VARCHAR(255) NULL AFTER `numero_folios`;
*/

-- 2. VERIFICAR SI FALTA RSAT_PA con campos adicionales
SELECT 'VERIFICANDO: numero_resolucion en rsat_pa' as verificacion;
SELECT COUNT(*) as tiene_campo FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'rsat_pa' AND COLUMN_NAME = 'numero_resolucion' AND TABLE_SCHEMA = DATABASE();

-- Si el resultado anterior es 0, descomentar:
/*
ALTER TABLE `rsat_pa` ADD COLUMN `numero_resolucion` VARCHAR(255) NULL AFTER `tipo_resolucion`;
ALTER TABLE `rsat_pa` ADD COLUMN `fecha` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `rsat_pa` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `rsat_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;
*/

-- 3. VERIFICAR RTRIBUTAS - cambios importantes
SELECT 'VERIFICANDO: fecha_hora_notificacion en rtributas' as verificacion;
SELECT COUNT(*) as tiene_campo FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'rtributas' AND COLUMN_NAME = 'fecha_hora_notificacion' AND TABLE_SCHEMA = DATABASE();

-- Si el resultado anterior es 0, descomentar (CUIDADO: modifica estructura existente):
/*
-- RTRIBUTAS VA
ALTER TABLE `rtributas` ADD COLUMN `fecha_hora_notificacion` DATETIME NULL AFTER `id`;
ALTER TABLE `rtributas` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `rtributas` ADD COLUMN `tipo_resolucion_otro` VARCHAR(255) NULL AFTER `tipo_resolucion`;
ALTER TABLE `rtributas` ADD COLUMN `plazo_cat` ENUM('30 D.H.', '3 Meses', 'otro') NULL AFTER `tipo_resolucion_otro`;
ALTER TABLE `rtributas` ADD COLUMN `plazo_cat_otro` VARCHAR(255) NULL AFTER `plazo_cat`;
ALTER TABLE `rtributas` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NULL;
-- IMPORTANTE: Solo si fecha existe y quieres reemplazarla:
-- ALTER TABLE `rtributas` DROP COLUMN `fecha`;

-- RTRIBUTAS PA  
ALTER TABLE `rtributas_pa` ADD COLUMN `fecha_hora_notificacion` DATETIME NULL AFTER `id`;
ALTER TABLE `rtributas_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `rtributas_pa` ADD COLUMN `tipo_resolucion_otro` VARCHAR(255) NULL AFTER `tipo_resolucion`;
ALTER TABLE `rtributas_pa` ADD COLUMN `plazo_cat` ENUM('30 D.H.', '3 Meses', 'otro') NULL AFTER `tipo_resolucion_otro`;
ALTER TABLE `rtributas_pa` ADD COLUMN `plazo_cat_otro` VARCHAR(255) NULL AFTER `plazo_cat`;
ALTER TABLE `rtributas_pa` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NULL;
-- IMPORTANTE: Solo si fecha existe y quieres reemplazarla:
-- ALTER TABLE `rtributas_pa` DROP COLUMN `fecha`;
*/

-- 4. VERIFICAR ECS - cambio fecha a DATETIME
SELECT 'VERIFICANDO: fecha en ecs (debería ser DATETIME)' as verificacion;
SELECT COLUMN_NAME, DATA_TYPE FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'ecs' AND COLUMN_NAME = 'fecha' AND TABLE_SCHEMA = DATABASE();

-- Si muestra DATE en lugar de DATETIME, descomentar:
/*
ALTER TABLE `ecs` MODIFY COLUMN `fecha` DATETIME NOT NULL;
ALTER TABLE `ecs` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `ecs` ADD COLUMN `juzgado` VARCHAR(255) NULL AFTER `fecha_resolucion`;
ALTER TABLE `ecs` ADD COLUMN `medidas` TEXT NULL AFTER `juzgado`;

ALTER TABLE `ecs_pa` MODIFY COLUMN `fecha` DATETIME NOT NULL;
ALTER TABLE `ecs_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `ecs_pa` ADD COLUMN `juzgado` VARCHAR(255) NULL AFTER `fecha_resolucion`;
ALTER TABLE `ecs_pa` ADD COLUMN `medidas` TEXT NULL AFTER `juzgado`;
*/

-- 5. VERIFICAR RRS - oficina_agencia_ea
SELECT 'VERIFICANDO: oficina_agencia_ea en rrs' as verificacion;
SELECT COUNT(*) as tiene_campo FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'rrs' AND COLUMN_NAME = 'oficina_agencia_ea' AND TABLE_SCHEMA = DATABASE();

-- Si el resultado anterior es 0, descomentar:
/*
ALTER TABLE `rrs` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;
ALTER TABLE `rrs_pa` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;
*/

-- 6. VERIFICAR NTRRS - cambio fecha a DATETIME
SELECT 'VERIFICANDO: fecha en ntrrs (debería ser DATETIME)' as verificacion;
SELECT COLUMN_NAME, DATA_TYPE FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'ntrrs' AND COLUMN_NAME = 'fecha' AND TABLE_SCHEMA = DATABASE();

-- Si muestra DATE en lugar de DATETIME, descomentar:
/*
ALTER TABLE `ntrrs` MODIFY COLUMN `fecha` DATETIME NOT NULL;
ALTER TABLE `ntrrs` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;
ALTER TABLE `ntrrs_pa` MODIFY COLUMN `fecha` DATETIME NOT NULL;
ALTER TABLE `ntrrs_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `numero_resolucion`;
*/

-- 7. VERIFICAR OCURSOS - oficina_agencia_ea  
SELECT 'VERIFICANDO: oficina_agencia_ea en ocursos' as verificacion;
SELECT COUNT(*) as tiene_campo FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'ocursos' AND COLUMN_NAME = 'oficina_agencia_ea' AND TABLE_SCHEMA = DATABASE();

-- Si el resultado anterior es 0, descomentar:
/*
ALTER TABLE `ocursos` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;
ALTER TABLE `ocursos_pa` ADD COLUMN `oficina_agencia_ea` VARCHAR(255) NULL AFTER `numero_documento`;
*/

-- 8. VERIFICAR ROS - fecha_notificacion y fecha_resolucion
SELECT 'VERIFICANDO: fecha_notificacion en ros' as verificacion;
SELECT COUNT(*) as tiene_campo FROM information_schema.COLUMNS 
WHERE TABLE_NAME = 'ros' AND COLUMN_NAME = 'fecha_notificacion' AND TABLE_SCHEMA = DATABASE();

-- Si el resultado anterior es 0, descomentar:
/*
ALTER TABLE `ros` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `ros` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;
ALTER TABLE `ros_pa` ADD COLUMN `fecha_notificacion` DATETIME NULL AFTER `fecha`;
ALTER TABLE `ros_pa` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_notificacion`;
*/

-- 9. AGREGAR ENTRADAS FALTANTES EN MIGRATIONS (solo las necesarias)
-- Solo descomentar después de aplicar los cambios anteriores:
/*
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
('2025_08_28_111114_add_fecha_resolucion_to_mpmrs_pa_table', 30);
*/

-- ====================================================================
-- INSTRUCCIONES DE USO
-- ====================================================================
/*
1. Ejecuta TODAS las verificaciones primero (líneas 27-95)
2. Revisa los resultados de cada verificación
3. Solo descomenta las secciones donde el resultado sea 0 o DATE (cuando debería ser DATETIME)
4. Ejecuta las modificaciones una sección a la vez
5. Al final, agrega las entradas a migrations

IMPORTANTE: 
- Si ya tienes datos en las tablas, ten cuidado con los MODIFY COLUMN
- Haz respaldo antes de modificar estructura existente
*/

SELECT 'SCRIPT DE VERIFICACIÓN Y MIGRACIONES FALTANTES LISTO' as 'RESULTADO';
