<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NulidadPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class NulidadPaController extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'audiencia_pa_id' => 'required',
            'fecha' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'tipo_nulidad' => 'required|string',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $nulidadPa = new NulidadPa();
        $nulidadPa->audiencia_pa_id = $request->audiencia_pa_id;
        $nulidadPa->usuario_id = Auth::user()->id;
        $nulidadPa->fecha = $request->fecha;
        $nulidadPa->numero_resolucion = $request->numero_resolucion;
        $nulidadPa->tipo_nulidad = $request->tipo_nulidad;
        $nulidadPa->observaciones = $request->observaciones;
        $nulidadPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/nulidad'), $filename);
            $nulidadPa->archivo = $filename;
            $nulidadPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $nulidadPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Solicitud de Nulidad PA No.: ' . $nulidadPa->numero_resolucion .
                             ' para la audiencia No.: ' . $nulidadPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $nulidadPa->audienciaPa->pat->cuenta->codigo . ' - ' . $nulidadPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $nulidadPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Solicitud de Nulidad PA creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'tipo_nulidad' => 'required|string',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $nulidadPa = NulidadPa::findOrFail($id);
        $nulidadPa->usuario_id = Auth::user()->id;
        $nulidadPa->fecha = $request->fecha;
        $nulidadPa->numero_resolucion = $request->numero_resolucion;
        $nulidadPa->tipo_nulidad = $request->tipo_nulidad;
        $nulidadPa->observaciones = $request->observaciones;
        $nulidadPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($nulidadPa->archivo && File::exists(public_path('uploads/pa/nulidad/' . $nulidadPa->archivo))) {
                File::delete(public_path('uploads/pa/nulidad/' . $nulidadPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/nulidad'), $filename);
            $nulidadPa->archivo = $filename;
            $nulidadPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $nulidadPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Solicitud de Nulidad PA No.: ' . $nulidadPa->numero_resolucion .
                             ' para la audiencia No.: ' . $nulidadPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $nulidadPa->audienciaPa->pat->cuenta->codigo . ' - ' . $nulidadPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $nulidadPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $nulidadPa->audiencia_pa_id)->with('status', 'Solicitud de Nulidad PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $nulidadPa = NulidadPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($nulidadPa->archivo && File::exists(public_path('uploads/pa/nulidad/' . $nulidadPa->archivo))) {
            File::delete(public_path('uploads/pa/nulidad/' . $nulidadPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Solicitud de Nulidad PA No.: ' . $nulidadPa->numero_resolucion .
                             ' para la audiencia No.: ' . $nulidadPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $nulidadPa->audienciaPa->pat->cuenta->codigo . ' - ' . $nulidadPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $nulidadPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $nulidadPa->audiencia_pa_id;
        $nulidadPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Solicitud de Nulidad PA eliminado exitosamente');
    }
}
