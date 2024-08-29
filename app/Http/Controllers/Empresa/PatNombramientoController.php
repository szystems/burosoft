<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\PatNombramiento;
use App\Http\Requests\PatNombramientoFormRequest;
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

class PatNombramientoController extends Controller
{
    public function insert(PatNombramientoFormRequest $request)
    {
        $nombramiento = new PatNombramiento();
        if($request->hasFile('archivo'))
        {
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/nombramientos',$filename);
            $nombramiento->archivo = $filename;
            $nombramiento->tipo = $ext;
        }
        // dd($ext);
        $nombramiento->pat_id = $request->input('pat_id');
        $nombramiento->usuario_id = $request->input('usuario_id');
        $nombramiento->no = $request->input('no');
        $nombramiento->nombrado_1 = $request->input('nombrado_1');
        $nombramiento->nombrado_2 = $request->input('nombrado_2');
        $nombramiento->nombrado_3 = $request->input('nombrado_3');
        $nombramiento->nombrado_4 = $request->input('nombrado_4');
        $nombramiento->nombrado_5 = $request->input('nombrado_5');
        $nombramiento->periodo = $request->input('periodo');
        $nombramiento->save();

        $pat = Pat::find($nombramiento->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Agrego un nuevo nombramiento en el pat No.Expediente:".$pat->no_expediente.", Nombramiento No:".$nombramiento->no,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Nombramiento agregado exitosamente.'));
    }

    public function update(PatNombramientoFormRequest $request, $id)
    {

        $nombramiento = PatNombramiento::find($id);
        if($request->hasFile('archivo'))
        {
            $path = 'assets/uploads/pat/nombramientos'.$nombramiento->archivo;
            if(File::exists($path))
            {
                File::delete($path);
            }
            $file = $request->file('archivo');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/pat/nombramientos',$filename);
            $nombramiento->archivo = $filename;
            $nombramiento->tipo = $ext;
        }
        $nombramiento->no = $request->input('no');
        $nombramiento->nombrado_1 = $request->input('nombrado_1');
        $nombramiento->nombrado_2 = $request->input('nombrado_2');
        $nombramiento->nombrado_3 = $request->input('nombrado_3');
        $nombramiento->nombrado_4 = $request->input('nombrado_4');
        $nombramiento->nombrado_5 = $request->input('nombrado_5');
        $nombramiento->periodo = $request->input('periodo');
        $nombramiento->update();

        $pat = Pat::find($nombramiento->pat_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Actualizo un nombramiento en el pat No.Expediente:".$pat->no_expediente.", Nombramiento No:".$nombramiento->no,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('Nombramiento actualizado exitosamente.'));

    }

    public function destroy($id)
    {
        $nombramiento = PatNombramiento::find($id);
        $pat = Pat::find($nombramiento->pat_id);
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Eliminó un nombramiento en el pat No.Expediente:".$pat->no_expediente.", Nombramiento No:".$nombramiento->no,
        ]);
        $nombramiento->delete();
        return redirect('show-pat/'.$pat->id)->with('status',__('Nombramiento eliminado exitosamente.'));
    }
}
