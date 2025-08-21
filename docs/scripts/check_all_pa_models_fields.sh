#!/bin/bash

echo "Verificando consistencia de campos en todos los controladores PA..."

CONTROLLERS_DIR="app/Http/Controllers"
MODELS_DIR="app/Models"

echo "Revisando campos en controladores PA..."

# Buscar posibles problemas de campo en todos los controladores PA
for controller in $(find $CONTROLLERS_DIR -name "*PaController.php"); do
    controller_name=$(basename "$controller" .php)
    echo "Revisando $controller_name:"
    
    # Buscar usos de request() y campos específicos
    if grep -q "fecha_hora_presentacion\|numero_documento" "$controller"; then
        echo "  ⚠️  Encontrados campos problemáticos en $controller_name"
        grep -n "fecha_hora_presentacion\|numero_documento" "$controller"
    else
        echo "  ✅ No se encontraron campos problemáticos en $controller_name"
    fi
done

echo -e "\nVerificando modelos PA existentes..."

for model in AdpmrPa AmpmrPa RsatPa DpmrPa EscritoPa PpmrPa SrdmrPa CdmrPa EaPa RrPa CeduPa CcPa PrPa ApPa EapPa; do
    if [ -f "$MODELS_DIR/${model}.php" ]; then
        echo "✅ Modelo $model existe"
    else
        echo "❌ Modelo $model NO existe"
    fi
done
