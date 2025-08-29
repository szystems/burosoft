<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RsatPaFormRequest;
use App\Models\RsatPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ResolucionPaController extends Controller
{
    public function insert(RsatPaFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/resolucion'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $rsatPa = RsatPa::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Resolución PA No.: ' . $rsatPa->numero_resolucion .
                             ' para la audiencia No.: ' . $rsatPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rsatPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rsatPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rsatPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Resolución PA creado exitosamente');
    }

    public function update(RsatPaFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $rsatPa = RsatPa::findOrFail($id);

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($rsatPa->archivo && File::exists(public_path('uploads/pa/resolucion/' . $rsatPa->archivo))) {
                File::delete(public_path('uploads/pa/resolucion/' . $rsatPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/resolucion'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $rsatPa->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Resolución PA No.: ' . $rsatPa->numero_resolucion .
                             ' para la audiencia No.: ' . $rsatPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rsatPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rsatPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rsatPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $rsatPa->audiencia_pa_id)->with('status', 'Resolución PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $rsatPa = RsatPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($rsatPa->archivo && File::exists(public_path('uploads/pa/resolucion/' . $rsatPa->archivo))) {
            File::delete(public_path('uploads/pa/resolucion/' . $rsatPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Resolución PA No.: ' . $rsatPa->numero_resolucion .
                             ' para la audiencia No.: ' . $rsatPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rsatPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rsatPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rsatPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $rsatPa->audiencia_pa_id;
        $rsatPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Resolución PA eliminado exitosamente');
    }
}
