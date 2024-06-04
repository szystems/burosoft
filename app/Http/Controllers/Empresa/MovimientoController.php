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

            $Consultafiltros->orderBy('fecha','desc');
            $movimientos = $Consultafiltros->get();

            $usuarios = User::where('empresa_id', Auth::user()->empresa_id)->orderBy('name','asc')->get();
            $cuentas = Cuenta::where('empresa_id', Auth::user()->empresa_id)->orderBy('razon_social','asc')->get();
            $rubros = Rubro::where('empresa_id', Auth::user()->empresa_id)->orderBy('nombre','asc')->get();
            $config = Config::first();
            //dd($request);
            return view('empresa.movimiento.index', compact('movimientos','usuarios','cuentas','rubros','config','fechaDesdeVista','fechaHastaVista'));
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
}
