<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pat;
use App\Models\Audiencia;
use App\Models\AudienciaPa;
use App\Models\EvPa;
use App\Models\PpPa;
use App\Models\DpmrPa;
use App\Models\AdpmrPa;
use App\Models\NtrrPa;
use App\Models\OcursoPa;
use App\Models\RoPa;
use App\Models\MpmrPa;
use App\Models\AmpmrPa;
use App\Models\AceptacionPa;
use App\Models\RsatPa;
use App\Models\RtributaPa;
use App\Models\NulidadPa;
use App\Models\EcPa;
use App\Models\RrPa;
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

class PaController extends Controller
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
        $audienciasPa = AudienciaPa::where('pat_id', $id)->paginate(10);
        $audienciasVaCount = Audiencia::where('pat_id', $id)->count();

        return view('empresa.expcaso.pa.show', compact('pat', 'patscount','cuenta','config','audienciasPa','audienciasVaCount'));
    }

    public function showaudiencia($id)
    {
        // Buscar audiencia PA que pertenezca a la empresa del usuario
        $audienciaPa = AudienciaPa::whereHas('pat.cuenta', function($query) {
            $query->where('empresa_id', auth()->user()->empresa_id);
        })->find($id);
        
        // Verificar si la audiencia existe y pertenece a la empresa
        if (!$audienciaPa) {
            return redirect()->back()->with('error', 'Audiencia PA no encontrada o no tiene permisos para acceder.');
        }
        
        $pat = $audienciaPa->pat; // Usar relación
        $cuenta = $pat->cuenta; // Usar relación
        
        $config = Config::where('empresa_id', $cuenta->empresa_id)->first();
        $patscount = Pat::where('cuenta_id', $cuenta->id)->count();
        $audienciasPa = AudienciaPa::where('pat_id', $pat->id)->paginate(10);
        $audienciasVaCount = Audiencia::where('pat_id', $pat->id)->count();
        $evacuacionesPa = EvPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $periodosPa = PpPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $dpmrsPa = DpmrPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $adpmrsPa = AdpmrPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $rsatPa = RsatPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $rtributaPa = RtributaPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $nulidadesPa = NulidadPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $ecsPa = EcPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $recursosPa = RrPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $ntrrsPa = NtrrPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $ocursosPa = OcursoPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $rosPa = RoPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $mpmrsPa = MpmrPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $ampmrsPa = AmpmrPa::where('audiencia_pa_id', $audienciaPa->id)->get();
        $aceptacionesPa = AceptacionPa::with('usuario')->where('audiencia_pa_id', $audienciaPa->id)->get();

        return view('empresa.expcaso.pa.showaudiencia', compact(
            'pat', 'patscount', 'cuenta', 'config', 'audienciasPa', 'audienciasVaCount',
            'audienciaPa', 'evacuacionesPa', 'periodosPa', 'dpmrsPa', 'adpmrsPa',
            'rsatPa', 'rtributaPa', 'nulidadesPa', 'ecsPa', 'recursosPa', 'ntrrsPa', 'ocursosPa', 'rosPa', 'mpmrsPa', 'ampmrsPa', 'aceptacionesPa'
        ))->with('audiencia', $audienciaPa);
    }
}
