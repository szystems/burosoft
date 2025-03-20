<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RrFormRequest;
use App\Models\Rr;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RrController extends Controller
{
    public function insert(RrFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/rrs'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $rr = Rr::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó un recurso de revocatoria No.: ' . $rr->numero_documento .
                             ' para la audiencia No.: ' . $rr->audiencia->numero_audiencia .
                             ', cuenta: ' . $rr->audiencia->pat->cuenta->codigo . ' - ' . $rr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $rr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Recurso de revocatoria agregado exitosamente');
    }

    public function update(RrFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $rr = Rr::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/rrs/' . $rr->archivo))) {
                File::delete(public_path('uploads/rrs/' . $rr->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/rrs'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $rr->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó el recurso de revocatoria No.: ' . $rr->numero_documento .
                             ' para la audiencia No.: ' . $rr->audiencia->numero_audiencia .
                             ', cuenta: ' . $rr->audiencia->pat->cuenta->codigo . ' - ' . $rr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $rr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Recurso de revocatoria actualizado exitosamente');
    }

    public function destroy($id)
    {
        $rr = Rr::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/rrs/' . $rr->archivo))) {
            File::delete(public_path('uploads/rrs/' . $rr->archivo));
        }

        $rr->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó el recurso de revocatoria No.: ' . $rr->numero_documento .
                             ' para la audiencia No.: ' . $rr->audiencia->numero_audiencia .
                             ', cuenta: ' . $rr->audiencia->pat->cuenta->codigo . ' - ' . $rr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $rr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $rr->audiencia_id)->with('status', 'Recurso de revocatoria eliminado exitosamente');
    }
}
