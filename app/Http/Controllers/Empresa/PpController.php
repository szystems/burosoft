<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PpFormRequest;
use App\Models\Pp;
use App\Models\PpPa;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PpController extends Controller
{
    public function insert(PpFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        // Detectar si es PA basándose en audiencia_pa_id o flag is_pa
        $isPa = $request->has('audiencia_pa_id') || $request->has('is_pa');
        
        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $uploadPath = $isPa ? 'uploads/pa/ppacuaciones' : 'uploads/ppacuaciones';
            $file->move(public_path($uploadPath), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        if ($isPa) {
            $pp = PpPa::create($data);
            $redirectRoute = 'show-audiencia-pa/' . $data['audiencia_pa_id'];
        } else {
            $pp = Pp::create($data);
            $redirectRoute = 'show-audiencia/' . $data['audiencia_id'];
        }

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó un Periodo de Prueba No.: ' . $pp->numero_documento . 
                             ($isPa ? ' (PA)' : ' (VA)') .
                             ' para la audiencia No.: ' . ($isPa ? $pp->audienciaPa->numero_audiencia : $pp->audiencia->numero_audiencia) .
                             ', cuenta: ' . ($isPa ? $pp->audienciaPa->pat->cuenta->codigo : $pp->audiencia->pat->cuenta->codigo) . ' - ' . 
                             ($isPa ? $pp->audienciaPa->pat->cuenta->razon_social : $pp->audiencia->pat->cuenta->razon_social) .
                             ', Expediente: ' . ($isPa ? $pp->audienciaPa->pat->no_expediente : $pp->audiencia->pat->no_expediente)
        ]);

        return redirect($redirectRoute)->with('status', 'Periodo de Prueba agregado exitosamente');
    }

    public function update(PpFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        // Detectar si es PA basándose en audiencia_pa_id o flag is_pa
        $isPa = $request->has('audiencia_pa_id') || $request->has('is_pa');
        
        if ($isPa) {
            $pp = PpPa::findOrFail($id);
            $uploadPath = 'uploads/pa/ppacuaciones';
            $redirectRoute = 'show-audiencia-pa/' . $data['audiencia_pa_id'];
        } else {
            $pp = Pp::findOrFail($id);
            $uploadPath = 'uploads/ppacuaciones';
            $redirectRoute = 'show-audiencia/' . $data['audiencia_id'];
        }

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path($uploadPath . '/' . $pp->archivo))) {
                File::delete(public_path($uploadPath . '/' . $pp->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($uploadPath), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $pp->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó el periodo de Prueba No.: ' . $pp->numero_documento . 
                             ($isPa ? ' (PA)' : ' (VA)') .
                             ' para la audiencia No.: ' . ($isPa ? $pp->audienciaPa->numero_audiencia : $pp->audiencia->numero_audiencia) .
                             ', cuenta: ' . ($isPa ? $pp->audienciaPa->pat->cuenta->codigo : $pp->audiencia->pat->cuenta->codigo) . ' - ' . 
                             ($isPa ? $pp->audienciaPa->pat->cuenta->razon_social : $pp->audiencia->pat->cuenta->razon_social) .
                             ', Expediente: ' . ($isPa ? $pp->audienciaPa->pat->no_expediente : $pp->audiencia->pat->no_expediente)
        ]);

        return redirect($redirectRoute)->with('status', 'Periodo de Prueba actualizado exitosamente');
    }

    public function destroy(Request $request, $id)
    {
        // Detectar si es PA basándose en flag is_pa o verificando el modelo
        $isPa = $request->has('is_pa');
        
        if ($isPa) {
            $pp = PpPa::findOrFail($id);
            $uploadPath = 'uploads/pa/ppacuaciones';
            $redirectRoute = 'show-audiencia-pa/' . $pp->audiencia_pa_id;
        } else {
            $pp = Pp::findOrFail($id);
            $uploadPath = 'uploads/ppacuaciones';
            $redirectRoute = 'show-audiencia/' . $pp->audiencia_id;
        }

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path($uploadPath . '/' . $pp->archivo))) {
            File::delete(public_path($uploadPath . '/' . $pp->archivo));
        }

        $pp->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó el periodo de Prueba No.: ' . $pp->numero_documento . 
                             ($isPa ? ' (PA)' : ' (VA)') .
                             ' para la audiencia No.: ' . ($isPa ? $pp->audienciaPa->numero_audiencia : $pp->audiencia->numero_audiencia) .
                             ', cuenta: ' . ($isPa ? $pp->audienciaPa->pat->cuenta->codigo : $pp->audiencia->pat->cuenta->codigo) . ' - ' . 
                             ($isPa ? $pp->audienciaPa->pat->cuenta->razon_social : $pp->audiencia->pat->cuenta->razon_social) .
                             ', Expediente: ' . ($isPa ? $pp->audienciaPa->pat->no_expediente : $pp->audiencia->pat->no_expediente)
        ]);

        return redirect($redirectRoute)->with('status', 'Periodo de Prueba eliminado exitosamente');
    }
}
