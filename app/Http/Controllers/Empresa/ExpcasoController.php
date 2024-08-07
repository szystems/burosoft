<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cuenta;
use App\Models\Config;
use App\Models\User;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PDF;
use DB;
use Maatwebsite\Excel\Facades\Excel;

class ExpcasoController extends Controller
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
                ->orWhere('nit', 'LIKE', '%' . $queryCuenta . '%');
            })
            ->orderBy('razon_social','asc')
            ->paginate(20);

            $filterCuentas = Cuenta::where('empresa_id', Auth::user()->empresa_id)->get();
            return view('empresa.expcaso.index', compact('cuentas','queryCuenta','filterCuentas'));
        }
    }

    public function show($id)
    {
        $cuenta = Cuenta::find($id);
        $config = Config::where('empresa_id', $cuenta->id)->first();
        return view('empresa.expcaso.show', compact('cuenta','config'));
    }
}
