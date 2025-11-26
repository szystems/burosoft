#!/bin/bash
# ============================================
# Script de Optimización Post-Despliegue
# Para ejecutar después de subir archivos por FTP
# ============================================

echo "====================================="
echo "Optimizando Laravel en Producción..."
echo "====================================="

# Limpiar todas las cachés
echo "1. Limpiando cachés..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# Cachear configuraciones para mejor rendimiento
echo "2. Cacheando configuraciones..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Optimizar autoloader de Composer
echo "3. Optimizando autoloader..."
composer dump-autoload --optimize --no-dev

# Optimizar aplicación
echo "4. Optimizando aplicación..."
php artisan optimize

# Verificar permisos de storage y bootstrap/cache
echo "5. Verificando permisos..."
chmod -R 775 storage bootstrap/cache
chmod -R 775 storage/logs
chmod -R 775 storage/framework/sessions
chmod -R 775 storage/framework/views
chmod -R 775 storage/framework/cache

echo ""
echo "====================================="
echo "✓ Optimización completada!"
echo "====================================="
echo ""
echo "Verificar:"
echo "- Permisos de directorios (775 o 755)"
echo "- Archivo .env configurado correctamente"
echo "- Base de datos accesible"
echo ""
