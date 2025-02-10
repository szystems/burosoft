<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\PatProvidencia;
use App\Http\Requests\PatProvidenciaFormRequest;
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

class PatProvidenciaController extends Controller
{
    public function insert(PatProvidenciaFormRequest $request)
    {
        $providencia = new PatProvidencia();
        if($request->hasFile('archivo'))
        {
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/providencias',$filename);
            $providencia->archivo = $filename;
            $providencia->tipo = $ext;
        }
        // dd($ext);
        $providencia->pat_id = $request->input('pat_id');
        $providencia->usuario_id = $request->input('usuario_id');
        $providencia->no = $request->input('no');
        $providencia->fecha = $request->input('fecha');
        $providencia->tipo_providencia = $request->input('tipo_providencia');
        $providencia->tipo_providencia_otro = $request->input('tipo_providencia_otro');
        $providencia->admite = $request->input('admite');
        $providencia->admite_otro = $request->input('admite_otro');
        $providencia->observaciones = $request->input('observaciones');

        $providencia->save();

        $pat = Pat::find($providencia->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Agrego una nueva providencia en el pat No.Expediente:".$pat->no_expediente.", providencia No:".$providencia->no,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Providencia agregado exitosamente.'));
    }

    public function update(PatProvidenciaFormRequest $request, $id)
    {

        $providencia = PatProvidencia::find($id);
        if($request->hasFile('archivo'))
        {
            $path = 'assets/uploads/pat/providencias'.$providencia->archivo;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/providencias',$filename);
            $providencia->archivo = $filename;
            $providencia->tipo = $ext;
        }
        $providencia->no = $request->input('no');
        $providencia->fecha = $request->input('fecha');
        $providencia->tipo_providencia = $request->input('tipo_providencia');
        $providencia->tipo_providencia_otro = $request->input('tipo_providencia_otro');
        $providencia->admite = $request->input('admite');
        $providencia->admite_otro = $request->input('admite_otro');
        $providencia->observaciones = $request->input('observaciones');
        $providencia->update();

        $pat = Pat::find($providencia->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Actualizo una providencia en el pat No.Expediente:".$pat->no_expediente.", Providencia No:".$providencia->no,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Providencia actualizado exitosamente.'));

    }

    public function destroy($id)
    {
        $providencia = PatProvidencia::find($id);
        $pat = Pat::find($providencia->pat_id);
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Eliminó una providencia en el pat No.Expediente:".$pat->no_expediente.", Providencia No:".$providencia->no,
        ]);
        $providencia->delete();
        return redirect('show-pat/'.$pat->id)->with('status',__('Providencia eliminado exitosamente.'));
    }
}
