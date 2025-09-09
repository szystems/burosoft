# 🎯 CONFIGURACIÓN ESPECÍFICA - appburo.burotributario.com
## Setup Final para el Subdomain Buro

### 📋 CONFIGURACIÓN CONFIRMADA:

```
Subdomain: appburo.burotributario.com
Directorio: szystems/buro-v2/public/
URL Final: https://appburo.burotributario.com
```

### 🔧 PASOS ESPECÍFICOS:

#### 1. 📝 ACTUALIZAR .ENV EN SERVIDOR:

**Cambiar APP_URL en `/szystems/buro-v2/.env`:**
```env
APP_NAME="BuroTributario"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://appburo.burotributario.com

# SESIONES CRÍTICAS
SESSION_DRIVER=file
SESSION_DOMAIN=.burotributario.com
SESSION_COOKIE=buro_app_session
SESSION_SECURE_COOKIE=true

# BASE DE DATOS
DB_HOST=szclinicascom.ipagemysql.com
DB_DATABASE=dbburonuevo
DB_USERNAME=sz
DB_PASSWORD=SPP7007aaa@@@

# LOGS OPTIMIZADOS
LOG_LEVEL=error
CACHE_DRIVER=file
```

#### 2. 🔑 VERIFICAR PERMISOS:

```bash
# En iPage File Manager:
chmod 755 szystems/buro-v2/storage/
chmod 755 szystems/buro-v2/storage/framework/
chmod 755 szystems/buro-v2/storage/framework/sessions/
chmod 755 szystems/buro-v2/storage/logs/
chmod 755 szystems/buro-v2/bootstrap/cache/
```

#### 3. 🌐 VERIFICAR SUBDOMAIN EN iPage:

```
Panel iPage → Subdomains
- Subdomain: appburo
- Domain: burotributario.com  
- Directory: szystems/buro-v2/public/
- Status: Active ✅
```

#### 4. ✅ VERIFICAR .HTACCESS:

**En `/szystems/buro-v2/public/.htaccess`:**
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On
    
    # Force HTTPS
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Laravel Routes
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Security
<Files .env>
    order allow,deny
    deny from all
</Files>
```

### 🧪 PRUEBAS ESPECÍFICAS:

#### Test 1: Acceso Principal
```
URL: https://appburo.burotributario.com
Esperado: Página de login/inicio
```

#### Test 2: Login Sistema
```
1. Ir a login
2. Ingresar credenciales
3. Verificar redirección sin Error 419
```

#### Test 3: Sesiones
```
1. Login exitoso
2. Navegar entre páginas
3. Verificar que mantiene sesión
4. Logout correcto
```

### ⚠️ CONFIGURACIÓN CRÍTICA SESSION_DOMAIN:

**IMPORTANTE:** Con `appburo.burotributario.com` usar:
```env
SESSION_DOMAIN=.burotributario.com
```
**NO:** `.appburo.burotributario.com`

### 🔄 COMANDOS DE CACHE (si tienes SSH):

```bash
cd /public_html/szystems/buro-v2/
php artisan config:clear
php artisan config:cache
php artisan route:cache
```

### 📧 CONFIGURACIÓN EMAIL (Verificar):

```env
MAIL_HOST=smtp.ipage.com
MAIL_PORT=465
MAIL_USERNAME=soluciones@burotributario.com
MAIL_FROM_ADDRESS=soluciones@burotributario.com
MAIL_ENCRYPTION=ssl
```

### ✅ CHECKLIST FINAL:

```
□ Subdomain appburo.burotributario.com configurado
□ .env APP_URL actualizado
□ SESSION_DOMAIN=.burotributario.com
□ Permisos storage/ configurados
□ .htaccess en public/
□ HTTPS forzado
□ Login/logout funcionando
□ Sin Error 419
□ Emails funcionando (si aplica)
```

---

**🚀 PRÓXIMO PASO:**
1. Acceder a: `https://appburo.burotributario.com`
2. Verificar que carga correctamente
3. Probar login completo
4. Confirmar funcionamiento sin errores
