<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ResolucionFormRequest;
use App\Models\Resolucion;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ResolucionController extends Controller
{
    public function insert(ResolucionFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/resoluciones'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $resolucion = Resolucion::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva resolución No.: ' . $resolucion->numero_resolucion .
                             ' de tipo: ' . $resolucion->tipo_resolucion .
                             ' para la audiencia No.: ' . $resolucion->audiencia->numero_audiencia .
                             ', cuenta: ' . $resolucion->audiencia->pat->cuenta->codigo . ' - ' . $resolucion->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $resolucion->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Resolución agregada exitosamente');
    }

    public function update(ResolucionFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $resolucion = Resolucion::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/resoluciones/' . $resolucion->archivo))) {
                File::delete(public_path('uploads/resoluciones/' . $resolucion->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/resoluciones'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $resolucion->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó la resolución No.: ' . $resolucion->numero_resolucion .
                             ' de tipo: ' . $resolucion->tipo_resolucion .
                             ' para la audiencia No.: ' . $resolucion->audiencia->numero_audiencia .
                             ', cuenta: ' . $resolucion->audiencia->pat->cuenta->codigo . ' - ' . $resolucion->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $resolucion->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Resolución actualizada exitosamente');
    }

    public function destroy($id)
    {
        $resolucion = Resolucion::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/resoluciones/' . $resolucion->archivo))) {
            File::delete(public_path('uploads/resoluciones/' . $resolucion->archivo));
        }

        $resolucion->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó la resolución No.: ' . $resolucion->numero_resolucion .
                             ' de tipo: ' . $resolucion->tipo_resolucion .
                             ' para la audiencia No.: ' . $resolucion->audiencia->numero_audiencia .
                             ', cuenta: ' . $resolucion->audiencia->pat->cuenta->codigo . ' - ' . $resolucion->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $resolucion->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $resolucion->audiencia_id)->with('status', 'Resolución eliminada exitosamente');
    }
}
