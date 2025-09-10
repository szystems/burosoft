<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AudienciaPa;
use App\Models\Pat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AudienciaPaController extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'pat_id' => 'required',
            'numero_audiencia' => 'required|string|max:255',
            'tipo_audiencia' => 'required|in:AEC,AIR,AS,AA,Otro',
            'tipo_audiencia_otro' => 'nullable|string|max:255|required_if:tipo_audiencia,Otro',
            'fecha' => 'required|date',
            'impuestos' => 'required|numeric|min:0',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'fecha_notificacion' => 'nullable|date',
            'plazo_evacuar' => 'nullable|in:5 Dias,10 Dias,30 Dias,Otro',
            'plazo_evacuar_otro' => 'nullable|string|max:255|required_if:plazo_evacuar,Otro',
        ]);

        $audienciaPa = new AudienciaPa();
        $audienciaPa->pat_id = $request->pat_id;
        $audienciaPa->usuario_id = Auth::user()->id;
        $audienciaPa->numero_audiencia = $request->numero_audiencia;
        $audienciaPa->tipo_audiencia = $request->tipo_audiencia;
        $audienciaPa->tipo_audiencia_otro = $request->tipo_audiencia_otro;
        $audienciaPa->fecha = $request->fecha;
        $audienciaPa->impuestos = $request->impuestos;
        $audienciaPa->fecha_notificacion = $request->fecha_notificacion;
        $audienciaPa->plazo_evacuar = $request->plazo_evacuar;
        $audienciaPa->plazo_evacuar_otro = $request->plazo_evacuar_otro;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/audiencias'), $filename);
            $audienciaPa->archivo = $filename;
            $audienciaPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $audienciaPa->save();

        return redirect('show-pa/' . $request->pat_id)->with('status', 'Audiencia PA creada exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_audiencia' => 'required|string|max:255',
            'tipo_audiencia' => 'required|in:AEC,AIR,AS,AA,Otro',
            'tipo_audiencia_otro' => 'nullable|string|max:255|required_if:tipo_audiencia,Otro',
            'fecha' => 'required|date',
            'impuestos' => 'required|numeric|min:0',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'fecha_notificacion' => 'nullable|date',
            'plazo_evacuar' => 'nullable|in:5 Dias,10 Dias,30 Dias,Otro',
            'plazo_evacuar_otro' => 'nullable|string|max:255|required_if:plazo_evacuar,Otro',
        ]);

        $audienciaPa = AudienciaPa::find($id);
        $audienciaPa->numero_audiencia = $request->numero_audiencia;
        $audienciaPa->tipo_audiencia = $request->tipo_audiencia;
        $audienciaPa->tipo_audiencia_otro = $request->tipo_audiencia_otro;
        $audienciaPa->fecha = $request->fecha;
        $audienciaPa->impuestos = $request->impuestos;
        $audienciaPa->fecha_notificacion = $request->fecha_notificacion;
        $audienciaPa->plazo_evacuar = $request->plazo_evacuar;
        $audienciaPa->plazo_evacuar_otro = $request->plazo_evacuar_otro;

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            // Eliminar archivo anterior si existe
            if ($audienciaPa->archivo && file_exists(public_path('uploads/pa/audiencias/' . $audienciaPa->archivo))) {
                unlink(public_path('uploads/pa/audiencias/' . $audienciaPa->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pa/audiencias'), $filename);
            $audienciaPa->archivo = $filename;
            $audienciaPa->tipo_archivo = $file->getClientOriginalExtension();
        }

        $audienciaPa->save();

        return redirect('show-pa/' . $audienciaPa->pat_id)->with('status', 'Audiencia PA actualizada exitosamente');
    }

    public function destroy($id)
    {
        $audienciaPa = AudienciaPa::find($id);
        $pat_id = $audienciaPa->pat_id;

        // Eliminar archivo si existe
        if ($audienciaPa->archivo && file_exists(public_path('uploads/pa/audiencias/' . $audienciaPa->archivo))) {
            unlink(public_path('uploads/pa/audiencias/' . $audienciaPa->archivo));
        }

        $audienciaPa->delete();

        return redirect('show-pa/' . $pat_id)->with('status', 'Audiencia PA eliminada exitosamente');
    }
}
