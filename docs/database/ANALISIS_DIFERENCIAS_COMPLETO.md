# ANÁLISIS COMPLETO: DIFERENCIAS ENTRE LOCAL E IPAGE
**Fecha:** 28 de agosto de 2025  
**Estado iPage:** dbburo (6).sql - Estructura parcialmente migrada  
**Estado Local:** Todas las migraciones aplicadas (batch 1-29)  

## 🔍 **TABLAS NUEVAS CREADAS CORRECTAMENTE EN IPAGE**
✅ `aceptacions` - Existe con correcciones aplicadas  
✅ `aceptacions_pa` - Existe con correcciones aplicadas  
✅ `pat_rcts` - Existe correctamente  
✅ `constancia_pagos` - Existe correctamente  

## ❌ **PROBLEMAS IDENTIFICADOS EN IPAGE**

### **1. ENUM plazo_evacuar INCOMPLETO**
**ESTADO ACTUAL iPage:**
```sql
`plazo_evacuar` enum('30 D.H.','3 Meses') -- FALTA 'Otro'
```

**ESTADO CORRECTO (Local):**
```sql
`plazo_evacuar` enum('30 D.H.','3 Meses','Otro') -- Incluye 'Otro'
```

**IMPACTO:** Error al crear audiencias PA con plazo_evacuar = 'Otro'

### **2. CAMPOS FALTANTES EN MÚLTIPLES TABLAS**
Basado en las migraciones locales (batch 2-29), faltan estos campos en iPage:

#### **AMPMRS/AMPMRS_PA**
- ❌ `oficina_ea` VARCHAR(191) NULL

#### **MPMRS/MPMRS_PA** 
- ❌ `fecha_resolucion` DATE NULL

#### **EVS/EVS_PA/PPS/PPS_PA/ADPMRS/ADPMRS_PA**
- ❌ `oficina_presentacion` VARCHAR(191) NULL

#### **RESOLUCIONS**
- ❌ `fecha_notificacion` DATETIME NULL
- ❌ `fecha_resolucion` DATE NULL

#### **RSAT_PA**
- ❌ `fecha_notificacion` DATETIME NULL
- ❌ `fecha_resolucion` DATE NULL
- ❌ ENUM `tipo_resolucion` actualizado

#### **RTRIBUTAS/RTRIBUTAS_PA**
- ❌ `fecha_hora_notificacion` DATETIME NULL
- ❌ `fecha_resolucion` DATE NULL
- ❌ `tipo_resolucion_otro` VARCHAR(191) NULL
- ❌ `plazo_cat` ENUM('30 D.H.', '3 Meses', 'otro') NULL
- ❌ `plazo_cat_otro` VARCHAR(191) NULL
- ❌ ENUM `tipo_resolucion` actualizado

#### **RRS/RRS_PA**
- ❌ `oficina_agencia_ea` VARCHAR(191) NULL

#### **OCURSOS/OCURSOS_PA**
- ❌ `oficina_agencia_ea` VARCHAR(191) NULL

#### **ROS/ROS_PA**
- ❌ `fecha_notificacion` DATETIME NULL
- ❌ `fecha_resolucion` DATE NULL

#### **NULIDADES/NULIDADES_PA**
- ❌ `fecha` DATE → DATETIME (modificación de tipo)
- ❌ `fecha_resolucion` DATE NULL

#### **ECS/ECS_PA**
- ❌ `fecha` DATE → DATETIME (modificación de tipo)
- ❌ `fecha_resolucion` DATE NULL
- ❌ `juzgado_que_conoce` VARCHAR(500) NULL
- ❌ `medidas_decretadas` JSON NULL

#### **NTRRS/NTRRS_PA**
- ❌ `fecha` DATE → DATETIME (modificación de tipo)
- ❌ `fecha_resolucion` DATE NULL

## 📊 **RESUMEN DE MIGRACIONES FALTANTES EN IPAGE**
- **Total migraciones locales:** 85 migraciones
- **Migraciones aplicadas iPage:** ~23 migraciones básicas
- **Migraciones faltantes:** ~62 migraciones (batch 2-29)

## 🎯 **RECOMENDACIÓN**
Crear un **SCRIPT DE SINCRONIZACIÓN COMPLETO** que:
1. ✅ Aplique TODAS las modificaciones faltantes
2. ✅ Corrija el ENUM de plazo_evacuar
3. ✅ Agregue todos los campos faltantes
4. ✅ Modifique tipos de datos (DATE → DATETIME)
5. ✅ Actualice todos los ENUMs
6. ✅ Registre todas las migraciones en la tabla migrations

**RESULTADO:** Base de datos iPage 100% sincronizada con local
