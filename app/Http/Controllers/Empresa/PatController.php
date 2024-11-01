<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Http\Requests\PatFormRequest;
use App\Models\PatNombramiento;
use App\Models\PatNotificacion;
use App\Models\PatRequerimiento;
use App\Models\PatExpediente;
use App\Models\PatAtencionRequerimiento;
use App\Models\PatActaAdministrativa;
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
        $config = Config::where('empresa_id', $pat->cuenta_id)->first();
        $nombramientos = PatNombramiento::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();
        $notificaciones = PatNotificacion::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();
        $requerimientos = PatRequerimiento::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();
        $expedientes = PatExpediente::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();
        $atencionrequerimientos = PatAtencionRequerimiento::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();
        $actasadministrativas = PatActaAdministrativa::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();

        return view('empresa.expcaso.pat.show', compact('pat','cuenta','config','nombramientos','notificaciones','requerimientos','expedientes','atencionrequerimientos','actasadministrativas'));
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
        $PatNombramientos = PatNombramiento::where('pat_id', $pat->id)->delete();
        $PatNotificaciones = PatNotificacion::where('pat_id', $pat->id)->delete();
        $PatRequerimientos = PatRequerimiento::where('pat_id', $pat->id)->delete();
        $PatExpedientes = PatExpediente::where('pat_id', $pat->id)->delete();
        $PatAtencionRequerimientos = PatAtencionRequerimiento::where('pat_id', $pat->id)->delete();
        $PatactasAdministrativas = PatActaAdministrativa::where('pat_id', $pat->id)->delete();

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

    public function pdf(Request $request)
    {
        // dd($request);
        if ($request)
        {

            //recibir detalles de la impresion
            $pdftamaño = $request->input('pdftamaño');
            $pdfhorientacion = $request->input('pdfhorientacion');
            $pdfarchivo = $request->input('pdfarchivo');

            //Consultas
            $pat = Pat::find($request->input('ffpat_id'));
            $cuenta = Cuenta::find($pat->cuenta_id);
            $config = $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();
            $nombramientos = PatNombramiento::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();
            $notificaciones = PatNotificacion::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();
            $requerimientos = PatRequerimiento::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();
            $expedientes = PatExpediente::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();
            $atencionrequerimientos = PatAtencionRequerimiento::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();
            $actasadministrativas = PatActaAdministrativa::where('pat_id', $pat->id)->orderBy('created_at','desc')->get();

            // dd($request->input('ffpat_id'));

            $nompdf = date('m/d/Y g:ia');
            $path = public_path('assets/uploads/');

            $currency = $config->currency_simbol;

            if ($config->logo == null)
            {
                $logo = null;
                $imagen = null;
            }
            else
            {
                    $logo = $config->logo;
                    $imagen = public_path('assets/uploads/logos/'.$logo);
            }

            if ( $pdfarchivo == "download" )
            {
                $pdf = PDF::loadView('empresa.expcaso.pat.pdf', compact('imagen','pat','cuenta','config','nombramientos','notificaciones','requerimientos','expedientes','atencionrequerimientos','actasadministrativas'));
                $pdf->setPaper($pdftamaño, $pdfhorientacion);
                return $pdf->download ('PAT No.Expediente: '.$pat->no_expediente.', No.Programa: '.$pat->no_programa.' '.$nompdf.'.pdf');
            }
            if ( $pdfarchivo == "stream" )
            {
                $pdf = PDF::loadView('empresa.expcaso.pat.pdf', compact('imagen','pat','cuenta','config','nombramientos','notificaciones','requerimientos','expedientes','atencionrequerimientos','actasadministrativas'));
                $pdf->setPaper($pdftamaño, $pdfhorientacion);
                return $pdf->stream ('PAT No.Expediente: '.$pat->no_expediente.', No.Programa: '.$pat->no_programa.' '.$nompdf.'.pdf');
            }
        }
    }
}
