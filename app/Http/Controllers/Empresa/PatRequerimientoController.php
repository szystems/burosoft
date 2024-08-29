<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\PatRequerimiento;
use App\Http\Requests\PatRequerimientoFormRequest;
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

class PatRequerimientoController extends Controller
{
    public function insert(PatRequerimientoFormRequest $request)
    {
        $requerimiento = new PatRequerimiento();
        if($request->hasFile('archivo'))
        {
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/requerimientos',$filename);
            $requerimiento->archivo = $filename;
            $requerimiento->tipo = $ext;
        }
        // dd($ext);
        $requerimiento->pat_id = $request->input('pat_id');
        $requerimiento->usuario_id = $request->input('usuario_id');
        $requerimiento->no = $request->input('no');
        $requerimiento->tipo_requerimiento = $request->input('tipo_requerimiento');
        $requerimiento->lugar_atender = $request->input('lugar_atender');
        $requerimiento->plazo_atencion = $request->input('plazo_atencion');
        $requerimiento->tipo_revision = $request->input('tipo_revision');
        $requerimiento->save();

        $pat = Pat::find($requerimiento->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Agrego un nuevo requerimiento en el pat No.Expediente:".$pat->no_expediente.", Requerimiento No:".$requerimiento->no,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Requerimiento agregado exitosamente.'));
    }

    public function update(PatRequerimientoFormRequest $request, $id)
    {

        $requerimiento = PatRequerimiento::find($id);
        if($request->hasFile('archivo'))
        {
            $path = 'assets/uploads/pat/requerimientos'.$requerimiento->archivo;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/requerimientos',$filename);
            $requerimiento->archivo = $filename;
            $requerimiento->tipo = $ext;
        }
        $requerimiento->no = $request->input('no');
        $requerimiento->tipo_requerimiento = $request->input('tipo_requerimiento');
        $requerimiento->lugar_atender = $request->input('lugar_atender');
        $requerimiento->plazo_atencion = $request->input('plazo_atencion');
        $requerimiento->tipo_revision = $request->input('tipo_revision');
        $requerimiento->update();

        $pat = Pat::find($requerimiento->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Actualizo un requerimiento en el pat No.Expediente:".$pat->no_expediente.", Requerimiento No:".$requerimiento->no,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Requerimiento actualizado exitosamente.'));

    }

    public function destroy($id)
    {
        $requerimiento = PatRequerimiento::find($id);
        $pat = Pat::find($requerimiento->pat_id);
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Eliminó un requerimiento en el pat No.Expediente:".$pat->no_expediente.", Requerimiento No:".$requerimiento->no,
        ]);
        $requerimiento->delete();
        return redirect('show-pat/'.$pat->id)->with('status',__('Requerimiento eliminado exitosamente.'));
    }
}
