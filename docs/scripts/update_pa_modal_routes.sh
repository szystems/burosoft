#!/bin/bash

BASE_DIR="resources/views/empresa/expcaso/pa"

# Función para actualizar rutas en modales de un módulo
update_modal_routes() {
    local module=$1
    local modal_dir="$BASE_DIR/$module"
    
    echo "Actualizando modales de $module..."
    
    # Modal ADD
    local add_file="$modal_dir/add${module}modal.blade.php"
    if [ -f "$add_file" ]; then
        # Cambiar de insert-module a insert-module-pa
        sed -i "s/action=\"{{ url('insert-$module') }}\"/action=\"{{ url('insert-$module-pa') }}\"/g" "$add_file"
        echo "  - Actualizado: $add_file"
    fi
    
    # Modal EDIT
    local edit_file="$modal_dir/edit${module}modal.blade.php" 
    if [ -f "$edit_file" ]; then
        # Cambiar de update-module a update-module-pa
        sed -i "s/action=\"{{ url('update-$module') }}\"/action=\"{{ url('update-$module-pa') }}\"/g" "$edit_file"
        echo "  - Actualizado: $edit_file"
    fi
    
    # Modal DELETE
    local delete_file="$modal_dir/delete${module}modal.blade.php"
    if [ -f "$delete_file" ]; then
        # Cambiar de delete-module a delete-module-pa
        sed -i "s/href=\"{{ url('delete-$module') }}\"/href=\"{{ url('delete-$module-pa') }}\"/g" "$delete_file"
        echo "  - Actualizado: $delete_file"
    fi
}

# Actualizar todos los módulos PA
update_modal_routes "dpmr"
update_modal_routes "adpmr"
update_modal_routes "ampmr"
update_modal_routes "mpmr"
update_modal_routes "ec"
update_modal_routes "ntrr"
update_modal_routes "nulidad"
update_modal_routes "ocurso"
update_modal_routes "resolucion"
update_modal_routes "ro"
update_modal_routes "rr"
update_modal_routes "rtributa"

echo ""
echo "¡Actualización de rutas PA completada!"
