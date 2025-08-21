#!/bin/bash

FILE="resources/views/empresa/expcaso/pa/showaudiencia.blade.php"

echo "Corrigiendo targets de modales de eliminación en $FILE..."

# Corregir targets de eliminación para PA
sed -i 's/data-bs-target="#deletePpModal-/data-bs-target="#deletePpPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#deleteDpmrModal-/data-bs-target="#deleteDpmrPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#deleteAdpmrModal-/data-bs-target="#deleteAdpmrPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#deleteResolucionModal-/data-bs-target="#deleteResolucionPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#deleteRtributaModal-/data-bs-target="#deleteRtributaPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#deleteNulidadModal-/data-bs-target="#deleteNulidadPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#deleteEcModal-/data-bs-target="#deleteEcPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#deleteRrModal-/data-bs-target="#deleteRrPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#deleteNtrrModal-/data-bs-target="#deleteNtrrPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#deleteOcursoModal-/data-bs-target="#deleteOcursoPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#deleteRoModal-/data-bs-target="#deleteRoPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#deleteMpmrModal-/data-bs-target="#deleteMpmrPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#deleteAmpmrModal-/data-bs-target="#deleteAmpmrPaModal-/g' "$FILE"

echo "Targets de modales de eliminación corregidos!"
