<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NulidadFormRequest;
use App\Models\Nulidad;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class NulidadController extends Controller
{
    public function insert(NulidadFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/nulidades'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $nulidad = Nulidad::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva nulidad No.: ' . $nulidad->numero_resolucion .
                             ', Expediente: ' . $nulidad->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Nulidad agregada exitosamente');
    }

    public function update(NulidadFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $nulidad = Nulidad::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/nulidades/' . $nulidad->archivo))) {
                File::delete(public_path('uploads/nulidades/' . $nulidad->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/nulidades'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $nulidad->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó la nulidad No.: ' . $nulidad->numero_resolucion .
                             ', Expediente: ' . $nulidad->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Nulidad actualizada exitosamente');
    }

    public function destroy($id)
    {
        $nulidad = Nulidad::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/nulidades/' . $nulidad->archivo))) {
            File::delete(public_path('uploads/nulidades/' . $nulidad->archivo));
        }

        $nulidad->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó la nulidad No.: ' . $nulidad->numero_resolucion .
                             ', Expediente: ' . $nulidad->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $nulidad->audiencia_id)->with('status', 'Nulidad eliminada exitosamente');
    }
}
