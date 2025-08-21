#!/bin/bash

echo "Corrigiendo variables en modales PA..."

# Corregir modales EV PA
sed -i 's/\$evPa/\$ev/g' "resources/views/empresa/expcaso/pa/ev/editevmodal.blade.php"
sed -i 's/\$evPa/\$ev/g' "resources/views/empresa/expcaso/pa/ev/deleteevmodal.blade.php"

# Corregir modales PP PA 
sed -i 's/\$ppPa/\$pp/g' "resources/views/empresa/expcaso/pa/pp/editppmodal.blade.php"
sed -i 's/\$ppPa/\$pp/g' "resources/views/empresa/expcaso/pa/pp/deleteppmodal.blade.php"

# Corregir modales DPMR PA
sed -i 's/\$dpmrPa/\$dpmr/g' "resources/views/empresa/expcaso/pa/dpmr/editdpmrmodal.blade.php"
sed -i 's/\$dpmrPa/\$dpmr/g' "resources/views/empresa/expcaso/pa/dpmr/deletedpmrmodal.blade.php"

# Corregir modales ADPMR PA
sed -i 's/\$adpmrPa/\$adpmr/g' "resources/views/empresa/expcaso/pa/adpmr/editadpmrmodal.blade.php"
sed -i 's/\$adpmrPa/\$adpmr/g' "resources/views/empresa/expcaso/pa/adpmr/deleteadpmrmodal.blade.php"

# Corregir modales Resolución PA
sed -i 's/\$resolucionPa/\$resolucion/g' "resources/views/empresa/expcaso/pa/resolucion/editresolucionmodal.blade.php"
sed -i 's/\$resolucionPa/\$resolucion/g' "resources/views/empresa/expcaso/pa/resolucion/deleteresolucionmodal.blade.php"

# Corregir modales RtributaPa
sed -i 's/\$rtributaPa/\$rtributa/g' "resources/views/empresa/expcaso/pa/rtributa/editrtributamodal.blade.php"
sed -i 's/\$rtributaPa/\$rtributa/g' "resources/views/empresa/expcaso/pa/rtributa/deletertributamodal.blade.php"

# Corregir modales EC PA
sed -i 's/\$ecPa/\$ec/g' "resources/views/empresa/expcaso/pa/ec/editecmodal.blade.php"
sed -i 's/\$ecPa/\$ec/g' "resources/views/empresa/expcaso/pa/ec/deleteecmodal.blade.php"

# Corregir modales RR PA
sed -i 's/\$rrPa/\$rr/g' "resources/views/empresa/expcaso/pa/rr/editrrmodal.blade.php"
sed -i 's/\$rrPa/\$rr/g' "resources/views/empresa/expcaso/pa/rr/deleterrmodal.blade.php"

# Corregir modales NTRR PA
sed -i 's/\$ntrrPa/\$ntrr/g' "resources/views/empresa/expcaso/pa/ntrr/editntrrmodal.blade.php"
sed -i 's/\$ntrrPa/\$ntrr/g' "resources/views/empresa/expcaso/pa/ntrr/deletentrrmodal.blade.php"

# Corregir modales Nulidad PA
sed -i 's/\$nulidadPa/\$nulidad/g' "resources/views/empresa/expcaso/pa/nulidad/editnulidadmodal.blade.php"
sed -i 's/\$nulidadPa/\$nulidad/g' "resources/views/empresa/expcaso/pa/nulidad/deletenulidadmodal.blade.php"

# Corregir modales Ocurso PA
sed -i 's/\$ocursoPa/\$ocurso/g' "resources/views/empresa/expcaso/pa/ocurso/editocursomodal.blade.php"
sed -i 's/\$ocursoPa/\$ocurso/g' "resources/views/empresa/expcaso/pa/ocurso/deleteocursomodal.blade.php"

# Corregir modales RO PA
sed -i 's/\$roPa/\$ro/g' "resources/views/empresa/expcaso/pa/ro/editromodal.blade.php"
sed -i 's/\$roPa/\$ro/g' "resources/views/empresa/expcaso/pa/ro/deleteromodal.blade.php"

# Corregir modales MPMR PA
sed -i 's/\$mpmrPa/\$mpmr/g' "resources/views/empresa/expcaso/pa/mpmr/editmpmrmodal.blade.php"
sed -i 's/\$mpmrPa/\$mpmr/g' "resources/views/empresa/expcaso/pa/mpmr/deletempmrmodal.blade.php"

# Corregir modales AMPMR PA
sed -i 's/\$ampmrPa/\$ampmr/g' "resources/views/empresa/expcaso/pa/ampmr/editampmrmodal.blade.php"
sed -i 's/\$ampmrPa/\$ampmr/g' "resources/views/empresa/expcaso/pa/ampmr/deleteampmrmodal.blade.php"

echo "Variables en modales PA corregidas!"
