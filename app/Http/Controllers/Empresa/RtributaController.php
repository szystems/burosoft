<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RtributaFormRequest;
use App\Models\Rtributa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RtributaController extends Controller
{
    public function insert(RtributaFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/rtributas'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $rtributa = Rtributa::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva resolución R-Tributa No.: ' . $rtributa->numero_resolucion .
                             ', Expediente: ' . $rtributa->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Resolución R-Tributa agregada exitosamente');
    }

    public function update(RtributaFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $rtributa = Rtributa::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/rtributas/' . $rtributa->archivo))) {
                File::delete(public_path('uploads/rtributas/' . $rtributa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/rtributas'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $rtributa->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó la resolución R-Tributa No.: ' . $rtributa->numero_resolucion .
                             ', Expediente: ' . $rtributa->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Resolución R-Tributa actualizada exitosamente');
    }

    public function destroy($id)
    {
        $rtributa = Rtributa::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/rtributas/' . $rtributa->archivo))) {
            File::delete(public_path('uploads/rtributas/' . $rtributa->archivo));
        }

        $rtributa->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó la resolución R-Tributa No.: ' . $rtributa->numero_resolucion .
                             ', Expediente: ' . $rtributa->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $rtributa->audiencia_id)->with('status', 'Resolución R-Tributa eliminada exitosamente');
    }
}
