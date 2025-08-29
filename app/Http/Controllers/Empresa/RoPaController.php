<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoPaFormRequest;
use App\Models\RoPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RoPaController extends Controller
{
    public function insert(RoPaFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ro'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $roPa = RoPa::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Resolución de Ocurso PA No.: ' . $roPa->numero_documento .
                             ' para la audiencia No.: ' . $roPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $roPa->audienciaPa->pat->cuenta->codigo . ' - ' . $roPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $roPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Resolución de Ocurso PA creado exitosamente');
    }

    public function update(RoPaFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $roPa = RoPa::findOrFail($id);

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($roPa->archivo && File::exists(public_path('uploads/pa/ro/' . $roPa->archivo))) {
                File::delete(public_path('uploads/pa/ro/' . $roPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ro'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $roPa->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Resolución de Ocurso PA No.: ' . $roPa->numero_documento .
                             ' para la audiencia No.: ' . $roPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $roPa->audienciaPa->pat->cuenta->codigo . ' - ' . $roPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $roPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $roPa->audiencia_pa_id)->with('status', 'Resolución de Ocurso PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $roPa = RoPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($roPa->archivo && File::exists(public_path('uploads/pa/ro/' . $roPa->archivo))) {
            File::delete(public_path('uploads/pa/ro/' . $roPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Resolución de Ocurso PA No.: ' . $roPa->numero_documento .
                             ' para la audiencia No.: ' . $roPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $roPa->audienciaPa->pat->cuenta->codigo . ' - ' . $roPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $roPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $roPa->audiencia_pa_id;
        $roPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Resolución de Ocurso PA eliminado exitosamente');
    }
}
