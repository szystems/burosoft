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

            $tipobusqueda = $request->input('tipobusqueda');
            $fcodigo=$request->input('fcodigo');

            //obtengo datos
            if ($request->input('fecha_desde') != "") {
                $fechaDesdeVista = date("d-m-Y", strtotime($request->input('fecha_desde')));
                $fechaDesde = date("Y-m-d", strtotime($request->input('fecha_desde')));
            } else {
                // Buscar la fecha más antigua de los movimientos para la empresa actual
                $movimientoMasAntiguo = Movimiento::where('empresa_id', Auth::user()->empresa_id)
                                      ->orderBy('fecha', 'asc')
                                      ->first();

                if ($movimientoMasAntiguo) {
                    $fechaDesdeVista = date("d-m-Y", strtotime($movimientoMasAntiguo->fecha));
                    $fechaDesde = date("Y-m-d", strtotime($movimientoMasAntiguo->fecha));
                } else {
                    // Si no hay movimientos, usar la fecha actual
                    $hoy = Carbon::now('America/Guatemala');
                    $fechaDesdeVista = $hoy->format('d-m-Y');
                    $fechaDesde = date("Y-m-d", strtotime($fechaDesdeVista));
                }
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
            $codigo = $request->input('codigo');

            $movimientos = []; // Inicializa como null
            // dd($tipobusqueda);

            if ($tipobusqueda == 1 or !$tipobusqueda) {

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
                if (!empty($codigo)) { // Verifica si el código no está vacío
                    $Consultafiltros->where('codigo', 'like', '%' . $codigo . '%'); // Agrega la condición para buscar por código
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
                    // $Consultafiltros->orderBy('cuenta_id','desc');
                }else{
                    $Consultafiltros->orderBy('codigo','desc');
                    // $Consultafiltros->orderBy('fecha','desc');
                }
                // $Consultafiltros->orderBy('fecha','desc');
                $movimientos = $Consultafiltros->get();

            } elseif ($tipobusqueda == 2) {
                // dd($fcodigo);
                $movimientos = Movimiento::where('cuenta_id', '=', $fcodigo)
                ->where('empresa_id', Auth::user()->empresa_id)
                ->orderBy('fecha', 'desc')
                ->get();
            }



            $usuarios = User::where('empresa_id', Auth::user()->empresa_id)->orderBy('name','asc')->get();
            $cuentas = Cuenta::where('empresa_id', Auth::user()->empresa_id)->orderByRaw("CAST(SUBSTRING_INDEX(codigo, '-', -1) AS UNSIGNED), codigo")->get();
            $rubros = Rubro::where('empresa_id', Auth::user()->empresa_id)->orderBy('nombre','asc')->get();
            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();
            //dd($request);
            return view('empresa.movimiento.index', compact('movimientos','usuarios','cuentas','rubros','config','fechaDesdeVista','fechaHastaVista','codigo','request','fcodigo','tipobusqueda'));
        }
    }

    public function show($id)
    {
        $movimiento = Movimiento::find($id);
        $documentos = MovimientoDocumento::where('movimiento_id', $id)->get();
        $pagos = MovimientoPago::where('movimiento_id', $id)->get();
        $totalAbonadoQ = MovimientoPago::where('movimiento_id', $id)->where('estado', 1)->sum('monto_q');
        $totalAbonadoD = MovimientoPago::where('movimiento_id', $id)->where('estado', 1)->sum('monto_d');
        $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();
        return view('empresa.movimiento.show', compact('movimiento','documentos','pagos','config','totalAbonadoQ','totalAbonadoD'));
    }

    public function add()
    {
        // $cuentas = cuenta::where('empresa_id', Auth::user()->empresa_id)->orderByRaw("CAST(SUBSTRING_INDEX(codigo, '-', -1) AS UNSIGNED), codigo")get();
        $cuentas = cuenta::where('empresa_id', Auth::user()->empresa_id)->orderBy('razon_social','asc')->get();

        $rubros = Rubro::where('empresa_id', Auth::user()->empresa_id)->orderBy('nombre','asc')->get();
        return view('empresa.movimiento.add', compact('cuentas','rubros'));
    }

    public function insert(MovimientoFormRequest $request)
    {
        $hoy = Carbon::now('America/Guatemala')->format('Y-m-d');

        DB::beginTransaction();
        try {
            $ultimoMovimiento = Movimiento::where('empresa_id', $request->input('empresa_id'))
                ->where('cuenta_id', $request->input('cuenta_id'))
                ->orderBy('id', 'desc')
                ->first();

            // Inicializar el correlativo
            $correlativo = 1; // Valor por defecto

            if ($ultimoMovimiento) {
                $codigoAnterior = $ultimoMovimiento->codigo;

                // Usar expresión regular para extraer el número del correlativo
                preg_match('/MOV(\d+)/', $codigoAnterior, $matches);

                if (isset($matches[1])) {
                    $correlativo = intval($matches[1]) + 1; // Incrementar el correlativo
                }
            }

            // Construir el código
            $codigo = $request->input('empresa_id') . '-' . $request->input('cuenta_id') . '-MOV' . $correlativo;

            $movimiento = new Movimiento();
            $movimiento->fecha = $hoy;
            $movimiento->empresa_id = $request->input('empresa_id');
            $movimiento->usuario_id = $request->input('usuario_id');
            $movimiento->cuenta_id = $request->input('cuenta_id');
            $movimiento->rubro_id = $request->input('rubro_id');
            $movimiento->monto_q = $request->input('monto_q');
            $movimiento->monto_d = $request->input('monto_d');
            $movimiento->descripcion = $request->input('descripcion');
            $movimiento->codigo = $codigo; // Asignar el código generado
            $movimiento->save();

            Bitacora::create([
                'empresa_id' => Auth::user()->empresa_id,
                'usuario_id' => Auth::user()->id,
                'fecha' => now(),
                'tipo' => "Movimiento",
                'descripcion' => "Creo un nuevo movimiento: " . $movimiento->cuenta->razon_social . ", " . $movimiento->rubro->nombre . ", Q." . number_format($movimiento->monto_q, 2, '.', ','),
            ]);

            DB::commit();

            // return redirect('show-movimiento/' . $movimiento->id)->with('status', __('Movimiento agregado exitosamente.'));
            return redirect('add-movimiento')->with('status', __('Movimiento agregado exitosamente.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error al agregar el movimiento: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $cuentas = Cuenta::where('empresa_id', Auth::user()->empresa_id)->orderByRaw("CAST(SUBSTRING_INDEX(codigo, '-', -1) AS UNSIGNED), codigo")->get();
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
        // Encontrar el movimiento por su ID
        $movimiento = Movimiento::find($id);

        // Verificar si el movimiento existe
        if (!$movimiento) {
            return redirect('movimientos')->with('error', __('Movimiento no encontrado.'));
        }

        // Cambiar el estado del movimiento a 0 (inactivo)
        $movimiento->estado = 0; // Asumiendo que 'estado' es el campo que usas
        $movimiento->save();

        // Crear un registro en la bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Movimiento",
            'descripcion' => "Desactivó un movimiento: " . $movimiento->cuenta->razon_social . ", " . $movimiento->rubro->nombre . ", Q." . number_format($movimiento->monto_q, 2, '.', ','),
        ]);

        // Redirigir con un mensaje de éxito
        return redirect('movimientos')->with('status', __('Movimiento desactivado correctamente.'));
    }

    public function pdfmovimientos(Request $request)
    {
        if ($request)
        {
            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();

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

            // Limitar la cantidad de registros para evitar problemas de memoria
            $limite = $request->input('limite') ? $request->input('limite') : 100;

            // Seleccionar solo las columnas necesarias
            $consultaBase = Movimiento::select('movimientos.*')
                ->with(['cuenta:id,razon_social', 'rubro:id,nombre', 'usuario:id,name'])
                ->where('fecha', '>=', $fechaDesde)
                ->where('fecha', '<=', $fechaHasta)
                ->where('empresa_id', Auth::user()->empresa_id);

            if (!empty($usuarioID)) {
                $consultaBase->where('usuario_id', '=', $usuarioID);
            }
            if (!empty($cuentaID)) {
                $consultaBase->where('cuenta_id', '=', $cuentaID);
            }
            if (!empty($rubroID)) {
                $consultaBase->where('rubro_id', '=', $rubroID);
            }

            // Optimización para la consulta de saldo
            if (!empty($saldo)){
                if ($saldo == "Pendiente") {
                    $consultaBase->whereRaw('(SELECT COALESCE(SUM(mp.monto_q), 0) FROM movimiento_pagos mp WHERE mp.movimiento_id = movimientos.id) < movimientos.monto_q');
                }
                if ($saldo == "Pagado") {
                    $consultaBase->whereRaw('(SELECT COALESCE(SUM(mp.monto_q), 0) FROM movimiento_pagos mp WHERE mp.movimiento_id = movimientos.id) >= movimientos.monto_q');
                }
            }

            if ($ordenar == "fecha") {
                $consultaBase->orderBy('fecha','desc');
            } else {
                $consultaBase->orderBy('cuenta_id','desc')
                            ->orderBy('fecha','desc');
            }

            // Limitar la cantidad de registros para prevenir problemas de memoria
            $movimientos = $consultaBase->limit($limite)->get();

            // Precalcular totales
            $monto_total_q = $movimientos->where('estado', 1)->sum('monto_q');
            $monto_total_d = $movimientos->where('estado', 1)->sum('monto_d');

            // Obtener todos los IDs de movimientos para consultar pagos
            $movimientoIds = $movimientos->pluck('id')->toArray();

            // Obtener pagos para todos los movimientos en una sola consulta
            $pagosPorMovimiento = DB::table('movimiento_pagos')
                ->select('movimiento_id', DB::raw('SUM(monto_q) as total_pagado'))
                ->whereIn('movimiento_id', $movimientoIds)
                ->groupBy('movimiento_id')
                ->pluck('total_pagado', 'movimiento_id')
                ->toArray();

            // Si se necesitan pagos detallados, obtenerlos para todos los movimientos
            $pagosDetallados = [];
            if($request->has('fpagos')) {
                $pagosDetallados = DB::table('movimiento_pagos')
                    ->select('*')
                    ->whereIn('movimiento_id', $movimientoIds)
                    ->orderBy('fecha_documento', 'asc')
                    ->get()
                    ->groupBy('movimiento_id')
                    ->toArray();
            }

            $nompdf = date('Y-m-d_H-i-s');
            $path = public_path('assets/uploads/');
            $currency = $config->currency_simbol;

            if ($config->logo == null) {
                $imagen = null;
            } else {
                $imagen = public_path('assets/uploads/logos/'.$config->logo);
            }

            // Pasar datos precalculados a la vista
            $viewData = compact(
                'imagen',
                'movimientos',
                'config',
                'request',
                'fechaDesdeVista',
                'fechaHastaVista',
                'pagosPorMovimiento',
                'pagosDetallados',
                'monto_total_q',
                'monto_total_d'
            );

            if ($pdfarchivo == "download" || $pdfarchivo == "stream") {
                // Primero crear el PDF con los datos de la vista
                $pdf = PDF::loadView('empresa.movimiento.pdfmovimientos', $viewData);

                // Luego configurar opciones una por una
                $pdf->setOption('isRemoteEnabled', true);
                $pdf->setOption('isHtml5ParserEnabled', true);
                $pdf->setOption('dpi', 72);
                $pdf->setOption('defaultFont', 'sans-serif');

                // Configurar tamaño y orientación del papel
                $pdf->setPaper($pdftamaño, $pdfhorientacion);

                // Devolver el PDF según el tipo solicitado
                if ($pdfarchivo == "download") {
                    return $pdf->download('Reporte_Movimientos_'.$nompdf.'.pdf');
                } else {
                    return $pdf->stream('Reporte_Movimientos_'.$nompdf.'.pdf');
                }
            }
        }
    }

    public function pdfmovimiento(Request $request)
    {
        // dd($request);
        if ($request)
        {
            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();
            $movimiento = Movimiento::find($request->input('fmovimiento_id'));
            $documentos = MovimientoDocumento::where('movimiento_id', $request->input('fmovimiento_id'))->get();
            $pagos = MovimientoPago::where('movimiento_id', $request->input('fmovimiento_id'))->get();
            $totalAbonadoQ = MovimientoPago::where('movimiento_id', $request->input('fmovimiento_id'))->where('estado', 1)->sum('monto_q');
            $totalAbonadoD = MovimientoPago::where('movimiento_id', $request->input('fmovimiento_id'))->where('estado', 1)->sum('monto_d');

            $nompdf = date('Y-m-d_H-i-s');
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

    public function pdfmovimientocabecera(Request $request, $id)
    {
        if ($request)
        {
            $verpdf = "Browser";
            $nompdf = date('Y-m-d_H-i-s');
            $path = public_path('assets/uploads/');

            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();
            $movimiento = Movimiento::find($id);
            $totalAbonadoQ = MovimientoPago::where('movimiento_id', $id)->where('estado', 1)->sum('monto_q');
            $totalAbonadoD = MovimientoPago::where('movimiento_id', $id)->where('estado', 1)->sum('monto_d');

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


            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();

            if ( $verpdf == "Download" )
            {
                $pdf = PDF::loadView('empresa.movimiento.pdfmovimientocabecera',['movimiento'=>$movimiento,'path'=>$path,'config'=>$config,'imagen'=>$imagen,'currency'=>$currency,'totalAbonadoQ'=>$totalAbonadoQ,'totalAbonadoD'=>$totalAbonadoD]);

                return $pdf->download ('Movimiento: '.$movimiento->id.'-'.$nompdf.'.pdf');
            }
            if ( $verpdf == "Browser" )
            {
                $pdf = PDF::loadView('empresa.movimiento.pdfmovimientocabecera',['movimiento'=>$movimiento,'path'=>$path,'config'=>$config,'imagen'=>$imagen,'currency'=>$currency,'totalAbonadoQ'=>$totalAbonadoQ,'totalAbonadoD'=>$totalAbonadoD]);

                return $pdf->stream ('Movimiento: '.$movimiento->id.'-'.$nompdf.'.pdf');
            }
        }
    }

    public function pdfestadisticas(Request $request)
    {
        if ($request)
        {
            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();

            //arreglo de fechas
            if ($request->input('fecha_desde') != "") {
                $fechaDesdeVista = date("d-m-Y", strtotime($request->input('fecha_desde')));
                $fechaDesde = date("Y-m-d", strtotime($request->input('fecha_desde')));
            } else {
                // Buscar la fecha más antigua de los movimientos para la empresa actual
                $movimientoMasAntiguo = Movimiento::where('empresa_id', Auth::user()->empresa_id)
                                      ->orderBy('fecha', 'asc')
                                      ->first();

                if ($movimientoMasAntiguo) {
                    $fechaDesdeVista = date("d-m-Y", strtotime($movimientoMasAntiguo->fecha));
                    $fechaDesde = date("Y-m-d", strtotime($movimientoMasAntiguo->fecha));
                } else {
                    // Si no hay movimientos, usar la fecha actual
                    $hoy = Carbon::now('America/Guatemala');
                    $fechaDesdeVista = $hoy->format('d-m-Y');
                    $fechaDesde = date("Y-m-d", strtotime($fechaDesdeVista));
                }
            }

            if ($request->input('fecha_hasta') != "") {
                $fechaHastaVista = date("d-m-Y", strtotime($request->input('fecha_hasta')));
                $fechaHasta = date("Y-m-d", strtotime($request->input('fecha_hasta')));
            } else {
                $hoy = Carbon::now('America/Guatemala');
                $fechaHastaVista = $hoy->format('d-m-Y');
                $fechaHasta = date("Y-m-d", strtotime($fechaHastaVista));
            }

            // Obtener los filtros
            $cuentaID = $request->input('cuenta_id');
            $rubroID = $request->input('rubro_id');
            $usuarioID = $request->input('usuario_id');
            $saldo = $request->input('saldo');
            $ordenar = $request->input('ordenar');
            $codigo = $request->input('codigo');

            // Consulta de movimientos con filtros
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
            if (!empty($codigo)) {
                $Consultafiltros->where('codigo', 'like', '%' . $codigo . '%');
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
            } else {
                $Consultafiltros->orderBy('codigo','desc');
            }

            $movimientos = $Consultafiltros->get();

            // Variables para estadísticas
            $monto_total_q = 0;
            $monto_total_d = 0;
            $pagado_total = 0;
            $saldo_total = 0;

            // Arrays para estadísticas
            $rubros_data = [];
            $cuentas_data = [];
            $usuarios_data = [];
            $estado_pagos = ['Pagado' => 0, 'Pendiente' => 0];
            $meses_data = [];

            // Calcular estadísticas
            foreach ($movimientos as $movimiento) {
                if ($movimiento->estado == 1) {
                    $monto_pagado_q = \App\Models\MovimientoPago::where('movimiento_id', $movimiento->id)
                        ->where('estado', 1)
                        ->sum('monto_q');
                    $saldo = $movimiento->monto_q - $monto_pagado_q;

                    $monto_total_q += $movimiento->monto_q;
                    $monto_total_d += $movimiento->monto_d;
                    $pagado_total += $monto_pagado_q;
                    $saldo_total += $saldo;

                    // Estadísticas por mes
                    $mes = date('Y-m', strtotime($movimiento->fecha));
                    if (!isset($meses_data[$mes])) {
                        $meses_data[$mes] = [
                            'monto_q' => 0,
                            'pagado_q' => 0,
                            'saldo_q' => 0,
                            'count' => 0
                        ];
                    }
                    $meses_data[$mes]['monto_q'] += $movimiento->monto_q;
                    $meses_data[$mes]['pagado_q'] += $monto_pagado_q;
                    $meses_data[$mes]['saldo_q'] += $saldo;
                    $meses_data[$mes]['count']++;

                    // Estadísticas por rubro
                    $rubro = $movimiento->rubro->nombre;
                    if (!isset($rubros_data[$rubro])) {
                        $rubros_data[$rubro] = [
                            'monto_q' => 0,
                            'pagado_q' => 0,
                            'saldo_q' => 0,
                            'count' => 0
                        ];
                    }
                    $rubros_data[$rubro]['monto_q'] += $movimiento->monto_q;
                    $rubros_data[$rubro]['pagado_q'] += $monto_pagado_q;
                    $rubros_data[$rubro]['saldo_q'] += $saldo;
                    $rubros_data[$rubro]['count']++;

                    // Estadísticas por cuenta
                    $cuenta = $movimiento->cuenta->razon_social;
                    if (!isset($cuentas_data[$cuenta])) {
                        $cuentas_data[$cuenta] = [
                            'monto_q' => 0,
                            'pagado_q' => 0,
                            'saldo_q' => 0,
                            'count' => 0
                        ];
                    }
                    $cuentas_data[$cuenta]['monto_q'] += $movimiento->monto_q;
                    $cuentas_data[$cuenta]['pagado_q'] += $monto_pagado_q;
                    $cuentas_data[$cuenta]['saldo_q'] += $saldo;
                    $cuentas_data[$cuenta]['count']++;

                    // Estadísticas por usuario
                    $usuario = $movimiento->usuario->name ?? 'Sin Usuario';
                    if (!isset($usuarios_data[$usuario])) {
                        $usuarios_data[$usuario] = [
                            'monto_q' => 0,
                            'pagado_q' => 0,
                            'saldo_q' => 0,
                            'count' => 0
                        ];
                    }
                    $usuarios_data[$usuario]['monto_q'] += $movimiento->monto_q;
                    $usuarios_data[$usuario]['pagado_q'] += $monto_pagado_q;
                    $usuarios_data[$usuario]['saldo_q'] += $saldo;
                    $usuarios_data[$usuario]['count']++;

                    // Estadísticas por estado de pago
                    if ($movimiento->monto_q <= $monto_pagado_q) {
                        $estado_pagos['Pagado']++;
                    } else {
                        $estado_pagos['Pendiente']++;
                    }
                }
            }

            // Preparar la generación del PDF
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
            $pdf = PDF::loadView('empresa.movimiento.pdfestadisticas', compact(
                'imagen',
                'movimientos',
                'config',
                'request',
                'fechaDesdeVista',
                'fechaHastaVista',
                'monto_total_q',
                'monto_total_d',
                'pagado_total',
                'saldo_total',
                'rubros_data',
                'cuentas_data',
                'usuarios_data',
                'estado_pagos',
                'meses_data'
            ));

            // Configurar el tamaño y orientación del PDF
            $pdf->setPaper('letter', 'portrait');

            // Devolver el PDF como descarga
            return $pdf->stream('Estadisticas_Movimientos_'.$nompdf.'.pdf');
        }
    }
}
