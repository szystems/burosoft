-- ====================================================================
-- CORRECCIÓN - Campos faltantes en tabla nulidades
-- Fecha: 28 de agosto de 2025
-- Problema: Faltan fecha_hora_notificacion y fecha_resolucion
-- Solución: Aplicar migración 2025_08_26_120000 en iPage
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_nulidades';

-- ====================================================================
-- APLICAR MIGRACIÓN - ACTUALIZAR ESTRUCTURA nulidades (VERSIÓN SEGURA)
-- ====================================================================

SELECT 'Actualizando estructura de nulidades (verificando campos existentes)...' as 'Status';

-- PASO 1: Verificar si fecha_hora_notificacion ya existe, si no, agregarlo
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists 
FROM information_schema.columns 
WHERE table_schema = DATABASE() 
AND table_name = 'nulidades' 
AND column_name = 'fecha_hora_notificacion';

SELECT IF(@col_exists > 0, 'fecha_hora_notificacion ya existe', 'agregando fecha_hora_notificacion') as 'Status_fecha_hora_notificacion';

-- Solo agregar fecha_hora_notificacion si no existe
SET @sql = IF(@col_exists = 0, 
    'ALTER TABLE `nulidades` ADD COLUMN `fecha_hora_notificacion` DATETIME NOT NULL AFTER `usuario_id`', 
    'SELECT "fecha_hora_notificacion ya existe" as Info');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- PASO 2: El campo fecha_resolucion ya existe según el error, así que lo omitimos

-- PASO 3: Verificar si el campo fecha original aún existe para migrarlo
SET @fecha_exists = 0;
SELECT COUNT(*) INTO @fecha_exists 
FROM information_schema.columns 
WHERE table_schema = DATABASE() 
AND table_name = 'nulidades' 
AND column_name = 'fecha';

SELECT IF(@fecha_exists > 0, 'Campo fecha existe - migrar datos', 'Campo fecha no existe - OK') as 'Status_migracion';

-- Solo migrar datos si el campo fecha aún existe
SET @migrate_sql = IF(@fecha_exists > 0, 
    'UPDATE `nulidades` SET `fecha_hora_notificacion` = TIMESTAMP(fecha, "00:00:00") WHERE `fecha_hora_notificacion` IS NULL OR `fecha_hora_notificacion` = "0000-00-00 00:00:00"', 
    'SELECT "No hay datos para migrar" as Info');
PREPARE stmt2 FROM @migrate_sql;
EXECUTE stmt2;
DEALLOCATE PREPARE stmt2;

-- PASO 4: Eliminar campo fecha solo si existe
SET @drop_sql = IF(@fecha_exists > 0, 
    'ALTER TABLE `nulidades` DROP COLUMN `fecha`', 
    'SELECT "Campo fecha ya eliminado" as Info');
PREPARE stmt3 FROM @drop_sql;
EXECUTE stmt3;
DEALLOCATE PREPARE stmt3;

SELECT 'Migración de nulidades completada' as 'Resultado';

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN nulidades COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'Nulidades debería funcionar correctamente ahora' as 'ACCION_SIGUIENTE';

/*
✅ MIGRACIÓN SEGURA APLICADA A nulidades:
- fecha_hora_notificacion: verificado y agregado si no existía
- fecha_resolucion: ya existía (por eso el error)
- fecha: migrado a fecha_hora_notificacion y eliminado si existía

✅ ESTRUCTURA FINAL:
- id, audiencia_id, usuario_id, fecha_hora_notificacion, numero_resolucion, fecha_resolucion, archivo, tipo_archivo, observaciones, tipo_nulidad, numero_folios, created_at, updated_at

✅ PRÓXIMO PASO:
- Ejecutar este script seguro en iPage
- Reintentar inserción de Nulidad
- El script verifica campos existentes antes de agregarlos

✅ MIGRACIÓN INTELIGENTE:
- Verifica si cada campo existe antes de agregarlo
- Solo migra datos si es necesario
- Evita errores de campos duplicados
*/
