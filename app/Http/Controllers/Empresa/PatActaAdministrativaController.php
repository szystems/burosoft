<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\PatActaAdministrativa;
use App\Http\Requests\PatActaAdministrativaFormRequest;
use App\Models\Cuenta;
use App\Models\Config;
use App\Models\User;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;

class PatActaAdministrativaController extends Controller
{
    public function insert(PatActaAdministrativaFormRequest $request)
    {
        $actaadministrativa = new PatActaAdministrativa();
        if($request->hasFile('archivo'))
        {
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/actasadministrativas',$filename);
            $actaadministrativa->archivo = $filename;
            $actaadministrativa->tipo = $ext;
        }
        // dd($ext);
        $actaadministrativa->pat_id = $request->input('pat_id');
        $actaadministrativa->usuario_id = $request->input('usuario_id');
        $actaadministrativa->fecha = $request->input('fecha');
        $actaadministrativa->quienes_intervinieron = $request->input('quienes_intervinieron');
        $actaadministrativa->tipo_acta = $request->input('tipo_acta');
        $actaadministrativa->tipo_acta_otro = $request->input('tipo_acta_otro');
        $actaadministrativa->observaciones = $request->input('observaciones');
        $actaadministrativa->save();

        $pat = Pat::find($actaadministrativa->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Agrego una nueva acta administrativa en el pat No.Expediente:".$pat->no_expediente.", Tipo de Acta:".$actaadministrativa->tipo_acta.", Intervinieron:".$actaadministrativa->quienes_intervinieron,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Acta administrativa agregada exitosamente.'));
    }

    public function update(PatActaAdministrativaFormRequest $request, $id)
    {

        $actaadministrativa = PatActaAdministrativa::find($id);
        if($request->hasFile('archivo'))
        {
            $path = 'assets/uploads/pat/actasadministrativas'.$actaadministrativa->archivo;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/actasadministrativas',$filename);
            $actaadministrativa->archivo = $filename;
            $actaadministrativa->tipo = $ext;
        }
        $actaadministrativa->fecha = $request->input('fecha');
        $actaadministrativa->fecha = $request->input('fecha');
        $actaadministrativa->quienes_intervinieron = $request->input('quienes_intervinieron');
        $actaadministrativa->tipo_acta = $request->input('tipo_acta');
        $actaadministrativa->tipo_acta_otro = $request->input('tipo_acta_otro');
        $actaadministrativa->observaciones = $request->input('observaciones');
        $actaadministrativa->update();

        $pat = Pat::find($actaadministrativa->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Actualizo una acta administrativa en el pat No.Expediente:".$pat->no_expediente.", Tipo de Acta:".$actaadministrativa->tipo_acta.", Intervinieron:".$actaadministrativa->quienes_intervinieron,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Acta administrativa actualizada exitosamente.'));

    }

    public function destroy($id)
    {
        $actaadministrativa = PatActaAdministrativa::find($id);
        $pat = Pat::find($actaadministrativa->pat_id);
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Eliminó una acta administrativa en el pat No.Expediente:".$pat->no_expediente.", Tipo de Acta:".$actaadministrativa->tipo_acta.", Intervinieron:".$actaadministrativa->quienes_intervinieron,
        ]);
        $actaadministrativa->delete();
        return redirect('show-pat/'.$pat->id)->with('status',__('Acta administrativa eliminada exitosamente.'));
    }
}
