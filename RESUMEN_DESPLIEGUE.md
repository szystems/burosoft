# ============================================
# RESUMEN DE ARCHIVOS PARA DESPLIEGUE
# ============================================

## 📁 ARCHIVOS CREADOS

1. **.env.produccion**
   - Archivo de configuración optimizado para iPage
   - Renombrar a `.env` antes de subir
   - ⚠️ Verificar credenciales de BD

2. **GUIA_DESPLIEGUE_IPAGE.md**
   - Guía completa paso a paso
   - Solución de problemas comunes
   - Configuración detallada

3. **CHECKLIST_DESPLIEGUE.md**
   - Lista de verificación completa
   - Uso para cada despliegue
   - Documentar problemas encontrados

4. **deploy-optimize.sh / deploy-optimize.bat**
   - Scripts de optimización
   - Ejecutar después de despliegue
   - Windows y Linux compatible

5. **optimize-server.php**
   - Optimización vía web (sin SSH)
   - Subir a `public/`
   - ⚠️ ELIMINAR después de usar

6. **public/.htaccess.produccion**
   - .htaccess optimizado para producción
   - Incluye seguridad adicional
   - Renombrar a `.htaccess`

7. **storage/.htaccess**
   - Protección del directorio storage
   - Previene acceso directo
   - Subir tal cual

## 🚀 ORDEN DE EJECUCIÓN

### 1. PREPARACIÓN LOCAL
```bash
# Instalar dependencias de producción
composer install --optimize-autoloader --no-dev

# Compilar assets (si aplica)
npm run build

# Copiar archivo de entorno
copy .env.produccion .env
```

### 2. SUBIR ARCHIVOS POR FTP
- Crear carpeta `/appburo/` en servidor
- Subir todos los archivos EXCEPTO `.env`
- Subir `.env` al final manualmente

### 3. CONFIGURAR SERVIDOR
- Document root: `/home/[usuario]/appburo/public`
- Permisos 775: `storage/` y `bootstrap/cache/`

### 4. OPTIMIZAR
**Opción A - Con SSH:**
```bash
cd appburo
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

**Opción B - Sin SSH:**
- Subir `optimize-server.php` a `public/`
- Visitar: `https://appburo.burotributario.com/optimize-server.php`
- Eliminar archivo después

### 5. VERIFICAR
- [ ] Aplicación carga
- [ ] Login funciona
- [ ] PDFs se generan
- [ ] No hay errores en logs

## ⚠️ IMPORTANTE

### ANTES de subir archivos:
1. Backup de la aplicación actual
2. Backup de la base de datos
3. Revisar que todo funciona localmente
4. Tener plan de rollback

### DESPUÉS de subir archivos:
1. Verificar permisos
2. Ejecutar optimizaciones
3. Probar funcionalidades críticas
4. Revisar logs
5. Monitorear primeras horas

## 📞 SOPORTE

Si algo sale mal:

1. **Error 500**
   - Revisar permisos de `storage/`
   - Revisar `.env` existe y es válido
   - Revisar logs: `storage/logs/laravel.log`

2. **Error 419 (CSRF)**
   - Verificar configuración de sesiones
   - Limpiar caché: `php artisan cache:clear`
   - Verificar permisos: `storage/framework/sessions/`

3. **Error 404**
   - Verificar `.htaccess` en `public/`
   - Verificar document root apunta a `public/`
   - Contactar soporte iPage

4. **Base de datos no conecta**
   - Verificar credenciales en `.env`
   - Verificar host: `szclinicascom.ipagemysql.com`
   - Verificar base de datos existe

## 📋 CHECKLIST RÁPIDO

- [ ] Archivos subidos
- [ ] `.env` configurado
- [ ] Permisos correctos
- [ ] Document root correcto
- [ ] Optimización ejecutada
- [ ] Aplicación funciona
- [ ] Logs sin errores
- [ ] `optimize-server.php` eliminado (si se usó)

---

**Todo listo para despliegue en iPage** ✅
