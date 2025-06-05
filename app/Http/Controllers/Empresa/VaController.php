<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\Audiencia;
use App\Models\Ev;
use App\Models\Pp;
use App\Models\Dpmr;
use App\Models\Adpmr;
use App\Models\Ntrr;
use App\Models\Ocurso;
use App\Models\Ro;
use App\Models\Mpmr;
use App\Models\Ampmr;
use App\Models\Resolucion;
use App\Models\Rtributa;
use App\Models\Nulidad;
use App\Models\Ec;
use App\Models\Rr;
use App\Http\Requests\AudienciaFormRequest;
use App\Models\Cuenta;
use App\Models\Config;
use App\Models\User;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class VaController extends Controller
{
    public function show($id)
    {
        $pat = Pat::find($id);
        $cuenta = Cuenta::find($pat->cuenta_id);
        $config = Config::where('empresa_id', $pat->cuenta_id)->first();
        $patscount = Pat::where('cuenta_id', $cuenta->id)->count();
        $audiencias = Audiencia::where('pat_id', $id)->paginate(10);

        return view('empresa.expcaso.va.show', compact('pat', 'patscount','cuenta','config','audiencias'));
    }

    public function showaudiencia($id)
    {
        $audiencia = Audiencia::find($id);
        $pat = Pat::find($audiencia->pat_id);
        $cuenta = Cuenta::find($pat->cuenta_id);
        $config = Config::where('empresa_id', $pat->cuenta_id)->first();
        $patscount = Pat::where('cuenta_id', $cuenta->id)->count();
        $audiencias = Audiencia::where('pat_id', $pat->id)->paginate(10);
        $evacuaciones = Ev::where('audiencia_id', $audiencia->id)->get();
        $periodos = Pp::where('audiencia_id', $audiencia->id)->get();
        $dpmrs = Dpmr::where('audiencia_id', $audiencia->id)->get();
        $adpmrs = Adpmr::where('audiencia_id', $audiencia->id)->get();
        $resoluciones = Resolucion::where('audiencia_id', $audiencia->id)->get();
        $rtributas = Rtributa::where('audiencia_id', $audiencia->id)->get();
        $nulidades = Nulidad::where('audiencia_id', $audiencia->id)->get();
        $ecs = Ec::where('audiencia_id', $audiencia->id)->get();
        $recursos = Rr::where('audiencia_id', $audiencia->id)->get();
        $ntrrs = Ntrr::where('audiencia_id', $audiencia->id)->get();
        $ocursos = Ocurso::where('audiencia_id', $audiencia->id)->get();
        $ros = Ro::where('audiencia_id', $audiencia->id)->get();
        $mpmrs = Mpmr::where('audiencia_id', $audiencia->id)->get();
        $ampmrs = Ampmr::where('audiencia_id', $audiencia->id)->get();

        return view('empresa.expcaso.va.showaudiencia', compact(
            'pat', 'patscount', 'cuenta', 'config', 'audiencias',
            'audiencia', 'evacuaciones', 'periodos', 'dpmrs', 'adpmrs',
            'resoluciones', 'rtributas', 'nulidades', 'ecs', 'recursos', 'ntrrs', 'ocursos', 'ros', 'mpmrs', 'ampmrs'
        ));
    }
}
