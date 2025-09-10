-- ===================================================================
-- SOLUCIÓN RÁPIDA: CREAR TABLA rsat_pa TEMPORAL
-- ===================================================================

-- Esta tabla es la que busca el modelo RsatPa en la versión antigua
-- Crear como copia de resolucins_pa para que funcione inmediatamente

SELECT '🔧 CREANDO TABLA rsat_pa TEMPORAL' as 'Status';

-- Crear tabla rsat_pa igual a resolucins_pa
CREATE TABLE `rsat_pa` LIKE `resolucins_pa`;

-- Verificar que se creó
DESCRIBE rsat_pa;

-- Agregar foreign keys
ALTER TABLE `rsat_pa` 
ADD CONSTRAINT `rsat_pa_usuario_id_foreign` 
FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `rsat_pa` 
ADD CONSTRAINT `rsat_pa_audiencia_pa_id_foreign` 
FOREIGN KEY (`audiencia_pa_id`) REFERENCES `audiencias_pa` (`id`) ON DELETE CASCADE;

SELECT '✅ TABLA rsat_pa CREADA COMO TEMPORAL' as 'Status_Final';
SELECT 'AHORA PRUEBA ACCEDER A PA - DEBERÍA FUNCIONAR' as 'Instruccion';
