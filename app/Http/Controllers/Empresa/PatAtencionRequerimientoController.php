<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\PatAtencionRequerimiento;
use App\Http\Requests\PatAtencionRequerimientoFormRequest;
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

class PatAtencionRequerimientoController extends Controller
{
    public function insert(PatAtencionRequerimientoFormRequest $request)
    {
        $atencionrequerimiento = new PatAtencionRequerimiento();
        if($request->hasFile('archivo'))
        {
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/atencionrequerimientos',$filename);
            $atencionrequerimiento->archivo = $filename;
            $atencionrequerimiento->tipo = $ext;
        }
        // dd($ext);
        $atencionrequerimiento->pat_id = $request->input('pat_id');
        $atencionrequerimiento->usuario_id = $request->input('usuario_id');
        $atencionrequerimiento->no = $request->input('no');
        $atencionrequerimiento->fecha = $request->input('fecha');
        $atencionrequerimiento->forma_atencion = $request->input('forma_atencion');
        $atencionrequerimiento->forma_atencion_otro = $request->input('forma_atencion_otro');
        $atencionrequerimiento->entregado_en = $request->input('entregado_en');
        $atencionrequerimiento->entregado_en_otro = $request->input('entregado_en_otro');
        $atencionrequerimiento->oficio_respuesta = $request->input('oficio_respuesta');
        $atencionrequerimiento->acta_administrativa = $request->input('acta_administrativa');
        $atencionrequerimiento->quien_atendio = $request->input('quien_atendio');
        $atencionrequerimiento->observaciones = $request->input('observaciones');
        $atencionrequerimiento->save();

        $pat = Pat::find($atencionrequerimiento->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Agrego una nueva atención de requerimiento en el pat No.Expediente:".$pat->no_expediente.", Atencion de Requerimiento No:".$atencionrequerimiento->no,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Atención de requerimiento agregado exitosamente.'));
    }

    public function update(PatAtencionRequerimientoFormRequest $request, $id)
    {

        $atencionrequerimiento = PatAtencionRequerimiento::find($id);
        if($request->hasFile('archivo'))
        {
            $path = 'assets/uploads/pat/atencionrequerimientos'.$atencionrequerimiento->archivo;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/atencionrequerimientos',$filename);
            $atencionrequerimiento->archivo = $filename;
            $atencionrequerimiento->tipo = $ext;
        }
        $atencionrequerimiento->no = $request->input('no');
        $atencionrequerimiento->fecha = $request->input('fecha');
        $atencionrequerimiento->forma_atencion = $request->input('forma_atencion');
        $atencionrequerimiento->forma_atencion_otro = $request->input('forma_atencion_otro');
        $atencionrequerimiento->entregado_en = $request->input('entregado_en');
        $atencionrequerimiento->entregado_en_otro = $request->input('entregado_en_otro');
        $atencionrequerimiento->oficio_respuesta = $request->input('oficio_respuesta');
        $atencionrequerimiento->acta_administrativa = $request->input('acta_administrativa');
        $atencionrequerimiento->quien_atendio = $request->input('quien_atendio');
        $atencionrequerimiento->observaciones = $request->input('observaciones');
        $atencionrequerimiento->update();

        $pat = Pat::find($atencionrequerimiento->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Actualizo una atención de requerimiento en el pat No.Expediente:".$pat->no_expediente.", Atencion de Requerimiento No:".$atencionrequerimiento->no,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Requerimiento actualizado exitosamente.'));

    }

    public function destroy($id)
    {
        $atencionrequerimiento = PatAtencionRequerimiento::find($id);
        $pat = Pat::find($atencionrequerimiento->pat_id);
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Eliminó una atención requerimiento en el pat No.Expediente:".$pat->no_expediente.", Atencion de Requerimiento No:".$atencionrequerimiento->no,
        ]);
        $atencionrequerimiento->delete();
        return redirect('show-pat/'.$pat->id)->with('status',__('Atención de requerimiento eliminado exitosamente.'));
    }
}
