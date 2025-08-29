<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OcursoPaFormRequest;
use App\Models\OcursoPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class OcursoPaController extends Controller
{
    public function insert(OcursoPaFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ocurso'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $ocursoPa = OcursoPa::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Ocurso PA No.: ' . $ocursoPa->numero_documento .
                             ' para la audiencia No.: ' . $ocursoPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ocursoPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ocursoPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ocursoPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Ocurso PA creado exitosamente');
    }

    public function update(OcursoPaFormRequest $request, $id)
    {
        $data = $request->validated();
        
        $ocursoPa = OcursoPa::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($ocursoPa->archivo && File::exists(public_path('uploads/pa/ocurso/' . $ocursoPa->archivo))) {
                File::delete(public_path('uploads/pa/ocurso/' . $ocursoPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ocurso'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $ocursoPa->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Ocurso PA No.: ' . $ocursoPa->numero_documento .
                             ' para la audiencia No.: ' . $ocursoPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ocursoPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ocursoPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ocursoPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $ocursoPa->audiencia_pa_id)->with('status', 'Ocurso PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $ocursoPa = OcursoPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($ocursoPa->archivo && File::exists(public_path('uploads/pa/ocurso/' . $ocursoPa->archivo))) {
            File::delete(public_path('uploads/pa/ocurso/' . $ocursoPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Ocurso PA No.: ' . $ocursoPa->numero_documento .
                             ' para la audiencia No.: ' . $ocursoPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ocursoPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ocursoPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ocursoPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $ocursoPa->audiencia_pa_id;
        $ocursoPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Ocurso PA eliminado exitosamente');
    }
}
