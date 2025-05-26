<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AmpmrFormRequest;
use App\Models\Ampmr;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AmpmrController extends Controller
{
    public function insert(AmpmrFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ampmrs'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $ampmr = Ampmr::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó una nueva atención de medidas para mejor resolver No.: ' . $ampmr->numero_documento .
                             ' para la audiencia No.: ' . $ampmr->audiencia->numero_audiencia .
                             ', cuenta: ' . $ampmr->audiencia->pat->cuenta->codigo . ' - ' . $ampmr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ampmr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Atención de medidas para mejor resolver agregada exitosamente');
    }

    public function update(AmpmrFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $ampmr = Ampmr::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/ampmrs/' . $ampmr->archivo))) {
                File::delete(public_path('uploads/ampmrs/' . $ampmr->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ampmrs'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $ampmr->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó la atención de medidas para mejor resolver No.: ' . $ampmr->numero_documento .
                             ' para la audiencia No.: ' . $ampmr->audiencia->numero_audiencia .
                             ', cuenta: ' . $ampmr->audiencia->pat->cuenta->codigo . ' - ' . $ampmr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ampmr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Atención de medidas para mejor resolver actualizada exitosamente');
    }

    public function destroy($id)
    {
        $ampmr = Ampmr::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/ampmrs/' . $ampmr->archivo))) {
            File::delete(public_path('uploads/ampmrs/' . $ampmr->archivo));
        }

        $ampmr->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó la atención de medidas para mejor resolver No.: ' . $ampmr->numero_documento .
                             ' para la audiencia No.: ' . $ampmr->audiencia->numero_audiencia .
                             ', cuenta: ' . $ampmr->audiencia->pat->cuenta->codigo . ' - ' . $ampmr->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ampmr->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $ampmr->audiencia_id)->with('status', 'Atención de medidas para mejor resolver eliminada exitosamente');
    }
}
