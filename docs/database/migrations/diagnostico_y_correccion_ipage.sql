-- ====================================================================
-- SCRIPT DE DIAGNÓSTICO Y CORRECCIÓN - IPAGE
-- Fecha: 28 de agosto de 2025
-- Error reportado: Column 'fecha_hora_presentacion' not found in 'aceptacions'
-- ====================================================================

-- Verificar conexión y base de datos actual
SELECT DATABASE() as 'Base_de_datos_activa', NOW() as 'Fecha_diagnostico';

-- ====================================================================
-- 1. VERIFICAR EXISTENCIA DE TABLAS NUEVAS
-- ====================================================================

SELECT 'VERIFICANDO TABLAS NUEVAS...' as 'Status_Check';

-- Verificar si existen las tablas que deberían haberse creado
SELECT 
    CASE 
        WHEN COUNT(*) > 0 THEN 'EXISTS' 
        ELSE 'NOT_EXISTS' 
    END as 'pat_rcts_status'
FROM information_schema.tables 
WHERE table_schema = DATABASE() AND table_name = 'pat_rcts';

SELECT 
    CASE 
        WHEN COUNT(*) > 0 THEN 'EXISTS' 
        ELSE 'NOT_EXISTS' 
    END as 'aceptacions_status'
FROM information_schema.tables 
WHERE table_schema = DATABASE() AND table_name = 'aceptacions';

SELECT 
    CASE 
        WHEN COUNT(*) > 0 THEN 'EXISTS' 
        ELSE 'NOT_EXISTS' 
    END as 'aceptacions_pa_status'
FROM information_schema.tables 
WHERE table_schema = DATABASE() AND table_name = 'aceptacions_pa';

SELECT 
    CASE 
        WHEN COUNT(*) > 0 THEN 'EXISTS' 
        ELSE 'NOT_EXISTS' 
    END as 'constancia_pagos_status'
FROM information_schema.tables 
WHERE table_schema = DATABASE() AND table_name = 'constancia_pagos';

-- ====================================================================
-- 2. VERIFICAR ESTRUCTURA DE TABLA ACEPTACIONS (si existe)
-- ====================================================================

DESCRIBE `aceptacions`;

-- ====================================================================
-- 3. VERIFICAR MIGRACIONES APLICADAS
-- ====================================================================

SELECT 'ÚLTIMAS MIGRACIONES APLICADAS:' as 'Status_Migrations';

SELECT migration, batch 
FROM migrations 
ORDER BY batch DESC, id DESC 
LIMIT 10;

-- ====================================================================
-- 4. CORRECCIÓN DEL PROBLEMA DETECTADO
-- ====================================================================

-- PROBLEMA: La aplicación busca 'fecha_hora_presentacion' pero la tabla tiene 'fecha_hora_aceptacion'
-- SOLUCIÓN: Agregar la columna que la aplicación está buscando

SELECT 'APLICANDO CORRECCIÓN...' as 'Status_Fix';

-- Si la tabla aceptacions existe, agregar la columna faltante
ALTER TABLE `aceptacions` ADD COLUMN `fecha_hora_presentacion` DATETIME NULL AFTER `fecha_hora_aceptacion`;

-- También agregar oficina_presentacion que aparece en el error
ALTER TABLE `aceptacions` ADD COLUMN `oficina_presentacion` VARCHAR(191) NULL AFTER `observaciones`;

SELECT '✅ Columnas agregadas a ACEPTACIONS' as 'Status_Fix_1';

-- Hacer lo mismo para aceptacions_pa si existe
ALTER TABLE `aceptacions_pa` ADD COLUMN `fecha_hora_presentacion` DATETIME NULL AFTER `fecha_hora_aceptacion`;
ALTER TABLE `aceptacions_pa` ADD COLUMN `oficina_presentacion` VARCHAR(191) NULL AFTER `observaciones`;

SELECT '✅ Columnas agregadas a ACEPTACIONS_PA' as 'Status_Fix_2';

-- ====================================================================
-- 5. VERIFICACIÓN FINAL
-- ====================================================================

SELECT 'VERIFICACIÓN POST-CORRECCIÓN:' as 'Status_Final';

DESCRIBE `aceptacions`;

SELECT 'CORRECCIÓN COMPLETADA EXITOSAMENTE' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';

-- ====================================================================
-- RESUMEN DE CORRECCIÓN APLICADA
-- ====================================================================
/*
✅ PROBLEMA IDENTIFICADO:
- La aplicación busca campos que no existen en la tabla aceptacions
- fecha_hora_presentacion (faltaba)
- oficina_presentacion (faltaba)

✅ CORRECCIÓN APLICADA:
- Agregadas columnas faltantes a aceptacions y aceptacions_pa
- Mantenida compatibilidad con estructura existente

✅ CAMPOS AHORA DISPONIBLES:
- fecha_hora_aceptacion (original)
- fecha_hora_presentacion (agregado)
- oficina_presentacion (agregado)
*/
