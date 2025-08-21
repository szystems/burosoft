#!/bin/bash

FILE="resources/views/empresa/expcaso/pa/showaudiencia.blade.php"

echo "Corrigiendo targets de modales en $FILE..."

# Cambiar targets de modales VA a PA
sed -i 's/data-bs-target="#addEvModal"/data-bs-target="#addEvPaModal"/g' "$FILE"
sed -i 's/data-bs-target="#addPpModal"/data-bs-target="#addPpPaModal"/g' "$FILE"
sed -i 's/data-bs-target="#addDpmrModal"/data-bs-target="#addDpmrPaModal"/g' "$FILE"
sed -i 's/data-bs-target="#addAdpmrModal"/data-bs-target="#addAdpmrPaModal"/g' "$FILE"
sed -i 's/data-bs-target="#addResolucionModal"/data-bs-target="#addResolucionPaModal"/g' "$FILE"
sed -i 's/data-bs-target="#addNulidadModal"/data-bs-target="#addNulidadPaModal"/g' "$FILE"
sed -i 's/data-bs-target="#addEcModal"/data-bs-target="#addEcPaModal"/g' "$FILE"
sed -i 's/data-bs-target="#addRrModal"/data-bs-target="#addRrPaModal"/g' "$FILE"
sed -i 's/data-bs-target="#addNtrrModal"/data-bs-target="#addNtrrPaModal"/g' "$FILE"
sed -i 's/data-bs-target="#addOcursoModal"/data-bs-target="#addOcursoPaModal"/g' "$FILE"
sed -i 's/data-bs-target="#addRoModal"/data-bs-target="#addRoPaModal"/g' "$FILE"
sed -i 's/data-bs-target="#addMpmrModal"/data-bs-target="#addMpmrPaModal"/g' "$FILE"
sed -i 's/data-bs-target="#addAmpmrModal"/data-bs-target="#addAmpmrPaModal"/g' "$FILE"

# También cambiar targets de edición y eliminación
sed -i 's/data-bs-target="#editEvModal-/data-bs-target="#editEvPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editPpModal-/data-bs-target="#editPpPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editDpmrModal-/data-bs-target="#editDpmrPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editAdpmrModal-/data-bs-target="#editAdpmrPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editResolucionModal-/data-bs-target="#editResolucionPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editRtributaModal-/data-bs-target="#editRtributaPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editNulidadModal-/data-bs-target="#editNulidadPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editEcModal-/data-bs-target="#editEcPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editRrModal-/data-bs-target="#editRrPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editNtrrModal-/data-bs-target="#editNtrrPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editOcursoModal-/data-bs-target="#editOcursoPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editRoModal-/data-bs-target="#editRoPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editMpmrModal-/data-bs-target="#editMpmrPaModal-/g' "$FILE"
sed -i 's/data-bs-target="#editAmpmrModal-/data-bs-target="#editAmpmrPaModal-/g' "$FILE"

echo "Targets de modales corregidos!"
