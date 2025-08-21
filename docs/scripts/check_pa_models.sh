#!/bin/bash

echo "Verificando modelos PA..."

models=("AdpmrPa" "AmpmrPa" "DpmrPa" "EcPa" "EvPa" "MpmrPa" "NtrrPa" "NulidadPa" "OcursoPa" "PpPa" "RrPa" "RoPa" "RsatPa" "RtributaPa" "AudienciaPa")

for model in "${models[@]}"; do
    if [ -f "app/Models/${model}.php" ]; then
        echo "✅ $model - EXISTS"
    else
        echo "❌ $model - MISSING"
    fi
done
