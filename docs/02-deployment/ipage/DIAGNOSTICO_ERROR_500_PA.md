# DIAGNÓSTICO ERROR 500 PA DESPUÉS DE ACTUALIZACIÓN DB

## Problema Actual
- ✅ Base de datos actualizada correctamente
- ❌ Error 500 persiste al acceder a pestaña PA
- ⚠️ Log muestra warnings de OPcache (no es la causa real)

## Posibles Causas del Error 500

### 1. **Cache de Laravel/OPcache**
El problema más probable es que Laravel/PHP está usando cache antigua de clases.

**Solución**:
```bash
# En el servidor iPage o via SSH:
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### 2. **Modelo RsatPa con tabla incorrecta**
El modelo `RsatPa` puede estar buscando tabla `rsat_pa` en lugar de `resolucins_pa`.

**Verificar en**: `app/Models/RsatPa.php`
```php
// Debe tener:
protected $table = 'resolucins_pa';
```

### 3. **Archivos Laravel no actualizados en iPage**
Los archivos PHP pueden estar desactualizados.

**Archivos críticos a verificar**:
- `app/Models/RsatPa.php`
- `app/Models/AudienciaPa.php`
- `app/Http/Controllers/Empresa/AudienciaPaController.php`

### 4. **Foreign Key Constraint Error**
Puede haber problemas con foreign keys en las nuevas tablas.

### 5. **Permisos de archivos en iPage**
Los archivos subidos pueden tener permisos incorrectos.

## Pasos de Diagnóstico

### PASO 1: Ejecutar diagnóstico DB
Ejecutar `DIAGNOSTICO_ERROR_500_PA.sql` para verificar que la base de datos esté correcta.

### PASO 2: Verificar logs de Laravel
**En iPage, buscar archivos de log más específicos**:
- `storage/logs/laravel.log`
- Error logs del panel de control de iPage

### PASO 3: Verificar modelo RsatPa
**Crear archivo de prueba** en iPage para verificar:
```php
<?php
// test_rsat_pa.php - Subir a raíz de iPage temporalmente
require_once 'vendor/autoload.php';

try {
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    
    // Probar modelo RsatPa
    $rsat = new App\Models\RsatPa();
    echo "Tabla RsatPa: " . $rsat->getTable() . "\n";
    echo "✅ Modelo RsatPa funciona correctamente\n";
    
} catch (Exception $e) {
    echo "❌ Error en RsatPa: " . $e->getMessage() . "\n";
}
?>
```

### PASO 4: Limpiar cache
**Si tienes acceso SSH o panel de control**:
```bash
# Eliminar archivos de cache
rm -rf storage/framework/cache/*
rm -rf storage/framework/views/*
rm -rf bootstrap/cache/*.php
```

### PASO 5: Verificar ruta PA
**Probar URL específica**:
```
/empresa/expcaso/pa/[ID_EMPRESA]
```

## Soluciones Rápidas

### Solución A: Actualizar modelo RsatPa
Si el modelo está mal configurado:
```php
// app/Models/RsatPa.php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RsatPa extends Model
{
    protected $table = 'resolucins_pa';  // ← CRÍTICO
    protected $fillable = [
        'numero_resolucion',
        'fecha_hora', 
        'tipo_resolucion',
        'tipo_resolucion_otro',
        'usuario_id',
        'audiencia_pa_id',
        'archivo',
        'tipo_archivo',
        'observaciones',
        'numero_folios'
    ];
}
```

### Solución B: Crear tabla rsat_pa alternativa
Si es más fácil, crear tabla con el nombre que espera el modelo:
```sql
CREATE TABLE `rsat_pa` LIKE `resolucins_pa`;
INSERT INTO `rsat_pa` SELECT * FROM `resolucins_pa`;
```

### Solución C: Verificar controlador PA
**Verificar**: `app/Http/Controllers/Empresa/AudienciaPaController.php`

## Próximos Pasos

1. **Ejecutar**: `DIAGNOSTICO_ERROR_500_PA.sql`
2. **Verificar**: Logs específicos de Laravel en iPage
3. **Probar**: Archivo de prueba para modelo RsatPa
4. **Limpiar**: Cache de Laravel/PHP

---
**Estado**: Aguardando diagnóstico para identificar causa específica del Error 500
**Prioridad**: Alta - Funcionalidad PA inaccesible
