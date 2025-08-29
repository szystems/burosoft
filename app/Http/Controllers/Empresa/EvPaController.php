<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EvPa;
use App\Models\AudienciaPa;
use Illuminate\Support\Facades\Auth;

class EvPaController extends Controller
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

        $evPa = new EvPa();
        $evPa->audiencia_pa_id = $request->audiencia_pa_id;
        $evPa->usuario_id = Auth::user()->id;
        $evPa->fecha_hora_presentacion = $request->fecha_hora_presentacion;
        $evPa->numero_documento = $request->numero_documento;
        $evPa->observaciones = $request->observaciones;
        $evPa->numero_folios = $request->numero_folios;
        $evPa->oficina_presentacion = $request->oficina_presentacion;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ev'), $filename);
            $evPa->archivo = $filename;
            $evPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $evPa->save();

        $audienciaPa = AudienciaPa::find($request->audiencia_pa_id);
        return redirect('show-audiencia-pa/' . $audienciaPa->id)->with('status', 'Evacuación PA creada exitosamente');
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

        $evPa = EvPa::find($id);
        $evPa->fecha_hora_presentacion = $request->fecha_hora_presentacion;
        $evPa->numero_documento = $request->numero_documento;
        $evPa->observaciones = $request->observaciones;
        $evPa->numero_folios = $request->numero_folios;
        $evPa->oficina_presentacion = $request->oficina_presentacion;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($evPa->archivo && file_exists(public_path('uploads/pa/ev/' . $evPa->archivo))) {
                unlink(public_path('uploads/pa/ev/' . $evPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ev'), $filename);
            $evPa->archivo = $filename;
            $evPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $evPa->save();

        return redirect('show-audiencia-pa/' . $evPa->audiencia_pa_id)->with('status', 'Evacuación PA actualizada exitosamente');
    }

    public function destroy($id)
    {
        $evPa = EvPa::find($id);
        $audiencia_pa_id = $evPa->audiencia_pa_id;

        // Eliminar archivo si existe
        if ($evPa->archivo && file_exists(public_path('uploads/pa/ev/' . $evPa->archivo))) {
            unlink(public_path('uploads/pa/ev/' . $evPa->archivo));
        }

        $evPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Evacuación PA eliminada exitosamente');
    }
}
