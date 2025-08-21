#!/bin/bash

echo "Corrigiendo campos en modales de resolución PA..."

BASE_DIR="resources/views/empresa/expcaso/pa/resolucion"

# Corregir modal ADD
sed -i 's/fecha_hora_presentacion/fecha/g' "$BASE_DIR/addresolucionmodal.blade.php"
sed -i 's/numero_documento/numero_escrito/g' "$BASE_DIR/addresolucionmodal.blade.php"

# Corregir modal EDIT
sed -i 's/fecha_hora_presentacion/fecha/g' "$BASE_DIR/editresolucionmodal.blade.php"
sed -i 's/numero_documento/numero_escrito/g' "$BASE_DIR/editresolucionmodal.blade.php"

# También corregir etiquetas
sed -i 's/Fecha y Hora de Presentación/Fecha de Notificación/g' "$BASE_DIR/addresolucionmodal.blade.php"
sed -i 's/No. de Documento/No. de Resolución/g' "$BASE_DIR/addresolucionmodal.blade.php"

sed -i 's/Fecha y Hora de Presentación/Fecha de Notificación/g' "$BASE_DIR/editresolucionmodal.blade.php"
sed -i 's/No. de Documento/No. de Resolución/g' "$BASE_DIR/editresolucionmodal.blade.php"

echo "Campos de modales de resolución PA corregidos!"
