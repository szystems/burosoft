# Database Migrations

Esta carpeta contiene todos los archivos SQL para migrar y sincronizar la base de datos del sistema BUROSOFT.

## Archivos de Migración

### Archivo Principal (Producción)
- **`migraciones_completas_ipage_final.sql`** - Script final para aplicar en iPage
  - ✅ 39 migraciones del 21-28 agosto 2025
  - ✅ Crea 4 nuevas tablas: pat_rcts, aceptacions, aceptacions_pa, constancia_pagos
  - ✅ Modifica 15+ tablas existentes con nuevos campos
  - ✅ Compatible con MySQL 5.7.44-log en iPage hosting
  - ✅ Validado para producción

### Archivos de Desarrollo/Testing
- `migraciones_completas_burosoft.sql` - Para entorno de desarrollo BuroSoft
- `aplicar_migraciones_ipage.sql` - Versión anterior para iPage
- `aplicar_migraciones_pendientes.sql` - Migraciones pendientes específicas
- `aplicar_migraciones_seguras.sql` - Solo migraciones validadas como seguras
- `migraciones_faltantes_final.sql` - Migraciones identificadas como faltantes
- `migraciones_pendientes_burosoft.sql` - Pendientes específicas para BuroSoft

## Instrucciones de Uso

### Para Producción (iPage)
1. Hacer backup de la base de datos actual
2. Ejecutar `migraciones_completas_ipage_final.sql` en phpMyAdmin
3. Verificar 16 mensajes "✅ Status_X" durante la ejecución
4. Confirmar mensaje final: "Script completado exitosamente"

### Para Desarrollo Local
1. Usar `migraciones_completas_burosoft.sql` para sincronizar con desarrollo
2. Aplicar `migraciones_pendientes_burosoft.sql` para cambios incrementales

## Características Técnicas

- **Motor**: InnoDB
- **Charset**: utf8mb4_unicode_ci
- **Versión MySQL**: 5.7.44-log (compatible)
- **Foreign Keys**: Validadas contra tablas existentes
- **Column Positioning**: AFTER clauses verificadas
- **Hosting**: Optimizado para iPage shared hosting
