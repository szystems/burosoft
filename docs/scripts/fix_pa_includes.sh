#!/bin/bash

FILE="resources/views/empresa/expcaso/pa/showaudiencia.blade.php"

echo "Corrigiendo includes en $FILE..."

# Cambiar todos los includes de VA a PA
sed -i "s/@include('empresa\.expcaso\.va\.ev\.deleteevmodal')/@include('empresa.expcaso.pa.ev.deleteevmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ev\.addevmodal')/@include('empresa.expcaso.pa.ev.addevmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ev\.editevmodal')/@include('empresa.expcaso.pa.ev.editevmodal')/g" "$FILE"

sed -i "s/@include('empresa\.expcaso\.va\.pp\.addppmodal')/@include('empresa.expcaso.pa.pp.addppmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.pp\.deleteppmodal')/@include('empresa.expcaso.pa.pp.deleteppmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.pp\.editppmodal')/@include('empresa.expcaso.pa.pp.editppmodal')/g" "$FILE"

sed -i "s/@include('empresa\.expcaso\.va\.dpmr\.adddpmrmodal')/@include('empresa.expcaso.pa.dpmr.adddpmrmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.dpmr\.deletedpmrmodal')/@include('empresa.expcaso.pa.dpmr.deletedpmrmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.dpmr\.editdpmrmodal')/@include('empresa.expcaso.pa.dpmr.editdpmrmodal')/g" "$FILE"

sed -i "s/@include('empresa\.expcaso\.va\.adpmr\.addadpmrmodal')/@include('empresa.expcaso.pa.adpmr.addadpmrmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.adpmr\.deleteadpmrmodal')/@include('empresa.expcaso.pa.adpmr.deleteadpmrmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.adpmr\.editadpmrmodal')/@include('empresa.expcaso.pa.adpmr.editadpmrmodal')/g" "$FILE"

sed -i "s/@include('empresa\.expcaso\.va\.resolucion\.addresolucionmodal')/@include('empresa.expcaso.pa.resolucion.addresolucionmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.resolucion\.deleteresolucionmodal')/@include('empresa.expcaso.pa.resolucion.deleteresolucionmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.resolucion\.editresolucionmodal')/@include('empresa.expcaso.pa.resolucion.editresolucionmodal')/g" "$FILE"

sed -i "s/@include('empresa\.expcaso\.va\.rtributa\.deletertributamodal')/@include('empresa.expcaso.pa.rtributa.deletertributamodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.rtributa\.editrtributamodal')/@include('empresa.expcaso.pa.rtributa.editrtributamodal')/g" "$FILE"

sed -i "s/@include('empresa\.expcaso\.va\.nulidad\.addnulidadmodal')/@include('empresa.expcaso.pa.nulidad.addnulidadmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.nulidad\.deletenulidadmodal')/@include('empresa.expcaso.pa.nulidad.deletenulidadmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.nulidad\.editnulidadmodal')/@include('empresa.expcaso.pa.nulidad.editnulidadmodal')/g" "$FILE"

echo "Includes corregidos!"
