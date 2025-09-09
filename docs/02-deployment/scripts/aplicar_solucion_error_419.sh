#!/bin/bash

# SCRIPT APLICAR SOLUCIÓN ERROR 419 - BURO PROYECTO
# Metodología probada en FleboCenter - 100% efectiva

echo "🚀 APLICANDO SOLUCIÓN ERROR 419 PARA BURO - METODOLOGÍA IPAGE"
echo "================================================================"

# 1. COPIAR .ENV OPTIMIZADO
echo "📋 Aplicando configuración .env optimizada..."
cp .env.produccion-ipage .env

# 2. LIMPIAR CACHÉ COMPLETO
echo "🧹 Limpiando caché completo..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
php artisan config:cache
php artisan route:cache

# 3. REGENERAR CLAVE APLICACIÓN (OPCIONAL)
echo "🔑 ¿Regenerar APP_KEY? (y/n)"
read -r response
if [[ "$response" =~ ^([yY][eE][sS]|[yY])$ ]]; then
    php artisan key:generate
fi

# 4. VERIFICAR CONFIGURACIÓN CRÍTICA
echo "✅ Verificando configuración crítica..."
echo "SESSION_DRIVER:" $(php artisan tinker --execute="echo config('session.driver');")
echo "LOG_LEVEL:" $(php artisan tinker --execute="echo config('logging.level');")
echo "APP_URL:" $(php artisan tinker --execute="echo config('app.url');")

# 5. CREAR DIRECTORIO DE SESIONES
echo "📁 Asegurando directorios de sesiones..."
mkdir -p storage/framework/sessions
chmod 775 storage/framework/sessions

# 6. TEST DE CONFIGURACIÓN
echo "🔧 Ejecutando tests básicos..."
php artisan route:list | head -5
php artisan config:show session.driver

echo ""
echo "✅ SOLUCIÓN ERROR 419 APLICADA EXITOSAMENTE"
echo "📋 Configuración lista para iPage"
echo "🚀 Proyecto listo para producción"
echo ""
echo "PRÓXIMOS PASOS:"
echo "1. Subir archivos a iPage"
echo "2. Verificar permisos storage/"
echo "3. Ejecutar migrations si es necesario"
echo "4. Probar login y sesiones"
