<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RoFormRequest;
use App\Models\Ro;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RoController extends Controller
{
    public function insert(RoFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ros'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $ro = Ro::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva resolución de ocurso No.: ' . $ro->numero_resolucion .
                             ' (' . $ro->tipo_resolucion . ') para la audiencia No.: ' . $ro->audiencia->numero_audiencia .
                             ', cuenta: ' . $ro->audiencia->pat->cuenta->codigo . ' - ' . $ro->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ro->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Resolución de ocurso agregada exitosamente');
    }

    public function update(RoFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $ro = Ro::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/ros/' . $ro->archivo))) {
                File::delete(public_path('uploads/ros/' . $ro->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ros'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $ro->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó la resolución de ocurso No.: ' . $ro->numero_resolucion .
                             ' (' . $ro->tipo_resolucion . ') para la audiencia No.: ' . $ro->audiencia->numero_audiencia .
                             ', cuenta: ' . $ro->audiencia->pat->cuenta->codigo . ' - ' . $ro->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ro->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Resolución de ocurso actualizada exitosamente');
    }

    public function destroy($id)
    {
        $ro = Ro::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/ros/' . $ro->archivo))) {
            File::delete(public_path('uploads/ros/' . $ro->archivo));
        }

        $ro->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó la resolución de ocurso No.: ' . $ro->numero_resolucion .
                             ' (' . $ro->tipo_resolucion . ') para la audiencia No.: ' . $ro->audiencia->numero_audiencia .
                             ', cuenta: ' . $ro->audiencia->pat->cuenta->codigo . ' - ' . $ro->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ro->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $ro->audiencia_id)->with('status', 'Resolución de ocurso eliminada exitosamente');
    }
}
