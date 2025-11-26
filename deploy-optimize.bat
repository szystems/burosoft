@echo off
REM ============================================
REM Script de Optimización Post-Despliegue (Windows)
REM Para ejecutar después de subir archivos por FTP
REM ============================================

echo =====================================
echo Optimizando Laravel en Producción...
echo =====================================

REM Limpiar todas las cachés
echo 1. Limpiando cachés...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

REM Cachear configuraciones para mejor rendimiento
echo 2. Cacheando configuraciones...
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

REM Optimizar autoloader de Composer
echo 3. Optimizando autoloader...
composer dump-autoload --optimize --no-dev

REM Optimizar aplicación
echo 4. Optimizando aplicación...
php artisan optimize

echo.
echo =====================================
echo √ Optimización completada!
echo =====================================
echo.
echo Verificar en el servidor:
echo - Permisos de directorios (775 o 755)
echo - Archivo .env configurado correctamente
echo - Base de datos accesible
echo.
pause
