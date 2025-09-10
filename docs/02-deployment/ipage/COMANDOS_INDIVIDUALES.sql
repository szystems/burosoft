-- ===================================================================
-- COMANDOS INDIVIDUALES: PROBAR UNO POR UNO
-- ===================================================================

-- EJECUTAR UNO POR UNO PARA VER CUÁL FALLA:

-- Comando 1: Ver base de datos actual
SELECT DATABASE();

-- Comando 2: Ver todas las tablas  
SHOW TABLES;

-- Comando 3: Ver tablas PA específicamente
SHOW TABLES LIKE '%dpmr%';

-- Comando 4: Intentar describir la tabla directamente
DESCRIBE dpmrs_pa;

-- Comando 5: Ver si existe en information_schema
SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'dbburonuevo' AND TABLE_NAME = 'dpmrs_pa';

-- Comando 6: Verificar permisos
SHOW GRANTS;
