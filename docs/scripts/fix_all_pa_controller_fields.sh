#!/bin/bash

echo "Corrigiendo campos en TODOS los controladores PA..."

CONTROLLERS_DIR="app/Http/Controllers/Empresa"

# Función para corregir campos básicos (fecha_hora_presentacion -> fecha, numero_documento -> numero_escrito)
fix_basic_fields() {
    local controller_file="$1"
    echo "  Corrigiendo campos básicos en $(basename "$controller_file")..."
    
    # Cambiar fecha_hora_presentacion por fecha
    sed -i "s/'fecha_hora_presentacion'/'fecha'/g" "$controller_file"
    sed -i 's/fecha_hora_presentacion/fecha/g' "$controller_file"
    
    # Cambiar numero_documento por numero_escrito
    sed -i "s/'numero_documento'/'numero_escrito'/g" "$controller_file"
    sed -i 's/numero_documento/numero_escrito/g' "$controller_file"
}

# Función para casos especiales
fix_special_cases() {
    local controller_file="$1"
    local controller_name=$(basename "$controller_file" .php)
    
    case "$controller_name" in
        "AdpmrPaController"|"AmpmrPaController")
            echo "  Aplicando corrección especial para $controller_name (numero_contestacion)..."
            # Estos usan numero_contestacion en lugar de numero_escrito
            sed -i "s/'numero_escrito'/'numero_contestacion'/g" "$controller_file"
            sed -i 's/numero_escrito/numero_contestacion/g' "$controller_file"
            ;;
        "EvPaController")
            echo "  Aplicando corrección especial para $controller_name (solo fecha)..."
            # EvPa solo necesita fecha, quitar validaciones de numero_escrito
            sed -i "/'numero_escrito'/d" "$controller_file"
            ;;
    esac
}

# Procesar todos los controladores PA problemáticos
for controller in AdpmrPaController AmpmrPaController DpmrPaController EcPaController EvPaController MpmrPaController NtrrPaController NulidadPaController OcursoPaController PpPaController RoPaController RrPaController RtributaPaController; do
    controller_file="$CONTROLLERS_DIR/${controller}.php"
    
    if [ -f "$controller_file" ]; then
        echo "Procesando $controller..."
        fix_basic_fields "$controller_file"
        fix_special_cases "$controller_file"
        echo "  ✅ $controller corregido"
    else
        echo "  ❌ $controller no encontrado"
    fi
done

echo "¡Corrección de campos completada!"
