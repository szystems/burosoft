<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bitacora;
use App\Http\Requests\BitacoraFormRequest;
use App\Models\Config;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use DB;

class BitacoraController extends Controller
{
    public function index(Request $request)
    {
        if ($request) {
            //obtengo datos
            if ($request->input('fecha_desde') != "") {
                $fechaDesdeVista = date("d-m-Y", strtotime($request->input('fecha_desde')));
                $fechaDesde = date("Y-m-d", strtotime($request->input('fecha_desde')));
            }else
            {
                $hoy = Carbon::now('America/Guatemala');
                $fechaDesdeVista = $hoy->format('d-m-Y');
                $fechaDesde = date("Y-m-d", strtotime($fechaDesdeVista));
            }

            if ($request->input('fecha_hasta') != "") {
                $fechaHastaVista = date("d-m-Y", strtotime($request->input('fecha_hasta')));
                $fechaHasta = date("Y-m-d", strtotime($request->input('fecha_hasta')));
            }else
            {
                $hoy = Carbon::now('America/Guatemala');
                $fechaHastaVista = $hoy->format('d-m-Y');
                $fechaHasta = date("Y-m-d", strtotime($fechaHastaVista));
            }

            $usuarioID = $request->input('usuario_id');
            $tipo = $request->input('tipo');

            $Consultafiltros = Bitacora::where('fecha', '>=', $fechaDesde)
                                        ->where('fecha', '<=', $fechaHasta)
                                        ->where('empresa_id', Auth::user()->empresa_id);

            if (!empty($usuarioID)) {
                $Consultafiltros->where('usuario_id', '=', $usuarioID);
            }

            if (!empty($tipo)) {
                $Consultafiltros->where('tipo', '=', $tipo);
            }

            $Consultafiltros->orderBy('created_at','desc');
            $bitacoras = $Consultafiltros->get();

            $usuarios = User::where('empresa_id', Auth::user()->empresa_id)->get();
            $config = Config::first();
            // dd($proveedores);
            return view('empresa.bitacora.index', compact('bitacoras','usuarios','config','fechaDesdeVista','fechaHastaVista'));
        }
    }

    public function show($id)
    {
        $bitacora = Bitacora::find($id);
        $config = Config::first();
        return view('empresa.bitacora.show', compact('bitacora','config'));
    }
}
