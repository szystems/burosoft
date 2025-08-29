-- ====================================================================
-- SCRIPT DE CORRECCIÓN RÁPIDA - IPAGE
-- Fecha: 28 de agosto de 2025
-- Error: Column 'fecha_hora_presentacion' not found in 'aceptacions'
-- Compatible con restricciones de iPage hosting
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion';

-- ====================================================================
-- DIAGNÓSTICO: VERIFICAR ESTRUCTURA ACTUAL
-- ====================================================================

SELECT 'VERIFICANDO ESTRUCTURA ACTUAL...' as 'Status';

-- Verificar si existe la tabla aceptacions
DESCRIBE `aceptacions`;

-- ====================================================================
-- CORRECCIÓN: AGREGAR COLUMNAS FALTANTES
-- ====================================================================

SELECT 'APLICANDO CORRECCIÓN...' as 'Status';

-- CORREGIR TABLA ACEPTACIONS
-- Agregar columna que la aplicación está buscando
ALTER TABLE `aceptacions` ADD COLUMN `fecha_hora_presentacion` DATETIME NULL AFTER `fecha_hora_aceptacion`;
ALTER TABLE `aceptacions` ADD COLUMN `oficina_presentacion` VARCHAR(191) NULL AFTER `observaciones`;

SELECT '✅ Columnas agregadas a ACEPTACIONS' as 'Status_1';

-- CORREGIR TABLA ACEPTACIONS_PA
ALTER TABLE `aceptacions_pa` ADD COLUMN `fecha_hora_presentacion` DATETIME NULL AFTER `fecha_hora_aceptacion`;
ALTER TABLE `aceptacions_pa` ADD COLUMN `oficina_presentacion` VARCHAR(191) NULL AFTER `observaciones`;

SELECT '✅ Columnas agregadas a ACEPTACIONS_PA' as 'Status_2';

-- ====================================================================
-- VERIFICACIÓN: ESTRUCTURA CORREGIDA
-- ====================================================================

SELECT 'VERIFICANDO CORRECCIÓN...' as 'Status';

DESCRIBE `aceptacions`;

-- ====================================================================
-- RESULTADO FINAL
-- ====================================================================

SELECT 'CORRECCIÓN COMPLETADA - ERROR SOLUCIONADO' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';

/*
✅ PROBLEMA SOLUCIONADO:
- Error: Column 'fecha_hora_presentacion' not found
- Error: Column 'oficina_presentacion' not found

✅ CORRECCIÓN APLICADA:
- Agregadas columnas faltantes a aceptacions
- Agregadas columnas faltantes a aceptacions_pa
- Aplicación ahora puede funcionar correctamente

✅ PRÓXIMOS PASOS:
- Probar inserción desde la aplicación
- Verificar que no hay más errores de columnas faltantes
*/
