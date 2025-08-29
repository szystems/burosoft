<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AceptacionPaFormRequest;
use App\Models\AceptacionPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AceptacionPaController extends Controller
{
    public function insert(AceptacionPaFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            
            // Verificar que el archivo sea válido
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $uploadPath = public_path('uploads/pa/aceptacion');
                
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

        $aceptacionPa = AceptacionPa::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva Aceptación PA No.: ' . $aceptacionPa->numero_documento .
                             ' para la audiencia No.: ' . $aceptacionPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $aceptacionPa->audienciaPa->pat->cuenta->codigo . ' - ' . $aceptacionPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $aceptacionPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $data['audiencia_pa_id'])->with('status', 'Aceptación PA creada exitosamente');
    }

    public function update(AceptacionPaFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $aceptacionPa = AceptacionPa::findOrFail($id);

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($aceptacionPa->archivo && File::exists(public_path('uploads/pa/aceptacion/' . $aceptacionPa->archivo))) {
                File::delete(public_path('uploads/pa/aceptacion/' . $aceptacionPa->archivo));
            }

            $file = $request->file('archivo');
            
            // Verificar que el archivo sea válido
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $uploadPath = public_path('uploads/pa/aceptacion');
                
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
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $aceptacionPa->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Aceptación PA No.: ' . $aceptacionPa->numero_documento .
                             ' para la audiencia No.: ' . $aceptacionPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $aceptacionPa->audienciaPa->pat->cuenta->codigo . ' - ' . $aceptacionPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $aceptacionPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $aceptacionPa->audiencia_pa_id)->with('status', 'Aceptación PA actualizada exitosamente');
    }

    public function destroy($id)
    {
        $aceptacionPa = AceptacionPa::findOrFail($id);

        // Eliminar archivo si existe
        if ($aceptacionPa->archivo && File::exists(public_path('uploads/pa/aceptacion/' . $aceptacionPa->archivo))) {
            File::delete(public_path('uploads/pa/aceptacion/' . $aceptacionPa->archivo));
        }

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Aceptación PA No.: ' . $aceptacionPa->numero_documento .
                             ' de la audiencia No.: ' . $aceptacionPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $aceptacionPa->audienciaPa->pat->cuenta->codigo . ' - ' . $aceptacionPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $aceptacionPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $aceptacionPa->audiencia_pa_id;
        $aceptacionPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Aceptación PA eliminada exitosamente');
    }
}
