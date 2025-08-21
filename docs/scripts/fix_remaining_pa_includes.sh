#!/bin/bash

FILE="resources/views/empresa/expcaso/pa/showaudiencia.blade.php"

echo "Corrigiendo includes restantes en $FILE..."

# Corregir includes de EC
sed -i "s/@include('empresa\.expcaso\.va\.ec\.addecmodal')/@include('empresa.expcaso.pa.ec.addecmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ec\.showecmodal')/@include('empresa.expcaso.pa.ec.showecmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ec\.editecmodal')/@include('empresa.expcaso.pa.ec.editecmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ec\.deleteecmodal')/@include('empresa.expcaso.pa.ec.deleteecmodal')/g" "$FILE"

# Corregir includes de RR
sed -i "s/@include('empresa\.expcaso\.va\.rr\.addrrmodal')/@include('empresa.expcaso.pa.rr.addrrmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.rr\.deleterrmodal')/@include('empresa.expcaso.pa.rr.deleterrmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.rr\.editrrmodal')/@include('empresa.expcaso.pa.rr.editrrmodal')/g" "$FILE"

# Corregir includes de NTRR
sed -i "s/@include('empresa\.expcaso\.va\.ntrr\.addntrrmodal')/@include('empresa.expcaso.pa.ntrr.addntrrmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ntrr\.deletentrrmodal')/@include('empresa.expcaso.pa.ntrr.deletentrrmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ntrr\.editntrrmodal')/@include('empresa.expcaso.pa.ntrr.editntrrmodal')/g" "$FILE"

# Corregir includes de OCURSO
sed -i "s/@include('empresa\.expcaso\.va\.ocurso\.addocursomodal')/@include('empresa.expcaso.pa.ocurso.addocursomodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ocurso\.deleteocursomodal')/@include('empresa.expcaso.pa.ocurso.deleteocursomodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ocurso\.editocursomodal')/@include('empresa.expcaso.pa.ocurso.editocursomodal')/g" "$FILE"

# Corregir includes de RO
sed -i "s/@include('empresa\.expcaso\.va\.ro\.addromodal')/@include('empresa.expcaso.pa.ro.addromodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ro\.deleteromodal')/@include('empresa.expcaso.pa.ro.deleteromodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ro\.editromodal')/@include('empresa.expcaso.pa.ro.editromodal')/g" "$FILE"

# Corregir includes de MPMR
sed -i "s/@include('empresa\.expcaso\.va\.mpmr\.addmpmrmodal')/@include('empresa.expcaso.pa.mpmr.addmpmrmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.mpmr\.deletempmrmodal')/@include('empresa.expcaso.pa.mpmr.deletempmrmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.mpmr\.editmpmrmodal')/@include('empresa.expcaso.pa.mpmr.editmpmrmodal')/g" "$FILE"

# Corregir includes de AMPMR
sed -i "s/@include('empresa\.expcaso\.va\.ampmr\.addampmrmodal')/@include('empresa.expcaso.pa.ampmr.addampmrmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ampmr\.deleteampmrmodal')/@include('empresa.expcaso.pa.ampmr.deleteampmrmodal')/g" "$FILE"
sed -i "s/@include('empresa\.expcaso\.va\.ampmr\.editampmrmodal')/@include('empresa.expcaso.pa.ampmr.editampmrmodal')/g" "$FILE"

echo "Includes restantes corregidos!"
