<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NtrrFormRequest;
use App\Models\Ntrr;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class NtrrController extends Controller
{
    public function insert(NtrrFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ntrrs'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $ntrr = Ntrr::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva negativa de trámite recurso de revocatoria No.: ' . $ntrr->numero_resolucion .
                             ' para la audiencia No.: ' . $ntrr->audiencia->numero_audiencia .
                             ', cuenta: ' . $ntrr->audiencia->pat->cuenta->codigo . ' - ' . $ntrr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ntrr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Negativa de trámite recurso de revocatoria agregada exitosamente');
    }

    public function update(NtrrFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $ntrr = Ntrr::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/ntrrs/' . $ntrr->archivo))) {
                File::delete(public_path('uploads/ntrrs/' . $ntrr->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ntrrs'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $ntrr->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó la negativa de trámite recurso de revocatoria No.: ' . $ntrr->numero_resolucion .
                             ' para la audiencia No.: ' . $ntrr->audiencia->numero_audiencia .
                             ', cuenta: ' . $ntrr->audiencia->pat->cuenta->codigo . ' - ' . $ntrr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ntrr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Negativa de trámite recurso de revocatoria actualizada exitosamente');
    }

    public function destroy($id)
    {
        $ntrr = Ntrr::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/ntrrs/' . $ntrr->archivo))) {
            File::delete(public_path('uploads/ntrrs/' . $ntrr->archivo));
        }

        $ntrr->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó la negativa de trámite recurso de revocatoria No.: ' . $ntrr->numero_resolucion .
                             ' para la audiencia No.: ' . $ntrr->audiencia->numero_audiencia .
                             ', cuenta: ' . $ntrr->audiencia->pat->cuenta->codigo . ' - ' . $ntrr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ntrr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $ntrr->audiencia_id)->with('status', 'Negativa de trámite recurso de revocatoria eliminada exitosamente');
    }
}
