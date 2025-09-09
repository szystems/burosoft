# 📋 PLAN DE DESPLIEGUE SEGURO - PROYECTO BURO
## Estrategia de Carpeta Nueva en iPage

### 🎯 ESTRUCTURA RECOMENDADA:

```
/public_html/
├── burosoftnuevo/           # ← ACTUAL (mantener como backup)
├── buro-v2/                 # ← NUEVA VERSIÓN (crear esta)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/              # ← Esta será la raíz web
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   └── vendor/
└── otros-proyectos/
```

### 📝 PASOS RECOMENDADOS:

#### 1. **CREAR CARPETA NUEVA:**
```bash
# En iPage File Manager o FTP:
/public_html/buro-v2/
```

#### 2. **SUBIR PROYECTO COMPLETO:**
- Subir todo el contenido del proyecto a `/buro-v2/`
- Configurar subdomain o carpeta temporal para pruebas

#### 3. **CONFIGURAR ACCESO TEMPORAL:**
```
URL TEMPORAL: https://szystems.com/buro-v2/public/
```

#### 4. **PROBAR COMPLETAMENTE:**
- ✅ Login/logout
- ✅ Funcionalidades principales
- ✅ Base de datos
- ✅ Sesiones (sin Error 419)
- ✅ CSRF tokens

#### 5. **CAMBIAR SUBDOMAIN/DOMINIO:**
Una vez probado, redirigir:
```
burotributario.com → /buro-v2/public/
```

#### 6. **MANTENER BACKUP:**
```
burosoftnuevo/ → backup-anterior/
```

### 🔧 CONFIGURACIÓN .HTACCESS PARA BURO-V2:

```apache
# /public_html/buro-v2/public/.htaccess
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
```

### ⚡ VENTAJAS DE CARPETA NUEVA:

1. **✅ CERO DOWNTIME** - La versión actual sigue funcionando
2. **✅ PRUEBAS COMPLETAS** - Puedes probar todo antes del switch
3. **✅ ROLLBACK RÁPIDO** - Si algo falla, cambias de vuelta
4. **✅ BACKUP AUTOMÁTICO** - La versión anterior queda como respaldo
5. **✅ MIGRACIÓN GRADUAL** - Puedes mover usuarios progresivamente

### 🎯 CRONOGRAMA RECOMENDADO:

```
DÍA 1: Crear buro-v2/ y subir archivos
DÍA 2: Configurar y probar funcionalidades
DÍA 3: Pruebas completas con usuarios test
DÍA 4: Switch de dominio principal
DÍA 5: Monitoreo y backup anterior
```

### 📞 URL DE PRUEBA:
```
https://szystems.com/buro-v2/public/
```

---

**🏆 RECOMENDACIÓN FINAL: CARPETA NUEVA (buro-v2)**
**✅ Máxima seguridad y cero riesgo de pérdida de datos**
