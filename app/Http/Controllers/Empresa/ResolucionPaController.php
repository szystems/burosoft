<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RsatPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ResolucionPaController extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'audiencia_pa_id' => 'required',
            'fecha' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'tipo_resolucion' => 'required|string|in:total a favor,total en contra,parcial,nulidad,penal',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $rsatPa = new RsatPa();
        $rsatPa->audiencia_pa_id = $request->audiencia_pa_id;
        $rsatPa->usuario_id = Auth::user()->id;
        $rsatPa->fecha = $request->fecha;
        $rsatPa->numero_resolucion = $request->numero_resolucion;
        $rsatPa->tipo_resolucion = $request->tipo_resolucion;
        $rsatPa->observaciones = $request->observaciones;
        $rsatPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/resolucion'), $filename);
            $rsatPa->archivo = $filename;
            $rsatPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $rsatPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Resolución PA No.: ' . $rsatPa->numero_resolucion .
                             ' para la audiencia No.: ' . $rsatPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rsatPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rsatPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rsatPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Resolución PA creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'tipo_resolucion' => 'required|string|in:total a favor,total en contra,parcial,nulidad,penal',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $rsatPa = RsatPa::findOrFail($id);
        $rsatPa->usuario_id = Auth::user()->id;
        $rsatPa->fecha = $request->fecha;
        $rsatPa->numero_resolucion = $request->numero_resolucion;
        $rsatPa->tipo_resolucion = $request->tipo_resolucion;
        $rsatPa->observaciones = $request->observaciones;
        $rsatPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($rsatPa->archivo && File::exists(public_path('uploads/pa/resolucion/' . $rsatPa->archivo))) {
                File::delete(public_path('uploads/pa/resolucion/' . $rsatPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/resolucion'), $filename);
            $rsatPa->archivo = $filename;
            $rsatPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $rsatPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Resolución PA No.: ' . $rsatPa->numero_resolucion .
                             ' para la audiencia No.: ' . $rsatPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rsatPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rsatPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rsatPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $rsatPa->audiencia_pa_id)->with('status', 'Resolución PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $rsatPa = RsatPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($rsatPa->archivo && File::exists(public_path('uploads/pa/resolucion/' . $rsatPa->archivo))) {
            File::delete(public_path('uploads/pa/resolucion/' . $rsatPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Resolución PA No.: ' . $rsatPa->numero_resolucion .
                             ' para la audiencia No.: ' . $rsatPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rsatPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rsatPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rsatPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $rsatPa->audiencia_pa_id;
        $rsatPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Resolución PA eliminado exitosamente');
    }
}
