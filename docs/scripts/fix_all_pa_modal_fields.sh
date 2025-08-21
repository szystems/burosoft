#!/bin/bash

echo "Corrigiendo campos en TODOS los modales PA..."

PA_VIEWS_DIR="resources/views/empresa/expcaso/pa"

# Función para corregir campos básicos en modales
fix_modal_fields() {
    local modal_dir="$1"
    local field_name="$2"
    local label_text="$3"
    
    if [ -d "$modal_dir" ]; then
        echo "  Corrigiendo modales en $(basename "$modal_dir")..."
        
        # Corregir addmodal
        if [ -f "$modal_dir/add$(basename "$modal_dir")modal.blade.php" ]; then
            # Cambiar fecha_hora_presentacion por fecha
            sed -i 's/fecha_hora_presentacion/fecha/g' "$modal_dir/add$(basename "$modal_dir")modal.blade.php"
            sed -i 's/Fecha y Hora de Presentación/Fecha de Notificación/g' "$modal_dir/add$(basename "$modal_dir")modal.blade.php"
            
            # Cambiar numero_documento por el campo específico
            sed -i "s/numero_documento/$field_name/g" "$modal_dir/add$(basename "$modal_dir")modal.blade.php"
            sed -i "s/No\. de Documento/$label_text/g" "$modal_dir/add$(basename "$modal_dir")modal.blade.php"
        fi
        
        # Corregir editmodal
        if [ -f "$modal_dir/edit$(basename "$modal_dir")modal.blade.php" ]; then
            # Cambiar fecha_hora_presentacion por fecha
            sed -i 's/fecha_hora_presentacion/fecha/g' "$modal_dir/edit$(basename "$modal_dir")modal.blade.php"
            sed -i 's/Fecha y Hora de Presentación/Fecha de Notificación/g' "$modal_dir/edit$(basename "$modal_dir")modal.blade.php"
            
            # Cambiar numero_documento por el campo específico
            sed -i "s/numero_documento/$field_name/g" "$modal_dir/edit$(basename "$modal_dir")modal.blade.php"
            sed -i "s/No\. de Documento/$label_text/g" "$modal_dir/edit$(basename "$modal_dir")modal.blade.php"
        fi
    fi
}

# Función para casos especiales (sin número)
fix_modal_fields_no_number() {
    local modal_dir="$1"
    
    if [ -d "$modal_dir" ]; then
        echo "  Corrigiendo modales en $(basename "$modal_dir") (sin campo número)..."
        
        for modal_file in "$modal_dir"/*.blade.php; do
            if [ -f "$modal_file" ]; then
                # Solo cambiar fecha
                sed -i 's/fecha_hora_presentacion/fecha/g' "$modal_file"
                sed -i 's/Fecha y Hora de Presentación/Fecha de Notificación/g' "$modal_file"
                
                # Eliminar campos de número completos
                sed -i '/numero_documento\|numero_escrito/d' "$modal_file"
            fi
        done
    fi
}

# Corregir cada tipo de modal según su modelo
echo "Corrigiendo modales adpmr..."
fix_modal_fields "$PA_VIEWS_DIR/adpmr" "numero_contestacion" "No. de Contestación"

echo "Corrigiendo modales ampmr..."
fix_modal_fields "$PA_VIEWS_DIR/ampmr" "numero_contestacion" "No. de Contestación"

echo "Corrigiendo modales dpmr..."
fix_modal_fields "$PA_VIEWS_DIR/dpmr" "numero_escrito" "No. de Escrito"

echo "Corrigiendo modales ec..."
fix_modal_fields "$PA_VIEWS_DIR/ec" "numero_escrito" "No. de Escrito"

echo "Corrigiendo modales ev (sin número)..."
fix_modal_fields_no_number "$PA_VIEWS_DIR/ev"

echo "Corrigiendo modales mpmr..."
fix_modal_fields "$PA_VIEWS_DIR/mpmr" "numero_escrito" "No. de Escrito"

echo "Corrigiendo modales ntrr..."
fix_modal_fields "$PA_VIEWS_DIR/ntrr" "numero_escrito" "No. de Escrito"

echo "Corrigiendo modales nulidad..."
fix_modal_fields "$PA_VIEWS_DIR/nulidad" "numero_escrito" "No. de Escrito"

echo "Corrigiendo modales ocurso..."
fix_modal_fields "$PA_VIEWS_DIR/ocurso" "numero_escrito" "No. de Escrito"

echo "Corrigiendo modales pp..."
fix_modal_fields "$PA_VIEWS_DIR/pp" "numero_escrito" "No. de Escrito"

echo "Corrigiendo modales ro..."
fix_modal_fields "$PA_VIEWS_DIR/ro" "numero_escrito" "No. de Escrito"

echo "Corrigiendo modales rr..."
fix_modal_fields "$PA_VIEWS_DIR/rr" "numero_escrito" "No. de Escrito"

echo "Corrigiendo modales rtributa..."
fix_modal_fields "$PA_VIEWS_DIR/rtributa" "numero_escrito" "No. de Escrito"

echo "¡Corrección de modales PA completada!"
