# Documentación Técnica Principal - BuroSoft

Esta carpeta contiene la documentación técnica principal del proyecto BuroSoft Sistema de Gestión Legal y Contable.

## 📚 Documentos Disponibles

### 📋 [PRD.md](PRD.md) - Product Requirements Document
**Requerimientos del Producto**
- ✅ Resumen ejecutivo y objetivos
- ✅ Alcance y límites del sistema  
- ✅ Requerimientos funcionales detallados
- ✅ Requerimientos no funcionales
- ✅ Casos de uso principales
- ✅ Criterios de éxito y métricas
- ✅ Roadmap y fases del proyecto

### 🏗️ [ARCHITECTURE.md](ARCHITECTURE.md) - Arquitectura del Sistema  
**Diseño Técnico y Decisiones Arquitectónicas**
- ✅ Arquitectura de alto nivel
- ✅ Modelo de base de datos completo
- ✅ Patrones de diseño implementados
- ✅ ADRs (Architecture Decision Records)
- ✅ Convenciones y estándares
- ✅ Seguridad y performance
- ✅ Estrategias de testing y deployment

### 🔌 [API.md](API.md) - Documentación de API
**Endpoints, Parámetros y Ejemplos**
- ✅ Módulos Frontend, Admin y Empresa
- ✅ Sistemas PAT, VA y PA completos  
- ✅ Operaciones CRUD estándar
- ✅ Códigos de estado HTTP
- ✅ Validaciones y reglas de negocio
- ✅ Exportaciones y reportes
- ✅ Filtros y paginación

## 🔍 Vista Rápida del Sistema

### Módulos Principales
- **Frontend**: Landing page y suscripciones
- **Admin**: Panel de administración del sistema
- **Empresa**: Dashboard y gestión por empresa cliente

### Entidades Clave
- **PAT**: 54+ migraciones de Procesos Administrativos Tributarios
- **VA/PA**: Sistema dual de Violaciones y Procesos Administrativos  
- **Contable**: Cuentas, movimientos, rubros y reportes
- **Multi-tenant**: Gestión independiente por empresa

### Tecnologías Utilizadas
- **Backend**: Laravel 8.x + PHP 8.0+
- **Frontend**: Blade Templates + Bootstrap + JavaScript  
- **Base de Datos**: MySQL 8.0
- **Reportes**: DomPDF + Maatwebsite/Excel
- **Autenticación**: Laravel Auth + Sessions

## 📊 Métricas del Proyecto

| Métrica | Valor |
|---------|-------|
| **Migraciones** | 54+ tablas |
| **Modelos** | 50+ entidades |
| **Controladores** | 40+ controladores |
| **Rutas** | 200+ endpoints |
| **Líneas de Código** | ~15,000 LOC |
| **Módulos** | 3 principales |

## 🚀 Flujos Principales

### 1. Gestión Contable
```
Empresa → Cuentas → Rubros → Movimientos → Documentos → Reportes
```

### 2. Proceso PAT  
```
PAT → Nombramientos → Notificaciones → Requerimientos → Providencias → PRAF
```

### 3. Flujo VA/PA
```
Audiencia → EV → PP → DPMR → Resolución → RR → Ejecutoria
```

## 📖 Cómo Usar Esta Documentación

### Para Desarrolladores Nuevos
1. Leer el [README principal](../../README.md) del proyecto
2. Revisar [PRD.md](PRD.md) para entender requerimientos
3. Estudiar [ARCHITECTURE.md](ARCHITECTURE.md) para diseño técnico
4. Consultar [API.md](API.md) para implementación

### Para Product Managers
- [PRD.md](PRD.md) contiene todos los requerimientos y casos de uso
- Métricas de éxito y roadmap detallado

### Para Arquitectos de Software  
- [ARCHITECTURE.md](ARCHITECTURE.md) tiene todas las decisiones técnicas
- ADRs documentados con contexto y consecuencias

### Para Frontend/Backend Developers
- [API.md](API.md) tiene todos los endpoints con ejemplos
- Validaciones y reglas de negocio documentadas

### Para QA/Testing
- [PRD.md](PRD.md) criterios de aceptación por requerimiento
- [ARCHITECTURE.md](ARCHITECTURE.md) estrategias de testing

## 🔄 Mantenimiento

### Frecuencia de Actualización
- **Releases menores**: Actualizar API.md si hay cambios en endpoints
- **Releases mayores**: Revisar y actualizar toda la documentación
- **Cambios arquitectónicos**: Agregar nuevos ADRs

### Responsabilidades
- **Tech Lead**: ARCHITECTURE.md y ADRs
- **Product Owner**: PRD.md y requerimientos
- **Backend Developer**: API.md y endpoints
- **Todo el equipo**: Revisión y feedback

---

**Equipo SZSystems**  
**Versión**: 2.0  
**Última actualización**: 21 de agosto de 2025
