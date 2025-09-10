-- ===================================================================
-- SOLUCIÓN DEFINITIVA: CREAR TABLA resolucins_pa EN IPAGE
-- ===================================================================

SELECT '🔧 CREANDO TABLA resolucins_pa' as 'Status';

-- PASO 1: Crear tabla resolucins_pa basada en rsat_pa corregida
CREATE TABLE `resolucins_pa` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `numero_resolucion` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `tipo_resolucion` enum('R-SAT','Otro') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'R-SAT',
  `tipo_resolucion_otro` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usuario_id` bigint(20) unsigned NOT NULL,
  `audiencia_pa_id` bigint(20) unsigned NOT NULL,
  `archivo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_archivo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_folios` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resolucins_pa_usuario_id_foreign` (`usuario_id`),
  KEY `resolucins_pa_audiencia_pa_id_foreign` (`audiencia_pa_id`),
  CONSTRAINT `resolucins_pa_audiencia_pa_id_foreign` FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE,
  CONSTRAINT `resolucins_pa_usuario_id_foreign` FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PASO 2: Migrar datos existentes de rsat_pa a resolucins_pa (si los hay)
SELECT 'MIGRANDO DATOS DE rsat_pa a resolucins_pa:' as 'Info';
INSERT INTO resolucins_pa (
    numero_resolucion,
    fecha_hora,
    tipo_resolucion,
    tipo_resolucion_otro,
    usuario_id,
    audiencia_pa_id,
    archivo,
    tipo_archivo,
    observaciones,
    numero_folios,
    created_at,
    updated_at
)
SELECT 
    numero_resolucion,
    fecha_hora,
    CASE 
        WHEN tipo_resolucion IN ('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal') THEN 'Otro'
        ELSE 'R-SAT'
    END as tipo_resolucion,
    CASE 
        WHEN tipo_resolucion IN ('total a favor', 'total en contra', 'parcial', 'nulidad', 'penal') THEN tipo_resolucion
        ELSE NULL
    END as tipo_resolucion_otro,
    usuario_id,
    audiencia_pa_id,
    archivo,
    tipo_archivo,
    observaciones,
    numero_folios,
    created_at,
    updated_at
FROM rsat_pa;

-- PASO 3: Verificar migración
SELECT 'VERIFICACIÓN FINAL:' as 'Info';
SELECT COUNT(*) as 'registros_resolucins_pa' FROM resolucins_pa;
SELECT COUNT(*) as 'registros_rsat_pa' FROM rsat_pa;

-- PASO 4: Mostrar estructura final
SELECT 'ESTRUCTURA FINAL resolucins_pa:' as 'Info';
DESCRIBE resolucins_pa;

SELECT '✅ TABLA resolucins_pa CREADA Y MIGRADA EXITOSAMENTE' as 'Status';
