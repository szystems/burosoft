#!/bin/bash

echo "Corrigiendo campos en showaudiencia.blade.php PA..."

FILE="resources/views/empresa/expcaso/pa/showaudiencia.blade.php"

if [ -f "$FILE" ]; then
    echo "Archivo encontrado, aplicando correcciones..."
    
    # Backup del archivo
    cp "$FILE" "${FILE}.backup"
    
    # Para EV (solo fecha, sin numero)
    sed -i 's/\$ev->fecha_hora_presentacion/\$ev->fecha/g' "$FILE"
    
    # Para PP (fecha y numero_escrito)
    sed -i 's/\$pp->fecha_hora_presentacion/\$pp->fecha/g' "$FILE"
    sed -i 's/\$pp->numero_documento/\$pp->numero_escrito/g' "$FILE"
    
    # Para ADPMR (fecha y numero_contestacion)
    sed -i 's/\$adpmr->fecha_hora_presentacion/\$adpmr->fecha/g' "$FILE"
    sed -i 's/\$adpmr->numero_documento/\$adpmr->numero_contestacion/g' "$FILE"
    
    # Para RR (fecha y numero_escrito)
    sed -i 's/\$rr->fecha_hora_presentacion/\$rr->fecha/g' "$FILE"
    sed -i 's/\$rr->numero_documento/\$rr->numero_escrito/g' "$FILE"
    
    # Para OCURSO (fecha y numero_escrito)
    sed -i 's/\$ocurso->fecha_hora_presentacion/\$ocurso->fecha/g' "$FILE"
    sed -i 's/\$ocurso->numero_documento/\$ocurso->numero_escrito/g' "$FILE"
    
    # Para AMPMR (fecha y numero_contestacion)
    sed -i 's/\$ampmr->fecha_hora_presentacion/\$ampmr->fecha/g' "$FILE"
    sed -i 's/\$ampmr->numero_documento/\$ampmr->numero_contestacion/g' "$FILE"
    
    # Para otros registros PA gen√©ricos
    sed -i 's/fecha_hora_presentacion/fecha/g' "$FILE"
    sed -i 's/numero_documento/numero_escrito/g' "$FILE"
    
    echo "‚úÖ Correcciones aplicadas a showaudiencia.blade.php"
    echo "Ì≥Ñ Backup guardado como ${FILE}.backup"
else
    echo "‚ùå Archivo no encontrado: $FILE"
fi
