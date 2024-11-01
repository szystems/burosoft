<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Movimiento;
use App\Models\MovimientoDocumento;
use App\Models\MovimientoPago;
use App\Models\User;
use App\Models\Cuenta;
use App\Models\Rubro;
use Illuminate\Support\Facades\Auth;
use App\Models\Config;
use App\Models\Bitacora;
use Carbon\Carbon;
use PDF;
use DB;

class RsiController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);
        if ($request) {
            //obtengo datos
            $cuentaID = $request->input('cuenta_id');
            $saldo = $request->input('saldo');

            $movimientos = DB::table('movimientos')
            ->join('cuentas', 'movimientos.cuenta_id', '=', 'cuentas.id')
            ->select(
                'cuentas.razon_social as cuenta',
                'cuentas.id as cuenta_id',
                'cuentas.codigo as codigo',
                DB::raw('SUM(movimientos.monto_q) as total_monto_q'),
                DB::raw('SUM(movimiento_pagos.monto_q) as total_pagado'),
                DB::raw('SUM(movimientos.monto_q) - SUM(movimiento_pagos.monto_q) as saldo')
            )
            ->leftJoin('movimiento_pagos', 'movimientos.id', '=', 'movimiento_pagos.movimiento_id');

            if (!empty($cuentaID)) {
                $movimientos->where('cuentas.id', '=', $cuentaID);
            }

            // Agregar 'cuentas.codigo' al groupBy
            $movimientos = $movimientos->groupBy('cuentas.id', 'cuentas.razon_social', 'cuentas.codigo');

            // Condiciones para el saldo
            if (!empty($saldo)){
                if ($saldo == "Pendiente") {
                    $movimientos->havingRaw('SUM(movimientos.monto_q) > SUM(movimiento_pagos.monto_q)');
                }
                if ($saldo == "Pagado") {
                    $movimientos->havingRaw('SUM(movimientos.monto_q) <= SUM(movimiento_pagos.monto_q)');
                }
            }

            // Ordenar por el código de cuenta
            $movimientos = $movimientos->orderByRaw("CAST(SUBSTRING_INDEX(codigo, '-', -1) AS UNSIGNED), codigo");

            // Obtener los resultados
            $movimientos = $movimientos->get();

            $usuarios = User::where('empresa_id', Auth::user()->empresa_id)->orderBy('name','asc')->get();
            $cuentas = Cuenta::where('empresa_id', Auth::user()->empresa_id)->orderByRaw("CAST(SUBSTRING_INDEX(codigo, '-', -1) AS UNSIGNED), codigo")->get();
            $rubros = Rubro::where('empresa_id', Auth::user()->empresa_id)->orderBy('nombre','asc')->get();
            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();
            //dd($request);
            return view('empresa.rsi.index', compact('movimientos','cuentas','config','request'));
        }
    }

    public function pdfrsi(Request $request)
    {
        // dd($request);
        if ($request)
        {
            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();



            //recibir datos de filtro para consulta
            $cuentaID = $request->input('ffcuenta');
            $saldo = $request->input('ffsaldo');

            //recibir detalles de la impresion
            $pdftamaño = $request->input('pdftamaño');
            $pdfhorientacion = $request->input('pdfhorientacion');
            $pdfarchivo = $request->input('pdfarchivo');

            //Consulta
            $movimientos = DB::table('movimientos')
            ->join('cuentas', 'movimientos.cuenta_id', '=', 'cuentas.id')
            ->select(
                'cuentas.razon_social as cuenta',
                'cuentas.id as cuenta_id',
                'cuentas.codigo as codigo',
                DB::raw('SUM(movimientos.monto_q) as total_monto_q'),
                DB::raw('SUM(movimiento_pagos.monto_q) as total_pagado'),
                DB::raw('SUM(movimientos.monto_q) - SUM(movimiento_pagos.monto_q) as saldo')
            )
            ->leftJoin('movimiento_pagos', 'movimientos.id', '=', 'movimiento_pagos.movimiento_id');
            if (!empty($cuentaID)) {
                $movimientos->where('cuentas.id', '=', $cuentaID);
            }

            $movimientos = $movimientos->groupBy('cuentas.id', 'cuentas.razon_social', 'cuentas.codigo');

            if (!empty($saldo)){
                if ($saldo == "Pendiente") {
                    $movimientos->havingRaw('SUM(movimientos.monto_q) > SUM(movimiento_pagos.monto_q)');
                }
                if ($saldo == "Pagado") {
                    $movimientos->havingRaw('SUM(movimientos.monto_q) <= SUM(movimiento_pagos.monto_q)');
                }
            }

            // Ordenar por el código de cuenta
            $movimientos = $movimientos->orderByRaw("CAST(SUBSTRING_INDEX(codigo, '-', -1) AS UNSIGNED), codigo");

            $movimientos = $movimientos->get();


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
                $pdf = PDF::loadView('empresa.rsi.pdfrsi', compact('imagen','movimientos','config','request'));
                $pdf->setPaper($pdftamaño, $pdfhorientacion);
                return $pdf->download ('RSI: '.$nompdf.'.pdf');
            }
            if ( $pdfarchivo == "stream" )
            {
                $pdf = PDF::loadView('empresa.rsi.pdfrsi', compact('imagen','movimientos','config','request'));
                $pdf->setPaper($pdftamaño, $pdfhorientacion);
                return $pdf->stream ('RSI: '.$nompdf.'.pdf');
            }
        }
    }
}
