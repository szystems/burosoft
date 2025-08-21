#!/bin/bash

echo "Ì¥Ñ Restaurando estructura id√©ntica entre modales VA y PA..."
echo ""

# Lista de secciones a corregir
sections=("pp" "dpmr" "ec" "mpmr" "ntrr" "nulidad" "ocurso" "ro" "rr" "rtributa")

for section in "${sections[@]}"; do
    echo "Ì¥ß Procesando $section..."
    
    # Verificar que existan los archivos VA
    va_add="resources/views/empresa/expcaso/va/$section/add${section}modal.blade.php"
    va_edit="resources/views/empresa/expcaso/va/$section/edit${section}modal.blade.php"
    
    pa_add="resources/views/empresa/expcaso/pa/$section/add${section}modal.blade.php"
    pa_edit="resources/views/empresa/expcaso/pa/$section/edit${section}modal.blade.php"
    
    if [ -f "$va_add" ] && [ -f "$pa_add" ]; then
        echo "  ‚úÖ Archivos encontrados para $section"
        
        # Extraer estructura de campos de VA
        echo "  Ì¥ç Analizando estructura VA de $section..."
        grep -n "name=" "$va_add" | head -5
        
    else
        echo "  ‚ùå Archivos no encontrados para $section"
    fi
done

echo ""
echo "An√°lisis completado. Continuar con correcciones manuales espec√≠ficas."
