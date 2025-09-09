<?php
// VERIFICADOR CONFIG/APP.PHP - check-config.php
// Subir como /szystems/buro-v2/public/check-config.php

echo "<h1>🔍 VERIFICADOR CONFIG/APP.PHP</h1>";

// Cambiar al directorio raíz
chdir('..');

echo "<h2>1. ANALIZANDO CONFIG/APP.PHP:</h2>";

if(file_exists('config/app.php')) {
    $configContent = file_get_contents('config/app.php');
    
    echo "<h3>Providers críticos en config:</h3>";
    
    $providers = [
        'SessionServiceProvider' => 'Illuminate\Session\SessionServiceProvider',
        'ViewServiceProvider' => 'Illuminate\View\ViewServiceProvider',
        'CookieServiceProvider' => 'Illuminate\Cookie\CookieServiceProvider',
        'EncryptionServiceProvider' => 'Illuminate\Encryption\EncryptionServiceProvider',
        'HashServiceProvider' => 'Illuminate\Hashing\HashServiceProvider'
    ];
    
    foreach($providers as $name => $class) {
        if(strpos($configContent, $class) !== false) {
            // Verificar si está comentado
            $lines = explode("\n", $configContent);
            $commented = false;
            foreach($lines as $line) {
                if(strpos($line, $class) !== false && strpos(trim($line), '//') === 0) {
                    $commented = true;
                    break;
                }
            }
            
            if($commented) {
                echo "⚠️ $name: EXISTE pero está COMENTADO<br>";
            } else {
                echo "✅ $name: ACTIVO<br>";
            }
        } else {
            echo "❌ $name: NO ENCONTRADO<br>";
        }
    }
    
    echo "<h3>Sección de providers:</h3>";
    
    // Extraer sección de providers
    if(preg_match("/\'providers\'\s*=>\s*\[(.*?)\]/s", $configContent, $matches)) {
        $providersSection = $matches[1];
        echo "<pre style='background:#f5f5f5; padding:10px; max-height:400px; overflow:auto;'>";
        echo htmlspecialchars($providersSection);
        echo "</pre>";
    } else {
        echo "❌ No se pudo extraer sección de providers<br>";
    }
    
} else {
    echo "❌ config/app.php no existe<br>";
}

echo "<h2>2. VERIFICANDO OTROS CONFIGS:</h2>";

$configs = ['session.php', 'cache.php', 'database.php'];
foreach($configs as $config) {
    $path = "config/$config";
    if(file_exists($path)) {
        echo "✅ $config existe<br>";
    } else {
        echo "❌ $config NO existe<br>";
    }
}

echo "<h2>3. BOOTSTRAP/APP.PHP:</h2>";

if(file_exists('bootstrap/app.php')) {
    $bootstrap = file_get_contents('bootstrap/app.php');
    echo "✅ bootstrap/app.php existe<br>";
    
    // Verificar estructura básica
    if(strpos($bootstrap, '$app = new Illuminate\Foundation\Application') !== false) {
        echo "✅ Application instance OK<br>";
    } else {
        echo "❌ Application instance problema<br>";
    }
    
    if(strpos($bootstrap, 'singleton') !== false) {
        echo "✅ Singleton bindings OK<br>";
    } else {
        echo "❌ Singleton bindings problema<br>";
    }
    
} else {
    echo "❌ bootstrap/app.php no existe<br>";
}

echo "<hr>";
echo "<h2>🔧 RECOMENDACIONES:</h2>";
echo "<ol>";
echo "<li>Si providers están comentados → Descomentarlos</li>";
echo "<li>Si faltan providers → Agregarlos a config/app.php</li>";
echo "<li>Ejecutar fix-session.php después</li>";
echo "</ol>";
?>
