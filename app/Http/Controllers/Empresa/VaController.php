<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\Audiencia;
use App\Models\AudienciaPa;
use App\Models\Ev;
use App\Models\Pp;
use App\Models\Dpmr;
use App\Models\Adpmr;
use App\Models\Ntrr;
use App\Models\Ocurso;
use App\Models\Ro;
use App\Models\Mpmr;
use App\Models\Ampmr;
use App\Models\Aceptacion;
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
        // Buscar el expediente con filtrado por empresa del usuario autenticado
        $pat = Pat::whereHas('cuenta', function($query) {
            $query->where('empresa_id', auth()->user()->empresa_id);
        })->find($id);
        
        // Verificar si el expediente existe y pertenece a la empresa del usuario
        if (!$pat) {
            return redirect()->back()->with('error', 'Expediente no encontrado o no tiene permisos para acceder.');
        }
        
        $cuenta = $pat->cuenta; // Usar relación en lugar de find
        
        // Verificar si la cuenta existe
        if (!$cuenta) {
            return redirect()->back()->with('error', 'Cuenta no encontrada para este expediente.');
        }
        
        $config = Config::where('empresa_id', $cuenta->empresa_id)->first();
        $patscount = Pat::where('cuenta_id', $cuenta->id)->count();
        $audiencias = Audiencia::where('pat_id', $id)->paginate(10);
        $audienciasVaCount = Audiencia::where('pat_id', $id)->count();
        $audienciasPaCount = AudienciaPa::where('pat_id', $id)->count();

        return view('empresa.expcaso.va.show', compact('pat', 'patscount','cuenta','config','audiencias','audienciasVaCount','audienciasPaCount'));
    }

    public function showaudiencia($id)
    {
        // Buscar audiencia que pertenezca a la empresa del usuario
        $audiencia = Audiencia::whereHas('pat.cuenta', function($query) {
            $query->where('empresa_id', auth()->user()->empresa_id);
        })->find($id);
        
        // Verificar si la audiencia existe y pertenece a la empresa
        if (!$audiencia) {
            return redirect()->back()->with('error', 'Audiencia no encontrada o no tiene permisos para acceder.');
        }
        
        $pat = $audiencia->pat; // Usar relación
        $cuenta = $pat->cuenta; // Usar relación
        
        $config = Config::where('empresa_id', $cuenta->empresa_id)->first();
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
        $aceptaciones = Aceptacion::with('usuario')->where('audiencia_id', $audiencia->id)->get();
        $audienciasVaCount = Audiencia::where('pat_id', $pat->id)->count();
        $audienciasPaCount = AudienciaPa::where('pat_id', $pat->id)->count();

        return view('empresa.expcaso.va.showaudiencia', compact(
            'pat', 'patscount', 'cuenta', 'config', 'audiencias',
            'audiencia', 'evacuaciones', 'periodos', 'dpmrs', 'adpmrs',
            'resoluciones', 'rtributas', 'nulidades', 'ecs', 'recursos', 'ntrrs', 'ocursos', 'ros', 'mpmrs', 'ampmrs', 'aceptaciones', 'audienciasVaCount', 'audienciasPaCount'
        ));
    }
}
