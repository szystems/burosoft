# 📋 GUÍA DE SUBIDA A iPage - PROYECTO BURO
## Carpetas y Archivos Esenciales

### ✅ CARPETAS OBLIGATORIAS (SUBIR):

```
📁 app/                    # ← CORE de Laravel
📁 bootstrap/              # ← Archivos de arranque
📁 config/                 # ← Configuraciones
📁 database/               # ← Migraciones y seeders
📁 public/                 # ← RAÍZ WEB (crítico)
📁 resources/              # ← Views, CSS, JS compilado
📁 routes/                 # ← Rutas de la aplicación
📁 storage/                # ← Logs, cache, sesiones
📁 vendor/                 # ← Dependencias Composer
```

### ❌ CARPETAS QUE NO DEBES SUBIR:

```
❌ node_modules/          # ← MUY GRANDE, se regenera
❌ .git/                  # ← Control de versiones
❌ tests/                 # ← Tests unitarios (opcional)
❌ .vscode/               # ← Configuración editor
❌ .idea/                 # ← Configuración IDE
```

### 📄 ARCHIVOS RAÍZ OBLIGATORIOS:

```
✅ .env                   # ← Tu .env.produccion-ipage renombrado
✅ artisan                # ← Comando Laravel
✅ composer.json          # ← Dependencias PHP
✅ composer.lock          # ← Versiones exactas
✅ package.json           # ← Info de Node (referencia)
✅ webpack.mix.js         # ← Configuración assets
✅ server.php             # ← Servidor PHP alternativo
```

### 🚫 ARCHIVOS QUE NO SUBIR:

```
❌ .env.example           # ← Solo plantilla
❌ .env.produccion-ipage  # ← Renombrar a .env
❌ .gitignore             # ← Control de versiones
❌ README.md              # ← Documentación
❌ *.sh                   # ← Scripts de desarrollo
❌ *.md                   # ← Documentación markdown
```

### 📦 ESTRUCTURA FINAL EN iPage:

```
/public_html/buro-v2/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/              # ← ESTA será tu raíz web
│   ├── index.php        # ← Punto de entrada
│   ├── .htaccess        # ← Reescritura URLs
│   ├── css/
│   ├── js/
│   ├── img/
│   └── assets/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env                 # ← Tu configuración optimizada
├── artisan
├── composer.json
├── composer.lock
└── server.php
```

### ⚡ COMANDOS PARA PREPARAR SUBIDA:

```bash
# 1. COPIAR .env optimizado
cp .env.produccion-ipage .env

# 2. COMPILAR ASSETS (si usas Mix)
npm run production

# 3. OPTIMIZAR COMPOSER (remover dev)
composer install --no-dev --optimize-autoloader

# 4. LIMPIAR CACHE
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 📋 CHECKLIST ANTES DE SUBIR:

```
✅ .env configurado con datos iPage
✅ APP_ENV=production
✅ APP_DEBUG=false
✅ Base de datos iPage configurada
✅ Assets compilados (npm run production)
✅ Composer optimizado (--no-dev)
✅ Cache generado
✅ vendor/ incluido
❌ node_modules/ excluido
❌ .git/ excluido
❌ tests/ excluido
```

### 🎯 TAMAÑO APROXIMADO:

```
📁 vendor/        ~50-100 MB
📁 app/           ~5-10 MB
📁 public/        ~10-20 MB
📁 resources/     ~5-10 MB
📁 storage/       ~1-5 MB
📁 otras/         ~5-10 MB
─────────────────────────
TOTAL:           ~75-155 MB
```

**🚀 SIN node_modules (que serían ~200-500 MB adicionales)**
