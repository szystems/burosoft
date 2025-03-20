<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AudienciaFormRequest;
use App\Models\Audiencia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Bitacora;

class AudienciaController extends Controller
{
    public function insert(AudienciaFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/va/audiencias'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $audiencia = Audiencia::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva audiencia No.: ' . $audiencia->numero_audiencia .
                             ' para la cuenta: ' . $audiencia->pat->cuenta->codigo . ' - ' . $audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $audiencia->pat->no_expediente
        ]);

        return redirect('show-va/' . $data['pat_id'])->with('status', 'Audiencia agregada exitosamente');
    }

    public function update(AudienciaFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $audiencia = Audiencia::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/va/audiencias/' . $audiencia->archivo))) {
                File::delete(public_path('uploads/va/audiencias/' . $audiencia->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/va/audiencias'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $audiencia->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó la audiencia No.: ' . $audiencia->numero_audiencia .
                             ' para la cuenta: ' . $audiencia->pat->cuenta->codigo . ' - ' . $audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $audiencia->pat->no_expediente
        ]);

        return redirect('show-va/' . $data['pat_id'])->with('status', 'Audiencia actualizada exitosamente');
    }

    public function destroy($id)
    {
        $audiencia = Audiencia::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/va/audiencias/' . $audiencia->archivo))) {
            File::delete(public_path('uploads/va/audiencias/' . $audiencia->archivo));
        }

        $audiencia->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó la audiencia No.: ' . $audiencia->numero_audiencia .
                             ' para la cuenta: ' . $audiencia->pat->cuenta->codigo . ' - ' . $audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $audiencia->pat->no_expediente
        ]);

        return redirect('show-va/' . $audiencia->pat_id)->with('status', 'Audiencia eliminada exitosamente');
    }
}
