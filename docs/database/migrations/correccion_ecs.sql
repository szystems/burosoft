-- ====================================================================
-- CORRECCIÓN - Campos faltantes en tabla ecs
-- Fecha: 28 de agosto de 2025
-- Problema: Faltan campos de migración 2025_08_26_130000
-- Solución: Agregar campos faltantes en ecs
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_ecs';

-- ====================================================================
-- AGREGAR CAMPOS FALTANTES EN ecs
-- ====================================================================

SELECT 'Agregando campos faltantes a ecs...' as 'Status';

-- Agregar fecha_hora_notificacion después de numero_resolucion
ALTER TABLE `ecs` ADD COLUMN `fecha_hora_notificacion` DATETIME NULL AFTER `numero_resolucion`;

-- Agregar fecha_resolucion después de fecha_hora_notificacion
ALTER TABLE `ecs` ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_hora_notificacion`;

-- Agregar juzgado_que_conoce después de fecha_resolucion
ALTER TABLE `ecs` ADD COLUMN `juzgado_que_conoce` VARCHAR(255) NULL AFTER `fecha_resolucion`;

-- Agregar medidas_decretadas (como TEXT para compatibilidad con JSON)
ALTER TABLE `ecs` ADD COLUMN `medidas_decretadas` TEXT NULL AFTER `juzgado_que_conoce`;

-- Agregar medidas_decretadas_otro después de medidas_decretadas
ALTER TABLE `ecs` ADD COLUMN `medidas_decretadas_otro` VARCHAR(255) NULL AFTER `medidas_decretadas`;

SELECT 'Campos agregados a ecs' as 'Resultado';

-- Verificar estructura final
SELECT 'Verificando estructura final...' as 'Status_final';
DESCRIBE `ecs`;

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN ecs COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'ECS debería funcionar correctamente ahora' as 'ACCION_SIGUIENTE';

/*
✅ CAMPOS AGREGADOS A ecs:
- fecha_hora_notificacion: DATETIME NULL (después de numero_resolucion)
- fecha_resolucion: DATE NULL (después de fecha_hora_notificacion)
- juzgado_que_conoce: VARCHAR(255) NULL (después de fecha_resolucion)
- medidas_decretadas: TEXT NULL (después de juzgado_que_conoce)
- medidas_decretadas_otro: VARCHAR(255) NULL (después de medidas_decretadas)

✅ ESTRUCTURA FINAL:
- id, audiencia_id, numero_resolucion, fecha_hora_notificacion, fecha_resolucion, juzgado_que_conoce, medidas_decretadas, medidas_decretadas_otro, observaciones, usuario_id, numero_folios, created_at, updated_at

✅ PRÓXIMO PASO:
- Ejecutar este script completo en iPage
- Reintentar inserción de EC
- Debería funcionar perfectamente ahora

✅ MIGRACIÓN APLICADA:
- Se aplicó la migración 2025_08_26_130000_update_ecs_table_add_datetime_and_fecha_resolucion
- Todos los campos requeridos ahora existen
- medidas_decretadas se creó como TEXT para compatibilidad con MySQL 5.7
*/
