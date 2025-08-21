<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RoPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RoPaController extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'audiencia_pa_id' => 'required',
            'fecha' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'tipo_resolucion' => 'required|string',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $roPa = new RoPa();
        $roPa->audiencia_pa_id = $request->audiencia_pa_id;
        $roPa->usuario_id = Auth::user()->id;
        $roPa->fecha = $request->fecha;
        $roPa->numero_resolucion = $request->numero_resolucion;
        $roPa->tipo_resolucion = $request->tipo_resolucion;
        $roPa->observaciones = $request->observaciones;
        $roPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ro'), $filename);
            $roPa->archivo = $filename;
            $roPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $roPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Resolución de Ocurso PA No.: ' . $roPa->numero_documento .
                             ' para la audiencia No.: ' . $roPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $roPa->audienciaPa->pat->cuenta->codigo . ' - ' . $roPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $roPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Resolución de Ocurso PA creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'tipo_resolucion' => 'required|string',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $roPa = RoPa::findOrFail($id);
        $roPa->usuario_id = Auth::user()->id;
        $roPa->fecha = $request->fecha;
        $roPa->numero_resolucion = $request->numero_resolucion;
        $roPa->tipo_resolucion = $request->tipo_resolucion;
        $roPa->observaciones = $request->observaciones;
        $roPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($roPa->archivo && File::exists(public_path('uploads/pa/ro/' . $roPa->archivo))) {
                File::delete(public_path('uploads/pa/ro/' . $roPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/ro'), $filename);
            $roPa->archivo = $filename;
            $roPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $roPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Resolución de Ocurso PA No.: ' . $roPa->numero_documento .
                             ' para la audiencia No.: ' . $roPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $roPa->audienciaPa->pat->cuenta->codigo . ' - ' . $roPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $roPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $roPa->audiencia_pa_id)->with('status', 'Resolución de Ocurso PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $roPa = RoPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($roPa->archivo && File::exists(public_path('uploads/pa/ro/' . $roPa->archivo))) {
            File::delete(public_path('uploads/pa/ro/' . $roPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Resolución de Ocurso PA No.: ' . $roPa->numero_documento .
                             ' para la audiencia No.: ' . $roPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $roPa->audienciaPa->pat->cuenta->codigo . ' - ' . $roPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $roPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $roPa->audiencia_pa_id;
        $roPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Resolución de Ocurso PA eliminado exitosamente');
    }
}
