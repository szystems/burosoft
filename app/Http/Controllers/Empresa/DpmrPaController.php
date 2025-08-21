<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DpmrPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DpmrPaController extends Controller
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

        $dpmrPa = new DpmrPa();
        $dpmrPa->audiencia_pa_id = $request->audiencia_pa_id;
        $dpmrPa->usuario_id = Auth::user()->id;
        $dpmrPa->fecha_hora = $request->fecha_hora;
        $dpmrPa->numero_resolucion = $request->numero_resolucion;
        $dpmrPa->observaciones = $request->observaciones;
        $dpmrPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/dpmr'), $filename);
            $dpmrPa->archivo = $filename;
            $dpmrPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $dpmrPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Diligencia Para Mejor Resolver PA No.: ' . $dpmrPa->numero_resolucion .
                             ' para la audiencia No.: ' . $dpmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $dpmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $dpmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $dpmrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Diligencia Para Mejor Resolver PA creado exitosamente');
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

        $dpmrPa = DpmrPa::findOrFail($id);
        $dpmrPa->usuario_id = Auth::user()->id;
        $dpmrPa->fecha_hora = $request->fecha_hora;
        $dpmrPa->numero_resolucion = $request->numero_resolucion;
        $dpmrPa->observaciones = $request->observaciones;
        $dpmrPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($dpmrPa->archivo && File::exists(public_path('uploads/pa/dpmr/' . $dpmrPa->archivo))) {
                File::delete(public_path('uploads/pa/dpmr/' . $dpmrPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/dpmr'), $filename);
            $dpmrPa->archivo = $filename;
            $dpmrPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $dpmrPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Diligencia Para Mejor Resolver PA No.: ' . $dpmrPa->numero_resolucion .
                             ' para la audiencia No.: ' . $dpmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $dpmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $dpmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $dpmrPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $dpmrPa->audiencia_pa_id)->with('status', 'Diligencia Para Mejor Resolver PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $dpmrPa = DpmrPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($dpmrPa->archivo && File::exists(public_path('uploads/pa/dpmr/' . $dpmrPa->archivo))) {
            File::delete(public_path('uploads/pa/dpmr/' . $dpmrPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Diligencia Para Mejor Resolver PA No.: ' . $dpmrPa->numero_resolucion .
                             ' para la audiencia No.: ' . $dpmrPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $dpmrPa->audienciaPa->pat->cuenta->codigo . ' - ' . $dpmrPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $dpmrPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $dpmrPa->audiencia_pa_id;
        $dpmrPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Diligencia Para Mejor Resolver PA eliminado exitosamente');
    }
}
