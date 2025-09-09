<?php
// Archivo para mostrar información de PHP
// Solo debe usarse en desarrollo, NUNCA en producción por seguridad

// Verificar que no estemos en producción
if (env('APP_ENV') === 'production') {
    die('Esta página no está disponible en producción por razones de seguridad.');
}

// Mostrar toda la información de PHP
phpinfo();
?>