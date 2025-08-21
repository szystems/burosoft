#!/bin/bash

echo "Corrigiendo IDs de modales de agregar PA..."

BASE_DIR="resources/views/empresa/expcaso/pa"

# Función para verificar y corregir IDs de modales add
fix_add_modal_ids() {
    local module=$1
    local modal_file="$BASE_DIR/$module/add${module}modal.blade.php"
    
    if [ -f "$modal_file" ]; then
        # Cambiar de addXxxModal a addXxxPaModal
        sed -i "s/id=\"add${module^}Modal\"/id=\"add${module^}PaModal\"/g" "$modal_file"
        sed -i "s/aria-labelledby=\"add${module^}Modal\"/aria-labelledby=\"add${module^}PaModal\"/g" "$modal_file"
        sed -i "s/id=\"add${module^}Modal\"/id=\"add${module^}PaModal\"/g" "$modal_file"
        echo "  - Corregido: $modal_file"
    fi
}

# Corregir todos los módulos (ya corregimos EV manualmente)
fix_add_modal_ids "dpmr"
fix_add_modal_ids "adpmr"
fix_add_modal_ids "resolucion"
fix_add_modal_ids "rtributa"
fix_add_modal_ids "nulidad"
fix_add_modal_ids "ec"
fix_add_modal_ids "rr"
fix_add_modal_ids "ntrr"
fix_add_modal_ids "ocurso"
fix_add_modal_ids "ro"
fix_add_modal_ids "mpmr"
fix_add_modal_ids "ampmr"

echo "IDs de modales de agregar PA corregidos!"
