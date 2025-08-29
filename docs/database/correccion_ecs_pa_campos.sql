-- CORRECCIÓN PARA LA TABLA ecs_pa
-- Agregar los campos que faltan según el modelo EcPa.php

-- ESTADO ACTUAL EN IPAGE:
-- Field             | Type                      | Null | Key | Default | Extra
-- -----------------|---------------------------|------|-----|---------|----------------
-- id               | bigint(20) unsigned       | NO   | PRI | NULL    | auto_increment
-- audiencia_pa_id  | bigint(20) unsigned       | NO   | MUL | NULL    |
-- numero_resolucion| text                      | NO   |     | NULL    |
-- observaciones    | text                      | YES  |     | NULL    |
-- usuario_id       | bigint(20) unsigned       | NO   | MUL | NULL    |
-- numero_folios    | int(11)                   | YES  |     | NULL    |
-- created_at       | timestamp                 | YES  |     | NULL    |
-- updated_at       | timestamp                 | YES  |     | NULL    |

-- CAMPOS QUE INTENTA INSERTAR EL CÓDIGO:
-- audiencia_pa_id ✓
-- usuario_id ✓
-- numero_resolucion ✓
-- fecha_hora_notificacion ❌ (FALTA)
-- fecha_resolucion ❌ (FALTA)
-- juzgado_que_conoce ❌ (FALTA)
-- medidas_decretadas ❌ (FALTA)
-- medidas_decretadas_otro ❌ (FALTA)
-- observaciones ✓
-- numero_folios ✓
-- updated_at ✓
-- created_at ✓

-- 1. Agregar fecha_hora_notificacion (datetime)
ALTER TABLE `ecs_pa` 
ADD COLUMN `fecha_hora_notificacion` DATETIME NULL AFTER `numero_resolucion`;

-- 2. Agregar fecha_resolucion (date)
ALTER TABLE `ecs_pa` 
ADD COLUMN `fecha_resolucion` DATE NULL AFTER `fecha_hora_notificacion`;

-- 3. Agregar juzgado_que_conoce (varchar)
ALTER TABLE `ecs_pa` 
ADD COLUMN `juzgado_que_conoce` VARCHAR(500) NULL AFTER `fecha_resolucion`;

-- 4. Agregar medidas_decretadas (json/text para arrays)
ALTER TABLE `ecs_pa` 
ADD COLUMN `medidas_decretadas` JSON NULL AFTER `juzgado_que_conoce`;

-- 5. Agregar medidas_decretadas_otro (text)
ALTER TABLE `ecs_pa` 
ADD COLUMN `medidas_decretadas_otro` TEXT NULL AFTER `medidas_decretadas`;

-- 6. Verificar la estructura de la tabla después de los cambios
DESCRIBE `ecs_pa`;

-- NOTA: Ejecutar estos comandos uno por uno en phpMyAdmin de iPage
-- El hosting compartido puede requerir ejecutar los ALTER TABLE por separado
