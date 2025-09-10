-- ===================================================================
-- PASO 1 FINAL: ACTUALIZAR ESTRUCTURA EXISTENTE audiencias_pa
-- ===================================================================

-- La tabla ya existe con estructura parcial, solo agregar lo que falta

-- 1. Agregar columnas faltantes
ALTER TABLE `audiencias_pa` ADD COLUMN `numero_resolucion` varchar(191) NULL AFTER `numero_audiencia`;
ALTER TABLE `audiencias_pa` ADD COLUMN `fecha_hora` datetime NULL AFTER `fecha`;
ALTER TABLE `audiencias_pa` ADD COLUMN `empresa_id` bigint(20) unsigned NULL AFTER `pat_id`;
ALTER TABLE `audiencias_pa` ADD COLUMN `observaciones` text NULL AFTER `tipo_archivo`;
ALTER TABLE `audiencias_pa` ADD COLUMN `numero_folios` int(11) NULL AFTER `observaciones`;
ALTER TABLE `audiencias_pa` ADD COLUMN `estado` varchar(50) DEFAULT 'Activo' AFTER `numero_folios`;

-- 2. Actualizar datos existentes (copiar valores)
UPDATE `audiencias_pa` SET 
    `numero_resolucion` = `numero_audiencia`,
    `fecha_hora` = `fecha`,
    `empresa_id` = `pat_id`
WHERE `numero_resolucion` IS NULL;

-- 3. Agregar índices si no existen
ALTER TABLE `audiencias_pa` ADD KEY `audiencias_pa_empresa_id_foreign` (`empresa_id`);

-- 4. Agregar foreign key constraint para empresa_id
ALTER TABLE `audiencias_pa` 
ADD CONSTRAINT `audiencias_pa_empresa_id_foreign` 
FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE;

-- 5. Verificar estructura final
DESCRIBE audiencias_pa;

-- 6. Mostrar datos para verificar migración
SELECT 
    id, 
    numero_audiencia, 
    numero_resolucion, 
    fecha, 
    fecha_hora, 
    pat_id, 
    empresa_id,
    estado
FROM audiencias_pa 
LIMIT 5;
