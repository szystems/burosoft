#!/bin/bash

# Función para crear controlador PA
create_controller() {
    local module=$1
    local modelName=$2
    local uploadDir=$3
    local title=$4
    
    cat > "app/Http/Controllers/Empresa/${modelName}PaController.php" << CONTROLLER
<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\\${modelName}Pa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ${modelName}PaController extends Controller
{
    public function insert(Request \$request)
    {
        \$request->validate([
            'audiencia_pa_id' => 'required',
            'fecha_hora_presentacion' => 'required|date',
            'numero_documento' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        \$${module}Pa = new ${modelName}Pa();
        \$${module}Pa->audiencia_pa_id = \$request->audiencia_pa_id;
        \$${module}Pa->usuario_id = Auth::user()->id;
        \$${module}Pa->fecha_hora_presentacion = \$request->fecha_hora_presentacion;
        \$${module}Pa->numero_documento = \$request->numero_documento;
        \$${module}Pa->observaciones = \$request->observaciones;
        \$${module}Pa->numero_folios = \$request->numero_folios;

        // Manejo de archivo
        if (\$request->hasFile('archivo')) {
            \$file = \$request->file('archivo');
            \$filename = time() . '_' . \$file->getClientOriginalName();
            \$file->move(public_path('uploads/pa/${uploadDir}'), \$filename);
            \$${module}Pa->archivo = \$filename;
            \$${module}Pa->tipo_archivo = \$file->getClientOriginalExtension();
        }

        \$${module}Pa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó ${title} PA No.: ' . \$${module}Pa->numero_documento .
                             ' para la audiencia No.: ' . \$${module}Pa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . \$${module}Pa->audienciaPa->pat->cuenta->codigo . ' - ' . \$${module}Pa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . \$${module}Pa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . \$request->audiencia_pa_id)->with('success', '${title} PA creado exitosamente');
    }

    public function update(Request \$request, \$id)
    {
        \$request->validate([
            'fecha_hora_presentacion' => 'required|date',
            'numero_documento' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        \$${module}Pa = ${modelName}Pa::findOrFail(\$id);
        \$${module}Pa->usuario_id = Auth::user()->id;
        \$${module}Pa->fecha_hora_presentacion = \$request->fecha_hora_presentacion;
        \$${module}Pa->numero_documento = \$request->numero_documento;
        \$${module}Pa->observaciones = \$request->observaciones;
        \$${module}Pa->numero_folios = \$request->numero_folios;

        // Manejo de archivo
        if (\$request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if (\$${module}Pa->archivo && File::exists(public_path('uploads/pa/${uploadDir}/' . \$${module}Pa->archivo))) {
                File::delete(public_path('uploads/pa/${uploadDir}/' . \$${module}Pa->archivo));
            }

            \$file = \$request->file('archivo');
            \$filename = time() . '_' . \$file->getClientOriginalName();
            \$file->move(public_path('uploads/pa/${uploadDir}'), \$filename);
            \$${module}Pa->archivo = \$filename;
            \$${module}Pa->tipo_archivo = \$file->getClientOriginalExtension();
        }

        \$${module}Pa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó ${title} PA No.: ' . \$${module}Pa->numero_documento .
                             ' para la audiencia No.: ' . \$${module}Pa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . \$${module}Pa->audienciaPa->pat->cuenta->codigo . ' - ' . \$${module}Pa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . \$${module}Pa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . \$${module}Pa->audiencia_pa_id)->with('success', '${title} PA actualizado exitosamente');
    }

    public function destroy(\$id)
    {
        \$${module}Pa = ${modelName}Pa::findOrFail(\$id);

        // Eliminar archivo asociado si existe
        if (\$${module}Pa->archivo && File::exists(public_path('uploads/pa/${uploadDir}/' . \$${module}Pa->archivo))) {
            File::delete(public_path('uploads/pa/${uploadDir}/' . \$${module}Pa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó ${title} PA No.: ' . \$${module}Pa->numero_documento .
                             ' para la audiencia No.: ' . \$${module}Pa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . \$${module}Pa->audienciaPa->pat->cuenta->codigo . ' - ' . \$${module}Pa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . \$${module}Pa->audienciaPa->pat->no_expediente
        ]);

        \$audiencia_pa_id = \$${module}Pa->audiencia_pa_id;
        \$${module}Pa->delete();

        return redirect('show-audiencia-pa/' . \$audiencia_pa_id)->with('success', '${title} PA eliminado exitosamente');
    }
}
CONTROLLER
}

# Crear controladores para cada módulo
create_controller "dpmr" "Dpmr" "dpmr" "Diligencia Para Mejor Resolver"
create_controller "adpmr" "Adpmr" "adpmr" "Atención de Diligencia Para Mejor Resolver"
create_controller "ampmr" "Ampmr" "ampmr" "Atención de Memorial Para Mejor Resolver"
create_controller "mpmr" "Mpmr" "mpmr" "Memorial Para Mejor Resolver"
create_controller "ec" "Ec" "ec" "Escrito de Conclusiones"
create_controller "ntrr" "Ntrr" "ntrr" "Notificación de Trámite de Recurso de Revocatoria"
create_controller "nulidad" "Nulidad" "nulidad" "Solicitud de Nulidad"
create_controller "ocurso" "Ocurso" "ocurso" "Ocurso"
create_controller "resolucion" "Resolucion" "resolucion" "Resolución"
create_controller "ro" "Ro" "ro" "Resolución de Ocurso"
create_controller "rr" "Rr" "rr" "Recurso de Revocatoria"
create_controller "rtributa" "Rtributa" "rtributa" "Resolución Tributaria"

echo "Todos los controladores PA han sido creados exitosamente!"
