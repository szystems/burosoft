<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\PatRaf;
use App\Http\Requests\PatRafFormRequest;
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

class PatRafController extends Controller
{
    public function insert(PatRafFormRequest $request)
    {
        $raf = new PatRaf();
        if($request->hasFile('archivo'))
        {
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/rafs',$filename);
            $raf->archivo = $filename;
            $raf->tipo = $ext;
        }
        // dd($ext);
        $raf->pat_id = $request->input('pat_id');
        $raf->usuario_id = $request->input('usuario_id');
        $raf->no = $request->input('no');
        $raf->fecha = $request->input('fecha');
        $raf->tipo_providencia = $request->input('tipo_providencia');
        $raf->tipo_providencia_otro = $request->input('tipo_providencia_otro');
        $raf->admite = $request->input('admite');
        $raf->admite_otro = $request->input('admite_otro');
        $raf->observaciones = $request->input('observaciones');

        $raf->save();

        $pat = Pat::find($raf->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Agrego una nueva providencia de urgencia en el pat No.Expediente:".$pat->no_expediente.", raf No:".$raf->no,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Providencia de urgencia agregado exitosamente.'));
    }

    public function update(PatRafFormRequest $request, $id)
    {

        $raf = PatRaf::find($id);
        if($request->hasFile('archivo'))
        {
            $path = 'assets/uploads/pat/rafs'.$raf->archivo;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/rafs',$filename);
            $raf->archivo = $filename;
            $raf->tipo = $ext;
        }
        $raf->no = $request->input('no');
        $raf->fecha = $request->input('fecha');
        $raf->tipo_providencia = $request->input('tipo_providencia');
        $raf->tipo_providencia_otro = $request->input('tipo_providencia_otro');
        $raf->admite = $request->input('admite');
        $raf->admite_otro = $request->input('admite_otro');
        $raf->observaciones = $request->input('observaciones');
        $raf->update();

        $pat = Pat::find($raf->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Actualizo una providencia de urgencia en el pat No.Expediente:".$pat->no_expediente.", Raf No:".$raf->no,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Providencia de urgencia actualizado exitosamente.'));

    }

    public function destroy($id)
    {
        $raf = PatRaf::find($id);
        $pat = Pat::find($raf->pat_id);
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Eliminó una providencia de urgencia en el pat No.Expediente:".$pat->no_expediente.", Raf No:".$raf->no,
        ]);
        $raf->delete();
        return redirect('show-pat/'.$pat->id)->with('status',__('Providencia de urgencia eliminado exitosamente.'));
    }
}
