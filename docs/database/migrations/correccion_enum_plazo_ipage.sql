-- ====================================================================
-- CORRECCIÓN FINAL - IPAGE 
-- Fecha: 28 de agosto de 2025
-- Error: Data truncated for column 'plazo_evacuar' - Valor 'Otro' no permitido
-- ====================================================================

-- Verificar conexión
SELECT DATABASE() as 'Base_activa', NOW() as 'Inicio_correccion_3';

-- ====================================================================
-- CORRECCIÓN: AGREGAR 'Otro' AL ENUM plazo_evacuar
-- ====================================================================

SELECT 'CORRIGIENDO ENUM plazo_evacuar...' as 'Status';

-- Actualizar ENUM en audiencias para incluir 'Otro'
ALTER TABLE `audiencias` MODIFY COLUMN `plazo_evacuar` ENUM('30 D.H.', '3 Meses', 'Otro') NULL;

-- Actualizar ENUM en audiencias_pa para incluir 'Otro'  
ALTER TABLE `audiencias_pa` MODIFY COLUMN `plazo_evacuar` ENUM('30 D.H.', '3 Meses', 'Otro') NULL;

SELECT '✅ ENUM plazo_evacuar actualizado con opción Otro' as 'Status_1';

-- ====================================================================
-- VERIFICACIÓN FINAL
-- ====================================================================

SELECT 'VERIFICANDO ESTRUCTURA...' as 'Status';

DESCRIBE `audiencias_pa`;

SELECT 'TERCERA CORRECCIÓN COMPLETADA' as 'RESULTADO_FINAL', NOW() as 'Fecha_completada';

/*
✅ PROBLEMA SOLUCIONADO:
- Error: Data truncated for column 'plazo_evacuar'
- Causa: ENUM no incluía valor 'Otro'
- Solución: Agregado 'Otro' a ENUM('30 D.H.', '3 Meses', 'Otro')

✅ VALORES AHORA PERMITIDOS:
- '30 D.H.' ✅
- '3 Meses' ✅  
- 'Otro' ✅ (agregado)

✅ APLICACIÓN DEBERÍA FUNCIONAR:
- Crear audiencias PA con plazo_evacuar = 'Otro' ✅
- Usar plazo_evacuar_otro para valores personalizados ✅
*/
