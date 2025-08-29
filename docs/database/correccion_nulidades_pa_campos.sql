-- CORRECCIÓN PARA LA TABLA nulidades_pa
-- Agregar el campo fecha_hora_notificacion que falta
-- El modelo NulidadPa.php espera este campo pero no existe en la tabla de iPage

-- 1. Agregar el campo fecha_hora_notificacion (datetime) - YA EJECUTADO
-- ALTER TABLE `nulidades_pa` 
-- ADD COLUMN `fecha_hora_notificacion` DATETIME NOT NULL AFTER `usuario_id`;

-- 2. NUEVO PROBLEMA: El campo 'fecha' es NOT NULL pero no se está enviando valor
-- Opción 1: Hacer el campo fecha NULLABLE (recomendado)
ALTER TABLE `nulidades_pa` 
MODIFY COLUMN `fecha` DATETIME NULL DEFAULT NULL;

-- Opción 2: Dar un valor por defecto al campo fecha (alternativa)
-- ALTER TABLE `nulidades_pa` 
-- MODIFY COLUMN `fecha` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- 3. Verificar la estructura de la tabla después del cambio
DESCRIBE `nulidades_pa`;

-- ESTADO ACTUAL EN IPAGE:
-- Field             | Type                      | Null | Key | Default | Extra
-- -----------------|---------------------------|------|-----|---------|----------------
-- id               | bigint(20) unsigned       | NO   | PRI | NULL    | auto_increment
-- audiencia_pa_id  | bigint(20) unsigned       | NO   | MUL | NULL    |
-- usuario_id       | bigint(20) unsigned       | NO   | MUL | NULL    |
-- fecha            | datetime                  | NO   |     | NULL    |
-- numero_resolucion| varchar(191)              | NO   |     | NULL    |
-- fecha_resolucion | date                      | YES  |     | NULL    |
-- archivo          | varchar(191)              | NO   |     | NULL    |
-- tipo_archivo     | varchar(191)              | NO   |     | NULL    |
-- observaciones    | text                      | YES  |     | NULL    |
-- tipo_nulidad     | enum('Absoluta','Relativa') | NO |     | NULL    |
-- numero_folios    | int(11)                   | YES  |     | NULL    |
-- created_at       | timestamp                 | YES  |     | NULL    |
-- updated_at       | timestamp                 | YES  |     | NULL    |

-- CAMPOS QUE INTENTA INSERTAR EL CÓDIGO:
-- audiencia_pa_id ✓
-- usuario_id ✓
-- fecha_hora_notificacion ❌ (FALTA - necesita ser agregado)
-- fecha_resolucion ✓
-- numero_resolucion ✓
-- tipo_nulidad ✓
-- observaciones ✓
-- numero_folios ✓
-- archivo ✓
-- tipo_archivo ✓
-- updated_at ✓
-- created_at ✓
