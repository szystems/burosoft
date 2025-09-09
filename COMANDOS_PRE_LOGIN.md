# 🔧 COMANDOS PHP PRE-LOGIN - PROYECTO BURO
## Secuencia Obligatoria en Servidor iPage

### ⚡ COMANDOS ARTISAN CRÍTICOS:

#### 1. 🧹 LIMPIAR CACHE COMPLETO:
```bash
# En el servidor iPage (por SSH o File Manager con terminal):
cd /public_html/szystems/buro-v2/

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
```

#### 2. 🔄 REGENERAR CACHE OPTIMIZADO:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 3. 🗄️ VERIFICAR/EJECUTAR MIGRACIONES:
```bash
# Verificar estado de migraciones
php artisan migrate:status

# Si hay migraciones pendientes:
php artisan migrate --force
```

#### 4. 🔑 VERIFICAR APP_KEY (si es necesario):
```bash
# Solo si APP_KEY está vacío
php artisan key:generate --force
```

#### 5. 🔧 VERIFICAR CONFIGURACIÓN:
```bash
# Confirmar configuraciones críticas
php artisan tinker --execute="echo 'SESSION_DRIVER: ' . config('session.driver');"
php artisan tinker --execute="echo 'APP_URL: ' . config('app.url');"
php artisan tinker --execute="echo 'DB_CONNECTION: ' . config('database.default');"
```

### 📁 VERIFICAR PERMISOS (CRÍTICO):

```bash
# Asegurar permisos correctos
chmod 755 storage/
chmod 755 storage/app/
chmod 755 storage/framework/
chmod 755 storage/framework/cache/
chmod 755 storage/framework/sessions/
chmod 755 storage/framework/views/
chmod 755 storage/logs/
chmod 755 bootstrap/cache/
```

### 🧪 TEST DE CONEXIÓN DB:

```bash
# Probar conexión a base de datos
php artisan tinker --execute="DB::connection()->getPdo(); echo 'DB Connected!';"
```

### ⚠️ SI NO TIENES SSH - ALTERNATIVA:

#### Crear archivo `setup.php` temporal:
```php
<?php
// Archivo temporal para setup
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "Limpiando cache...\n";
$kernel->call('cache:clear');
$kernel->call('config:clear');
$kernel->call('route:clear');
$kernel->call('view:clear');

echo "Regenerando cache...\n";
$kernel->call('config:cache');
$kernel->call('route:cache');

echo "Verificando migraciones...\n";
$kernel->call('migrate:status');

echo "Setup completado!\n";
```

### 📋 CHECKLIST PRE-LOGIN:

```
□ .env copiado como archivo activo
□ cache:clear ejecutado
□ config:clear ejecutado
□ route:clear ejecutado
□ view:clear ejecutado
□ config:cache regenerado
□ route:cache regenerado
□ Permisos storage/ verificados
□ APP_KEY configurado
□ DB conexión verificada
□ Migraciones ejecutadas (si necesario)
```

### 🎯 ORDEN RECOMENDADO:

```
1. Copiar .env.produccion-ipage como .env
2. Ejecutar comandos de limpieza
3. Regenerar cache
4. Verificar permisos
5. Probar conexión DB
6. Ejecutar migraciones si es necesario
7. PROBAR LOGIN
```

---

**🚀 DESPUÉS DE ESTOS COMANDOS:**
**Tu aplicación estará lista para login sin Error 419**
