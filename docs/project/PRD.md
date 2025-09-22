# PRD - Product Requirements Document
## BUROSOFT Sistema de Gestión Tributaria y Administrativa

**Versión**: 3.3 - Módulo Resumen Expedientes  
**Fecha**: 22 de septiembre de 2025  
**Autor**: Equipo SZSystems  
**Estado**: **PA/VA/RESUMEN EXPEDIENTES COMPLETAMENTE OPERATIVOS**

---

## 1. Resumen Ejecutivo

BUROSOFT es una plataforma SaaS multi-tenant **completamente funcional** diseñada para profesionales del derecho tributario y administrativo. El sistema gestiona múltiples empresas cliente con módulos especializados en **Vía Administrativa (VA)** y **Procedimiento Ampliado (PA)**, ambos completamente implementados y operativos.

**ACTUALIZACIÓN CRÍTICA 9 SEP 2025**: Error 500 PA resuelto, tabla `resolucions_pa` sincronizada, vistas R-SAT mejoradas con fecha+hora, proyecto completamente funcional.

### 1.1 Objetivos del Producto ✅ COMPLETADOS

- ✅ Centralizar la gestión de múltiples empresas en una sola plataforma
- ✅ Automatizar procesos legales y administrativos (VA/PA)
- ✅ Proveer control de expedientes y casos con documentación completa
- ✅ Facilitar el seguimiento detallado de audiencias y procedimientos
- ✅ Generar reportes y documentación legal automatizada
- ✅ Sistema de gestión de archivos y documentos integrado
- ✅ **NUEVO**: Vistas R-SAT mejoradas con fecha de notificación CON HORA
- ✅ **NUEVO**: Nueva columna "Fecha de Resolución" en listados R-SAT

### 1.2 Estado Actual del Sistema

| Módulo | Estado | Funcionalidad | Issues Pendientes | Última Actualización |
|--------|--------|---------------|-------------------|-------------------|
| **PA (Procedimiento Ampliado)** | ✅ **COMPLETO** | 100% | **Ninguno** | **9 Sep 2025** |
| **PA R-SAT** | ✅ **CORREGIDO** | 100% | **Vistas mejoradas** | **9 Sep 2025** |
| **VA (Vía Administrativa)** | ✅ **COMPLETO** | 100% | **Ninguno** | **9 Sep 2025** |
| **VA R-SAT** | ✅ **MEJORADO** | 100% | **Vistas mejoradas** | **9 Sep 2025** |
| **VA (Vía Administrativa)** | ✅ Completo | 100% | Ninguno | **9 Sep 2025** |
| **PA (Procedimiento Administrativo)** | ✅ Completo | 100% | Ninguno | **9 Sep 2025** |
| **Audiencias VA/PA** | ✅ **CORREGIDO** | 100% | **Error 1265 RESUELTO** | **9 Sep 2025** |
| **PAT (Proc. Admin. Tributarios)** | ✅ Completo | 100% | Ninguno | Ago 2025 |
| **Base de Datos** | ✅ Consolidada | 100% | Ninguno | **9 Sep 2025** |
| **Migraciones** | ✅ Optimizadas | 30 archivos | Ninguno | **9 Sep 2025** |
| **JavaScript/Modales** | ✅ Sin conflictos | 100% | Ninguno | Ago 2025 |

---

## 2. Alcance y Límites del Sistema

### 2.1 Módulos Implementados y Operativos

#### ✅ **Módulo Resumen de Expedientes - NUEVO 22 SEP 2025**
- **Dashboard Principal**: Cards con estadísticas totales (activos, cerrados, archivo)
- **Filtros Avanzados**: Por estado, rango de fechas, cuenta y número de expediente
- **Búsqueda Inteligente**: Datalist nativo para filtro por cuenta empresarial
- **Vista de Estadísticas**: Gráficos Chart.js interactivos con distribución por estado
- **Exportación PDF**: Formato horizontal con logo empresarial integrado
- **Responsive Design**: Compatible con dispositivos móviles Bootstrap 5
- **Integración Completa**: Modelos Pat y Cuenta existentes reutilizados
- **Seguridad Multi-tenant**: Filtrado automático por empresa_id del usuario
- **Layout Actualizado**: @stack('scripts') agregado para soporte de librerías JS

#### ✅ **Módulo VA (Vía Administrativa) - COMPLETO**
- **Gestión de Audiencias**: Sistema completo de programación y seguimiento
- **Documentos EA (Escritos de Alegatos)**: Con campos especializados y validación
- **Documentos PP (Propuesta de Pruebas)**: Sistema de gestión documental
- **ADPMR (Alegatos de Descargo)**: Gestión completa de documentación
- **Resoluciones**: Sistema R-SAT con campo "otro" funcional
- **RR (Recursos de Revocatoria)**: Gestión de recursos administrativos
- **Ejecutoria**: Seguimiento de estados finales
- **Modales JavaScript**: Funciones únicas sin conflictos de naming

#### ✅ **Módulo PA (Procedimiento Administrativo) - COMPLETO**  
- **Sistema independiente de audiencias PA**: CRUD completo con campos ENUM corregidos
- **Tablas PA completadas**: dpmrs_pa y aceptacions_pa creadas y funcionales (9 Sep 2025)
- **Documentos EV (Escritos Varios)**: Con campo numero_documento especializado
- **PP PA (Propuesta de Pruebas)**: Sistema independiente del VA
- **ADPMR PA**: Gestión completa de documentación con archivos
- **EC PA (Económico Coactivo)**: Campo medidas_decretadas (JSON)
- **NTRRS PA**: Campos de fecha especializados para notificaciones
- **Nulidades PA**: Con fecha_hora_notificacion específica
- **R-SAT PA**: Modelo corregido, apunta a resolucions_pa correctamente
- **Funcionalidad "Otro"**: Implementada en todos los campos relevantes
- **Modales JavaScript**: Sistema único sin conflictos de naming
- **Audiencias PA**: Sistema independiente de gestión de audiencias
- **Documentos EV (Escritos Varios)**: Con numero_documento y gestión completa
- **Documentos PP PA**: Sistema específico para procedimientos administrativos
- **ADPMR PA**: Gestión independiente de alegatos
- **EC PA (Económico Coactivo)**: Sistema completo con medidas decretadas
- **NTRRS PA**: Notificación de resoluciones con fechas específicas  
- **Nulidades PA**: Sistema completo de gestión de nulidades
- **R-SAT PA**: Resoluciones administrativas con campo "otro" funcional
- **Sistema de archivos**: Gestión completa de documentos PDF/imágenes

#### ✅ **Módulo PAT (Procedimientos Administrativos Tributarios) - COMPLETO**
- **RCT (Resolución del Conflicto Tributario)**: Sistema completo de gestión
- **Notificaciones PAT**: Gestión de notificaciones con fechas y plazos
- **Nombramientos**: Sistema de gestión de nombramientos administrativos
- **Nulidades PAT**: Gestión especializada de nulidades tributarias
- **Sistema de archivos**: Upload y gestión de documentos especializados
#### ✅ **Frontend/Landing - OPERATIVO**
- Página de presentación del producto completamente funcional
- Sistema de registro y autenticación implementado
- Integración con sistema de suscripciones
- Gestión de planes y acceso por roles

#### ✅ **Panel de Administración - FUNCIONAL**
- Dashboard administrativo con métricas en tiempo real
- Gestión completa de usuarios del sistema
- Configuración global del sistema implementada
- Administración de empresas registradas operativa
- Control de suscripciones y estados de cuenta

#### ✅ **Módulo Empresa - COMPLETO**
- Dashboard personalizado por empresa cliente
- Sistema de usuarios y roles por empresa
- Configuración específica por empresa implementada
- Gestión independiente de datos por empresa

### 2.2 Integración de Base de Datos ✅ CONSOLIDADA Y OPTIMIZADA

| Aspecto | Estado | Detalles |
|---------|---------|----------|
| **Migraciones Originales** | ⭐ Optimizadas | 92+ archivos → 28 consolidadas |
| **Migraciones Actuales** | ✅ 28 consolidadas | Estructura limpia y mantenible |
| **Fresh Migration** | ✅ Exitosa | php artisan migrate:fresh --seed |
| **Producción iPage** | ✅ Sincronizada | Base sólida para deployment |
| **Scripts de Corrección** | ✅ Implementados | Sistema de corrección automática |
| **Campos Especializados** | ✅ Consolidados | Todos incluidos en migraciones finales |
| **Constraints y Validaciones** | ✅ Aplicados | Sistema de validación robusto |
| **Seeders** | ✅ Operativos | Datos base cargados correctamente |

### 2.3 Sistema de Modales JavaScript ✅ RESUELTO

| Problema Original | Solución Implementada | Estado |
|-------------------|----------------------|---------|
| Conflictos de naming VA/PA | Sistema de naming único | ✅ Resuelto |
| Campos "otro" no funcionando | Funciones específicas por modal | ✅ Funcional |
| Toggle de campos dinámicos | JavaScript modular | ✅ Implementado |

---

## 3. Requerimientos Funcionales Completados

### 3.1 Gestión de Audiencias (VA/PA) ✅

**RF-001: Creación y Gestión de Audiencias**
- ✅ CRUD completo de audiencias VA y PA
- ✅ Campos especializados: fecha, hora, estado, observaciones
- ✅ Relaciones con documentos y procedimientos
- ✅ Sistema de filtros y búsqueda implementado

**RF-002: Asociación de Documentos a Audiencias**
- ✅ Documentos EA, PP, ADPMR asociados a audiencias VA
- ✅ Documentos EV, PP-PA, ADPMR-PA asociados a audiencias PA
- ✅ Sistema de upload de archivos PDF/imágenes
- ✅ Validación de tipos de archivo y tamaños

### 3.2 Sistema de Documentos ✅

**RF-003: Gestión de Escritos de Alegatos (EA)**
- ✅ CRUD completo con campos especializados
- ✅ Campo `numero_documento` implementado
- ✅ Sistema de archivos adjuntos operativo
- ✅ Validaciones de formulario implementadas

**RF-004: Gestión de Escritos Varios (EV)**  
- ✅ Sistema independiente para módulo PA
- ✅ Campo `numero_documento` con validación única
- ✅ Gestión completa de archivos adjuntos
- ✅ Modales JavaScript sin conflictos de naming
- Gestión independiente pero con misma funcionalidad

### 2.2 Límites del Sistema

#### ❌ **No Incluye**
- Sistema de nómina completo
- Facturación electrónica directa
- Integración con SAT/SUNAT
- Sistema de inventarios
- CRM avanzado
- Sistema de citas/calendario
- Chat en tiempo real
- Aplicación móvil nativa

---

## 3. Requerimientos Funcionales

### 3.1 RF001 - Autenticación y Autorización
- **Descripción**: Sistema multi-nivel de autenticación
- **Criterios de Aceptación**:
  - Login seguro con validación de credenciales
  - Roles diferenciados: Admin, Empresa, Usuario Empresa
  - Middleware de protección por rutas
  - Sistema de permisos granular
- **Prioridad**: Alta
- **Estado**: ✅ Implementado

### 3.2 RF002 - Gestión Multi-Empresa
- **Descripción**: Capacidad de manejar múltiples empresas independientes
- **Criterios de Aceptación**:
  - Aislamiento completo de datos entre empresas
  - Dashboard personalizado por empresa
  - Configuración independiente por empresa
  - Usuarios específicos por empresa
- **Prioridad**: Alta
- **Estado**: ✅ Implementado

### 3.3 RF003 - Sistema de Suscripciones
- **Descripción**: Gestión completa de planes y suscripciones
- **Criterios de Aceptación**:
  - Múltiples planes disponibles
  - Integración con pasarelas de pago
  - Control de estados de suscripción
  - Renovación automática
- **Prioridad**: Alta
- **Estado**: ✅ Implementado

### 3.4 RF004 - Gestión Contable
- **Descripción**: Sistema completo de contabilidad básica
- **Criterios de Aceptación**:
  - CRUD completo de cuentas contables
  - Gestión de rubros con jerarquía
  - Registro de movimientos con validación de balance
  - Adjuntos de documentos soporte
  - Reportes de movimientos por período
- **Prioridad**: Alta
- **Estado**: ✅ Implementado

### 3.5 RF005 - Gestión de Procesos PAT
- **Descripción**: Control completo del flujo PAT
- **Criterios de Aceptación**:
  - Registro de PAT con datos completos
  - Flujo secuencial de estados
  - Gestión de documentos por etapa
  - Reportes de seguimiento
  - Alertas de vencimientos
- **Prioridad**: Alta
- **Estado**: ✅ Implementado

### 3.6 RF006 - Sistema VA/PA *(Actualizado v2.1)*
- **Descripción**: Gestión completa de violaciones y procesos administrativos
- **Criterios de Aceptación**:
  - Flujo completo desde audiencia hasta ejecutoria
  - Gestión de documentos en cada etapa
  - Control de términos y vencimientos
  - Reportes de estado por proceso
  - Duplicación funcional entre VA y PA
  - **NUEVO**: Registro de oficina de presentación en EA/PP/ADPMR
- **Prioridad**: Alta
- **Estado**: ✅ Implementado

### 3.6.1 RF006.1 - Trazabilidad de Oficinas de Presentación *(Nuevo)*
- **Descripción**: Capacidad de registrar dónde fueron presentados documentos
- **Criterios de Aceptación**:
  - Campo opcional "oficina_presentacion" en módulos EA, PP y ADPMR
  - Máximo 255 caracteres, formato texto libre
  - Visible en formularios de creación y edición
  - Incluido en listados y reportes
  - Aplicable tanto en sistema VA como PA
- **Prioridad**: Media
- **Estado**: ✅ Implementado (agosto 2025)

### 3.7 RF007 - Generación de Reportes
- **Descripción**: Sistema de reportes y exportación
- **Criterios de Aceptación**:
  - Exportación a PDF y Excel
  - Reportes financieros por período
  - Reportes de casos por estado
  - Dashboard con métricas en tiempo real
- **Prioridad**: Media
- **Estado**: ✅ Implementado

### 3.8 RF008 - Sistema de Bitácoras
- **Descripción**: Auditoría completa de actividades
- **Criterios de Aceptación**:
  - Registro de todas las acciones del usuario
  - Timestamps precisos
  - Identificación de usuario que realiza la acción
  - Datos antes y después del cambio
- **Prioridad**: Media
- **Estado**: ✅ Implementado

---

## 4. Requerimientos No Funcionales

### 4.1 RNF001 - Performance
- **Tiempo de respuesta**: < 2 segundos para operaciones estándar
- **Carga concurrente**: Soporte para 100+ usuarios simultáneos
- **Optimización de consultas**: Uso de índices y eager loading
- **Estado**: ✅ Implementado

### 4.2 RNF002 - Seguridad
- **Autenticación**: Sistema robusto con hash de contraseñas
- **Autorización**: Middleware de protección en todas las rutas
- **Validación**: Sanitización de inputs en formularios
- **CSRF Protection**: Tokens CSRF en todos los formularios
- **Estado**: ✅ Implementado

### 4.3 RNF003 - Usabilidad
- **Interfaz intuitiva**: Bootstrap 4/5 con diseño responsive
- **Navegación clara**: Menús organizados por módulo
- **Feedback visual**: Mensajes de éxito/error claros
- **Estado**: ✅ Implementado

### 4.4 RNF004 - Mantenibilidad
- **Arquitectura MVC**: Separación clara de responsabilidades
- **Código documentado**: Comentarios en funciones complejas
- **Convenciones Laravel**: Seguimiento de estándares Laravel
- **Estado**: ✅ Implementado

### 4.5 RNF005 - Escalabilidad
- **Base de datos optimizada**: Relaciones e índices apropiados
- **Caché**: Implementación de caché para consultas frecuentes
- **Estructura modular**: Fácil adición de nuevos módulos
- **Estado**: ✅ Implementado

---

## 5. Casos de Uso Principales

### 5.1 CU001 - Gestión de Empresa Cliente
**Actor**: Usuario Empresa  
**Flujo Principal**:
1. Usuario se autentica en el sistema
2. Accede al dashboard de empresa
3. Gestiona información de la empresa
4. Configura usuarios de la empresa
5. Revisa métricas y reportes

### 5.2 CU002 - Proceso Contable Completo
**Actor**: Usuario Empresa  
**Flujo Principal**:
1. Configura cuentas contables
2. Define rubros de ingreso/egreso
3. Registra movimientos diarios
4. Adjunta documentos soporte
5. Genera reportes periódicos

### 5.3 CU003 - Seguimiento de PAT
**Actor**: Usuario Empresa  
**Flujo Principal**:
1. Registra nuevo PAT
2. Gestiona nombramientos
3. Controla notificaciones
4. Maneja requerimientos
5. Genera documentos de seguimiento

### 5.4 CU004 - Flujo VA Completo
**Actor**: Usuario Empresa  
**Flujo Principal**:
1. Registra audiencia inicial
2. Maneja evaluación y proposición
3. Gestiona DPMR y alegatos
4. Emite resolución
5. Controla recursos y ejecutorias

---

## 6. Criterios de Éxito

### 6.1 Métricas de Adopción
- **Empresas registradas**: > 50 empresas en primer año
- **Usuarios activos mensuales**: > 200 usuarios
- **Retención de usuarios**: > 80% después de 3 meses

### 6.2 Métricas de Performance  
- **Tiempo de carga**: < 2 segundos promedio
- **Uptime**: > 99.5% mensual
- **Bugs críticos**: < 1 por mes

### 6.3 Métricas de Satisfacción
- **Rating de usuario**: > 4.0/5.0
- **Tiempo de soporte**: < 24 horas respuesta
- **Documentación**: 100% de funcionalidades documentadas

---

## 7. Riesgos y Mitigaciones

### 7.1 Riesgos Técnicos
- **Escalabilidad de BD**: Migración a clusters si es necesario
- **Performance con crecimiento**: Implementar caché y CDN
- **Seguridad de datos**: Auditorías regulares y backups

### 7.2 Riesgos de Negocio
- **Competencia**: Diferenciación por especialización legal
- **Regulaciones**: Cumplimiento de normativas de protección de datos
- **Adopción**: Capacitación y soporte constante a usuarios

---

## 8. Roadmap y Fases

### ✅ **Fase 1 - MVP (Completada)**
- Sistema básico multi-empresa
- Gestión contable fundamental
- Procesos PAT básicos

### ✅ **Fase 2 - VA/PA (Completada)** 
- Sistema completo de violaciones administrativas
- Duplicación para procesos administrativos
- Reportes avanzados

### 🔄 **Fase 3 - Mejoras (En progreso)**
- Optimización de performance
- Corrección de bugs reportados
- Mejoras de UX/UI

### 📋 **Fase 4 - Futuras (Planificada)**
- API REST completa
- Integración con sistemas externos
- Aplicación móvil
- IA para automatización de procesos

---

## 10. Historial de Cambios *(Nuevo)*

### v3.0 - 29 de agosto de 2025 ⭐ **CONSOLIDACIÓN HISTÓRICA**
**Feature: Optimización Masiva de Base de Datos**
- ✅ **Consolidación de migraciones**: 92+ archivos → 28 migraciones optimizadas
- ✅ **Fresh migration exitosa**: php artisan migrate:fresh --seed completo
- ✅ **Optimización**: 49% reducción en archivos de migración
- ✅ **Estructura limpia**: Base de datos completamente reorganizada
- ✅ **Seeders operativos**: Datos base cargados correctamente
- ✅ **Foreign keys verificadas**: Todas las relaciones funcionando
- ✅ **Documentación actualizada**: Toda la documentación técnica sincronizada

**Impacto del cambio:**
- **Desarrollo**: Base de datos más mantenible y comprensible
- **Performance**: Migraciones más rápidas y eficientes
- **Mantenimiento**: Estructura consolidada facilita debugging
- **Onboarding**: Nuevos desarrolladores pueden entender la BD fácilmente

### v2.1 - 22 de agosto de 2025
**Feature: Trazabilidad de Oficinas de Presentación**
- ✅ **RF006.1** Nuevo requerimiento funcional agregado
- ✅ Campo "oficina_presentacion" incluido en consolidación final
- ✅ Validación nullable|string|max:255 aplicada
- ✅ Formularios y vistas actualizadas para VA y PA
- ✅ Migraciones consolidadas en estructura final
- ✅ Documentación técnica actualizada

**Impacto del cambio:**
- **Usuarios**: Nueva funcionalidad opcional sin afectar flujos existentes
- **Datos**: Retrocompatible, campo nullable para registros existentes  
- **UI**: Nuevos campos en formularios, nueva columna en listados
- **Base de Datos**: 6 nuevas columnas agregadas (evs, evs_pa, pps, pps_pa, adpmrs, adpmrs_pa)

### v2.0 - 21 de agosto de 2025
- Documentación técnica inicial completa
- Sistema base implementado y funcional

---

**Documento aprobado por**: Equipo de Desarrollo SZSystems  
**Última actualización**: 22 de agosto de 2025
