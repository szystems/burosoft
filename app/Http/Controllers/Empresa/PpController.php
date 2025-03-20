<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PpFormRequest;
use App\Models\Pp;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PpController extends Controller
{
    public function insert(PpFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ppacuaciones'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $pp = Pp::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó un Periodo de Prueba No.: ' . $pp->numero_documento .
                             ' para la audiencia No.: ' . $pp->audiencia->numero_audiencia .
                             ', cuenta: ' . $pp->audiencia->pat->cuenta->codigo . ' - ' . $pp->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $pp->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Periodo de Prueba agregado exitosamente');
    }

    public function update(PpFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $pp = Pp::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/ppacuaciones/' . $pp->archivo))) {
                File::delete(public_path('uploads/ppacuaciones/' . $pp->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ppacuaciones'), $filename);
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
                             ' para la audiencia No.: ' . $pp->audiencia->numero_audiencia .
                             ', cuenta: ' . $pp->audiencia->pat->cuenta->codigo . ' - ' . $pp->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $pp->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Periodo de Prueba actualizado exitosamente');
    }

    public function destroy($id)
    {
        $pp = Pp::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/ppacuaciones/' . $pp->archivo))) {
            File::delete(public_path('uploads/ppacuaciones/' . $pp->archivo));
        }

        $pp->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó el periodo de Prueba No.: ' . $pp->numero_documento .
                             ' para la audiencia No.: ' . $pp->audiencia->numero_audiencia .
                             ', cuenta: ' . $pp->audiencia->pat->cuenta->codigo . ' - ' . $pp->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $pp->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $pp->audiencia_id)->with('status', 'Periodo de Prueba eliminado exitosamente');
    }
}
