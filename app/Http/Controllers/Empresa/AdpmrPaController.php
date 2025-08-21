<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdpmrPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdpmrPaController extends Controller
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

        $adpmrPa = new AdpmrPa();
        $adpmrPa->audiencia_pa_id = $request->audiencia_pa_id;
        $adpmrPa->usuario_id = Auth::user()->id;
        $adpmrPa->fecha_hora_presentacion = $request->fecha_hora_presentacion;
        $adpmrPa->numero_documento = $request->numero_documento;
        $adpmrPa->observaciones = $request->observaciones;
        $adpmrPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/adpmr'), $filename);
            $adpmrPa->archivo = $filename;
            $adpmrPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $adpmrPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Atención de Diligencia Para Mejor Resolver PA No.: ' . $adpmrPa->numero_contestacion .
                             ' para la audiencia No.: ' . $adpmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $adpmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $adpmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $adpmrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Atención de Diligencia Para Mejor Resolver PA creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'audiencia_pa_id' => 'required',
            'fecha_hora_presentacion' => 'required|date',
            'numero_documento' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $adpmrPa = AdpmrPa::findOrFail($id);
        $adpmrPa->audiencia_pa_id = $request->audiencia_pa_id;
        $adpmrPa->usuario_id = Auth::user()->id;
        $adpmrPa->fecha_hora_presentacion = $request->fecha_hora_presentacion;
        $adpmrPa->numero_documento = $request->numero_documento;
        $adpmrPa->observaciones = $request->observaciones;
        $adpmrPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($adpmrPa->archivo && File::exists(public_path('uploads/pa/adpmr/' . $adpmrPa->archivo))) {
                File::delete(public_path('uploads/pa/adpmr/' . $adpmrPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/adpmr'), $filename);
            $adpmrPa->archivo = $filename;
            $adpmrPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $adpmrPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Atención de Diligencia Para Mejor Resolver PA No.: ' . $adpmrPa->numero_contestacion .
                             ' para la audiencia No.: ' . $adpmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $adpmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $adpmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $adpmrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $adpmrPa->audiencia_pa_id)->with('status', 'Atención de Diligencia Para Mejor Resolver PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $adpmrPa = AdpmrPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($adpmrPa->archivo && File::exists(public_path('uploads/pa/adpmr/' . $adpmrPa->archivo))) {
            File::delete(public_path('uploads/pa/adpmr/' . $adpmrPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Atención de Diligencia Para Mejor Resolver PA No.: ' . $adpmrPa->numero_contestacion .
                             ' para la audiencia No.: ' . $adpmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $adpmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $adpmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $adpmrPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $adpmrPa->audiencia_pa_id;
        $adpmrPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Atención de Diligencia Para Mejor Resolver PA eliminado exitosamente');
    }
}
