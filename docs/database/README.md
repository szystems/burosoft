# Database Documentation

Esta carpeta contiene toda la documentación relacionada con la base de datos del sistema BUROSOFT.

## Estructura

### `/migrations`
Contiene todos los archivos SQL de migración para sincronizar la base de datos:

- `migraciones_completas_ipage_final.sql` - **SCRIPT PRINCIPAL** - Migración completa para iPage (39 migraciones del 21-28 agosto 2025)
- `migraciones_completas_burosoft.sql` - Migración completa para BuroSoft
- `aplicar_migraciones_ipage.sql` - Script específico para aplicar en iPage
- `aplicar_migraciones_pendientes.sql` - Migraciones pendientes de aplicar
- `aplicar_migraciones_seguras.sql` - Migraciones validadas como seguras
- `migraciones_faltantes_final.sql` - Migraciones que faltaban por aplicar
- `migraciones_pendientes_burosoft.sql` - Migraciones pendientes en BuroSoft

## Uso

Para aplicar las migraciones en producción (iPage), utilizar el archivo principal:
```sql
-- Ejecutar en phpMyAdmin de iPage
migraciones_completas_ipage_final.sql
```

## Notas Importantes

- Todos los scripts están optimizados para MySQL 5.7.44-log
- Compatible con restricciones de iPage hosting
- Incluye validación de foreign keys y column positioning
- Charset: utf8mb4_unicode_ci consistente
