<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AmpmrPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AmpmrPaController extends Controller
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

        $ampmrPa = new AmpmrPa();
        $ampmrPa->audiencia_pa_id = $request->audiencia_pa_id;
        $ampmrPa->usuario_id = Auth::user()->id;
        $ampmrPa->fecha_hora_presentacion = $request->fecha_hora_presentacion;
        $ampmrPa->numero_documento = $request->numero_documento;
        $ampmrPa->observaciones = $request->observaciones;
        $ampmrPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ampmr'), $filename);
            $ampmrPa->archivo = $filename;
            $ampmrPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $ampmrPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Atención de Memorial Para Mejor Resolver PA No.: ' . $ampmrPa->numero_documento .
                             ' para la audiencia No.: ' . $ampmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ampmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ampmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ampmrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Atención de Memorial Para Mejor Resolver PA creado exitosamente');
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

        $ampmrPa = AmpmrPa::findOrFail($id);
        $ampmrPa->usuario_id = Auth::user()->id;
        $ampmrPa->fecha_hora_presentacion = $request->fecha_hora_presentacion;
        $ampmrPa->numero_documento = $request->numero_documento;
        $ampmrPa->observaciones = $request->observaciones;
        $ampmrPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($ampmrPa->archivo && File::exists(public_path('uploads/pa/ampmr/' . $ampmrPa->archivo))) {
                File::delete(public_path('uploads/pa/ampmr/' . $ampmrPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ampmr'), $filename);
            $ampmrPa->archivo = $filename;
            $ampmrPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $ampmrPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Atención de Memorial Para Mejor Resolver PA No.: ' . $ampmrPa->numero_contestacion .
                             ' para la audiencia No.: ' . $ampmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ampmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ampmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ampmrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $ampmrPa->audiencia_pa_id)->with('status', 'Atención de Memorial Para Mejor Resolver PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $ampmrPa = AmpmrPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($ampmrPa->archivo && File::exists(public_path('uploads/pa/ampmr/' . $ampmrPa->archivo))) {
            File::delete(public_path('uploads/pa/ampmr/' . $ampmrPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Atención de Memorial Para Mejor Resolver PA No.: ' . $ampmrPa->numero_contestacion .
                             ' para la audiencia No.: ' . $ampmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ampmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ampmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ampmrPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $ampmrPa->audiencia_pa_id;
        $ampmrPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Atención de Memorial Para Mejor Resolver PA eliminado exitosamente');
    }
}
