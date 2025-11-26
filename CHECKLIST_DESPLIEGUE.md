# ============================================
# CHECKLIST DE DESPLIEGUE - iPAGE
# BuroTributario Laravel 12
# ============================================

## 📦 ANTES DE SUBIR ARCHIVOS

### Preparación Local
- [ ] Código funciona correctamente en local
- [ ] Tests pasados (si existen)
- [ ] `composer install --optimize-autoloader --no-dev` ejecutado
- [ ] `npm run build` ejecutado (si aplica)
- [ ] Archivo `.env.produccion` creado y revisado
- [ ] Backup de la aplicación actual en servidor (si existe)
- [ ] Backup de base de datos (si existe)

### Archivos Críticos Preparados
- [ ] `.env.produccion` → renombrar a `.env`
- [ ] `public/.htaccess.produccion` → renombrar a `.htaccess`
- [ ] `storage/.htaccess` existe
- [ ] `optimize-server.php` listo para subir

---

## 📤 SUBIDA POR FTP

### Conexión FTP
- [ ] Conectado a: `ftp.burotributario.com` o IP de iPage
- [ ] Usuario y contraseña correctos
- [ ] Navegado a directorio correcto: `/home/[usuario]/appburo/`

### Archivos a Subir
- [ ] `app/` (completo)
- [ ] `bootstrap/` (completo)
- [ ] `config/` (completo)
- [ ] `database/migrations/` (completo)
- [ ] `database/seeders/` (completo)
- [ ] `public/` (completo)
- [ ] `resources/` (completo)
- [ ] `routes/` (completo)
- [ ] `storage/` (estructura, logs vacíos)
- [ ] `vendor/` (completo - puede tardar)
- [ ] `artisan`
- [ ] `composer.json`
- [ ] `composer.lock`
- [ ] `.env` (subido manualmente al final)

### Archivos NO Subir
- [ ] `node_modules/`
- [ ] `.git/`
- [ ] `.env.example`
- [ ] `tests/`
- [ ] `.gitignore`
- [ ] `README.md` (opcional)
- [ ] Archivos de desarrollo local

---

## ⚙️ CONFIGURACIÓN EN SERVIDOR

### Document Root
- [ ] Subdomain `appburo.burotributario.com` creado
- [ ] Document root configurado: `/home/[usuario]/appburo/public`
- [ ] DNS propagado (puede tardar hasta 24hrs)

### Archivo .env
- [ ] `.env` subido a `/appburo/`
- [ ] Verificado `APP_ENV=production`
- [ ] Verificado `APP_DEBUG=false`
- [ ] Verificado `APP_URL=https://appburo.burotributario.com`
- [ ] Credenciales de base de datos correctas
- [ ] `SESSION_DOMAIN=.burotributario.com`

### Permisos (vía SSH o FTP)
- [ ] `storage/` → 775 (recursivo)
- [ ] `bootstrap/cache/` → 775 (recursivo)
- [ ] `storage/framework/sessions/` → 775
- [ ] `storage/framework/views/` → 775
- [ ] `storage/framework/cache/` → 775
- [ ] `storage/logs/` → 775
- [ ] `public/assets/uploads/` → 775 (si existe)

---

## 🚀 OPTIMIZACIÓN

### Via SSH (Preferido)
```bash
cd appburo
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
composer dump-autoload --optimize --no-dev
```

- [ ] Todos los comandos ejecutados sin errores

### Via Navegador (Sin SSH)
- [ ] Subir `optimize-server.php` a `public/`
- [ ] Ejecutar: `https://appburo.burotributario.com/optimize-server.php`
- [ ] Verificar que todos los comandos se ejecutaron
- [ ] **ELIMINAR `optimize-server.php` inmediatamente**

---

## 🗄️ BASE DE DATOS

### Conexión
- [ ] Conexión a base de datos verificada
- [ ] Host correcto: `szclinicascom.ipagemysql.com`
- [ ] Base de datos `dbburonuevo` existe
- [ ] Usuario `sz` tiene permisos

### Migraciones
- [ ] `php artisan migrate --force` ejecutado (si hay nuevas)
- [ ] No hay errores en migraciones
- [ ] Estructura de BD correcta

### Datos (si es primera vez)
- [ ] Seeders ejecutados (si necesario)
- [ ] Datos de prueba creados (si necesario)
- [ ] Usuario admin creado

---

## ✅ VERIFICACIÓN FUNCIONAL

### Acceso Básico
- [ ] `https://appburo.burotributario.com` carga correctamente
- [ ] No hay error 500
- [ ] No hay error 404 en homepage
- [ ] SSL/HTTPS funciona (candado verde)

### Autenticación
- [ ] Página de login carga
- [ ] Login funciona correctamente
- [ ] No hay error 419 (CSRF)
- [ ] Sesiones persisten entre páginas
- [ ] Logout funciona

### Funcionalidades Core
- [ ] Dashboard carga después del login
- [ ] Menú de navegación funciona
- [ ] Listados de datos cargan
- [ ] Formularios funcionan (crear/editar)
- [ ] Validación de formularios funciona
- [ ] Mensajes flash aparecen correctamente

### Archivos y Medios
- [ ] Imágenes cargan correctamente
- [ ] CSS aplicado correctamente
- [ ] JavaScript funciona
- [ ] Iconos/fuentes cargan

### Funcionalidades Específicas
- [ ] Generación de PDFs funciona
- [ ] Subida de archivos funciona
- [ ] Export a Excel funciona (si aplica)
- [ ] Envío de emails funciona (si aplica)
- [ ] PayPal/Pagos funcionan (si aplica)

---

## 🔍 REVISIÓN DE LOGS

### Logs de Laravel
- [ ] `storage/logs/laravel.log` revisado
- [ ] No hay errores críticos
- [ ] No hay warnings importantes
- [ ] Solo logs normales de operación

### Logs del Servidor (iPage)
- [ ] Logs de error PHP revisados (panel iPage)
- [ ] No hay errores 500 registrados
- [ ] No hay errores de permisos

---

## 🔒 SEGURIDAD

### Archivos Protegidos
- [ ] `.env` no es accesible vía web
- [ ] `storage/` no es accesible vía web
- [ ] `composer.json` no es accesible
- [ ] Listado de directorios deshabilitado

### Configuración
- [ ] `APP_DEBUG=false` en producción
- [ ] `APP_ENV=production`
- [ ] Cookies seguras habilitadas
- [ ] CSRF protección activa
- [ ] `optimize-server.php` ELIMINADO

### SSL/HTTPS
- [ ] Certificado SSL instalado
- [ ] Redirección HTTP → HTTPS activa
- [ ] Cookies secure habilitadas

---

## 📊 RENDIMIENTO

### Cache
- [ ] Config cacheada
- [ ] Rutas cacheadas
- [ ] Vistas cacheadas
- [ ] Autoloader optimizado

### Pruebas de Velocidad
- [ ] Homepage carga en <3 segundos
- [ ] Dashboard carga en <5 segundos
- [ ] Listados cargan razonablemente rápido

---

## 📞 POST-DESPLIEGUE

### Monitoreo Inicial
- [ ] Revisar logs cada hora las primeras 4 horas
- [ ] Revisar logs diariamente la primera semana
- [ ] Configurar alertas (opcional)

### Comunicación
- [ ] Notificar a usuarios (si aplica)
- [ ] Documentar versión desplegada
- [ ] Actualizar documentación técnica

### Backup
- [ ] Backup de archivos post-despliegue
- [ ] Backup de base de datos post-despliegue
- [ ] Programar backups automáticos

---

## 🚨 EN CASO DE PROBLEMAS

### Rollback
- [ ] Backup anterior disponible
- [ ] Procedimiento de rollback documentado
- [ ] Backup de BD anterior disponible

### Debug
1. Cambiar temporalmente `APP_DEBUG=true`
2. Reproducir error
3. Revisar mensaje completo
4. Volver `APP_DEBUG=false`

### Contactos de Soporte
- **Hosting (iPage):** support.ipage.com
- **Laravel:** Documentación oficial
- **Desarrollador:** [Tu contacto]

---

## ✅ DESPLIEGUE COMPLETADO

Fecha: _________________
Hora: _________________
Desplegado por: _________________

**Firma:** _________________

---

### Notas Adicionales:
________________________________
________________________________
________________________________
________________________________

---

**Este checklist debe completarse para cada despliegue a producción**
