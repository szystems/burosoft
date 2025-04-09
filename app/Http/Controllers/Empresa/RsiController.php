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
            $movimientos = $movimientos->orderByRaw("CAST(SUBSTRING_INDEX(cuentas.codigo, '-', -1) AS UNSIGNED), cuentas.codigo");

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
        if ($request)
        {
            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();

            // Limitar la cantidad de registros para evitar problemas de memoria
            $limite = $request->input('limite') ? $request->input('limite') : 500;

            //recibir datos de filtro para consulta
            $cuentaID = $request->input('ffcuenta');
            $saldo = $request->input('ffsaldo');

            //recibir detalles de la impresion
            $pdftamaño = $request->input('pdftamaño') ?? 'letter';
            $pdfhorientacion = $request->input('pdfhorientacion') ?? 'portrait';
            $pdfarchivo = $request->input('pdfarchivo') ?? 'stream';

            //Consulta optimizada
            $movimientos = DB::table('movimientos')
            ->join('cuentas', 'movimientos.cuenta_id', '=', 'cuentas.id')
            ->select(
                'cuentas.razon_social as cuenta',
                'cuentas.id as cuenta_id',
                'cuentas.codigo as codigo',
                DB::raw('SUM(movimientos.monto_q) as total_monto_q'),
                DB::raw('COALESCE(SUM(movimiento_pagos.monto_q), 0) as total_pagado'),
                DB::raw('SUM(movimientos.monto_q) - COALESCE(SUM(movimiento_pagos.monto_q), 0) as saldo')
            )
            ->leftJoin('movimiento_pagos', 'movimientos.id', '=', 'movimiento_pagos.movimiento_id')
            ->where('movimientos.empresa_id', Auth::user()->empresa_id);
            
            if (!empty($cuentaID)) {
                $movimientos->where('cuentas.id', '=', $cuentaID);
            }

            $movimientos = $movimientos->groupBy('cuentas.id', 'cuentas.razon_social', 'cuentas.codigo');

            if (!empty($saldo)){
                if ($saldo == "Pendiente") {
                    $movimientos->havingRaw('SUM(movimientos.monto_q) > COALESCE(SUM(movimiento_pagos.monto_q), 0)');
                }
                if ($saldo == "Pagado") {
                    $movimientos->havingRaw('SUM(movimientos.monto_q) <= COALESCE(SUM(movimiento_pagos.monto_q), 0)');
                }
            }

            // Ordenar por el código de cuenta
            $movimientos = $movimientos->orderByRaw("CAST(SUBSTRING_INDEX(cuentas.codigo, '-', -1) AS UNSIGNED), cuentas.codigo")
                ->limit($limite)
                ->get();

            // Calcular totales para usar en la vista
            $tmonto = $movimientos->sum('total_monto_q');
            $tpagado = $movimientos->sum('total_pagado');
            
            // Calcular saldo total
            $tsaldo = 0;
            foreach ($movimientos as $movimiento) {
                if ($movimiento->saldo == 0 && ($movimiento->total_pagado != $movimiento->total_monto_q)) {
                    $tsaldo += $movimiento->total_monto_q;
                } else {
                    $tsaldo += $movimiento->saldo;
                }
            }

            $nompdf = date('Y-m-d_H-i-s');
            
            // Preparar imagen del logo
            if ($config->logo == null) {
                $imagen = null;
            } else {
                $imagen = public_path('assets/uploads/logos/'.$config->logo);
            }

            // Preparar los datos para la vista
            $viewData = compact('imagen', 'movimientos', 'config', 'request', 'tmonto', 'tpagado', 'tsaldo');

            // Crear el PDF con opciones optimizadas
            $pdf = PDF::loadView('empresa.rsi.pdfrsi', $viewData);
            
            // Configurar opciones para reducir uso de memoria
            $pdf->setOption('isRemoteEnabled', true);
            $pdf->setOption('isHtml5ParserEnabled', true);
            $pdf->setOption('dpi', 72);
            $pdf->setOption('defaultFont', 'sans-serif');
            
            // Configurar tamaño y orientación
            $pdf->setPaper($pdftamaño, $pdfhorientacion);
            
            // Devolver el PDF según el tipo solicitado
            if ($pdfarchivo == "download") {
                return $pdf->download('RSI_'.$nompdf.'.pdf');
            } else {
                return $pdf->stream('RSI_'.$nompdf.'.pdf');
            }
        }
    }

    // En el archivo RsiController.php
    public function pdfRsiEstadisticas(Request $request)
    {
        if ($request)
        {
            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();

            //arreglo de fechas
            //recibir datos de filtro para consulta
            $cuentaID = $request->input('cuenta_id');
            $saldo = $request->input('saldo');

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
            $movimientos = $movimientos->orderByRaw("CAST(SUBSTRING_INDEX(cuentas.codigo, '-', -1) AS UNSIGNED), cuentas.codigo");
            $movimientos = $movimientos->get();

            // Variables para estadísticas
            $tmonto = 0;
            $tpagado = 0;
            $tsaldo = 0;

            // Arrays para estadísticas
            $cuentas_data = [];
            $estado_pagos = ['Pagado' => 0, 'Pendiente' => 0];

            // Calcular las estadísticas
            foreach ($movimientos as $movimiento) {
                $tmonto += $movimiento->total_monto_q;
                $tpagado += $movimiento->total_pagado;

                if ($movimiento->saldo == 0 && ($movimiento->total_pagado != $movimiento->total_monto_q)) {
                    $tsaldo += $movimiento->total_monto_q;
                } else {
                    $tsaldo += $movimiento->saldo;
                }

                // Estado de pagos
                if ($movimiento->total_monto_q > $movimiento->total_pagado) {
                    $estado_pagos['Pendiente']++;
                } else {
                    $estado_pagos['Pagado']++;
                }

                // Datos para estadísticas por cuenta
                $cuentaNombre = $movimiento->cuenta;
                $cuentas_data[$cuentaNombre] = [
                    'monto' => $movimiento->total_monto_q,
                    'pagado' => $movimiento->total_pagado,
                    'saldo' => ($movimiento->saldo == 0 && $movimiento->total_pagado != $movimiento->total_monto_q)
                            ? $movimiento->total_monto_q
                            : $movimiento->saldo,
                    'codigo' => $movimiento->codigo
                ];
            }

            $nompdf = date('Y-m-d_H-i-s');

            // Configurar el logo
            if ($config->logo == null) {
                $logo = null;
                $imagen = null;
            } else {
                $logo = $config->logo;
                $imagen = public_path('assets/uploads/logos/'.$logo);
            }

            // Generar el PDF
            $pdf = PDF::loadView('empresa.rsi.pdfestadisticas', compact(
                'imagen',
                'movimientos',
                'config',
                'request',
                'tmonto',
                'tpagado',
                'tsaldo',
                'cuentas_data',
                'estado_pagos'
            ));

            // Configurar el tamaño y orientación del PDF
            $pdf->setPaper('letter', 'portrait');

            // Devolver el PDF como descarga
            return $pdf->stream('Estadisticas_RSI_'.$nompdf.'.pdf');
        }
    }
}
