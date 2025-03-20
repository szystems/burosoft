<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\DpmrFormRequest;
use App\Models\Dpmr;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class DpmrController extends Controller
{
    public function insert(DpmrFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/dpmrs'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $dpmr = Dpmr::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una diligencia para mejor resolver No.: ' . $dpmr->numero_resolucion .
                             ' para la audiencia No.: ' . $dpmr->audiencia->numero_audiencia .
                             ', cuenta: ' . $dpmr->audiencia->pat->cuenta->codigo . ' - ' . $dpmr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $dpmr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Diligencia para mejor resolver agregada exitosamente');
    }

    public function update(DpmrFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $dpmr = Dpmr::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/dpmrs/' . $dpmr->archivo))) {
                File::delete(public_path('uploads/dpmrs/' . $dpmr->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/dpmrs'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $dpmr->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó la diligencia para mejor resolver No.: ' . $dpmr->numero_resolucion .
                             ' para la audiencia No.: ' . $dpmr->audiencia->numero_audiencia .
                             ', cuenta: ' . $dpmr->audiencia->pat->cuenta->codigo . ' - ' . $dpmr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $dpmr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Diligencia para mejor resolver actualizada exitosamente');
    }

    public function destroy($id)
    {
        $dpmr = Dpmr::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/dpmrs/' . $dpmr->archivo))) {
            File::delete(public_path('uploads/dpmrs/' . $dpmr->archivo));
        }

        $dpmr->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó la diligencia para mejor resolver No.: ' . $dpmr->numero_resolucion .
                             ' para la audiencia No.: ' . $dpmr->audiencia->numero_audiencia .
                             ', cuenta: ' . $dpmr->audiencia->pat->cuenta->codigo . ' - ' . $dpmr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $dpmr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $dpmr->audiencia_id)->with('status', 'Diligencia para mejor resolver eliminada exitosamente');
    }
}
