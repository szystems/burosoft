# Corrección Campo numero_documento - Modelo EvPa

## ❌ **Error Original:**
```
SQLSTATE[HY000]: General error: 1364 Field 'numero_documento' doesn't have a default value
```

## 🔍 **Problema Identificado:**
- **Base de datos** requiere campo `numero_documento` (no nullable)
- **Controlador** no enviaba este campo en el INSERT
- **Modales** no tenían input para `numero_documento`
- **Vista** mostraba campo incorrecto

## ✅ **Correcciones Aplicadas:**

### 1. **addevmodal.blade.php**
```blade
<!-- AGREGADO: -->
<div class="col-md-6 mb-3">
    <label for="numero_documento" class="form-label">No. de Documento</label>
    <input type="text" name="numero_documento" class="form-control" value="{{ old('numero_documento') }}" required>
    @if ($errors->has('numero_documento'))
        <span class="help-block opacity-7">
            <strong>
                <font color="red">{{ $errors->first('numero_documento') }}</font>
            </strong>
        </span>
    @endif
</div>
```

### 2. **editevmodal.blade.php**
```blade
<!-- AGREGADO: -->
<div class="col-md-6 mb-3">
    <label for="numero_documento" class="form-label">No. de Documento</label>
    <input type="text" name="numero_documento" class="form-control" value="{{ $ev->numero_documento }}" required>
    <!-- ... validación ... -->
</div>
```

### 3. **EvPaController.php**
```php
// AGREGADO en validación:
'numero_documento' => 'required|string|max:255',

// AGREGADO en insert():
$evPa->numero_documento = $request->numero_documento;

// AGREGADO en update():
$evPa->numero_documento = $request->numero_documento;
```

### 4. **showaudiencia.blade.php**
```blade
<!-- ANTES (incorrecto): -->
<td>{{ $ev->numero_escrito }}</td>

<!-- DESPUÉS (corregido): -->
<td>{{ $ev->numero_documento }}</td>
```

## 📋 **Estructura Final del Modelo EvPa:**

```php
protected $fillable = [
    'fecha_hora_presentacion',  // ✅ Mapeado desde 'fecha' en formulario
    'numero_documento',         // ✅ Ahora incluido en formularios
    'usuario_id',               // ✅ Auto-asignado
    'audiencia_pa_id',          // ✅ Hidden input
    'archivo',                  // ✅ File upload
    'tipo_archivo',             // ✅ Auto-generado
    'observaciones',            // ✅ Textarea opcional
    'numero_folios',            // ✅ Number input opcional
];
```

## 🎯 **Resultado:**
- ✅ **Error SQL eliminado**
- ✅ **Campo numero_documento requerido incluido**
- ✅ **Formularios completos**
- ✅ **Vista sincronizada**

**Estado**: 🚀 **MODELO EvPa COMPLETAMENTE FUNCIONAL CON TODOS LOS CAMPOS**
