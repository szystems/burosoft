<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NtrrPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class NtrrPaController extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'audiencia_pa_id' => 'required',
            'fecha' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $ntrrPa = new NtrrPa();
        $ntrrPa->audiencia_pa_id = $request->audiencia_pa_id;
        $ntrrPa->usuario_id = Auth::user()->id;
        $ntrrPa->fecha = $request->fecha;
        $ntrrPa->numero_resolucion = $request->numero_resolucion;
        $ntrrPa->observaciones = $request->observaciones;
        $ntrrPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ntrr'), $filename);
            $ntrrPa->archivo = $filename;
            $ntrrPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $ntrrPa->save();

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

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $ntrrPa = NtrrPa::findOrFail($id);
        $ntrrPa->usuario_id = Auth::user()->id;
        $ntrrPa->fecha = $request->fecha;
        $ntrrPa->numero_resolucion = $request->numero_resolucion;
        $ntrrPa->observaciones = $request->observaciones;
        $ntrrPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($ntrrPa->archivo && File::exists(public_path('uploads/pa/ntrr/' . $ntrrPa->archivo))) {
                File::delete(public_path('uploads/pa/ntrr/' . $ntrrPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ntrr'), $filename);
            $ntrrPa->archivo = $filename;
            $ntrrPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $ntrrPa->save();

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

        return redirect('show-audiencia-pa/' . $ntrrPa->audiencia_pa_id)->with('status', 'Notificación de Trámite de Recurso de Revocatoria PA actualizado exitosamente');
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
