<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MpmrPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class MpmrPaController extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'audiencia_pa_id' => 'required',
            'fecha_hora' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $mpmrPa = new MpmrPa();
        $mpmrPa->audiencia_pa_id = $request->audiencia_pa_id;
        $mpmrPa->usuario_id = Auth::user()->id;
        $mpmrPa->fecha_hora = $request->fecha_hora;
        $mpmrPa->numero_resolucion = $request->numero_resolucion;
        $mpmrPa->observaciones = $request->observaciones;
        $mpmrPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/mpmr'), $filename);
            $mpmrPa->archivo = $filename;
            $mpmrPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $mpmrPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Memorial Para Mejor Resolver PA No.: ' . $mpmrPa->numero_resolucion .
                             ' para la audiencia No.: ' . $mpmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $mpmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $mpmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $mpmrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Memorial Para Mejor Resolver PA creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_hora' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $mpmrPa = MpmrPa::findOrFail($id);
        $mpmrPa->usuario_id = Auth::user()->id;
        $mpmrPa->fecha_hora = $request->fecha_hora;
        $mpmrPa->numero_resolucion = $request->numero_resolucion;
        $mpmrPa->observaciones = $request->observaciones;
        $mpmrPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($mpmrPa->archivo && File::exists(public_path('uploads/pa/mpmr/' . $mpmrPa->archivo))) {
                File::delete(public_path('uploads/pa/mpmr/' . $mpmrPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/mpmr'), $filename);
            $mpmrPa->archivo = $filename;
            $mpmrPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $mpmrPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Memorial Para Mejor Resolver PA No.: ' . $mpmrPa->numero_resolucion .
                             ' para la audiencia No.: ' . $mpmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $mpmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $mpmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $mpmrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $mpmrPa->audiencia_pa_id)->with('status', 'Memorial Para Mejor Resolver PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $mpmrPa = MpmrPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($mpmrPa->archivo && File::exists(public_path('uploads/pa/mpmr/' . $mpmrPa->archivo))) {
            File::delete(public_path('uploads/pa/mpmr/' . $mpmrPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Memorial Para Mejor Resolver PA No.: ' . $mpmrPa->numero_resolucion .
                             ' para la audiencia No.: ' . $mpmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $mpmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $mpmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $mpmrPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $mpmrPa->audiencia_pa_id;
        $mpmrPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Memorial Para Mejor Resolver PA eliminado exitosamente');
    }
}
