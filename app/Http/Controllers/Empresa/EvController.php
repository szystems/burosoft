<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EvFormRequest;
use App\Models\Ev;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class EvController extends Controller
{
    public function insert(EvFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/evacuaciones'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $ev = Ev::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva evacuación de audiencia No.: ' . $ev->numero_documento .
                             ' para la audiencia No.: ' . $ev->audiencia->numero_audiencia .
                             ', cuenta: ' . $ev->audiencia->pat->cuenta->codigo . ' - ' . $ev->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ev->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Evacuación de audiencia agregada exitosamente');
    }

    public function update(EvFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $ev = Ev::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/evacuaciones/' . $ev->archivo))) {
                File::delete(public_path('uploads/evacuaciones/' . $ev->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/evacuaciones'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $ev->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó la evacuación de audiencia No.: ' . $ev->numero_documento .
                             ' para la audiencia No.: ' . $ev->audiencia->numero_audiencia .
                             ', cuenta: ' . $ev->audiencia->pat->cuenta->codigo . ' - ' . $ev->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ev->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Evacuación de audiencia actualizada exitosamente');
    }

    public function destroy($id)
    {
        $ev = Ev::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/evacuaciones/' . $ev->archivo))) {
            File::delete(public_path('uploads/evacuaciones/' . $ev->archivo));
        }

        $ev->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó la evacuación de audiencia No.: ' . $ev->numero_documento .
                             ' para la audiencia No.: ' . $ev->audiencia->numero_audiencia .
                             ', cuenta: ' . $ev->audiencia->pat->cuenta->codigo . ' - ' . $ev->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ev->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $ev->audiencia_id)->with('status', 'Evacuación de audiencia eliminada exitosamente');
    }
}
