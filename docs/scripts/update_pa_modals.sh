#!/bin/bash

# Función para actualizar modales de un módulo
update_module_modals() {
    local module=$1
    local module_upper=$2
    local modal_dir="resources/views/empresa/pa/$module"
    
    # Modal ADD
    if [ -f "$modal_dir/add.blade.php" ]; then
        sed -i "s/action=\"{{ route('insert\\.$module') }}\"/action=\"{{ route('insert.$module.pa') }}\"/g" "$modal_dir/add.blade.php"
    fi
    
    # Modal EDIT  
    if [ -f "$modal_dir/edit.blade.php" ]; then
        sed -i "s/action=\"{{ route('update\\.$module', \\\$${module}->id) }}\"/action=\"{{ route('update.$module.pa', \\\$${module}Pa->id) }}\"/g" "$modal_dir/edit.blade.php"
    fi
    
    # Modal DELETE
    if [ -f "$modal_dir/delete.blade.php" ]; then
        sed -i "s/action=\"{{ route('delete\\.$module', \\\$${module}->id) }}\"/action=\"{{ route('delete.$module.pa', \\\$${module}Pa->id) }}\"/g" "$modal_dir/delete.blade.php"
    fi
    
    echo "Modales de $module_upper actualizados"
}

# Actualizar todos los módulos
update_module_modals "dpmr" "DPMR"
update_module_modals "adpmr" "ADPMR"  
update_module_modals "ampmr" "AMPMR"
update_module_modals "mpmr" "MPMR"
update_module_modals "ec" "EC"
update_module_modals "ntrr" "NTRR"
update_module_modals "nulidad" "Nulidad"
update_module_modals "ocurso" "Ocurso"
update_module_modals "resolucion" "Resolución"
update_module_modals "ro" "RO"
update_module_modals "rr" "RR"
update_module_modals "rtributa" "Rtributa"

echo "Todos los modales PA han sido actualizados!"
