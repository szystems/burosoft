<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\PatNulidad;
use App\Http\Requests\PatNulidadFormRequest;
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

class PatNulidadController extends Controller
{
    public function insert(PatNulidadFormRequest $request)
    {
        $nulidad = new PatNulidad();
        if($request->hasFile('archivo'))
        {
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/nulidades',$filename);
            $nulidad->archivo = $filename;
            $nulidad->tipo = $ext;
        }
        // dd($ext);
        $nulidad->pat_id = $request->input('pat_id');
        $nulidad->usuario_id = $request->input('usuario_id');
        $nulidad->no = $request->input('no');
        $nulidad->fecha = $request->input('fecha');
        $nulidad->tipo_nulidad = $request->input('tipo_nulidad');
        $nulidad->nueva_notificacion = $request->input('nueva_notificacion');

        $nulidad->save();

        $pat = Pat::find($nulidad->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Agrego una nueva nulidad en el pat No.Expediente:".$pat->no_expediente.", nulidad No:".$nulidad->no,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Nulidad agregada exitosamente.'));
    }

    public function update(PatNulidadFormRequest $request, $id)
    {

        $nulidad = PatNulidad::find($id);
        if($request->hasFile('archivo'))
        {
            $path = 'assets/uploads/pat/nulidades'.$nulidad->archivo;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/nulidades',$filename);
            $nulidad->archivo = $filename;
            $nulidad->tipo = $ext;
        }
        $nulidad->no = $request->input('no');
        $nulidad->fecha = $request->input('fecha');
        $nulidad->tipo_nulidad = $request->input('tipo_nulidad');
        $nulidad->nueva_notificacion = $request->input('nueva_notificacion');
        $nulidad->update();

        $pat = Pat::find($nulidad->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Actualizo una nulidad en el pat No.Expediente:".$pat->no_expediente.", Nulidad No:".$nulidad->no,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Nulidad actualizado exitosamente.'));

    }

    public function destroy($id)
    {
        $nulidad = PatNulidad::find($id);
        $pat = Pat::find($nulidad->pat_id);
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Eliminó una nulidad en el pat No.Expediente:".$pat->no_expediente.", Nulidad No:".$nulidad->no,
        ]);
        $nulidad->delete();
        return redirect('show-pat/'.$pat->id)->with('status',__('Nulidad eliminada exitosamente.'));
    }
}
