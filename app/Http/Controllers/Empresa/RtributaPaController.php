<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RtributaPaFormRequest;
use App\Models\RtributaPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RtributaPaController extends Controller
{
    public function insert(RtributaPaFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/rtributa'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $rtributaPa = RtributaPa::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva resolución R-Tributa PA No.: ' . $rtributaPa->numero_resolucion .
                             ', Expediente: ' . $rtributaPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $data['audiencia_pa_id'])->with('status', 'Resolución Tributaria PA creada exitosamente');
    }

    public function update(RtributaPaFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $rtributaPa = RtributaPa::findOrFail($id);

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($rtributaPa->archivo && File::exists(public_path('uploads/pa/rtributa/' . $rtributaPa->archivo))) {
                File::delete(public_path('uploads/pa/rtributa/' . $rtributaPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/rtributa'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $rtributaPa->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Resolución Tributaria PA No.: ' . $rtributaPa->numero_resolucion .
                             ' para la audiencia No.: ' . $rtributaPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rtributaPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rtributaPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rtributaPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $rtributaPa->audiencia_pa_id)->with('status', 'Resolución Tributaria PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $rtributaPa = RtributaPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($rtributaPa->archivo && File::exists(public_path('uploads/pa/rtributa/' . $rtributaPa->archivo))) {
            File::delete(public_path('uploads/pa/rtributa/' . $rtributaPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Resolución Tributaria PA No.: ' . $rtributaPa->numero_resolucion .
                             ' para la audiencia No.: ' . $rtributaPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rtributaPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rtributaPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rtributaPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $rtributaPa->audiencia_pa_id;
        $rtributaPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Resolución Tributaria PA eliminado exitosamente');
    }
}
