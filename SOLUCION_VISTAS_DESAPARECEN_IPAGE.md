# SOLUCIÓN: Vistas se Ocultan en iPage

## 🐛 Problema
Al iniciar sesión en iPage, el panel de control aparece momentáneamente pero las vistas se ocultan casi instantáneamente, dejando solo los layouts visibles.

## 🔍 Causa Raíz PRINCIPAL
**Tracking Prevention bloqueando localStorage/sessionStorage:**

El navegador (Edge/Safari con Tracking Prevention activado) está bloqueando el acceso a `localStorage` y `sessionStorage`, causando múltiples errores:

```
Tracking Prevention blocked access to storage for <URL>. (x50+)
```

El archivo `modernizr.js` intenta detectar capacidades del navegador usando:
```javascript
localStorage.setItem(h,h)
sessionStorage.setItem(h,h)
```

Cuando estos fallan por el bloqueo de Tracking Prevention, causan errores en cascada que rompen la funcionalidad de JavaScript.

## 🔍 Causa Raíz Secundaria
El archivo `public/dashboardtemplate/design/assets/js/main.js` también contenía este código:

```javascript
$("#loading-wrapper").fadeOut(2000);
```

Este código intenta ocultar un elemento `#loading-wrapper` que **está comentado** en el layout `resources/views/layouts/empresa.blade.php` (líneas 72-82).

Cuando jQuery intenta manipular un elemento que no existe, puede causar errores silenciosos que interrumpen la ejecución de otros scripts, causando comportamientos inesperados en la UI.

## ✅ Solución Implementada

### 🎯 Solución 1: Deshabilitar modernizr.js (PRINCIPAL - IMPLEMENTADA)

**Archivos modificados:**
- `resources/views/layouts/empresa.blade.php` (línea ~110)
- `resources/views/layouts/admin.blade.php` (línea ~105)

**Cambio:**
```blade
{{-- Modernizr deshabilitado: causa problemas con Tracking Prevention --}}
{{-- <script src="{{ asset('dashboardtemplate/design/assets/js/modernizr.js') }}"></script> --}}
```

**Por qué funciona:**
- Modernizr intenta usar localStorage/sessionStorage para detectar capacidades
- Tracking Prevention bloquea estos intentos
- Los errores resultantes rompen la ejecución de JavaScript
- Al deshabilitar modernizr, eliminamos la fuente de errores

### 🔧 Solución 2: Verificar Existencia del Elemento (SECUNDARIA - IMPLEMENTADA)
Modificamos `public/dashboardtemplate/design/assets/js/main.js` para verificar si el elemento existe antes de manipularlo:

```javascript
// Loading
$(function () {
	// Verificar si el elemento existe antes de intentar ocultarlo
	if ($("#loading-wrapper").length) {
		$("#loading-wrapper").fadeOut(2000);
	}
});
```

### 📝 Opción Alternativa: Descomentar el Loading Wrapper
Si prefieres tener el loading wrapper visible, descomenta estas líneas en `resources/views/layouts/empresa.blade.php`:

```blade
<div id="loading-wrapper">
	<div class="spinner">
		<div class="line1"></div>
		<div class="line2"></div>
		<div class="line3"></div>
		<div class="line4"></div>
		<div class="line5"></div>
		<div class="line6"></div>
	</div>
</div>
```

## 🚀 Pasos para Aplicar en iPage

1. **Subir archivos corregidos via FTP:**
   ```bash
   # Archivos a subir:
   public/dashboardtemplate/design/assets/js/main.js
   resources/views/layouts/empresa.blade.php
   resources/views/layouts/admin.blade.php
   public/clear-cache.php  # Script de limpieza
   ```

2. **Limpiar caché de Laravel profundamente:**
   - Subir `public/clear-cache.php` al servidor
   - Visitar: `https://appburo.burotributario.com/clear-cache.php`
   - Esperar que complete todas las operaciones
   - **⚠️ ELIMINAR el archivo inmediatamente** después de usar
   
3. **Limpiar caché del navegador:**
   - Ctrl + F5 (Windows) o Cmd + Shift + R (Mac)
   - O usar modo incógnito
   - **IMPORTANTE:** Deshabilitar Tracking Prevention temporalmente para probar:
     - Edge: Settings → Privacy → Tracking Prevention → Basic
     - Safari: Preferences → Privacy → Desmarcar "Prevent cross-site tracking"

4. **Verificar funcionalidad:**
   - Iniciar sesión
   - Verificar que las vistas permanecen visibles
   - Abrir consola del navegador (F12) → Console
   - **NO debe haber errores de "Tracking Prevention blocked"**
   - Verificar que no hay otros errores JavaScript

## 🔍 Depuración Adicional

Si el problema persiste, verificar en la consola del navegador (F12):

1. **Errores de JavaScript:**
   - Abrir Consola (Console)
   - Buscar errores en rojo

2. **Errores de carga de recursos:**
   - Abrir Network
   - Buscar archivos .js o .css con error 404

3. **Rutas de assets:**
   - Verificar que `APP_URL` en `.env` es correcto:
     ```env
     APP_URL=https://appburo.burotributario.com
     ```

## ⚠️ Problemas Comunes en iPage

1. **Rutas de assets incorrectas:**
   - Usar `{{ asset() }}` helper siempre
   - Verificar APP_URL en .env

2. **jQuery no carga:**
   - Verificar CDN accesible
   - Verificar orden de carga de scripts

3. **Conflictos de versiones:**
   - Bootstrap 4.5.3 cargado
   - jQuery 3.7.1 cargado
   - Verificar compatibilidad

## 📋 Checklist de Verificación

- [x] modernizr.js deshabilitado en layouts
- [x] main.js corregido con verificación de existencia
- [ ] Archivos subidos a iPage via FTP
- [ ] Caché del navegador limpiado
- [ ] Tracking Prevention configurado correctamente
- [ ] Login funcional
- [ ] Vistas permanecen visibles
- [ ] Sin errores "Tracking Prevention blocked" en consola
- [ ] Sin errores JavaScript en consola

---

**Fecha:** 25 de noviembre de 2025
**Archivo modificado:** `public/dashboardtemplate/design/assets/js/main.js`
**Línea:** 3
