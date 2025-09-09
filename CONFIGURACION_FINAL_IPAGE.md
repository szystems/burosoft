# 🔧 CONFIGURACIÓN FINAL EN iPage - PROYECTO BURO
## Pasos Específicos Post-Subida

### 1. 📁 VERIFICAR ESTRUCTURA EN iPage:

```
/public_html/buro-v2/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/              # ← IMPORTANTE: Esta es tu raíz web
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env                 # ← Tu .env.produccion-ipage
├── artisan
├── composer.json
└── server.php
```

### 2. 🔑 CONFIGURAR PERMISOS (CRÍTICO):

```bash
# En iPage File Manager o por SSH:
chmod 755 buro-v2/
chmod 755 buro-v2/storage/
chmod 755 buro-v2/storage/app/
chmod 755 buro-v2/storage/framework/
chmod 755 buro-v2/storage/framework/cache/
chmod 755 buro-v2/storage/framework/sessions/
chmod 755 buro-v2/storage/framework/views/
chmod 755 buro-v2/storage/logs/
chmod 755 buro-v2/bootstrap/cache/
```

### 3. 🌐 CONFIGURAR SUBDOMAIN/ACCESO WEB:

#### OPCIÓN A: Subdomain Temporal (RECOMENDADO)
```
1. En iPage Panel → Subdomains
2. Crear: buro-v2.szystems.com
3. Apuntar a: /public_html/buro-v2/public/
4. URL de prueba: https://buro-v2.szystems.com
```

#### OPCIÓN B: Carpeta de Acceso
```
URL: https://szystems.com/buro-v2/public/
```

### 4. ✅ VERIFICAR .ENV EN SERVIDOR:

**Confirmar que contiene:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://buro-v2.szystems.com  # o tu URL elegida

# BASE DE DATOS iPage
DB_HOST=szclinicascom.ipagemysql.com
DB_DATABASE=dbburonuevo
DB_USERNAME=sz
DB_PASSWORD=SPP7007aaa@@@

# CONFIGURACIÓN ANTI-ERROR 419
SESSION_DRIVER=file
LOG_LEVEL=error
CACHE_DRIVER=file
```

### 5. 🔧 CONFIGURAR .HTACCESS (SI NO EXISTE):

**Crear en `/buro-v2/public/.htaccess`:**
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Optimizaciones de seguridad
<Files .env>
    order allow,deny
    deny from all
</Files>
```

### 6. 🗄️ CONFIGURAR BASE DE DATOS:

#### Si necesitas ejecutar migraciones:
```bash
# Por SSH en iPage (si tienes acceso):
cd /public_html/buro-v2/
php artisan migrate --force

# O usar phpMyAdmin para importar SQL
```

### 7. 🧪 PRUEBAS INICIALES:

```
1. Acceder a: https://buro-v2.szystems.com
2. Verificar que carga sin errores
3. Probar login/logout
4. Verificar que no aparezca Error 419
5. Probar formularios principales
```

### 8. 📝 CONFIGURAR LOGS (OPCIONAL):

**En iPage File Manager:**
```bash
# Verificar que storage/logs/ tenga permisos
# Los logs se escribirán automáticamente
```

### 9. 🔄 CONFIGURAR DOMINIO PRINCIPAL (CUANDO TODO FUNCIONE):

```
1. En iPage → Domains
2. Redirigir burotributario.com → /buro-v2/public/
3. O actualizar DNS si usas dominio externo
```

### 🚨 ERRORES COMUNES Y SOLUCIONES:

#### Error 500:
```
- Verificar permisos storage/
- Revisar .env (especialmente DB_*)
- Comprobar .htaccess
```

#### Error 419:
```
- Confirmar SESSION_DRIVER=file
- Verificar SESSION_DOMAIN en .env
- Limpiar cache del navegador
```

#### "Application key not set":
```
- Verificar APP_KEY en .env
- Si falta: generar nueva clave
```

### ✅ CHECKLIST FINAL:

```
□ Permisos 755 en storage/
□ .env configurado correctamente
□ .htaccess en public/
□ URL de acceso funcionando
□ Base de datos conectada
□ Login/logout funcionando
□ Sin Error 419
□ Logs escribiéndose en storage/logs/
```

---

**🎯 ORDEN RECOMENDADO:**
1. Permisos → 2. .env → 3. URL acceso → 4. Pruebas → 5. Dominio final
