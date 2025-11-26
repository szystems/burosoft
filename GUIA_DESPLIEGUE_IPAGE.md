# ============================================
# GUÍA DE DESPLIEGUE - iPAGE
# BuroTributario - Laravel 12
# Dominio: appburo.burotributario.com
# ============================================

## 📋 PRE-REQUISITOS

### En tu computadora local:
- ✅ Laravel 12.40.1 actualizado
- ✅ Todas las dependencias actualizadas (`composer.json`)
- ✅ Código testeado y funcionando localmente
- ✅ Cliente FTP (FileZilla, WinSCP, o similar)
- ✅ Acceso SSH a iPage (opcional pero recomendado)

### En el servidor iPage:
- PHP 8.3+ activado
- MySQL accesible
- Extensiones PHP requeridas habilitadas

---

## 🚀 PASOS DE DESPLIEGUE

### PASO 1: Preparar Archivos Localmente

1. **Generar archivos optimizados para producción:**
   ```bash
   # En tu computadora local
   cd c:/Users/szott/Dropbox/Desarrollo/buro
   
   # Instalar dependencias sin desarrollo
   composer install --optimize-autoloader --no-dev
   
   # Opcional: Compilar assets frontend si usas npm
   npm run build
   ```

2. **Copiar archivo de entorno:**
   ```bash
   # Copiar .env.produccion como .env
   copy .env.produccion .env
   ```

3. **Verificar que estos directorios existan y estén vacíos:**
   - `storage/framework/sessions/`
   - `storage/framework/views/`
   - `storage/framework/cache/`
   - `storage/logs/`
   - `bootstrap/cache/`

---

### PASO 2: Estructura de Directorios en iPage

En iPage, la estructura recomendada es:

```
/home/[tu-usuario]/
├── public_html/              # Root público de tu dominio principal
├── appburo/                  # Carpeta para la nueva aplicación
│   ├── public/              # Este será el document root
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/             # ⚠️ IMPORTANTE: Permisos 775
│   ├── vendor/
│   ├── .env                 # ⚠️ CRÍTICO
│   ├── artisan
│   └── composer.json
```

---

### PASO 3: Subir Archivos por FTP

#### Opción A: FTP Completo (Primera vez o cambios mayores)

1. **Conectar por FTP:**
   - Host: `ftp.tudominio.com` o `ftp.ipage.com`
   - Usuario: Tu usuario de iPage
   - Password: Tu contraseña de iPage
   - Puerto: 21 (FTP) o 22 (SFTP si está disponible)

2. **Crear carpeta `appburo` en el servidor:**
   ```
   /home/[tu-usuario]/appburo/
   ```

3. **Subir TODOS los archivos EXCEPTO:**
   - ❌ `.env` (se sube después manualmente)
   - ❌ `node_modules/` (no es necesario)
   - ❌ `.git/` (no es necesario)
   - ❌ `tests/` (opcional)
   - ❌ Archivos de desarrollo local

4. **Archivos y carpetas CRÍTICOS a subir:**
   - ✅ `app/`
   - ✅ `bootstrap/`
   - ✅ `config/`
   - ✅ `database/migrations/`
   - ✅ `public/`
   - ✅ `resources/`
   - ✅ `routes/`
   - ✅ `storage/` (estructura vacía)
   - ✅ `vendor/` (todas las dependencias)
   - ✅ `artisan`
   - ✅ `composer.json`
   - ✅ `composer.lock`

#### Opción B: FTP Incremental (Solo cambios)

Si ya tienes la aplicación desplegada y solo haces cambios menores:

1. Subir solo archivos modificados:
   - Controladores actualizados
   - Vistas modificadas
   - Archivos de configuración
   - Modelos actualizados

---

### PASO 4: Configurar Archivo .env

1. **Subir `.env.produccion` como `.env`:**
   - Renombrar `.env.produccion` a `.env`
   - Subir a la raíz de `/appburo/`

2. **Verificar configuración crítica en `.env`:**
   ```env
   APP_ENV=production
   APP_DEBUG=false  # ⚠️ CRÍTICO: false en producción
   APP_URL=https://appburo.burotributario.com
   
   DB_HOST=szclinicascom.ipagemysql.com
   DB_DATABASE=dbburonuevo
   DB_USERNAME=sz
   DB_PASSWORD=SPP7007aaa@@@
   
   SESSION_DRIVER=file
   SESSION_COOKIE=appburo_session
   SESSION_DOMAIN=.burotributario.com
   SESSION_SECURE_COOKIE=true
   ```

---

### PASO 5: Configurar Document Root en iPage

1. **Acceder al Panel de Control de iPage:**
   - Login en tu cuenta iPage
   - Ir a "Dominios" o "Domain Manager"

2. **Configurar subdomain `appburo.burotributario.com`:**
   - Crear subdomain si no existe
   - **Document Root:** `/home/[tu-usuario]/appburo/public`
   - ⚠️ **IMPORTANTE:** Apuntar al directorio `public`, NO a la raíz

3. **Alternativa con .htaccess (si no puedes cambiar document root):**
   
   Crear `.htaccess` en `/appburo/`:
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteRule ^(.*)$ public/$1 [L]
   </IfModule>
   ```

---

### PASO 6: Configurar Permisos

**VÍA SSH (Recomendado):**
```bash
ssh tu-usuario@tudominio.com

cd appburo

# Permisos para storage y cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Específicamente para sesiones y logs
chmod -R 775 storage/framework/sessions
chmod -R 775 storage/framework/views
chmod -R 775 storage/framework/cache
chmod -R 775 storage/logs

# Uploads si existen
chmod -R 775 public/assets/uploads
```

**VÍA FTP (Si no tienes SSH):**
- En FileZilla: Click derecho → Permisos de archivo → 775 (rwxrwxr-x)
- Aplicar a:
  - `storage/` (recursivo)
  - `bootstrap/cache/` (recursivo)

---

### PASO 7: Ejecutar Comandos de Optimización

**VÍA SSH:**
```bash
cd appburo

# Limpiar cachés
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Cachear para producción
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimizar
php artisan optimize
composer dump-autoload --optimize --no-dev
```

**Sin SSH (Crear archivo PHP temporal):**

Subir `optimize.php` a `/appburo/public/`:
```php
<?php
// Ejecutar: https://appburo.burotributario.com/optimize.php
// ⚠️ ELIMINAR DESPUÉS DE USAR

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

echo "Optimizando...<br>";

Artisan::call('config:clear');
echo "✓ Config cleared<br>";

Artisan::call('cache:clear');
echo "✓ Cache cleared<br>";

Artisan::call('route:clear');
echo "✓ Routes cleared<br>";

Artisan::call('view:clear');
echo "✓ Views cleared<br>";

Artisan::call('config:cache');
echo "✓ Config cached<br>";

Artisan::call('route:cache');
echo "✓ Routes cached<br>";

Artisan::call('view:cache');
echo "✓ Views cached<br>";

Artisan::call('optimize');
echo "✓ Optimized<br>";

echo "<br><strong>✓ Optimización completada!</strong>";
echo "<br><br><em>⚠️ ELIMINA ESTE ARCHIVO AHORA</em>";
```

---

### PASO 8: Verificar Base de Datos

1. **Verificar conexión:**
   ```bash
   php artisan db:show
   ```

2. **Ejecutar migraciones (si hay nuevas):**
   ```bash
   php artisan migrate --force
   ```
   
   ⚠️ **Nota:** `--force` es necesario en producción

3. **Si necesitas seeders (datos iniciales):**
   ```bash
   php artisan db:seed --force
   ```

---

### PASO 9: Verificación Final

1. **Comprobar que la aplicación carga:**
   - Visitar: `https://appburo.burotributario.com`
   - Verificar que no hay errores

2. **Probar funcionalidades críticas:**
   - ✅ Login/Logout
   - ✅ CRUD de entidades principales
   - ✅ Generación de PDFs
   - ✅ Subida de archivos
   - ✅ Envío de emails

3. **Revisar logs:**
   - `storage/logs/laravel.log`
   - Buscar errores o warnings

4. **Verificar sesiones:**
   - Login debe funcionar sin error 419
   - Sesiones deben persistir entre páginas

---

## 🔧 SOLUCIÓN DE PROBLEMAS COMUNES

### Error 500 - Internal Server Error

**Causa:** Permisos incorrectos o error de configuración

**Solución:**
```bash
# Verificar permisos
chmod -R 775 storage bootstrap/cache

# Verificar .env existe
ls -la .env

# Limpiar cachés
php artisan config:clear
php artisan cache:clear
```

### Error 419 - CSRF Token Mismatch

**Causa:** Problemas con sesiones

**Solución en `.env`:**
```env
SESSION_DRIVER=file
SESSION_DOMAIN=.burotributario.com
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=lax
SESSION_COOKIE=appburo_session
```

Luego:
```bash
php artisan config:clear
php artisan cache:clear
chmod -R 775 storage/framework/sessions
```

### Error 404 en rutas (excepto homepage)

**Causa:** mod_rewrite no habilitado o .htaccess incorrecto

**Solución:**
1. Verificar que `public/.htaccess` existe
2. Verificar que mod_rewrite está habilitado en iPage
3. Contactar soporte de iPage si persiste

### Base de datos no conecta

**Causa:** Credenciales incorrectas o host incorrecto

**Verificar en `.env`:**
```env
DB_HOST=szclinicascom.ipagemysql.com  # Debe ser el host de iPage
DB_DATABASE=dbburonuevo
DB_USERNAME=sz
DB_PASSWORD=SPP7007aaa@@@
```

### Páginas cargan muy lento

**Solución:**
```bash
# Cachear todo
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Optimizar autoloader
composer dump-autoload --optimize --no-dev
```

---

## 📁 CHECKLIST FINAL

Antes de considerar el despliegue completo:

- [ ] Archivos subidos correctamente por FTP
- [ ] `.env` configurado con valores de producción
- [ ] `APP_DEBUG=false` en `.env`
- [ ] Permisos 775 en `storage/` y `bootstrap/cache/`
- [ ] Document root apunta a `/appburo/public`
- [ ] Comandos de optimización ejecutados
- [ ] Base de datos accesible
- [ ] Migraciones ejecutadas
- [ ] Login funciona sin error 419
- [ ] PDFs se generan correctamente
- [ ] Emails se envían (si aplica)
- [ ] Logs no muestran errores críticos
- [ ] SSL (HTTPS) funciona correctamente
- [ ] Backups programados (opcional)

---

## 🔒 SEGURIDAD ADICIONAL

### 1. Proteger archivo .env

Verificar que `.htaccess` en raíz tiene:
```apache
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

### 2. Deshabilitar listado de directorios

En `public/.htaccess` verificar:
```apache
Options -Indexes
```

### 3. Proteger directorios sensibles

Crear `.htaccess` en `/storage/`:
```apache
Deny from all
```

---

## 📞 SOPORTE

Si encuentras problemas:

1. **Revisar logs:**
   - `storage/logs/laravel.log`
   - Panel de iPage → Error Logs

2. **Modo debug temporal:**
   - Cambiar `APP_DEBUG=true` en `.env`
   - Ver error completo en navegador
   - ⚠️ Volver a `false` después

3. **Contactar soporte:**
   - iPage Support: Para temas de servidor/PHP
   - Desarrollador: Para temas de código Laravel

---

## 📝 NOTAS IMPORTANTES

- **Backup:** Siempre hacer backup antes de desplegar
- **Testing:** Probar en staging/desarrollo antes de producción
- **Downtime:** Programar despliegues en horarios de bajo tráfico
- **Monitoreo:** Revisar logs regularmente después del despliegue
- **Actualizaciones:** Mantener Laravel y dependencias actualizadas

---

**Última actualización:** 25 de noviembre de 2025
**Laravel Version:** 12.40.1
**PHP Version:** 8.3.16
