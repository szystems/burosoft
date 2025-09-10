# ARCHITECTURE - Arquitectura del Sistema
## BUROSOFT Sistema de Gestión Tributaria y Administrativa

**Versión**: 3.1 CORREGIDA  
**Fecha**: 9 de septiembre de 2025  
**Autor**: Equipo SZSystems  
**Estado**: **SISTEMA EN PRODUCCIÓN - AUDIENCIAS VA/PA CORREGIDAS**

---

## 1. Resumen Arquitectónico

BUROSOFT está construido como una aplicación web monolítica multi-tenant **completamente operativa** utilizando Laravel 8, con arquitectura MVC robusta, base de datos sincronizada entre desarrollo y producción, y sistema de modales JavaScript sin conflictos. **ACTUALIZACIÓN CRÍTICA**: Error 1265 audiencias resuelto, tablas PA completadas.

### 1.1 Principios Arquitectónicos Implementados ✅

- ✅ **Separación de Responsabilidades**: Cada capa con responsabilidad específica
- ✅ **Multi-tenancy**: Aislamiento completo de datos entre empresas
- ✅ **Modularidad**: Organización por módulos VA/PA/PAT completamente funcionales
- ✅ **Reutilización**: Traits, Services y Helpers implementados
- ✅ **Seguridad**: Middleware y validación en cada capa operativa
- ✅ **Escalabilidad**: Sistema preparado para crecimiento en iPage hosting
- ✅ **Integridad de Datos**: Campos ENUM corregidos y validados

### 1.2 Estado de Despliegue Actual

| Entorno | Estado | Base de Datos | Funcionalidad | Última Actualización |
|---------|--------|---------------|---------------|-------------------|
| **Desarrollo Local** | ✅ Operativo | 30 migraciones consolidadas | 100% funcional | 9 Sep 2025 |
| **Producción iPage** | ✅ Desplegado | Sincronizada | 100% funcional | 9 Sep 2025 |
| **Sistema VA** | ✅ Completo | Audiencias corregidas | Sin problemas | 9 Sep 2025 |
| **Sistema PA** | ✅ Completo | Tablas dpmrs_pa/aceptacions_pa | Sin problemas | 9 Sep 2025 |
| **JavaScript/Modales** | ✅ Sin conflictos | - | Naming único | 9 Sep 2025 |

---

## 2. Arquitectura de Alto Nivel

```
┌─────────────────────────────────────────────────────────────┐
│                    NAVEGADOR WEB                            │
│                 (Chrome, Firefox, Edge)                     │
└─────────────────────┬───────────────────────────────────────┘
                     │ HTTPS (Producción iPage)
┌─────────────────────▼───────────────────────────────────────┐
│                 SERVIDOR WEB                                │
│              (iPage Apache + PHP 7.4+)                     │
└─────────────────────┬───────────────────────────────────────┘
                     │
┌─────────────────────▼───────────────────────────────────────┐
│                 LARAVEL 8 APPLICATION                       │
│  ┌─────────────────────────────────────────────────────┐   │
│  │            FRONTEND LAYER ✅ OPERATIVO              │   │
│  │        (Blade Templates + Bootstrap 5 + JS)        │   │
│  │        Modal System sin conflictos naming          │   │
│  └─────────────────────┬───────────────────────────────┘   │
│  ┌─────────────────────▼───────────────────────────────┐   │
│  │             ROUTING LAYER ✅ COMPLETO               │   │
│  │        (web.php con rutas VA/PA/PAT)                │   │
│  └─────────────────────┬───────────────────────────────┘   │
│  ┌─────────────────────▼───────────────────────────────┐   │
│  │           MIDDLEWARE LAYER ✅ SEGURO                │   │
│  │          (Auth, CSRF, Validation, etc.)             │   │
│  └─────────────────────┬───────────────────────────────┘   │
│  ┌─────────────────────▼───────────────────────────────┐   │
│  │             CONTROLLER LAYER                        │   │
│  │       (Admin, Empresa, Frontend Controllers)        │   │
│  └─────────────────────┬───────────────────────────────┘   │
│  ┌─────────────────────▼───────────────────────────────┐   │
│  │              BUSINESS LOGIC                         │   │
│  │          (Services, Traits, Helpers)                │   │
│  └─────────────────────┬───────────────────────────────┘   │
│  ┌─────────────────────▼───────────────────────────────┐   │
│  │               MODEL LAYER                           │   │
│  │             (Eloquent Models)                       │   │
│  └─────────────────────┬───────────────────────────────┘   │
└──────────────────────┬─┴───────────────────────────────────┘
                     │
┌─────────────────────▼───────────────────────────────────────┐
│                    DATABASE                                 │
│                   (MySQL 8.0)                               │
└─────────────────────────────────────────────────────────────┘
```

---

## 3. Arquitectura de Datos

### 3.1 Modelo de Base de Datos

#### **Núcleo del Sistema**
```sql
-- Configuración global
configs
currencies
payment_platforms
plans
subscriptions

-- Gestión de usuarios y empresas  
users
empresas
bitacoras (audit log)
```

#### **Sistema Contable**
```sql
-- Estructura contable
cuentas
rubros
movimientos
movimiento_documentos
movimiento_pagos
```

#### **Sistema PAT (Proceso Administrativo Tributario)**
```sql
-- Flujo PAT
pats
pat_nombramientos
pat_notificacions
pat_requerimientos
pat_atencion_requerimientos
pat_providencias
pat_rafs
pat_acta_administrativas
pat_expedientes
pat_nulidads
```

#### **Sistema VA (Violaciones Administrativas)** *(Actualizado)*
```sql
-- Flujo VA completo con mejoras agosto 2025
audiencias → evs* → pps* → dpmrs → adpmrs* → resolucions → 
rrs → ntrrs → ocursos → ros → mpmrs → ampmrs → 
rtributas → nulidades → ecs

-- * Incluyen campo oficina_presentacion (nullable)
```

#### **Sistema PA (Procesos Administrativos)** *(Actualizado)*
```sql
-- Duplicación del flujo VA con sufijo _pa + campo oficina_presentacion
audiencias_pa → evs_pa* → pps_pa* → dpmrs_pa → adpmrs_pa* → 
resolucions_pa → rsat_pa → rrs_pa → ntrrs_pa → ocursos_pa → 
ros_pa → mpmrs_pa → ampmrs_pa → rtributas_pa → 
nulidades_pa → ecs_pa

-- * Incluyen campo oficina_presentacion (nullable)
```

### 3.2 Relaciones Clave

```php
// Multi-tenancy por empresa
user -> belongsTo(empresa)
movimiento -> belongsTo(empresa)
pat -> belongsTo(empresa)

// Flujo secuencial VA/PA
audiencia -> hasMany(ev)
ev -> hasOne(pp)
pp -> hasOne(dpmr)
dpmr -> hasMany(adpmr)
// ... continúa el flujo

// Trazabilidad
bitacora -> belongsTo(user)
bitacora -> morphTo(auditable) // Polimórfica
```

---

## 4. Patrones de Diseño Implementados

### 4.1 **MVC (Model-View-Controller)**
```php
// Separación clara de responsabilidades
app/Http/Controllers/     # Controladores
app/Models/               # Modelos Eloquent
resources/views/          # Vistas Blade
```

### 4.2 **Repository Pattern (Implícito)**
```php
// Eloquent actúa como repositorio
$movimientos = Movimiento::where('empresa_id', $empresaId)->get();
```

### 4.3 **Service Layer Pattern**
```php
// Lógica de negocio en servicios
app/Services/
├── MovimientoService.php
├── PatService.php
└── AuditService.php
```

### 4.4 **Trait Pattern** 
```php
// Funcionalidad reutilizable
app/Traits/
├── AuditableTrait.php
├── EmpresaTrait.php
└── ExportableTrait.php
```

### 4.5 **Factory Pattern**
```php
// Creación de objetos para testing
database/factories/
├── MovimientoFactory.php
├── PatFactory.php
└── UserFactory.php
```

---

## 5. ADRs (Architecture Decision Records)

### 5.1 ADR-001: Selección de Framework
**Fecha**: 2023-11-01  
**Estado**: Aceptado  

**Contexto**: Necesidad de framework PHP robusto para aplicación multi-tenant.

**Decisión**: Laravel 8.x como framework principal.

**Razones**:
- Ecosistema maduro y documentación extensa
- ORM Eloquent para manejo eficiente de base de datos
- Sistema de middleware robusto
- Blade template engine intuitivo
- Comunidad activa y paquetes disponibles

**Consecuencias**:
- ✅ Desarrollo rápido y mantenible
- ✅ Seguridad incorporada (CSRF, validación)
- ✅ Testing integrado
- ❌ Curva de aprendizaje para desarrolladores nuevos en Laravel

### 5.2 ADR-002: Arquitectura Multi-Tenant
**Fecha**: 2024-03-01  
**Estado**: Aceptado  

**Contexto**: Necesidad de aislar datos entre múltiples empresas cliente.

**Decisión**: Multi-tenancy por empresa_id con aislamiento a nivel de aplicación.

**Razones**:
- Simplicidad de implementación
- Una sola base de datos facilita mantenimiento
- Escalabilidad horizontal cuando sea necesario
- Middleware para filtrado automático por empresa

**Consecuencias**:
- ✅ Desarrollo más rápido
- ✅ Backups y mantenimiento simplificados
- ✅ Consultas eficientes con índices apropiados
- ❌ Riesgo de filtrado incorrecto (mitigado con middleware)

### 5.3 ADR-003: Duplicación VA/PA
**Fecha**: 2025-07-01  
**Estado**: Aceptado  

**Contexto**: Necesidad de manejar Violaciones Administrativas y Procesos Administrativos por separado.

**Decisión**: Duplicar completamente las tablas VA con sufijo _pa.

**Razones**:
- Separación clara de flujos legales diferentes
- Flexibilidad para modificaciones específicas
- Performance mejorada (no hay JOINs complejos)
- Cumplimiento de requerimientos legales específicos

**Consecuencias**:
- ✅ Flexibilidad total por tipo de proceso
- ✅ Performance óptima
- ✅ Mantenimiento específico por flujo
- ❌ Duplicación de código (mitigado con traits)
- ✅ **RESUELTO (29 ago 2025)**: Migraciones consolidadas de 92+ a 28 archivos

### 5.4 ADR-004: Sistema de Auditoría
**Fecha**: 2024-05-01  
**Estado**: Aceptado  

**Contexto**: Necesidad de trazabilidad completa de acciones del usuario.

**Decisión**: Tabla bitacoras con relación polimórfica.

**Razones**:
- Auditoría completa de cambios
- Flexibilidad para auditar cualquier modelo
- Cumplimiento de requisitos legales
- Debugging y soporte facilitados

**Consecuencias**:
- ✅ Trazabilidad completa
- ✅ Debugging eficiente
- ✅ Cumplimiento regulatorio
- ❌ Ligero overhead en performance

---

## 6. Convenciones y Estándares

### 6.1 Nomenclatura de Base de Datos
```sql
-- Tablas en plural, snake_case
movimientos, pat_nombramientos, audiencias_pa

-- Campos en snake_case
created_at, empresa_id, numero_documento

-- Claves foráneas terminan en _id
empresa_id, user_id, movimiento_id

-- Campos booleanos empiezan con is_ o has_
is_active, has_documents
```

### 6.2 Nomenclatura de Código PHP
```php
// Modelos en PascalCase singular
Movimiento, PatNombramiento, AudienciaPa

// Controladores terminan en Controller
MovimientoController, PatController

// Métodos en camelCase
public function createMovimiento()
public function showAudiencia()

// Variables en camelCase
$movimientoId, $empresaActual
```

### 6.3 Estructura de Rutas
```php
// Prefijos por módulo
Route::prefix('admin')->group(...);
Route::prefix('empresa')->group(...);

// Middleware aplicado por grupo
Route::middleware(['auth', 'empresa'])->group(...);

// Nombres de rutas descriptivos  
Route::name('empresa.movimientos.index');
Route::name('admin.empresas.show');
```

### 6.4 Organización de Vistas
```
resources/views/
├── admin/           # Vistas de administración
├── empresa/         # Vistas de empresa  
├── frontend/        # Vistas públicas
├── auth/           # Vistas de autenticación
├── components/     # Componentes reutilizables
├── layouts/        # Layouts principales
└── mails/          # Templates de email
```

---

## 7. Seguridad

### 7.1 Autenticación y Autorización
```php
// Middleware de autenticación
Route::middleware(['auth'])->group(...);

// Middleware de empresa (multi-tenancy)
Route::middleware(['auth', 'empresa'])->group(...);

// Validación en controladores
$this->authorize('view', $movimiento);
```

### 7.2 Validación de Datos
```php
// Form Requests para validación
MovimientoRequest extends FormRequest
PatRequest extends FormRequest

// Validación a nivel de base de datos
Schema::table('movimientos', function (Blueprint $table) {
    $table->decimal('monto', 15, 2);
    $table->enum('tipo', ['ingreso', 'egreso']);
});
```

### 7.3 Protección CSRF
```php
// Token CSRF en todos los formularios
@csrf

// Verificación automática por middleware
'middleware' => ['web'] // Incluye VerifyCsrfToken
```

---

## 8. Performance y Escalabilidad

### 8.1 Optimización de Base de Datos
```sql
-- Índices en campos frecuentemente consultados
CREATE INDEX idx_movimientos_empresa_fecha ON movimientos(empresa_id, fecha);
CREATE INDEX idx_pats_empresa_estado ON pats(empresa_id, estado);

-- Relaciones optimizadas con eager loading
Movimiento::with(['cuenta', 'rubro', 'documentos'])->get();
```

### 8.2 Caché
```php
// Caché de configuraciones
Cache::remember('config.empresa.' . $empresaId, 3600, function() {
    return Config::where('empresa_id', $empresaId)->get();
});
```

### 8.3 Paginación
```php
// Paginación en listados largos
$movimientos = Movimiento::paginate(25);
$pats = Pat::simplePaginate(15);
```

---

## 9. Testing

### 9.1 Estrategia de Testing
```php
// Unit Tests para lógica de negocio
tests/Unit/Services/MovimientoServiceTest.php

// Feature Tests para flujos completos  
tests/Feature/Empresa/MovimientoTest.php
tests/Feature/Admin/DashboardTest.php
```

### 9.2 Testing de Base de Datos
```php
// Factories para datos de prueba
MovimientoFactory::class
PatFactory::class
EmpresaFactory::class

// Database Seeders para datos iniciales
DatabaseSeeder::run()
```

---

## 10. Monitoreo y Mantenimiento

### 10.1 Logs
```php
// Logs estructurados por canal
'channels' => [
    'stack' => ['single', 'slack'],
    'database' => ['daily'],
    'security' => ['daily', 'slack']
]
```

### 10.2 Health Checks
```php
// Artisan commands para verificación
php artisan app:health-check
php artisan queue:work --health-check
```

### 10.3 Backups
```bash
# Scripts automatizados de backup
scripts/backup_database.sh
scripts/backup_files.sh
```

---

## 11. Deployment

### 11.1 Estructura de Deploy
```bash
# Producción
/var/www/burosoft/
├── current/          # Versión actual
├── releases/         # Versiones históricas
├── shared/           # Archivos compartidos
│   ├── .env
│   ├── storage/
│   └── public/uploads/
└── scripts/          # Scripts de deploy
```

### 11.2 Pipeline CI/CD
```yaml
# .github/workflows/deploy.yml
stages:
  - test
  - build  
  - deploy
```

---

## 12. Architecture Decision Records (ADRs)

### ADR-001: Campo oficina_presentacion en módulos EA/PP/ADPMR
**Fecha**: 22 de agosto de 2025  
**Estado**: Aceptado  

**Contexto**: Los módulos EA (Evacuación de Audiencia), PP (Período de Prueba) y ADPMR (Atención de Diligencias Para Mejor Resolver) necesitan registrar la oficina o agencia donde fueron presentados los documentos.

**Decisión**: Agregar campo `oficina_presentacion` (varchar(255), nullable) a las tablas:
- evs, evs_pa
- pps, pps_pa  
- adpmrs, adpmrs_pa

**Consecuencias**:
- ✅ Permite trazabilidad completa de documentos
- ✅ Consistencia entre sistemas VA y PA
- ✅ Campo opcional para retrocompatibilidad
- ✅ Formularios y vistas actualizadas automáticamente
- ✅ **COMPLETADO (29 ago 2025)**: Campo incluido en consolidación de migraciones

**Implementación COMPLETADA**: 
- ✅ Consolidación: Campos incluidos en 28 migraciones consolidadas
- ✅ Validación: nullable|string|max:255 implementada
- ✅ UI: Campo en modales de agregar/editar funcionando
- ✅ Listados: Nueva columna "Oficina Presentación" operativa

---

**Documento técnico aprobado por**: Arquitecto de Software SZSystems  
**Última actualización**: 29 de agosto de 2025  
**Consolidación DB**: ✅ COMPLETADA - 28 migraciones optimizadas  
**Próxima revisión**: 29 de noviembre de 2025
