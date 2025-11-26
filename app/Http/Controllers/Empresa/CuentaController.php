<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cuenta;
use App\Models\Rubro;
use App\Models\Movimiento;
use App\Http\Requests\CuentaFormRequest;
use App\Models\Config;
use App\Models\User;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use DB;
use App\Exports\CuentasExport;
use Maatwebsite\Excel\Facades\Excel;

class CuentaController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $queryCuenta=$request->input('fcuenta');
            $cuentas = DB::table('cuentas')
            ->where('empresa_id', Auth::user()->empresa_id)
            ->where(function ($query) use ($queryCuenta) {
            $query->where('razon_social', 'LIKE', '%' . $queryCuenta . '%')
                ->orWhere('correo', 'LIKE', '%' . $queryCuenta . '%')
                ->orWhere('telefono', 'LIKE', '%' . $queryCuenta . '%')
                ->orWhere('dpi', 'LIKE', '%' . $queryCuenta . '%')
                ->orWhere('nit', 'LIKE', '%' . $queryCuenta . '%')
                ->orWhere('codigo', '=',  $queryCuenta );
            })
            ->orderByRaw("CAST(SUBSTRING_INDEX(codigo, '-', -1) AS UNSIGNED), codigo")
            ->paginate(20);

            $filterCuentas = Cuenta::where('empresa_id', Auth::user()->empresa_id)->get();
            return view('empresa.cuenta.index', compact('cuentas','queryCuenta','filterCuentas'));
        }
    }

    public function show($id)
    {
        $cuenta = Cuenta::find($id);

        $fechas = DB::table('movimientos')
        ->where('cuenta_id', $id)
        ->selectRaw('MAX(fecha) as fecha_max, MIN(fecha) as fecha_min')
        ->get();
        $fecha_min = Carbon::parse($fechas->first()->fecha_min);
        $fecha_max = Carbon::parse($fechas->first()->fecha_max);
        $fechaDesdeVista = $fecha_min->format('d-m-Y');
        $fechaHastaVista = $fecha_max->format('d-m-Y');

        $movimientos = Movimiento::where('empresa_id', Auth::user()->empresa_id)
        ->where('cuenta_id', $cuenta->id)
        ->orderBy('fecha','desc')
        ->get();

        $usuarios = User::where('empresa_id', Auth::user()->empresa_id)->orderBy('name','asc')->get();
            $cuentas = Cuenta::where('empresa_id', Auth::user()->empresa_id)->orderBy('razon_social','asc')->get();
            $rubros = Rubro::where('empresa_id', Auth::user()->empresa_id)->orderBy('nombre','asc')->get();

        $config = Config::where('empresa_id', $cuenta->id)->first();
        return view('empresa.cuenta.show', compact('cuenta','movimientos','usuarios','cuentas','rubros','config','fechaDesdeVista','fechaHastaVista','fecha_min','fecha_max'));
    }

    public function add()
    {
        return view('empresa.cuenta.add');
    }

    public function insert(CuentaFormRequest $request)
    {

        // Obtener el ID de la empresa del usuario autenticado
        $empresaId = Auth::user()->empresa_id;

        // Obtener el correlativo para el nuevo código
        $correlativo = Cuenta::where('empresa_id', $empresaId)->count() + 1;

        // Formatear el código como "empresa_id-correlativo"
        $codigo = "{$empresaId}-{$correlativo}";

        $cuenta = new Cuenta();
        $cuenta->empresa_id = Auth::user()->empresa_id;
        $cuenta->nit = $request->input('nit');
        $cuenta->dpi = $request->input('dpi');
        $cuenta->razon_social = $request->input('razon_social');
        $cuenta->telefono = $request->input('telefono');
        $cuenta->correo = $request->input('correo');
        $cuenta->direccion = $request->input('direccion');
        $cuenta->otra_forma_contacto = $request->input('otra_forma_contacto');
        $cuenta->datos_intermediario_nombre = $request->input('datos_intermediario_nombre');
        $cuenta->datos_intermediario_telefono = $request->input('datos_intermediario_telefono');
        $cuenta->datos_intermediario_correo = $request->input('datos_intermediario_correo');
        $cuenta->datos_propietario_nombre = $request->input('datos_propietario_nombre');
        $cuenta->datos_propietario_telefono = $request->input('datos_propietario_telefono');
        $cuenta->datos_propietario_correo = $request->input('datos_propietario_correo');
        $cuenta->codigo = $codigo;
        $cuenta->estado = 1;
        $cuenta->save();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Cuenta",
            'descripcion' => "Creo una nueva cuenta: ".$cuenta->razon_social
        ]);

        return redirect('show-cuenta/'.$cuenta->id)->with('status',__('Cuenta agregada exitosamente.'));
    }

    public function edit($id)
    {
        $config = Config::where('empresa_id', $id)->first();
        $cuenta = Cuenta::find($id);
        return view('empresa.cuenta.edit', \compact('cuenta', 'config'));
    }

    public function update(CuentaFormRequest $request, $id)
    {
        $cuenta = Cuenta::find($id);
        $cuenta->nit = $request->input('nit');
        $cuenta->dpi = $request->input('dpi');
        $cuenta->razon_social = $request->input('razon_social');
        $cuenta->telefono = $request->input('telefono');
        $cuenta->correo = $request->input('correo');
        $cuenta->direccion = $request->input('direccion');
        $cuenta->otra_forma_contacto = $request->input('otra_forma_contacto');
        $cuenta->datos_intermediario_nombre = $request->input('datos_intermediario_nombre');
        $cuenta->datos_intermediario_telefono = $request->input('datos_intermediario_telefono');
        $cuenta->datos_intermediario_correo = $request->input('datos_intermediario_correo');
        $cuenta->datos_propietario_nombre = $request->input('datos_propietario_nombre');
        $cuenta->datos_propietario_telefono = $request->input('datos_propietario_telefono');
        $cuenta->datos_propietario_correo = $request->input('datos_propietario_correo');
        $cuenta->update();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Cuenta",
            'descripcion' => "Actualizó una cuenta: ".$cuenta->razon_social
        ]);

        return redirect('show-cuenta/'.$id)->with('status',__('Cuenta actualizada correctamente.'));

    }

    public function destroy($id)
    {
        $cuenta = Cuenta::find($id);
        $cuenta->estado = 0; // Cambiar el estado a 0 en lugar de eliminar
        $cuenta->save();

        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Cuenta",
            'descripcion' => "Cancelo una cuenta: ".$cuenta->razon_social
        ]);

        return redirect('cuentas')->with('status',__('Cuenta cancelada correctamente.'));
    }

    public function activate($id)
    {
        // Buscar la cuenta por su ID
        $cuenta = Cuenta::find($id);

        // Verificar si la cuenta existe
        if (!$cuenta) {
            return redirect('cuentas')->with('error', __('Cuenta no encontrada.'));
        }

        // Cambiar el estado a 1 (activada)
        $cuenta->estado = 1;
        $cuenta->save();

        // Registrar en la bitácora
        Bitacora::create([
            'empresa_id' => Auth::user()->empresa_id,
            'usuario_id' => Auth::user()->id,
            'fecha' => now(),
            'tipo' => "Cuenta",
            'descripcion' => "Activó una cuenta: " . $cuenta->razon_social
        ]);

        return redirect('cuentas')->with('status', __('Cuenta activada correctamente.'));
    }

    public function pdf(Request $request)
    {
        if ($request)
        {
            // Limitar la cantidad de registros para evitar problemas de memoria
            $limite = $request->input('limite') ? $request->input('limite') : 500;

            // Seleccionar solo las columnas necesarias para reducir uso de memoria
            $cuentas = Cuenta::select(
                    'id',
                    'codigo',
                    'razon_social',
                    'nit',
                    'dpi',
                    'correo',
                    'telefono',
                    'otra_forma_contacto',
                    'datos_intermediario_nombre',
                    'datos_intermediario_telefono',
                    'datos_intermediario_correo',
                    'datos_propietario_nombre',
                    'datos_propietario_telefono',
                    'datos_propietario_correo'
                )
                ->where('empresa_id', Auth::user()->empresa_id)
                ->where('estado', 1) // Solo cuentas activas
                ->orderByRaw("CAST(SUBSTRING_INDEX(codigo, '-', -1) AS UNSIGNED), codigo")
                ->limit($limite)
                ->get();

            $nompdf = date('Y-m-d_H-i-s');
            $path = public_path('assets/uploads/');

            $config = Config::where('empresa_id', Auth::user()->empresa_id)->first();
            $currency = $config->currency_simbol;

            if ($config->logo == null) {
                $imagen = null;
            } else {
                $imagen = public_path('assets/uploads/logos/'.$config->logo);
            }

            // Determinar si descargar o mostrar en navegador
            $pdfarchivo = $request->input('pdfarchivo') ?? "stream";
            $pdftamaño = $request->input('pdftamaño') ?? "letter";
            $pdfhorientacion = $request->input('pdfhorientacion') ?? "portrait";

            // Preparar los datos para la vista
            $viewData = compact('cuentas', 'path', 'config', 'imagen', 'currency');

            // Crear el PDF con opciones optimizadas
            $pdf = PDF::loadView('empresa.cuenta.pdf', $viewData);

            // Configurar opciones para reducir uso de memoria
            $pdf->setOption('isRemoteEnabled', true);
            $pdf->setOption('isHtml5ParserEnabled', true);
            $pdf->setOption('dpi', 72);
            $pdf->setOption('defaultFont', 'sans-serif');

            // Configurar tamaño y orientación
            $pdf->setPaper($pdftamaño, $pdfhorientacion);

            // Devolver el PDF según el tipo solicitado
            if ($pdfarchivo == "download") {
                $filename = 'Cuentas_'.str_replace(['/', '\\', ':'], '_', $nompdf).'.pdf';
                return $pdf->download($filename);
            } else {
                return $pdf->stream('Cuentas_'.$nompdf.'.pdf');
            }
        }
    }

    public function exportexcel(Request $request)
    {
        return Excel::download(new CuentasExport, 'cuentas.xlsx');
    }
}
