<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NtrrPaFormRequest;
use App\Models\NtrrPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class NtrrPaController extends Controller
{
    public function insert(NtrrPaFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ntrr'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $ntrrPa = NtrrPa::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Notificación de Trámite de Recurso de Revocatoria PA No.: ' . $ntrrPa->numero_resolucion .
                             ' para la audiencia No.: ' . $ntrrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ntrrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ntrrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ntrrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Notificación de Trámite de Recurso de Revocatoria PA creado exitosamente');
    }

    public function update(NtrrPaFormRequest $request)
    {
        $data = $request->validated();
        
        $ntrrPa = NtrrPa::find($request->id);

        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($ntrrPa->archivo && file_exists(public_path('uploads/pa/ntrr/' . $ntrrPa->archivo))) {
                unlink(public_path('uploads/pa/ntrr/' . $ntrrPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ntrr'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $ntrrPa->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Notificación de Trámite de Recurso de Revocatoria PA No.: ' . $ntrrPa->numero_resolucion .
                             ' para la audiencia No.: ' . $ntrrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ntrrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ntrrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ntrrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect()->back()->with('success', 'Notificación Tipo Recurso de Reposición (PA) actualizada exitosamente');
    }

    public function destroy($id)
    {
        $ntrrPa = NtrrPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($ntrrPa->archivo && File::exists(public_path('uploads/pa/ntrr/' . $ntrrPa->archivo))) {
            File::delete(public_path('uploads/pa/ntrr/' . $ntrrPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Notificación de Trámite de Recurso de Revocatoria PA No.: ' . $ntrrPa->numero_resolucion .
                             ' para la audiencia No.: ' . $ntrrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ntrrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ntrrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ntrrPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $ntrrPa->audiencia_pa_id;
        $ntrrPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Notificación de Trámite de Recurso de Revocatoria PA eliminado exitosamente');
    }
}
