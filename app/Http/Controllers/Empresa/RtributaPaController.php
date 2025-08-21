<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RtributaPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RtributaPaController extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'audiencia_pa_id' => 'required',
            'fecha' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'tipo_resolucion' => 'required|in:total a favor,total en contra,parcial,nulidad,penal',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $data = $request->only([
            'audiencia_pa_id',
            'fecha',
            'numero_resolucion',
            'tipo_resolucion',
            'observaciones',
            'numero_folios',
        ]);
        $data['usuario_id'] = Auth::user()->id;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/rtributa'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $rtributaPa = RtributaPa::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva resolución R-Tributa PA No.: ' . $rtributaPa->numero_resolucion .
                             ', Expediente: ' . $rtributaPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $data['audiencia_pa_id'])->with('status', 'Resolución Tributaria PA creada exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'numero_resolucion' => 'required|string|max:255',
            'tipo_resolucion' => 'required|in:total a favor,total en contra,parcial,nulidad,penal',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'observaciones' => 'nullable|string',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $rtributaPa = RtributaPa::findOrFail($id);
        $rtributaPa->usuario_id = Auth::user()->id;
        $rtributaPa->fecha = $request->fecha;
        $rtributaPa->numero_resolucion = $request->numero_resolucion;
        $rtributaPa->tipo_resolucion = $request->tipo_resolucion;
        $rtributaPa->observaciones = $request->observaciones;
        $rtributaPa->numero_folios = $request->numero_folios;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($rtributaPa->archivo && File::exists(public_path('uploads/pa/rtributa/' . $rtributaPa->archivo))) {
                File::delete(public_path('uploads/pa/rtributa/' . $rtributaPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/rtributa'), $filename);
            $rtributaPa->archivo = $filename;
            $rtributaPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $rtributaPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Resolución Tributaria PA No.: ' . $rtributaPa->numero_resolucion .
                             ' para la audiencia No.: ' . $rtributaPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rtributaPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rtributaPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rtributaPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $rtributaPa->audiencia_pa_id)->with('status', 'Resolución Tributaria PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $rtributaPa = RtributaPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($rtributaPa->archivo && File::exists(public_path('uploads/pa/rtributa/' . $rtributaPa->archivo))) {
            File::delete(public_path('uploads/pa/rtributa/' . $rtributaPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Resolución Tributaria PA No.: ' . $rtributaPa->numero_resolucion .
                             ' para la audiencia No.: ' . $rtributaPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $rtributaPa->audienciaPa->pat->cuenta->codigo . ' - ' . $rtributaPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $rtributaPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $rtributaPa->audiencia_pa_id;
        $rtributaPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Resolución Tributaria PA eliminado exitosamente');
    }
}
