<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MpmrFormRequest;
use App\Models\Mpmr;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class MpmrController extends Controller
{
    public function insert(MpmrFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/mpmrs'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $mpmr = Mpmr::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva medida para mejor resolver No.: ' . $mpmr->numero_resolucion .
                             ' para la audiencia No.: ' . $mpmr->audiencia->numero_audiencia .
                             ', cuenta: ' . $mpmr->audiencia->pat->cuenta->codigo . ' - ' . $mpmr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $mpmr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Medida para mejor resolver agregada exitosamente');
    }

    public function update(MpmrFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $mpmr = Mpmr::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/mpmrs/' . $mpmr->archivo))) {
                File::delete(public_path('uploads/mpmrs/' . $mpmr->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/mpmrs'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $mpmr->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó la medida para mejor resolver No.: ' . $mpmr->numero_resolucion .
                             ' para la audiencia No.: ' . $mpmr->audiencia->numero_audiencia .
                             ', cuenta: ' . $mpmr->audiencia->pat->cuenta->codigo . ' - ' . $mpmr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $mpmr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Medida para mejor resolver actualizada exitosamente');
    }

    public function destroy($id)
    {
        $mpmr = Mpmr::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/mpmrs/' . $mpmr->archivo))) {
            File::delete(public_path('uploads/mpmrs/' . $mpmr->archivo));
        }

        $mpmr->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó la medida para mejor resolver No.: ' . $mpmr->numero_resolucion .
                             ' para la audiencia No.: ' . $mpmr->audiencia->numero_audiencia .
                             ', cuenta: ' . $mpmr->audiencia->pat->cuenta->codigo . ' - ' . $mpmr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $mpmr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $mpmr->audiencia_id)->with('status', 'Medida para mejor resolver eliminada exitosamente');
    }
}
