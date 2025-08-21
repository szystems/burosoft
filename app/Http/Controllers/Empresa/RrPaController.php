<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RrPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RrPaController extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'audiencia_pa_id' => 'required',
            'fecha_hora_presentacion' => 'required|date',
            'numero_documento' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $rrPa = new RrPa();
        $rrPa->audiencia_pa_id = $request->audiencia_pa_id;
        $rrPa->usuario_id = Auth::user()->id;
        $rrPa->fecha_hora_presentacion = $request->fecha_hora_presentacion;
        $rrPa->numero_documento = $request->numero_documento;
        $rrPa->observaciones = $request->observaciones;
        $rrPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/rr'), $filename);
            $rrPa->archivo = $filename;
            $rrPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $rrPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Recurso de Revocatoria PA No.: ' . $rrPa->numero_documento .
                             ' para la audiencia No.: ' . $rrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Recurso de Revocatoria PA creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_hora_presentacion' => 'required|date',
            'numero_documento' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $rrPa = RrPa::findOrFail($id);
        $rrPa->usuario_id = Auth::user()->id;
        $rrPa->fecha_hora_presentacion = $request->fecha_hora_presentacion;
        $rrPa->numero_documento = $request->numero_documento;
        $rrPa->observaciones = $request->observaciones;
        $rrPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($rrPa->archivo && File::exists(public_path('uploads/pa/rr/' . $rrPa->archivo))) {
                File::delete(public_path('uploads/pa/rr/' . $rrPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/rr'), $filename);
            $rrPa->archivo = $filename;
            $rrPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $rrPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Recurso de Revocatoria PA No.: ' . $rrPa->numero_documento .
                             ' para la audiencia No.: ' . $rrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $rrPa->audiencia_pa_id)->with('status', 'Recurso de Revocatoria PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $rrPa = RrPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($rrPa->archivo && File::exists(public_path('uploads/pa/rr/' . $rrPa->archivo))) {
            File::delete(public_path('uploads/pa/rr/' . $rrPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Recurso de Revocatoria PA No.: ' . $rrPa->numero_documento .
                             ' para la audiencia No.: ' . $rrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rrPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $rrPa->audiencia_pa_id;
        $rrPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Recurso de Revocatoria PA eliminado exitosamente');
    }
}
