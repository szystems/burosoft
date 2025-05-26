<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OcursoFormRequest;
use App\Models\Ocurso;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class OcursoController extends Controller
{
    public function insert(OcursoFormRequest $request)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ocursos'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        }

        $ocurso = Ocurso::create($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se insertó un nuevo ocurso No.: ' . $ocurso->numero_documento .
                             ' para la audiencia No.: ' . $ocurso->audiencia->numero_audiencia .
                             ', cuenta: ' . $ocurso->audiencia->pat->cuenta->codigo . ' - ' . $ocurso->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ocurso->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Ocurso agregado exitosamente');
    }

    public function update(OcursoFormRequest $request, $id)
    {
        $data = $request->validated();
        $data['usuario_id'] = Auth::user()->id;

        $ocurso = Ocurso::findOrFail($id);

        if ($request->hasFile('archivo')) {
            // Eliminar el archivo anterior si existe
            if (File::exists(public_path('uploads/ocursos/' . $ocurso->archivo))) {
                File::delete(public_path('uploads/ocursos/' . $ocurso->archivo));
            }

            $file = $request->file('archivo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/ocursos'), $filename);
            $data['archivo'] = $filename;
            $data['tipo_archivo'] = $file->getClientOriginalExtension();
        } else {
            unset($data['archivo']);
            unset($data['tipo_archivo']);
        }

        $ocurso->update($data);

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se actualizó el ocurso No.: ' . $ocurso->numero_documento .
                             ' para la audiencia No.: ' . $ocurso->audiencia->numero_audiencia .
                             ', cuenta: ' . $ocurso->audiencia->pat->cuenta->codigo . ' - ' . $ocurso->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ocurso->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $data['audiencia_id'])->with('status', 'Ocurso actualizado exitosamente');
    }

    public function destroy($id)
    {
        $ocurso = Ocurso::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if (File::exists(public_path('uploads/ocursos/' . $ocurso->archivo))) {
            File::delete(public_path('uploads/ocursos/' . $ocurso->archivo));
        }

        $ocurso->delete();

        // Insertar en Bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => date('Y-m-d'),
            'tipo' => 'Exp/Caso',
            'descripcion' => 'Se eliminó el ocurso No.: ' . $ocurso->numero_documento .
                             ' para la audiencia No.: ' . $ocurso->audiencia->numero_audiencia .
                             ', cuenta: ' . $ocurso->audiencia->pat->cuenta->codigo . ' - ' . $ocurso->audiencia->pat->cuenta->razon_social .
                             ', Expediente: ' . $ocurso->audiencia->pat->no_expediente
        ]);

        return redirect('show-audiencia/' . $ocurso->audiencia_id)->with('status', 'Ocurso eliminado exitosamente');
    }
}
