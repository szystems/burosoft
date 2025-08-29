<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AceptacionFormRequest;
use App\Models\Aceptacion;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AceptacionController extends Controller
{
    public function insert(AceptacionFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            
            // Verificar que el archivo sea válido
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $uploadPath = public_path('uploads/aceptacions');
                
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

        $aceptacion = Aceptacion::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva Aceptación No.: ' . $aceptacion->numero_documento .
                             ' para la audiencia No.: ' . $aceptacion->audiencia->numero_audiencia .
                             ', cuenta: ' . $aceptacion->audiencia->pat->cuenta->codigo . ' - ' . $aceptacion->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $aceptacion->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Aceptación agregada exitosamente');
    }

    public function update(AceptacionFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $aceptacion = Aceptacion::findOrFail($id);

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($aceptacion->archivo && File::exists(public_path('uploads/aceptacions/' . $aceptacion->archivo))) {
                File::delete(public_path('uploads/aceptacions/' . $aceptacion->archivo));
            }

            $file = $request->file('archivo');
            
            // Verificar que el archivo sea válido
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $uploadPath = public_path('uploads/aceptacions');
                
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

        $aceptacion->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Aceptación No.: ' . $aceptacion->numero_documento .
                             ' para la audiencia No.: ' . $aceptacion->audiencia->numero_audiencia .
                             ', cuenta: ' . $aceptacion->audiencia->pat->cuenta->codigo . ' - ' . $aceptacion->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $aceptacion->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $aceptacion->audiencia_id)->with('status', 'Aceptación actualizada exitosamente');
    }

    public function destroy($id)
    {
        $aceptacion = Aceptacion::findOrFail($id);

        // Eliminar archivo si existe
        if ($aceptacion->archivo && File::exists(public_path('uploads/aceptacions/' . $aceptacion->archivo))) {
            File::delete(public_path('uploads/aceptacions/' . $aceptacion->archivo));
        }

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Aceptación No.: ' . $aceptacion->numero_documento .
                             ' de la audiencia No.: ' . $aceptacion->audiencia->numero_audiencia .
                             ', cuenta: ' . $aceptacion->audiencia->pat->cuenta->codigo . ' - ' . $aceptacion->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $aceptacion->audiencia->pat->no_expediente
        ]);

        $audiencia_id = $aceptacion->audiencia_id;
        $aceptacion->delete();

        return redirect('show-audiencia/' . $audiencia_id)->with('status', 'Aceptación eliminada exitosamente');
    }
}
