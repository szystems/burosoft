<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\EcFormRequest;
use App\Models\Ec;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EcController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function insert(EcFormRequest $request)
    {        try {
            $ec = Ec::create($request->validated());

            // Registrar en bitácora
            Bitacora::create([
                'empresa_id' => Auth::user()->empresa_id,
                'usuario_id' => Auth::user()->id,
                'fecha' => date('Y-m-d'),
                'tipo' => 'Exp/Caso',
                'descripcion' => 'Se insertó un nuevo EC (Económico Coactivo) No.: ' . $ec->numero_resolucion .
                                 ' para la audiencia No.: ' . $ec->audiencia->numero_audiencia .
                                 ', cuenta: ' . $ec->audiencia->pat->cuenta->codigo . ' - ' . $ec->audiencia->pat->cuenta->razon_social .
                                 ', Expediente: ' . $ec->audiencia->pat->no_expediente
            ]);

            return redirect()->back()->with('status', 'EC (Económico Coactivo) creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'Error al crear el EC: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EcFormRequest $request, $id)
    {        try {
            $ec = Ec::findOrFail($id);
            $oldData = $ec->toArray();
            
            $ec->update($request->validated());

            // Registrar en bitácora
            Bitacora::create([
                'empresa_id' => Auth::user()->empresa_id,
                'usuario_id' => Auth::user()->id,
                'fecha' => date('Y-m-d'),
                'tipo' => 'Exp/Caso',
                'descripcion' => 'Se actualizó EC (Económico Coactivo) No.: ' . $ec->numero_resolucion .
                                 ' para la audiencia No.: ' . $ec->audiencia->numero_audiencia .
                                 ', cuenta: ' . $ec->audiencia->pat->cuenta->codigo . ' - ' . $ec->audiencia->pat->cuenta->razon_social .
                                 ', Expediente: ' . $ec->audiencia->pat->no_expediente
            ]);

            return redirect()->back()->with('status', 'EC (Económico Coactivo) actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'Error al actualizar el EC: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {        try {
            $ec = Ec::findOrFail($id);
            
            // Registrar en bitácora antes de eliminar
            Bitacora::create([
                'empresa_id' => Auth::user()->empresa_id,
                'usuario_id' => Auth::user()->id,
                'fecha' => date('Y-m-d'),
                'tipo' => 'Exp/Caso',
                'descripcion' => 'Se eliminó EC (Económico Coactivo) No.: ' . $ec->numero_resolucion .
                                 ' para la audiencia No.: ' . $ec->audiencia->numero_audiencia .
                                 ', cuenta: ' . $ec->audiencia->pat->cuenta->codigo . ' - ' . $ec->audiencia->pat->cuenta->razon_social .
                                 ', Expediente: ' . $ec->audiencia->pat->no_expediente
            ]);

            $ec->delete();

            return redirect()->back()->with('status', 'EC (Económico Coactivo) eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'Error al eliminar el EC: ' . $e->getMessage());
        }
    }
}
