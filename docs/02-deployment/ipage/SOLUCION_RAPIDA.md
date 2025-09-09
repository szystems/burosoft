# Instrucciones para copiar configuración de asonatanuevo a burosoftnuevo

## 🔄 PASOS INMEDIATOS:

### 1. BACKUP ACTUAL
- Respalda: burosoftnuevo/public/.htaccess → .htaccess.backup
- Respalda: burosoftnuevo/public/.user.ini → .user.ini.backup (si existe)

### 2. COPIAR DESDE ASONATANUEVO
- Copia: asonatanuevo/public/.htaccess → burosoftnuevo/public/.htaccess
- Elimina: burosoftnuevo/public/.user.ini (si existe)

### 3. VERIFICAR PERMISOS
- burosoftnuevo/storage/: 0755 (como asonatanuevo)
- burosoftnuevo/storage/logs/: 0755
- burosoftnuevo/storage/framework/: 0755 recursivo

### 4. PROBAR INMEDIATAMENTE
- https://szystems.com/burosoftnuevo/public/

## 🎯 CAUSA MÁS PROBABLE:
- .user.ini personalizado está causando conflictos
- .htaccess modificado tiene reglas problemáticas

## ✅ RESULTADO ESPERADO:
Si el problema es configuración, debería funcionar inmediatamente.
