<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Movimiento;
use App\Http\Requests\MovimientoFormRequest;
use App\Models\MovimientoDocumento;
use App\Models\MovimientoPago;
use App\Models\User;
use App\Models\Cuenta;
use App\Models\Rubro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Config;
use App\Models\Bitacora;
use Carbon\Carbon;
use PDF;
use DB;

class MovimientoController extends Controller
{
    public function index(Request $request)
    {
        // dd($request);
        if ($request) {
            //obtengo datos
            if ($request->input('fecha_desde') != "") {
                $fechaDesdeVista = date("d-m-Y", strtotime($request->input('fecha_desde')));
                $fechaDesde = date("Y-m-d", strtotime($request->input('fecha_desde')));
            }else
            {
                $hoy = Carbon::now('America/Guatemala');
                $fechaDesdeVista = $hoy->subDays(30);
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

            $cuentaID = $request->input('cuenta_id');
            $rubroID = $request->input('rubro_id');
            $usuarioID = $request->input('usuario_id');
            $saldo = $request->input('saldo');
            $ordenar = $request->input('ordenar');


            $Consultafiltros = Movimiento::where('fecha', '>=', $fechaDesde)
            ->where('fecha', '<=', $fechaHasta)
            ->where('empresa_id', Auth::user()->empresa_id);
            if (!empty($usuarioID)) {
                $Consultafiltros->where('usuario_id', '=', $usuarioID);
            }
            if (!empty($cuentaID)) {
                $Consultafiltros->where('cuenta_id', '=', $cuentaID);
            }
            if (!empty($rubroID)) {
                $Consultafiltros->where('rubro_id', '=', $rubroID);
            }
            if (!empty($saldo)){
                if ($saldo == "Pendiente") {
                    $Consultafiltros->where(function ($query) {
                        $query->whereRaw('monto_q > (SELECT COALESCE(SUM(mp.monto_q), 0) FROM movimiento_pagos mp WHERE mp.movimiento_id = movimientos.id)');
                    });
                }
                if ($saldo == "Pagado") {
                    $Consultafiltros->where(function ($query) {
                        $query->whereRaw('monto_q <= (SELECT COALESCE(SUM(mp.monto_q), 0) FROM movimiento_pagos mp WHERE mp.movimiento_id = movimientos.id)');
                    });
                }
            }
            if ($ordenar == "fecha") {
                $Consultafiltros->orderBy('fecha','desc');
                $Consultafiltros->orderBy('cuenta_id','desc');
            }else{
                $Consultafiltros->orderBy('cuenta_id','desc');
                $Consultafiltros->orderBy('fecha','desc');
            }
            $Consultafiltros->orderBy('fecha','desc');
            $movimientos = $Consultafiltros->get();

            $usuarios = User::where('empresa_id', Auth::user()->empresa_id)->orderBy('name','asc')->get();
            $cuentas = Cuenta::where('empresa_id', Auth::user()->empresa_id)->orderBy('razon_social','asc')->get();
            $rubros = Rubro::where('empresa_id', Auth::user()->empresa_id)->orderBy('nombre','asc')->get();
            $config = Config::first();
            //dd($request);
            return view('empresa.movimiento.index', compact('movimientos','usuarios','cuentas','rubros','config','fechaDesdeVista','fechaHastaVista','request'));
        }
    }

    public function show($id)
    {
        $movimiento = Movimiento::find($id);
        $documentos = MovimientoDocumento::where('movimiento_id', $id)->get();
        $pagos = MovimientoPago::where('movimiento_id', $id)->get();
        $totalAbonadoQ = MovimientoPago::where('movimiento_id', $id)->sum('monto_q');
        $totalAbonadoD = MovimientoPago::where('movimiento_id', $id)->sum('monto_d');
        $config = Config::first();
        return view('empresa.movimiento.show', compact('movimiento','documentos','pagos','config','totalAbonadoQ','totalAbonadoD'));
    }

    public function add()
    {
        $cuentas = cuenta::where('empresa_id', Auth::user()->empresa_id)->orderBy('razon_social','asc')->get();
        $rubros = Rubro::where('empresa_id', Auth::user()->empresa_id)->orderBy('nombre','asc')->get();
        return view('empresa.movimiento.add', compact('cuentas','rubros'));
    }

    public function insert(MovimientoFormRequest $request)
    {
        $hoy = Carbon::now('America/Guatemala');
        $hoy = $hoy->format('Y-m-d');

        $movimiento = new Movimiento();
        $movimiento->fecha = $hoy;
        $movimiento->empresa_id = $request->input('empresa_id');
        $movimiento->usuario_id = $request->input('usuario_id');
        $movimiento->cuenta_id = $request->input('cuenta_id');
        $movimiento->rubro_id = $request->input('rubro_id');
        $movimiento->monto_q = $request->input('monto_q');
        $movimiento->monto_d = $request->input('monto_d');
        $movimiento->descripcion = $request->input('descripcion');
        $movimiento->save();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Movimiento",
            'descripcion' => "Creo una nuevo movimiento: ".$movimiento->cuenta->razon_social.", ".$movimiento->rubro->nombre.", Q.".number_format($movimiento->monto_q,2, '.', ','),
        ]);

        return redirect('show-movimiento/'.$movimiento->id)->with('status',__('Movimiento agregado exitosamente.'));
    }

    public function edit($id)
    {
        $cuentas = Cuenta::where('empresa_id', Auth::user()->empresa_id)->orderBy('razon_social','asc')->get();
        $rubros = Rubro::where('empresa_id', Auth::user()->empresa_id)->orderBy('nombre','asc')->get();
        $config = Config::where('empresa_id', $id)->first();
        $movimiento = Movimiento::find($id);
        //dd($movimiento);
        return view('empresa.movimiento.edit', \compact('cuentas','rubros','movimiento','config'));
    }

    public function update(MovimientoFormRequest $request, $id)
    {
        $movimiento = Movimiento::find($id);
        $movimiento->cuenta_id = $request->input('cuenta_id');
        $movimiento->rubro_id = $request->input('rubro_id');
        $movimiento->monto_q = $request->input('monto_q');
        $movimiento->monto_d = $request->input('monto_d');
        $movimiento->descripcion = $request->input('descripcion');
        $movimiento->update();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Movimiento",
            'descripcion' => "Actualizó un movimiento: ".$movimiento->cuenta->razon_social.", ".$movimiento->rubro->nombre.", Q.".number_format($movimiento->monto_q,2, '.', ','),
        ]);

        return redirect('show-movimiento/'.$id)->with('status',__('Movimiento actualizado correctamente.'));

    }

    public function destroy($id)
    {
        $movimiento = Movimiento::find($id);
        $razon_social = $movimiento->razon_social;
        $movimiento->delete();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Movimiento",
            'descripcion' => "Eliminó un movimiento: ".$movimiento->cuenta->razon_social.", ".$movimiento->rubro->nombre.", Q.".number_format($movimiento->monto_q,2, '.', ','),
        ]);

        return redirect('movimientos')->with('status',__('Movimiento eliminado correctamente.'));
    }

    public function pdfmovimientos(Request $request)
    {
        // dd($request);
        if ($request)
        {
            $config = Config::first();

            //arreglo de fechas
            if ($request->input('ffechadesde') != "") {
                $fechaDesdeVista = date("d-m-Y", strtotime($request->input('ffechadesde')));
                $fechaDesde = date("Y-m-d", strtotime($request->input('ffechadesde')));
            }else
            {
                $hoy = Carbon::now('America/Guatemala');
                $fechaDesdeVista = $hoy->subDays(30);
                $fechaDesdeVista = $hoy->format('d-m-Y');
                $fechaDesde = date("Y-m-d", strtotime($fechaDesdeVista));
            }

            if ($request->input('ffechahasta') != "") {
                $fechaHastaVista = date("d-m-Y", strtotime($request->input('ffechahasta')));
                $fechaHasta = date("Y-m-d", strtotime($request->input('ffechahasta')));
            }else
            {
                $hoy = Carbon::now('America/Guatemala');
                $fechaHastaVista = $hoy->format('d-m-Y');
                $fechaHasta = date("Y-m-d", strtotime($fechaHastaVista));
            }

            //recibir datos de filtro para consulta
            $cuentaID = $request->input('ffcuenta');
            $rubroID = $request->input('ffrubro');
            $usuarioID = $request->input('ffusuario');
            $saldo = $request->input('ffsaldo');
            $ordenar = $request->input('ordenar');

            //recibir detalles de la impresion
            $pdftamaño = $request->input('pdftamaño');
            $pdfhorientacion = $request->input('pdfhorientacion');
            $pdfarchivo = $request->input('pdfarchivo');

            //recibir las columnas a mostrar
            // $fid = $request->has('fid');
            // $ffecha = $request->has('ffecha');
            // $fcuenta = $request->has('fcuenta');
            // $frubro = $request->has('frubro');
            // $fcargo = $request->has('fcargo');
            // $festadosaldo = $request->has('festadosaldo');
            // $fpagadosaldo = $request->has('fpagadosaldo');
            // $fusuario = $request->has('fusuario');
            // $fpagos = $request->has('fpagos');


            $Consultafiltros = Movimiento::where('fecha', '>=', $fechaDesde)
            ->where('fecha', '<=', $fechaHasta)
            ->where('empresa_id', Auth::user()->empresa_id);
            if (!empty($usuarioID)) {
                $Consultafiltros->where('usuario_id', '=', $usuarioID);
            }
            if (!empty($cuentaID)) {
                $Consultafiltros->where('cuenta_id', '=', $cuentaID);
            }
            if (!empty($rubroID)) {
                $Consultafiltros->where('rubro_id', '=', $rubroID);
            }
            if (!empty($saldo)){
                if ($saldo == "Pendiente") {
                    $Consultafiltros->where(function ($query) {
                        $query->whereRaw('monto_q > (SELECT COALESCE(SUM(mp.monto_q), 0) FROM movimiento_pagos mp WHERE mp.movimiento_id = movimientos.id)');
                    });
                }
                if ($saldo == "Pagado") {
                    $Consultafiltros->where(function ($query) {
                        $query->whereRaw('monto_q <= (SELECT COALESCE(SUM(mp.monto_q), 0) FROM movimiento_pagos mp WHERE mp.movimiento_id = movimientos.id)');
                    });
                }
            }
            if ($ordenar == "fecha") {
                $Consultafiltros->orderBy('fecha','desc');
                $Consultafiltros->orderBy('cuenta_id','desc');
            }else{
                $Consultafiltros->orderBy('cuenta_id','desc');
                $Consultafiltros->orderBy('fecha','desc');
            }
            $movimientos = $Consultafiltros->get();


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
                $pdf = PDF::loadView('empresa.movimiento.pdfmovimientos', compact('imagen','movimientos','config','request','fechaDesdeVista','fechaHastaVista'));
                $pdf->setPaper($pdftamaño, $pdfhorientacion);
                return $pdf->download ('Reporte Movimientos: '.$nompdf.'.pdf');
            }
            if ( $pdfarchivo == "stream" )
            {
                $pdf = PDF::loadView('empresa.movimiento.pdfmovimientos', compact('imagen','movimientos','config','request','fechaDesdeVista','fechaHastaVista'));
                $pdf->setPaper($pdftamaño, $pdfhorientacion);
                return $pdf->stream ('Reporte Movimientos: '.$nompdf.'.pdf');
            }
        }
    }

    public function pdfmovimiento(Request $request)
    {
        // dd($request);
        if ($request)
        {
            $config = Config::first();
            $movimiento = Movimiento::find($request->input('fmovimiento_id'));
            $documentos = MovimientoDocumento::where('movimiento_id', $request->input('fmovimiento_id'))->get();
            $pagos = MovimientoPago::where('movimiento_id', $request->input('fmovimiento_id'))->get();
            $totalAbonadoQ = MovimientoPago::where('movimiento_id', $request->input('fmovimiento_id'))->sum('monto_q');
            $totalAbonadoD = MovimientoPago::where('movimiento_id', $request->input('fmovimiento_id'))->sum('monto_d');

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

            //recibir detalles de la impresion
            $pdftamaño = $request->input('pdftamaño');
            $pdfhorientacion = $request->input('pdfhorientacion');
            $pdfarchivo = $request->input('pdfarchivo');

            if ( $pdfarchivo == "download" )
            {
                $pdf = PDF::loadView('empresa.movimiento.pdfmovimiento', compact('imagen','movimiento','config','documentos','pagos','totalAbonadoQ','totalAbonadoD'));
                $pdf->setPaper($pdftamaño, $pdfhorientacion);
                return $pdf->download ('Reporte Movimiento: '.$movimiento->id.'-'.$nompdf.'.pdf');
            }
            if ( $pdfarchivo == "stream" )
            {
                $pdf = PDF::loadView('empresa.movimiento.pdfmovimiento', compact('imagen','movimiento','config','documentos','pagos','totalAbonadoQ','totalAbonadoD'));
                $pdf->setPaper($pdftamaño, $pdfhorientacion);
                return $pdf->stream ('Reporte Movimiento ID: '.$movimiento->id.'-'.$nompdf.'.pdf');
            }
        }
    }
}
