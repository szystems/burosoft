<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pat;
use App\Models\Cuenta;
use App\Models\User;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ResumenExpedientesController extends Controller
{
    public function index(Request $request)
    {
        // Verificar usuario autenticado
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Filtros disponibles
        $filtroEstado = $request->input('estado', 'todos'); // activos, cerrados, archivo, todos
        $filtroFecha = $request->input('fecha_desde');
        $filtroFechaHasta = $request->input('fecha_hasta');
        $filtroCuenta = $request->input('cuenta_id');
        $filtroCuentaBusqueda = $request->input('cuenta_busqueda');
        $filtroUsuario = $request->input('usuario_id');
        $filtroNoExpediente = $request->input('no_expediente');

        // Query base para expedientes con relaciones
        $query = Pat::with(['cuenta', 'usuario', 'audiencias', 'audienciasPa'])
            ->whereHas('cuenta', function($subquery) {
                $subquery->where('empresa_id', Auth::user()->empresa_id);
            });

        // Aplicar filtros
        if ($filtroEstado !== 'todos') {
            $query->where('estado', $filtroEstado);
        }

        if ($filtroFecha) {
            $query->whereDate('created_at', '>=', $filtroFecha);
        }

        if ($filtroFechaHasta) {
            $query->whereDate('created_at', '<=', $filtroFechaHasta);
        }

        if ($filtroCuenta) {
            $query->where('cuenta_id', $filtroCuenta);
        }

        if ($filtroCuentaBusqueda) {
            $query->whereHas('cuenta', function($subquery) use ($filtroCuentaBusqueda) {
                $subquery->where('razon_social', 'like', '%' . $filtroCuentaBusqueda . '%')
                         ->orWhere('nit', 'like', '%' . $filtroCuentaBusqueda . '%');
            });
        }

        if ($filtroUsuario) {
            $query->where('usuario_id', $filtroUsuario);
        }

        if ($filtroNoExpediente) {
            $query->where('no_expediente', 'like', '%' . $filtroNoExpediente . '%');
        }

        // Obtener expedientes paginados
        $expedientes = $query->orderBy('created_at', 'desc')->paginate(20);

        // Estadísticas generales
        $estadisticas = $this->obtenerEstadisticas();

        // Datos para filtros
        $cuentas = Cuenta::where('empresa_id', Auth::user()->empresa_id)
            ->orderBy('razon_social')
            ->get();
        
        $usuarios = User::where('empresa_id', Auth::user()->empresa_id)
            ->orderBy('name')
            ->get();

        // Si hay un filtro de cuenta por ID y no hay búsqueda de texto, mostrar la cuenta seleccionada
        if ($filtroCuenta && !$filtroCuentaBusqueda) {
            $cuentaSeleccionada = $cuentas->where('id', $filtroCuenta)->first();
            if ($cuentaSeleccionada) {
                $filtroCuentaBusqueda = $cuentaSeleccionada->razon_social . ' (' . $cuentaSeleccionada->nit . ')';
            }
        }

        return view('empresa.juridico.resumen-expedientes.index', compact(
            'expedientes',
            'estadisticas', 
            'cuentas',
            'usuarios',
            'filtroEstado',
            'filtroFecha',
            'filtroFechaHasta',
            'filtroCuenta',
            'filtroCuentaBusqueda',
            'filtroUsuario',
            'filtroNoExpediente'
        ));
    }

    public function estadisticas(Request $request)
    {
        $estadisticas = $this->obtenerEstadisticas();
        $graficoData = $this->obtenerDatosGrafico($request);
        
        return view('empresa.juridico.resumen-expedientes.estadisticas', compact(
            'estadisticas',
            'graficoData'
        ));
    }

    private function obtenerEstadisticas()
    {
        $empresaId = Auth::user()->empresa_id;
        
        return [
            'total_expedientes' => Pat::whereHas('cuenta', function($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })->count(),
            
            'expedientes_activos' => Pat::whereHas('cuenta', function($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })->where('estado', 'Activo')->count(),
            
            'expedientes_cerrados' => Pat::whereHas('cuenta', function($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })->where('estado', 'Cerrado')->count(),
            
            'expedientes_archivo' => Pat::whereHas('cuenta', function($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })->where('estado', 'Archivo')->count(),
            
            'total_cuentas' => Cuenta::where('empresa_id', $empresaId)->count(),
            
            'expedientes_este_mes' => Pat::whereHas('cuenta', function($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })->whereMonth('created_at', Carbon::now()->month)
              ->whereYear('created_at', Carbon::now()->year)
              ->count(),
              
            'expedientes_por_resultado' => Pat::whereHas('cuenta', function($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })->select('resultado', DB::raw('count(*) as total'))
              ->groupBy('resultado')
              ->get()
              ->pluck('total', 'resultado')
              ->toArray()
        ];
    }

    private function obtenerDatosGrafico($request)
    {
        $tipoGrafico = $request->input('tipo_grafico', 'mensual');
        $empresaId = Auth::user()->empresa_id;
        
        if ($tipoGrafico === 'mensual') {
            // Últimos 12 meses
            $datos = Pat::whereHas('cuenta', function($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })->select(
                DB::raw('YEAR(created_at) as año'),
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )->where('created_at', '>=', Carbon::now()->subMonths(12))
             ->groupBy('año', 'mes')
             ->orderBy('año', 'asc')
             ->orderBy('mes', 'asc')
             ->get();
        } else {
            // Por estado
            $datos = Pat::whereHas('cuenta', function($q) use ($empresaId) {
                $q->where('empresa_id', $empresaId);
            })->select('estado', DB::raw('count(*) as total'))
              ->groupBy('estado')
              ->get();
        }
        
        return $datos;
    }

    public function exportarPdf(Request $request)
    {
        $filtroEstado = $request->input('estado', 'todos');
        $filtroFecha = $request->input('fecha_desde');
        $filtroFechaHasta = $request->input('fecha_hasta');
        $filtroCuenta = $request->input('cuenta_id');
        $filtroCuentaBusqueda = $request->input('cuenta_busqueda');
        $filtroNoExpediente = $request->input('no_expediente');
        
        // Query similar al index pero sin paginación
        $query = Pat::with(['cuenta', 'usuario', 'audiencias', 'audienciasPa'])
            ->whereHas('cuenta', function($q) {
                $q->where('empresa_id', Auth::user()->empresa_id);
            });

        if ($filtroEstado !== 'todos') {
            $query->where('estado', $filtroEstado);
        }

        if ($filtroFecha) {
            $query->whereDate('created_at', '>=', $filtroFecha);
        }

        if ($filtroFechaHasta) {
            $query->whereDate('created_at', '<=', $filtroFechaHasta);
        }

        if ($filtroCuenta) {
            $query->where('cuenta_id', $filtroCuenta);
        }

        if ($filtroCuentaBusqueda) {
            $query->whereHas('cuenta', function($subquery) use ($filtroCuentaBusqueda) {
                $subquery->where('razon_social', 'like', '%' . $filtroCuentaBusqueda . '%')
                         ->orWhere('nit', 'like', '%' . $filtroCuentaBusqueda . '%');
            });
        }

        if ($filtroNoExpediente) {
            $query->where('no_expediente', 'like', '%' . $filtroNoExpediente . '%');
        }

        $expedientes = $query->orderBy('created_at', 'desc')->get();
        $estadisticas = $this->obtenerEstadisticas();

        // Configurar PDF en orientación horizontal
        $pdf = PDF::loadView('empresa.juridico.resumen-expedientes.pdf', compact(
            'expedientes', 
            'estadisticas',
            'filtroEstado',
            'filtroFecha',
            'filtroFechaHasta',
            'filtroCuenta',
            'filtroCuentaBusqueda',
            'filtroNoExpediente'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('resumen-expedientes-' . date('Y-m-d') . '.pdf');
    }

    public function exportarExcel(Request $request)
    {
        // Implementar exportación a Excel si se requiere
        // return Excel::download(new ExpedientesExport($request), 'resumen-expedientes.xlsx');
    }
}