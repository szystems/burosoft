<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdpmrFormRequest;
use App\Models\Adpmr;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdpmrController extends Controller
{
    public function insert(AdpmrFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/adpmrs'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $adpmr = Adpmr::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva atención DPMR No.: ' . $adpmr->numero_documento .
                             ' para la audiencia No.: ' . $adpmr->audiencia->numero_audiencia .
                             ', cuenta: ' . $adpmr->audiencia->pat->cuenta->codigo . ' - ' . $adpmr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $adpmr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Atención de DPMR agregada exitosamente');
    }

    public function update(AdpmrFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $adpmr = Adpmr::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/adpmrs/' . $adpmr->archivo))) {
                File::delete(public_path('uploads/adpmrs/' . $adpmr->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/adpmrs'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $adpmr->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó la atención DPMR No.: ' . $adpmr->numero_documento .
                             ' para la audiencia No.: ' . $adpmr->audiencia->numero_audiencia .
                             ', cuenta: ' . $adpmr->audiencia->pat->cuenta->codigo . ' - ' . $adpmr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $adpmr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Atención DPMR actualizada exitosamente');
    }

    public function destroy($id)
    {
        $adpmr = Adpmr::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/adpmrs/' . $adpmr->archivo))) {
            File::delete(public_path('uploads/adpmrs/' . $adpmr->archivo));
        }

        $adpmr->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó la atención DPMR No.: ' . $adpmr->numero_documento .
                             ' para la audiencia No.: ' . $adpmr->audiencia->numero_audiencia .
                             ', cuenta: ' . $adpmr->audiencia->pat->cuenta->codigo . ' - ' . $adpmr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $adpmr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $adpmr->audiencia_id)->with('status', 'Atención DPMR eliminada exitosamente');
    }
}
