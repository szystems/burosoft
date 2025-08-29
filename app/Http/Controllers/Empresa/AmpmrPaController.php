<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AmpmrPaFormRequest;
use App\Models\AmpmrPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AmpmrPaController extends Controller
{
    public function insert(AmpmrPaFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            
            // Verificar que el archivo sea válido
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $uploadPath = public_path('uploads/pa/ampmr');
                
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

        $ampmrPa = AmpmrPa::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Atención de Memorial Para Mejor Resolver PA No.: ' . $ampmrPa->numero_documento .
                             ' para la audiencia No.: ' . $ampmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ampmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ampmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ampmrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $data['audiencia_pa_id'])->with('status', 'Atención de Memorial Para Mejor Resolver PA creado exitosamente');
    }

    public function update(AmpmrPaFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $ampmrPa = AmpmrPa::findOrFail($id);

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($ampmrPa->archivo && File::exists(public_path('uploads/pa/ampmr/' . $ampmrPa->archivo))) {
                File::delete(public_path('uploads/pa/ampmr/' . $ampmrPa->archivo));
            }

            $file = $request->file('archivo');
            
            // Verificar que el archivo sea válido
            if ($file->isValid()) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $uploadPath = public_path('uploads/pa/ampmr');
                
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

        $ampmrPa->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Atención de Memorial Para Mejor Resolver PA No.: ' . $ampmrPa->numero_contestacion .
                             ' para la audiencia No.: ' . $ampmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ampmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ampmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ampmrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $ampmrPa->audiencia_pa_id)->with('status', 'Atención de Memorial Para Mejor Resolver PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $ampmrPa = AmpmrPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($ampmrPa->archivo && File::exists(public_path('uploads/pa/ampmr/' . $ampmrPa->archivo))) {
            File::delete(public_path('uploads/pa/ampmr/' . $ampmrPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Atención de Memorial Para Mejor Resolver PA No.: ' . $ampmrPa->numero_contestacion .
                             ' para la audiencia No.: ' . $ampmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ampmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ampmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ampmrPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $ampmrPa->audiencia_pa_id;
        $ampmrPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Atención de Memorial Para Mejor Resolver PA eliminado exitosamente');
    }
}
