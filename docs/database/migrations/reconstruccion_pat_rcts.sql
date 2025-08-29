-- ====================================================================
-- RECONSTRUCCIÓN pat_rcts - Agregar TODOS los campos faltantes
-- Fecha: 28 de agosto de 2025
-- Problema: pat_rcts de iPage tiene estructura completamente obsoleta
-- Solución: Agregar todos los campos que la aplicación necesita
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_reconstruccion_pat_rcts';

-- ====================================================================
-- AGREGAR TODOS LOS CAMPOS FALTANTES EN pat_rcts
-- ====================================================================

SELECT 'Reconstruyendo tabla pat_rcts - Agregando campos faltantes...' as 'Status';

-- Campos que la aplicación envía pero no existen en iPage:
ALTER TABLE `pat_rcts` ADD COLUMN `fecha_citacion` DATE NOT NULL AFTER `user_id`;
ALTER TABLE `pat_rcts` ADD COLUMN `medio_citacion` VARCHAR(191) NOT NULL AFTER `fecha_citacion`;
ALTER TABLE `pat_rcts` ADD COLUMN `medio_citacion_otro` VARCHAR(191) NULL AFTER `medio_citacion`;
ALTER TABLE `pat_rcts` ADD COLUMN `fecha_atencion` DATE NOT NULL AFTER `medio_citacion_otro`;
ALTER TABLE `pat_rcts` ADD COLUMN `participantes_reunion` TEXT NOT NULL AFTER `fecha_atencion`;
ALTER TABLE `pat_rcts` ADD COLUMN `lugar_celebracion` VARCHAR(191) NOT NULL AFTER `participantes_reunion`;
ALTER TABLE `pat_rcts` ADD COLUMN `descripcion_resultado` TEXT NOT NULL AFTER `lugar_celebracion`;
ALTER TABLE `pat_rcts` ADD COLUMN `suscribe_acta` VARCHAR(191) NOT NULL AFTER `descripcion_resultado`;

-- Campos de archivos que faltan:
ALTER TABLE `pat_rcts` ADD COLUMN `archivo_acta` VARCHAR(191) NULL AFTER `suscribe_acta`;
ALTER TABLE `pat_rcts` ADD COLUMN `tipo_archivo_acta` VARCHAR(191) NULL AFTER `archivo_acta`;
ALTER TABLE `pat_rcts` ADD COLUMN `archivo_recibo_pago` VARCHAR(191) NULL AFTER `tipo_archivo_acta`;
ALTER TABLE `pat_rcts` ADD COLUMN `tipo_archivo_recibo` VARCHAR(191) NULL AFTER `archivo_recibo_pago`;

-- Agregar usuario_id (que parece faltar)
ALTER TABLE `pat_rcts` ADD COLUMN `usuario_id` BIGINT(20) UNSIGNED NOT NULL AFTER `tipo_archivo_recibo`;

-- Renombrar user_id para que coincida con la aplicación (si es necesario)
-- ALTER TABLE `pat_rcts` CHANGE `user_id` `usuario_id_old` BIGINT(20) UNSIGNED NOT NULL;

SELECT 'Campos principales agregados a pat_rcts' as 'Resultado';

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'RECONSTRUCCIÓN pat_rcts COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';
SELECT 'pat_rcts ahora debería ser compatible con la aplicación' as 'ACCION_SIGUIENTE';

/*
✅ CAMPOS AGREGADOS A pat_rcts:
- fecha_citacion, medio_citacion, medio_citacion_otro
- fecha_atencion, participantes_reunion, lugar_celebracion  
- descripcion_resultado, suscribe_acta
- archivo_acta, tipo_archivo_acta
- archivo_recibo_pago, tipo_archivo_recibo
- usuario_id

✅ PRÓXIMO PASO:
- Reintentar inserción de pat-rct
- La tabla ahora tiene todos los campos necesarios
*/
