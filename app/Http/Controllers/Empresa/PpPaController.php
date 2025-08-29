<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PpPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PpPaController extends Controller
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
            'oficina_presentacion' => 'nullable|string|max:255',
        ]);

        $ppPa = new PpPa();
        $ppPa->audiencia_pa_id = $request->audiencia_pa_id;
        $ppPa->usuario_id = Auth::user()->id;
        $ppPa->fecha_hora_presentacion = $request->fecha_hora_presentacion;
        $ppPa->numero_documento = $request->numero_documento;
        $ppPa->observaciones = $request->observaciones;
        $ppPa->numero_folios = $request->numero_folios;
        $ppPa->oficina_presentacion = $request->oficina_presentacion;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ppacuaciones'), $filename);
            $ppPa->archivo = $filename;
            $ppPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $ppPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó un Periodo de Prueba PA No.: ' . $ppPa->numero_documento .
                             ' para la audiencia No.: ' . $ppPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ppPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ppPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ppPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Periodo de Prueba PA creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_hora_presentacion' => 'required|date',
            'numero_documento' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
            'oficina_presentacion' => 'nullable|string|max:255',
        ]);

        $ppPa = PpPa::findOrFail($id);
        $ppPa->usuario_id = Auth::user()->id;
        $ppPa->fecha_hora_presentacion = $request->fecha_hora_presentacion;
        $ppPa->numero_documento = $request->numero_documento;
        $ppPa->observaciones = $request->observaciones;
        $ppPa->numero_folios = $request->numero_folios;
        $ppPa->oficina_presentacion = $request->oficina_presentacion;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($ppPa->archivo && File::exists(public_path('uploads/pa/ppacuaciones/' . $ppPa->archivo))) {
                File::delete(public_path('uploads/pa/ppacuaciones/' . $ppPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ppacuaciones'), $filename);
            $ppPa->archivo = $filename;
            $ppPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $ppPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó el Periodo de Prueba PA No.: ' . $ppPa->numero_documento .
                             ' para la audiencia No.: ' . $ppPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ppPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ppPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ppPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $ppPa->audiencia_pa_id)->with('status', 'Periodo de Prueba PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $ppPa = PpPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($ppPa->archivo && File::exists(public_path('uploads/pa/ppacuaciones/' . $ppPa->archivo))) {
            File::delete(public_path('uploads/pa/ppacuaciones/' . $ppPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó el Periodo de Prueba PA No.: ' . $ppPa->numero_documento .
                             ' para la audiencia No.: ' . $ppPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ppPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ppPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ppPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $ppPa->audiencia_pa_id;
        $ppPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Periodo de Prueba PA eliminado exitosamente');
    }
}
