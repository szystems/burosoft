<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MpmrPaFormRequest;
use App\Models\MpmrPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class MpmrPaController extends Controller
{
    public function insert(MpmrPaFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            
            // Verificar que el archivo sea válido
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $uploadPath = public_path('uploads/pa/mpmr');
                
                // Crear directorio si no existe
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Mover archivo
                if ($file->move($uploadPath, $filename)) {
                    $data['archivo'] = $filename;
                    $data['tipo_archivo'] = $file->getClientOriginalExtension();
                } else {
                    return redirect()->back()->withErrors(['archivo' => 'Error al subir el archivo.'])->withInput();
                }
            } else {
                return redirect()->back()->withErrors(['archivo' => 'El archivo no es válido.'])->withInput();
            }
        }

        $mpmrPa = MpmrPa::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Memorial Para Mejor Resolver PA No.: ' . $mpmrPa->numero_resolucion .
                             ' para la audiencia No.: ' . $mpmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $mpmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $mpmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $mpmrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Memorial Para Mejor Resolver PA creado exitosamente');
    }

    public function update(MpmrPaFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $mpmrPa = MpmrPa::findOrFail($id);

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($mpmrPa->archivo && File::exists(public_path('uploads/pa/mpmr/' . $mpmrPa->archivo))) {
                File::delete(public_path('uploads/pa/mpmr/' . $mpmrPa->archivo));
            }

            $file = $request->file('archivo');
            
            // Verificar que el archivo sea válido
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $uploadPath = public_path('uploads/pa/mpmr');
                
                // Crear directorio si no existe
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Mover archivo
                if ($file->move($uploadPath, $filename)) {
                    $data['archivo'] = $filename;
                    $data['tipo_archivo'] = $file->getClientOriginalExtension();
                } else {
                    return redirect()->back()->withErrors(['archivo' => 'Error al subir el archivo.'])->withInput();
                }
            } else {
                return redirect()->back()->withErrors(['archivo' => 'El archivo no es válido.'])->withInput();
            }
        }

        $mpmrPa->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Memorial Para Mejor Resolver PA No.: ' . $mpmrPa->numero_resolucion .
                             ' para la audiencia No.: ' . $mpmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $mpmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $mpmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $mpmrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $mpmrPa->audiencia_pa_id)->with('status', 'Memorial Para Mejor Resolver PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $mpmrPa = MpmrPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($mpmrPa->archivo && File::exists(public_path('uploads/pa/mpmr/' . $mpmrPa->archivo))) {
            File::delete(public_path('uploads/pa/mpmr/' . $mpmrPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Memorial Para Mejor Resolver PA No.: ' . $mpmrPa->numero_resolucion .
                             ' para la audiencia No.: ' . $mpmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $mpmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $mpmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $mpmrPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $mpmrPa->audiencia_pa_id;
        $mpmrPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Memorial Para Mejor Resolver PA eliminado exitosamente');
    }
}
