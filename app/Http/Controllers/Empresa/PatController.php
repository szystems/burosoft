<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Http\Requests\PatFormRequest;
use App\Models\PatNombramiento;
use App\Models\Cuenta;
use App\Models\Config;
use App\Models\User;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class PatController extends Controller
{
    public function index(Request $request, $id)
    {
        if ($request)
        {
            $cuenta = Cuenta::find($id);
            $queryPat = $request->input('queryPat');
            $gerencia = $request->input('gerencia');
            $tipoContribuyente = $request->input('tipo_contribuyente');
            $estado = $request->input('estado');

            $config = Config::where('empresa_id', $cuenta->id)->first();

            $pats = Pat::where('cuenta_id', $cuenta->id)
                ->when($queryPat, function ($query, $queryPat) {
                    return $query->where('no_programa', 'like', '%' . $queryPat . '%')
                        ->orWhere('no_expediente', 'like', '%' . $queryPat . '%');
                })
                ->when($gerencia, function ($query, $gerencia) {
                    return $query->where('gerencia', $gerencia);
                })
                ->when($tipoContribuyente, function ($query, $tipoContribuyente) {
                    return $query->where('tipo_contribuyente', $tipoContribuyente);
                })
                ->when($estado, function ($query, $estado) {
                    return $query->where('estado', $estado);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(25);

                $usuarios = User::where('empresa_id', Auth::user()->empresa_id)->orderBy('name','asc')->get();

            return view('empresa.expcaso.pat.index', compact('cuenta', 'config', 'pats', 'queryPat','usuarios'));
        }
    }

    public function show($id)
    {
        $pat = Pat::find($id);
        $cuenta = Cuenta::find($pat->cuenta_id);
        $config = Config::first();
        $nombramientos = PatNombramiento::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();
        return view('empresa.expcaso.pat.show', compact('pat','cuenta','config','nombramientos'));
    }

    public function insert(PatFormRequest $request)
    {
        $pat = new Pat();
        $pat->cuenta_id = $request->input('cuenta_id');
        $pat->usuario_id = $request->input('usuario_id');
        $pat->no_expediente = $request->input('no_expediente');
        $pat->no_programa = $request->input('no_programa');
        $pat->gerencia = $request->input('gerencia');
        $pat->tipo_contribuyente = $request->input('tipo_contribuyente');
        $pat->estado = $request->input('estado');
        $pat->save();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Creo un nuevo PAT de Exp/Caso: No. Expediente:".$pat->no_expediente.", No. Programa".$pat->no_programa.", Gerencia:".$pat->gerencia.", Tipo Contribuyente:".$pat->tipo_contribuyente.", Estado".$pat->estado,
        ]);

        return redirect('show-pat/'.$pat->id)->with('status',__('PAT agregado exitosamente.'));
    }

    public function update(PatFormRequest $request, $id)
    {
        $pat = Pat::find($id);
        $pat->no_expediente = $request->input('no_expediente');
        $pat->no_programa = $request->input('no_programa');
        $pat->gerencia = $request->input('gerencia');
        $pat->tipo_contribuyente = $request->input('tipo_contribuyente');
        $pat->estado = $request->input('estado');
        $pat->update();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Actualizó un PAT de Exp/Caso: No. Expediente:".$pat->no_expediente.", No. Programa".$pat->no_programa.", Gerencia:".$pat->gerencia.", Tipo Contribuyente:".$pat->tipo_contribuyente.", Estado".$pat->estado,
        ]);

        return redirect('show-pat/'.$id)->with('status',__('Pat actualizado correctamente.'));

    }

    public function destroy($id)
    {
        $pat = Pat::find($id);
        $cuenta = Cuenta::find($pat->cuenta_id);

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Exp/Caso",
            'descripcion' => "Eliminó un PAT de Exp/Caso: ".$pat->no_expediente.", No. Programa".$pat->no_programa.", Gerencia:".$pat->gerencia.", Tipo Contribuyente:".$pat->tipo_contribuyente.", Estado".$pat->estado,
        ]);

        $pat->delete();

        return redirect('index-pat/'.$cuenta->id)->with('status',__('PAT eliminado correctamente.'));
    }
}
