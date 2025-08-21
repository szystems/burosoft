#!/bin/bash

echo "Corrigiendo IDs de modales PA..."

# Directorio base de modales PA
BASE_DIR="resources/views/empresa/expcaso/pa"

# Función para corregir IDs en modales de eliminación
fix_delete_modal_ids() {
    local module=$1
    local modal_file="$BASE_DIR/$module/delete${module}modal.blade.php"
    
    if [ -f "$modal_file" ]; then
        # Cambiar de deleteXxxModal a deleteXxxPaModal
        sed -i "s/id=\"delete${module^}Modal-/id=\"delete${module^}PaModal-/g" "$modal_file"
        sed -i "s/aria-labelledby=\"delete${module^}Modal-/aria-labelledby=\"delete${module^}PaModal-/g" "$modal_file"
        sed -i "s/id=\"delete${module^}Modal-/id=\"delete${module^}PaModal-/g" "$modal_file"
        echo "  - Corregido: $modal_file"
    fi
}

# Función para corregir IDs en modales de edición
fix_edit_modal_ids() {
    local module=$1
    local modal_file="$BASE_DIR/$module/edit${module}modal.blade.php"
    
    if [ -f "$modal_file" ]; then
        # Cambiar de editXxxModal a editXxxPaModal
        sed -i "s/id=\"edit${module^}Modal-/id=\"edit${module^}PaModal-/g" "$modal_file"
        sed -i "s/aria-labelledby=\"edit${module^}Modal-/aria-labelledby=\"edit${module^}PaModal-/g" "$modal_file"
        sed -i "s/id=\"edit${module^}Modal-/id=\"edit${module^}PaModal-/g" "$modal_file"
        echo "  - Corregido: $modal_file"
    fi
}

# Corregir todos los módulos
fix_delete_modal_ids "pp"
fix_edit_modal_ids "pp"

fix_delete_modal_ids "dpmr"
fix_edit_modal_ids "dpmr"

fix_delete_modal_ids "adpmr"
fix_edit_modal_ids "adpmr"

fix_delete_modal_ids "resolucion"
fix_edit_modal_ids "resolucion"

fix_delete_modal_ids "rtributa"
fix_edit_modal_ids "rtributa"

fix_delete_modal_ids "nulidad"
fix_edit_modal_ids "nulidad"

fix_delete_modal_ids "ec"
fix_edit_modal_ids "ec"

fix_delete_modal_ids "rr"
fix_edit_modal_ids "rr"

fix_delete_modal_ids "ntrr"
fix_edit_modal_ids "ntrr"

fix_delete_modal_ids "ocurso"
fix_edit_modal_ids "ocurso"

fix_delete_modal_ids "ro"
fix_edit_modal_ids "ro"

fix_delete_modal_ids "mpmr"
fix_edit_modal_ids "mpmr"

fix_delete_modal_ids "ampmr"
fix_edit_modal_ids "ampmr"

echo "IDs de modales PA corregidos!"
