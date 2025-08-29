<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EcPa;
use App\Models\AudienciaPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class EcPaController extends Controller
{
    public function insert(Request $request)
    {
        $request->validate([
            'audiencia_pa_id' => 'required',
            'numero_resolucion' => 'required|string|max:1000',
            'fecha_hora_notificacion' => 'nullable|date',
            'fecha_resolucion' => 'nullable|date',
            'juzgado_que_conoce' => 'nullable|string|max:500',
            'medidas_decretadas' => 'nullable|array',
            'medidas_decretadas.*' => 'nullable|string|in:Arraigo,Bloqueo de cuentas,Bloqueo de Vehiculos,Bloqueo de bienes inmuebles,Interventor,Otro',
            'medidas_decretadas_otro' => 'nullable|string|max:500',
            'observaciones' => 'nullable|string|max:5000',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $ecPa = new EcPa();
        $ecPa->audiencia_pa_id = $request->audiencia_pa_id;
        $ecPa->usuario_id = Auth::user()->id;
        $ecPa->numero_resolucion = $request->numero_resolucion;
        $ecPa->fecha_hora_notificacion = $request->fecha_hora_notificacion;
        $ecPa->fecha_resolucion = $request->fecha_resolucion;
        $ecPa->juzgado_que_conoce = $request->juzgado_que_conoce;
        $ecPa->medidas_decretadas = $request->medidas_decretadas;
        $ecPa->medidas_decretadas_otro = $request->medidas_decretadas_otro;
        $ecPa->observaciones = $request->observaciones;
        $ecPa->numero_folios = $request->numero_folios;

        $ecPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó Escrito de Conclusiones PA No.: ' . $ecPa->numero_resolucion .
                             ' para la audiencia No.: ' . $ecPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ecPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ecPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ecPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $request->audiencia_pa_id)->with('status', 'Escrito de Conclusiones PA creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero_resolucion' => 'required|string|max:1000',
            'fecha_hora_notificacion' => 'nullable|date',
            'fecha_resolucion' => 'nullable|date',
            'juzgado_que_conoce' => 'nullable|string|max:500',
            'medidas_decretadas' => 'nullable|array',
            'medidas_decretadas.*' => 'nullable|string|in:Arraigo,Bloqueo de cuentas,Bloqueo de Vehiculos,Bloqueo de bienes inmuebles,Interventor,Otro',
            'medidas_decretadas_otro' => 'nullable|string|max:500',
            'observaciones' => 'nullable|string|max:5000',
            'numero_folios' => 'nullable|integer|min:1',
        ]);

        $ecPa = EcPa::findOrFail($id);
        $ecPa->usuario_id = Auth::user()->id;
        $ecPa->numero_resolucion = $request->numero_resolucion;
        $ecPa->fecha_hora_notificacion = $request->fecha_hora_notificacion;
        $ecPa->fecha_resolucion = $request->fecha_resolucion;
        $ecPa->juzgado_que_conoce = $request->juzgado_que_conoce;
        $ecPa->medidas_decretadas = $request->medidas_decretadas;
        $ecPa->medidas_decretadas_otro = $request->medidas_decretadas_otro;
        $ecPa->observaciones = $request->observaciones;
        $ecPa->numero_folios = $request->numero_folios;

        $ecPa->save();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó Escrito de Conclusiones PA No.: ' . $ecPa->numero_resolucion .
                             ' para la audiencia No.: ' . $ecPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ecPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ecPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ecPa->audienciaPa->pat->no_expediente
        ]);

        return redirect('show-audiencia-pa/' . $ecPa->audiencia_pa_id)->with('status', 'Escrito de Conclusiones PA actualizado exitosamente');
    }

    public function destroy($id)
    {
        $ecPa = EcPa::findOrFail($id);

        // Eliminar archivo asociado si existe
        if ($ecPa->archivo && File::exists(public_path('uploads/pa/ec/' . $ecPa->archivo))) {
            File::delete(public_path('uploads/pa/ec/' . $ecPa->archivo));
        }

        // Insertar en Bitácora antes de eliminar
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó Escrito de Conclusiones PA No.: ' . $ecPa->numero_resolucion .
                             ' para la audiencia No.: ' . $ecPa->audienciaPa->numero_audiencia .
                             ', cuenta: ' . $ecPa->audienciaPa->pat->cuenta->codigo . ' - ' . $ecPa->audienciaPa->pat->cuenta->razon_social .
                             ', Expediente: ' . $ecPa->audienciaPa->pat->no_expediente
        ]);

        $audiencia_pa_id = $ecPa->audiencia_pa_id;
        $ecPa->delete();

        return redirect('show-audiencia-pa/' . $audiencia_pa_id)->with('status', 'Escrito de Conclusiones PA eliminado exitosamente');
    }
}
