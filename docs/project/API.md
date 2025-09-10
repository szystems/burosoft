# API - Documentación de Endpoints
## BUROSOFT Sistema de Gestión Tributaria y Administrativa

**Versión**: 3.1 CORREGIDA  
**Fecha**: 9 de septiembre de 2025  
**Autor**: Equipo SZSystems  
**Estado**: **ENDPOINTS COMPLETAMENTE FUNCIONALES - AUDIENCIAS VA/PA CORREGIDAS**

---

## 1. Información General

### 1.1 Base URL
```
Desarrollo: http://localhost:8000  
Producción: https://software.burotributario.com (✅ OPERATIVO)
```

### 1.2 Autenticación ✅ IMPLEMENTADA
- **Sistema**: Laravel Auth con sesiones
- **Middleware**: `auth` aplicado a todas las rutas protegidas
- **Protección**: CSRF tokens en todos los formularios
- **Estado**: Completamente funcional y seguro

### 1.3 Middleware Aplicado ✅

| Middleware | Propósito | Estado |
|------------|-----------|---------|
| **auth** | Autenticación requerida | ✅ Operativo |
| **empresa** | Filtrado por empresa del usuario | ✅ Funcional |
| **csrf** | Protección CSRF en formularios | ✅ Implementado |
| **validated** | Validación de formularios | ✅ Activo |

### 1.4 Formatos de Respuesta ✅ DISPONIBLES
- **HTML**: Vistas Blade (principal) - ✅ Funcional
- **PDF**: Reportes y documentos - ✅ Generación activa  
- **Excel**: Exportaciones de datos - ✅ Disponible
- **JSON**: Respuestas AJAX - ✅ Implementado
- **File Downloads**: Archivos PDF/imágenes - ✅ Sistema completo

---

## 2. Módulo VA (Vía Administrativa) ✅ COMPLETO CON CORRECCIONES

### 2.1 Gestión de Audiencias VA - **CORREGIDAS 9 SEP 2025**

| Método | Endpoint | Descripción | Estado | Correcciones |
|--------|----------|-------------|---------|------------|
| GET | `/audiencia-va/{id}` | Mostrar audiencia VA | ✅ Funcional | Campos ENUM corregidos |
| POST | `/insert-audiencia-va` | Crear nueva audiencia VA | ✅ Funcional | Error 1265 resuelto |
| PUT | `/update-audiencia-va/{id}` | Actualizar audiencia VA | ✅ Funcional | Validación "Otro" |
| DELETE | `/delete-audiencia-va/{id}` | Eliminar audiencia VA | ✅ Funcional | Sin cambios |

**Campos ENUM Corregidos**:
- `plazo_evacuar`: '5 Dias', '10 Dias', '30 Dias', 'Otro'
- `tipo_audiencia`: 'AEC', 'AIR', 'AS', 'AA', 'Otro' + campo `tipo_audiencia_otro`
| PUT | `/update-audiencia-va/{id}` | Actualizar audiencia VA | ✅ Funcional |
| DELETE | `/delete-audiencia-va/{id}` | Eliminar audiencia VA | ✅ Funcional |

### 2.2 Documentos EA (Escritos de Alegatos) ✅

| Método | Endpoint | Descripción | Estado |
|--------|----------|-------------|---------|
| POST | `/insert-ea` | Crear nuevo EA | ✅ Funcional |
| PUT | `/update-ea/{id}` | Actualizar EA | ✅ Funcional |
| DELETE | `/delete-ea/{id}` | Eliminar EA | ✅ Funcional |
| GET | `/download-ea/{filename}` | Descargar archivo EA | ✅ Funcional |

### 2.3 Resoluciones R-SAT VA ✅

| Método | Endpoint | Descripción | Estado |
|--------|----------|-------------|---------|
| POST | `/insert-resolucion` | Crear resolución | ✅ Con campo "otro" |
| PUT | `/update-resolucion/{id}` | Actualizar resolución | ✅ Funcional |
| DELETE | `/delete-resolucion/{id}` | Eliminar resolución | ✅ Funcional |

---

## 3. Módulo PA (Procedimiento Administrativo) ✅ COMPLETO CON CORRECCIONES

### 3.1 Gestión de Audiencias PA - **CORREGIDAS 9 SEP 2025**

| Método | Endpoint | Descripción | Estado | Correcciones |
|--------|----------|-------------|---------|------------|
| GET | `/audiencia-pa/{id}` | Mostrar audiencia PA | ✅ Funcional | Campos ENUM corregidos |
| POST | `/insert-audiencia-pa` | Crear nueva audiencia PA | ✅ Funcional | Error 1265 resuelto |
| PUT | `/update-audiencia-pa/{id}` | Actualizar audiencia PA | ✅ Funcional | Validación "Otro" |
| DELETE | `/delete-audiencia-pa/{id}` | Eliminar audiencia PA | ✅ Funcional | Sin cambios |

**Tablas PA Completadas 9 SEP 2025**:
- ✅ `dpmrs_pa` - Nueva tabla creada y funcional
- ✅ `aceptacions_pa` - Nueva tabla creada y funcional  
- ✅ `resolucions_pa` - Modelo RsatPa corregido para usar esta tabla

**Campos ENUM Corregidos**:
- `plazo_evacuar`: '5 Dias', '10 Dias', '30 Dias', 'Otro'
- `tipo_audiencia`: 'AEC', 'AIR', 'AS', 'AA', 'Otro' + campo `tipo_audiencia_otro`

### 3.2 Documentos EV PA (Escritos Varios) ✅

| Método | Endpoint | Descripción | Estado |
|--------|----------|-------------|---------|
| POST | `/insert-ev-pa` | Crear nuevo EV PA | ✅ Con numero_documento |
| PUT | `/update-ev-pa/{id}` | Actualizar EV PA | ✅ Funcional |
| DELETE | `/delete-ev-pa/{id}` | Eliminar EV PA | ✅ Funcional |

### 3.3 Nulidades PA ✅

| Método | Endpoint | Descripción | Estado |
|--------|----------|-------------|---------|
| POST | `/insert-nulidad-pa` | Crear nulidad PA | ✅ Con fecha_hora_notificacion |
| PUT | `/update-nulidad-pa/{id}` | Actualizar nulidad PA | ✅ Funcional |
| DELETE | `/delete-nulidad-pa/{id}` | Eliminar nulidad PA | ✅ Funcional |

### 3.4 EC PA (Económico Coactivo) ✅

| Método | Endpoint | Descripción | Estado |
|--------|----------|-------------|---------|
| POST | `/insert-ec-pa` | Crear EC PA | ✅ Con medidas_decretadas |
| PUT | `/update-ec-pa/{id}` | Actualizar EC PA | ✅ Funcional |
| DELETE | `/delete-ec-pa/{id}` | Eliminar EC PA | ✅ Funcional |
email=juan@email.com&
message=Consulta sobre precios&
_token=csrf_token_here
```

**Respuesta Exitosa**:
```http
HTTP/1.1 302 Found
Location: /contact
Set-Cookie: success_message=Mensaje enviado correctamente
```

---

## 3. Módulo Admin

### 3.1 Dashboard Administrativo

| Método | Endpoint | Descripción | Parámetros |
|--------|----------|-------------|------------|
| GET | `/admin` | Dashboard principal admin | - |
| GET | `/admin/empresas` | Lista de empresas | - |
| GET | `/admin/usuarios` | Gestión de usuarios | - |
| GET | `/admin/suscripciones` | Control de suscripciones | - |

### 3.2 Gestión de Empresas

| Método | Endpoint | Descripción | Parámetros |
|--------|----------|-------------|------------|
| GET | `/admin/empresas` | Listar empresas | `page`, `search` |
| GET | `/admin/empresa/{id}` | Ver empresa específica | `id`: ID empresa |
| POST | `/admin/empresa` | Crear nueva empresa | Form data |
| PUT | `/admin/empresa/{id}` | Actualizar empresa | `id`: ID empresa |
| DELETE | `/admin/empresa/{id}` | Eliminar empresa | `id`: ID empresa |

---

## 4. Módulo Empresa

### 4.1 Dashboard Empresa

| Método | Endpoint | Descripción | Middleware |
|--------|----------|-------------|------------|
| GET | `/empresa-dashboard` | Dashboard principal empresa | auth |

#### Respuesta Dashboard:
```json
{
    "movimientos_mes": 1250.50,
    "pats_activos": 12,
    "audiencias_pendientes": 5,
    "casos_va": 23,
    "casos_pa": 18
}
```

### 4.2 Gestión de Cuentas Contables

| Método | Endpoint | Descripción | Parámetros |
|--------|----------|-------------|------------|
| GET | `/cuentas` | Lista de cuentas | `page`, `search` |
| GET | `/show-cuenta/{id}` | Ver cuenta específica | `id`: ID cuenta |
| GET | `/edit-cuenta/{id}` | Formulario editar cuenta | `id`: ID cuenta |
| PUT | `/update-cuenta/{id}` | Actualizar cuenta | `id`: ID cuenta |
| GET | `/add-cuenta` | Formulario nueva cuenta | - |
| POST | `/insert-cuenta` | Crear nueva cuenta | Form data |
| GET | `/delete-cuenta/{id}` | Eliminar cuenta | `id`: ID cuenta |
| GET | `/activate-cuenta/{id}` | Activar/desactivar | `id`: ID cuenta |

#### Estructura Cuenta:
```json
{
    "id": 1,
    "empresa_id": 10,
    "codigo": "1001",
    "nombre": "Caja General",
    "tipo": "activo",
    "estado": "activo",
    "saldo_inicial": 5000.00,
    "created_at": "2024-01-15T10:30:00Z"
}
```

### 4.3 Gestión de Movimientos

| Método | Endpoint | Descripción | Parámetros |
|--------|----------|-------------|------------|
| GET | `/movimientos` | Lista movimientos | `fecha_inicio`, `fecha_fin`, `tipo` |
| GET | `/show-movimiento/{id}` | Ver movimiento | `id`: ID movimiento |
| GET | `/edit-movimiento/{id}` | Editar movimiento | `id`: ID movimiento |
| PUT | `/update-movimiento/{id}` | Actualizar movimiento | `id`: ID movimiento |
| GET | `/add-movimiento` | Nuevo movimiento | - |
| POST | `/insert-movimiento` | Crear movimiento | Form data |
| GET | `/delete-movimiento/{id}` | Eliminar movimiento | `id`: ID movimiento |

#### Estructura Movimiento:
```json
{
    "id": 1,
    "empresa_id": 10,
    "cuenta_id": 5,
    "rubro_id": 3,
    "tipo": "ingreso",
    "monto": 1500.00,
    "fecha": "2024-08-21",
    "concepto": "Pago de honorarios",
    "numero_documento": "FAC-001",
    "estado": "registrado"
}
```

### 4.4 Reportes Contables

| Método | Endpoint | Descripción | Formato |
|--------|----------|-------------|---------|
| GET | `/pdf-movimientos` | Reporte movimientos | PDF |
| GET | `/pdf-movimiento` | Movimiento individual | PDF |  
| GET | `/exportmovimientos` | Exportar movimientos | Excel |
| GET | `/pdf-estadisticas-movimientos` | Estadísticas | PDF |

---

## 5. Sistema PAT (Proceso Administrativo Tributario)

### 5.1 Gestión de PATs

| Método | Endpoint | Descripción | Parámetros |
|--------|----------|-------------|------------|
| GET | `/pats` | Lista de PATs | `estado`, `fecha` |
| GET | `/show-pat/{id}` | Ver PAT específico | `id`: ID PAT |
| GET | `/edit-pat/{id}` | Editar PAT | `id`: ID PAT |
| POST | `/insert-pat` | Crear nuevo PAT | Form data |
| PUT | `/update-pat/{id}` | Actualizar PAT | `id`: ID PAT |

#### Estructura PAT:
```json
{
    "id": 1,
    "empresa_id": 10,
    "numero_pat": "PAT-2024-001",
    "contribuyente": "Empresa ABC S.A.",
    "ruc": "12345678901",
    "periodo": "2024-01",
    "impuesto": "IGV",
    "estado": "en_proceso",
    "fecha_inicio": "2024-08-01"
}
```

### 5.2 Subprocesos PAT

| Entidad | Endpoint Base | Descripción |
|---------|---------------|-------------|
| Nombramientos | `/pat-nombramientos` | Gestión de nombramientos |
| Notificaciones | `/pat-notificaciones` | Control de notificaciones |
| Requerimientos | `/pat-requerimientos` | Manejo de requerimientos |
| Atención Req. | `/pat-atencion-req` | Seguimiento atención |
| Providencias | `/pat-providencias` | Gestión providencias |
| PRAF | `/pat-raf` | Resoluciones de archivo |
| Actas Admin. | `/pat-actas` | Actas administrativas |
| Expedientes | `/pat-expedientes` | Control de expedientes |
| Nulidades | `/pat-nulidades` | Gestión de nulidades |

---

## 6. Sistema VA (Violaciones Administrativas)

### 6.1 Flujo Completo VA

| Secuencia | Entidad | Endpoint | Descripción |
|-----------|---------|----------|-------------|
| 1 | Audiencias | `/audiencias` | Inicio del proceso |
| 2 | EV | `/evs` | Evaluación |
| 3 | PP | `/pps` | Proposición |
| 4 | DPMR | `/dpmrs` | Determinación Provisional |
| 5 | ADPMR | `/adpmrs` | Alegatos contra DPMR |
| 6 | Resoluciones | `/resoluciones` | Resolución del caso |
| 7 | RR | `/rrs` | Recurso de Reconsideración |
| 8 | NTRR | `/ntrrs` | Notificación Términos RR |
| 9 | Ocursos | `/ocursos` | Ocursos |
| 10 | RO | `/ros` | Recurso de Oposición |
| 11 | MPMR | `/mpmrs` | Modificación Provisional |
| 12 | AMPMR | `/ampmrs` | Alegatos MPMR |
| 13 | RTributas | `/rtributas` | Resoluciones Tributarias |
| 14 | Nulidades | `/nulidades` | Nulidades |
| 15 | EC | `/ecs` | Ejecutorias |

#### Ejemplo Audiencia:
```json
{
    "id": 1,
    "empresa_id": 10,
    "numero_audiencia": "AUD-2024-001",
    "contribuyente": "Empresa XYZ",
    "fecha_audiencia": "2024-08-25T09:00:00Z",
    "tipo_infraccion": "Formal",
    "estado": "programada",
    "observaciones": "Primera citación"
}
```

### 6.2 Operaciones CRUD Estándar

Cada entidad del flujo VA sigue el mismo patrón:

| Método | Patrón URL | Descripción |
|--------|------------|-------------|
| GET | `/{entidad}` | Listar registros |
| GET | `/show-{entidad}/{id}` | Ver específico |
| GET | `/edit-{entidad}/{id}` | Formulario editar |
| PUT | `/update-{entidad}/{id}` | Actualizar |
| GET | `/add-{entidad}` | Formulario crear |
| POST | `/insert-{entidad}` | Crear nuevo |
| GET | `/delete-{entidad}/{id}` | Eliminar |

---

## 7. Sistema PA (Procesos Administrativos)

### 7.1 Estructura Duplicada

El sistema PA replica exactamente la funcionalidad de VA con sufijo `_pa`:

| Entidad VA | Entidad PA | Endpoint PA |
|------------|------------|-------------|
| audiencias | audiencias_pa | `/audiencias-pa` |
| evs | evs_pa | `/evs-pa` |  
| pps | pps_pa | `/pps-pa` |
| resolucions | resolucions_pa | `/resoluciones-pa` |
| ... | ... | ... |

### 7.2 Misma Funcionalidad

Todos los endpoints PA siguen el mismo patrón que VA, solo cambia el sufijo `-pa`.

---

## 8. Códigos de Estado HTTP

### 8.1 Respuestas Exitosas
- **200 OK**: Operación exitosa (GET, PUT)
- **201 Created**: Recurso creado exitosamente (POST)
- **302 Found**: Redirección después de operación

### 8.2 Errores del Cliente  
- **400 Bad Request**: Datos de entrada inválidos
- **401 Unauthorized**: No autenticado
- **403 Forbidden**: Sin permisos para la empresa
- **404 Not Found**: Recurso no encontrado
- **422 Unprocessable Entity**: Errores de validación

### 8.3 Errores del Servidor
- **500 Internal Server Error**: Error interno del servidor

---

## 9. Validaciones y Reglas de Negocio

### 9.1 Validaciones Comunes *(Actualizado v2.1)*
```php
// Movimientos
'monto' => 'required|numeric|min:0.01|max:9999999.99'
'fecha' => 'required|date|before_or_equal:today'
'tipo' => 'required|in:ingreso,egreso'

// PAT
'numero_pat' => 'required|unique:pats,numero_pat'
'ruc' => 'required|digits:11'
'periodo' => 'required|date_format:Y-m'

// EA/PP/ADPMR (Nuevos campos agosto 2025)
'fecha_hora_presentacion' => 'required|date'
'numero_documento' => 'required|string|max:255'
'numero_folios' => 'nullable|integer|min:1'
'oficina_presentacion' => 'nullable|string|max:255' // NUEVO CAMPO

// Empresa Filter (Automático)
WHERE empresa_id = {user.empresa_id}
```

### 9.2 Reglas de Negocio
- Los movimientos no pueden tener monto negativo
- Las fechas no pueden ser futuras
- Los PATs deben tener número único por empresa
- Solo usuarios de la misma empresa pueden ver los datos

---

## 10. Exportaciones y Reportes

### 10.1 Formatos Disponibles

| Formato | Uso | Content-Type |
|---------|-----|--------------|
| PDF | Reportes oficiales | application/pdf |
| Excel | Exportación de datos | application/vnd.openxmlformats |
| HTML | Vista principal | text/html |

### 10.2 Endpoints de Exportación

| Tipo | Endpoint | Parámetros Opcionales |
|------|----------|----------------------|
| Cuentas PDF | `/pdf-cuentas` | - |
| Cuentas Excel | `/exportcuentas` | - |
| Movimientos PDF | `/pdf-movimientos` | `fecha_inicio`, `fecha_fin` |
| Movimientos Excel | `/exportmovimientos` | `fecha_inicio`, `fecha_fin` |
| Estadísticas PDF | `/pdf-estadisticas-movimientos` | `periodo` |

---

## 11. Paginación

### 11.1 Parámetros de Paginación
```http
GET /movimientos?page=2&per_page=25
```

### 11.2 Estructura de Respuesta (Metadata)
```html
<!-- Laravel Pagination Links -->
<nav aria-label="Pagination">
    <ul class="pagination">
        <li><a href="/movimientos?page=1">1</a></li>
        <li class="active"><span>2</span></li>
        <li><a href="/movimientos?page=3">3</a></li>
    </ul>
</nav>
```

---

## 12. Filtros de Búsqueda

### 12.1 Filtros Comunes

| Parámetro | Aplicable a | Tipo | Ejemplo |
|-----------|-------------|------|---------|
| `search` | Todas las listas | string | `?search=empresa` |
| `fecha_inicio` | Movimientos, PATs | date | `?fecha_inicio=2024-01-01` |
| `fecha_fin` | Movimientos, PATs | date | `?fecha_fin=2024-12-31` |
| `tipo` | Movimientos | enum | `?tipo=ingreso` |
| `estado` | PATs, VA, PA | enum | `?estado=activo` |

### 12.2 Ejemplo de Búsqueda Completa
```http
GET /movimientos?search=honorarios&fecha_inicio=2024-08-01&fecha_fin=2024-08-31&tipo=ingreso
```

---

## 13. Manejo de Archivos

### 13.1 Upload de Documentos
```http
POST /insert-documento
Content-Type: multipart/form-data

movimiento_id=123&
tipo_documento=factura&
archivo=[binary_data]&
_token=csrf_token
```

### 13.2 Estructura de Archivos
- **Ubicación**: `/public/uploads/empresa_{id}/`
- **Tipos permitidos**: PDF, JPG, PNG, DOC, DOCX
- **Tamaño máximo**: 10MB por archivo

---

## 14. Seguridad

### 14.1 Headers de Seguridad
```http
X-CSRF-TOKEN: required_for_post_requests
X-Requested-With: XMLHttpRequest (para AJAX)
```

### 14.2 Middleware de Empresa
Todos los endpoints de empresa aplican automáticamente:
```sql
WHERE empresa_id = {authenticated_user.empresa_id}
```

---

## 15. Notas para Desarrolladores

### 15.1 Convenciones de Rutas
- **Listado**: `/{entidad}` (GET)
- **Ver**: `/show-{entidad}/{id}` (GET)  
- **Crear**: `/add-{entidad}` (GET) → `/insert-{entidad}` (POST)
- **Editar**: `/edit-{entidad}/{id}` (GET) → `/update-{entidad}/{id}` (PUT)
- **Eliminar**: `/delete-{entidad}/{id}` (GET)

### 15.2 Respuestas Típicas
```php
// Éxito
return redirect()->back()->with('success', 'Operación realizada correctamente');

// Error
return redirect()->back()->with('error', 'Ocurrió un error')->withInput();

// Validación  
return redirect()->back()->withErrors($validator)->withInput();
```

---

## 13. Changelog API *(Nuevo)*

### v2.1 - 22 de agosto de 2025
**Nuevos campos en módulos EA/PP/ADPMR:**
- ✅ Campo `oficina_presentacion` consolidado en migraciones finales
- ✅ Validación: `nullable|string|max:255`
- ✅ Disponible en formularios de crear/editar
- ✅ Visible en listados de VA y PA
- ✅ Incluido en consolidación de 28 migraciones (29 ago 2025)

**Módulos afectados:**
- evs (Evacuación de Audiencia)
- pps (Período de Prueba)  
- adpmrs (Atención DPMR)
- Equivalentes PA: evs_pa, pps_pa, adpmrs_pa

**Ejemplo de payload actualizado:**
```json
{
    "fecha_hora_presentacion": "2025-08-22T10:30:00",
    "numero_documento": "DOC-2025-001",
    "numero_folios": 5,
    "observaciones": "Documento presentado correctamente",
    "oficina_presentacion": "Oficina Central SAT", // NUEVO CAMPO
    "archivo": "documento.pdf"
}
```

---

**Documentación API v2.1**  
**Última actualización**: 22 de agosto de 2025  
**Equipo**: SZSystems Development Team
