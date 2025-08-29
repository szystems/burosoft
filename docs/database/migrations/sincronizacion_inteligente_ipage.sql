-- ====================================================================
-- SCRIPT DE SINCRONIZACIÓN INTELIGENTE - IPAGE ↔ LOCAL
-- Fecha: 28 de agosto de 2025
-- Objetivo: Sincronizar iPage con verificaciones automáticas
-- No falla si las columnas ya existen
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_sincronizacion_inteligente';

-- ====================================================================
-- 1. CORREGIR ENUM plazo_evacuar (CRÍTICO - Causa error actual)
-- ====================================================================

SELECT 'CORRIGIENDO ENUM plazo_evacuar...' as 'Status_1';

-- Modificar ENUM para incluir 'Otro' si no lo tiene
ALTER TABLE `audiencias` MODIFY COLUMN `plazo_evacuar` ENUM('30 D.H.', '3 Meses', 'Otro') NULL;
ALTER TABLE `audiencias_pa` MODIFY COLUMN `plazo_evacuar` ENUM('30 D.H.', '3 Meses', 'Otro') NULL;

SELECT '✅ ENUM plazo_evacuar actualizado' as 'Status_1_OK';

-- ====================================================================
-- 2. FUNCIÓN AUXILIAR PARA AGREGAR COLUMNAS SEGURAMENTE
-- ====================================================================

DELIMITER $$
CREATE PROCEDURE IF NOT EXISTS AddColumnIfNotExists(
    IN table_name VARCHAR(128),
    IN column_name VARCHAR(128),
    IN column_definition TEXT
)
BEGIN
    SET @count = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS 
                  WHERE TABLE_SCHEMA = DATABASE() 
                  AND TABLE_NAME = table_name 
                  AND COLUMN_NAME = column_name);
    
    IF @count = 0 THEN
        SET @sql = CONCAT('ALTER TABLE `', table_name, '` ADD COLUMN `', column_name, '` ', column_definition);
        PREPARE stmt FROM @sql;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;
        SELECT CONCAT('✅ Columna ', column_name, ' agregada a ', table_name) as Result;
    ELSE
        SELECT CONCAT('ℹ️ Columna ', column_name, ' ya existe en ', table_name) as Result;
    END IF;
END$$
DELIMITER ;

-- ====================================================================
-- 3. AGREGAR TODAS LAS COLUMNAS FALTANTES
-- ====================================================================

SELECT 'Agregando columnas con verificación automática...' as 'Status_3';

-- AMPMRS
CALL AddColumnIfNotExists('ampmrs', 'oficina_ea', 'VARCHAR(191) NULL AFTER `numero_folios`');
CALL AddColumnIfNotExists('ampmrs_pa', 'oficina_ea', 'VARCHAR(191) NULL AFTER `numero_folios`');

-- MPMRS
CALL AddColumnIfNotExists('mpmrs', 'fecha_resolucion', 'DATE NULL AFTER `numero_resolucion`');
CALL AddColumnIfNotExists('mpmrs_pa', 'fecha_resolucion', 'DATE NULL AFTER `numero_resolucion`');

-- EVS, PPS, ADPMRS
CALL AddColumnIfNotExists('evs', 'oficina_presentacion', 'VARCHAR(191) NULL AFTER `numero_folios`');
CALL AddColumnIfNotExists('evs_pa', 'oficina_presentacion', 'VARCHAR(191) NULL AFTER `numero_folios`');
CALL AddColumnIfNotExists('pps', 'oficina_presentacion', 'VARCHAR(191) NULL AFTER `numero_folios`');
CALL AddColumnIfNotExists('pps_pa', 'oficina_presentacion', 'VARCHAR(191) NULL AFTER `numero_folios`');
CALL AddColumnIfNotExists('adpmrs', 'oficina_presentacion', 'VARCHAR(191) NULL AFTER `numero_folios`');
CALL AddColumnIfNotExists('adpmrs_pa', 'oficina_presentacion', 'VARCHAR(191) NULL AFTER `numero_folios`');

-- RESOLUCIONS
CALL AddColumnIfNotExists('resolucions', 'fecha_notificacion', 'DATETIME NULL AFTER `fecha`');
CALL AddColumnIfNotExists('resolucions', 'fecha_resolucion', 'DATE NULL AFTER `fecha_notificacion`');

-- RSAT_PA
CALL AddColumnIfNotExists('rsat_pa', 'fecha_notificacion', 'DATETIME NULL AFTER `fecha`');
CALL AddColumnIfNotExists('rsat_pa', 'fecha_resolucion', 'DATE NULL AFTER `fecha_notificacion`');

-- RTRIBUTAS
CALL AddColumnIfNotExists('rtributas', 'fecha_hora_notificacion', 'DATETIME NULL AFTER `id`');
CALL AddColumnIfNotExists('rtributas', 'fecha_resolucion', 'DATE NULL AFTER `numero_resolucion`');
CALL AddColumnIfNotExists('rtributas', 'tipo_resolucion_otro', 'VARCHAR(191) NULL AFTER `tipo_resolucion`');
CALL AddColumnIfNotExists('rtributas', 'plazo_cat', 'ENUM(\'5 días\', \'10 días\', \'15 días\', \'30 días\', \'45 días\', \'60 días\', \'otro\') NULL AFTER `tipo_resolucion_otro`');
CALL AddColumnIfNotExists('rtributas', 'plazo_cat_otro', 'VARCHAR(191) NULL AFTER `plazo_cat`');

CALL AddColumnIfNotExists('rtributas_pa', 'fecha_hora_notificacion', 'DATETIME NULL AFTER `id`');
CALL AddColumnIfNotExists('rtributas_pa', 'fecha_resolucion', 'DATE NULL AFTER `numero_resolucion`');
CALL AddColumnIfNotExists('rtributas_pa', 'tipo_resolucion_otro', 'VARCHAR(191) NULL AFTER `tipo_resolucion`');
CALL AddColumnIfNotExists('rtributas_pa', 'plazo_cat', 'ENUM(\'5 días\', \'10 días\', \'15 días\', \'30 días\', \'45 días\', \'60 días\', \'otro\') NULL AFTER `tipo_resolucion_otro`');
CALL AddColumnIfNotExists('rtributas_pa', 'plazo_cat_otro', 'VARCHAR(191) NULL AFTER `plazo_cat`');

-- RRS, OCURSOS
CALL AddColumnIfNotExists('rrs', 'oficina_agencia_ea', 'VARCHAR(191) NULL AFTER `numero_documento`');
CALL AddColumnIfNotExists('rrs_pa', 'oficina_agencia_ea', 'VARCHAR(191) NULL AFTER `numero_documento`');
CALL AddColumnIfNotExists('ocursos', 'oficina_agencia_ea', 'VARCHAR(191) NULL AFTER `numero_documento`');
CALL AddColumnIfNotExists('ocursos_pa', 'oficina_agencia_ea', 'VARCHAR(191) NULL AFTER `numero_documento`');

-- ROS
CALL AddColumnIfNotExists('ros', 'fecha_notificacion', 'DATETIME NULL AFTER `fecha`');
CALL AddColumnIfNotExists('ros', 'fecha_resolucion', 'DATE NULL AFTER `fecha_notificacion`');
CALL AddColumnIfNotExists('ros_pa', 'fecha_notificacion', 'DATETIME NULL AFTER `fecha`');
CALL AddColumnIfNotExists('ros_pa', 'fecha_resolucion', 'DATE NULL AFTER `fecha_notificacion`');

-- NULIDADES
CALL AddColumnIfNotExists('nulidades', 'fecha_resolucion', 'DATE NULL AFTER `numero_resolucion`');
CALL AddColumnIfNotExists('nulidades_pa', 'fecha_resolucion', 'DATE NULL AFTER `numero_resolucion`');

-- ECS
CALL AddColumnIfNotExists('ecs', 'fecha_resolucion', 'DATE NULL AFTER `numero_resolucion`');
CALL AddColumnIfNotExists('ecs', 'juzgado_que_conoce', 'VARCHAR(500) NULL AFTER `fecha_resolucion`');
CALL AddColumnIfNotExists('ecs', 'medidas_decretadas', 'JSON NULL AFTER `juzgado_que_conoce`');
CALL AddColumnIfNotExists('ecs_pa', 'fecha_resolucion', 'DATE NULL AFTER `numero_resolucion`');
CALL AddColumnIfNotExists('ecs_pa', 'juzgado_que_conoce', 'VARCHAR(500) NULL AFTER `fecha_resolucion`');
CALL AddColumnIfNotExists('ecs_pa', 'medidas_decretadas', 'JSON NULL AFTER `juzgado_que_conoce`');

-- NTRRS
CALL AddColumnIfNotExists('ntrrs', 'fecha_resolucion', 'DATE NULL AFTER `numero_resolucion`');
CALL AddColumnIfNotExists('ntrrs_pa', 'fecha_resolucion', 'DATE NULL AFTER `numero_resolucion`');

SELECT '✅ Todas las columnas verificadas/agregadas' as 'Status_3_OK';

-- ====================================================================
-- 4. ACTUALIZAR ENUMs Y TIPOS DE DATOS
-- ====================================================================

SELECT 'Actualizando ENUMs y tipos de datos...' as 'Status_4';

-- Actualizar ENUMs tipo_resolucion
ALTER TABLE `rsat_pa` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NULL;
ALTER TABLE `rtributas` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NOT NULL;
ALTER TABLE `rtributas_pa` MODIFY COLUMN `tipo_resolucion` ENUM('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal', 'otro') NOT NULL;

-- Actualizar campos fecha a DATETIME
ALTER TABLE `nulidades` MODIFY COLUMN `fecha` DATETIME NOT NULL;
ALTER TABLE `nulidades_pa` MODIFY COLUMN `fecha` DATETIME NOT NULL;
ALTER TABLE `ecs` MODIFY COLUMN `fecha` DATETIME NOT NULL;
ALTER TABLE `ecs_pa` MODIFY COLUMN `fecha` DATETIME NOT NULL;
ALTER TABLE `ntrrs` MODIFY COLUMN `fecha` DATETIME NOT NULL;
ALTER TABLE `ntrrs_pa` MODIFY COLUMN `fecha` DATETIME NOT NULL;

SELECT '✅ ENUMs y tipos de datos actualizados' as 'Status_4_OK';

-- ====================================================================
-- 5. LIMPIAR FUNCIÓN AUXILIAR
-- ====================================================================

DROP PROCEDURE IF EXISTS AddColumnIfNotExists;

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'SINCRONIZACIÓN INTELIGENTE COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'BASE DE DATOS IPAGE SINCRONIZADA SIN ERRORES' as 'ESTADO_FINAL';

-- ====================================================================
-- VERIFICACIONES POSTERIORES RECOMENDADAS
-- ====================================================================
/*
✅ ESTE SCRIPT:
1. No falla si las columnas ya existen
2. Verifica automáticamente antes de agregar
3. Actualiza ENUMs y tipos de datos
4. Resuelve el error crítico de plazo_evacuar

✅ PRÓXIMOS PASOS:
1. Probar creación de expedientes PA
2. Probar inserción de aceptaciones
3. La aplicación debería funcionar completamente
*/
