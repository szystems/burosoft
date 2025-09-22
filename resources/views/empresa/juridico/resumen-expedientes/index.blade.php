@extends('layouts.empresa')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-file-bar-graph"></i>
                </div>
                <div class="page-title">
                    <h5>Resumen de Expedientes</h5>
                </div>
            </div>
            <!-- Date range start -->
            <div class="d-flex align-items-end d-none d-sm-block">
                <h6 class="float-end text-light" id="reloj"></h6>
            </div>
        </div>
        <!-- Main header ends -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">

            @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Tarjetas de estadísticas -->
            <div class="row gx-3 mb-4">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="icon-box md bg-light rounded-5">
                                    <i class="bi bi-folder text-primary"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="text-white mb-1">{{ number_format($estadisticas['total_expedientes']) }}</h2>
                                    <p class="text-white opacity-75 m-0">Total Expedientes</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="icon-box md bg-light rounded-5">
                                    <i class="bi bi-check-circle text-success"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="text-white mb-1">{{ number_format($estadisticas['expedientes_activos']) }}</h2>
                                    <p class="text-white opacity-75 m-0">Activos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="icon-box md bg-light rounded-5">
                                    <i class="bi bi-x-circle text-danger"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="text-white mb-1">{{ number_format($estadisticas['expedientes_cerrados']) }}</h2>
                                    <p class="text-white opacity-75 m-0">Cerrados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="icon-box md bg-light rounded-5">
                                    <i class="bi bi-archive text-warning"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="text-dark mb-1">{{ number_format($estadisticas['expedientes_archivo']) }}</h2>
                                    <p class="text-dark opacity-75 m-0">Archivo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="row gx-3 mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Filtros de Búsqueda</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ url('resumen-expedientes') }}">
                                <div class="row gx-3">
                                    <div class="col-md-2 mb-3">
                                        <label for="estado" class="form-label">Estado</label>
                                        <select name="estado" id="estado" class="form-select">
                                            <option value="todos" {{ $filtroEstado == 'todos' ? 'selected' : '' }}>Todos</option>
                                            <option value="Activo" {{ $filtroEstado == 'Activo' ? 'selected' : '' }}>Activos</option>
                                            <option value="Cerrado" {{ $filtroEstado == 'Cerrado' ? 'selected' : '' }}>Cerrados</option>
                                            <option value="Archivo" {{ $filtroEstado == 'Archivo' ? 'selected' : '' }}>Archivo</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="fecha_desde" class="form-label">Fecha Desde</label>
                                        <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" value="{{ $filtroFecha }}">
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                                        <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" value="{{ $filtroFechaHasta }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="cuenta_busqueda" class="form-label">Cuenta</label>
                                        <input type="text" 
                                               name="cuenta_busqueda" 
                                               id="cuenta_busqueda" 
                                               class="form-control" 
                                               placeholder="Buscar cuenta por nombre o NIT..."
                                               value="{{ $filtroCuentaBusqueda ?? '' }}"
                                               list="cuentas_list">
                                        <datalist id="cuentas_list">
                                            @foreach($cuentas as $cuenta)
                                                <option value="{{ $cuenta->razon_social }} ({{ $cuenta->nit }})" data-id="{{ $cuenta->id }}">
                                                    {{ $cuenta->razon_social }} - {{ $cuenta->nit }}
                                                </option>
                                            @endforeach
                                        </datalist>
                                        <input type="hidden" name="cuenta_id" id="cuenta_id_hidden" value="{{ $filtroCuenta }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="no_expediente" class="form-label">No. Expediente</label>
                                        <input type="text" name="no_expediente" id="no_expediente" class="form-control" 
                                               placeholder="Buscar por número de expediente..." value="{{ $filtroNoExpediente ?? '' }}">
                                    </div>
                                </div>
                                <div class="row gx-3">
                                    <div class="col-md-6 mb-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-search"></i> Filtrar
                                        </button>
                                        <a href="{{ url('resumen-expedientes') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-clockwise"></i> Limpiar
                                        </a>
                                    </div>
                                    <div class="col-md-6 mb-3 text-end">
                                        <a href="{{ url('resumen-expedientes/estadisticas') }}" class="btn btn-info">
                                            <i class="bi bi-bar-chart"></i> Estadísticas
                                        </a>
                                        <a href="{{ url('resumen-expedientes/exportar-pdf') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}" 
                                           class="btn btn-danger" target="_blank">
                                            <i class="bi bi-file-pdf"></i> PDF
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de resultados -->
            <div class="row gx-3">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Expedientes 
                                @if($filtroEstado !== 'todos')
                                    - {{ ucfirst($filtroEstado) }}s
                                @endif
                                ({{ $expedientes->total() }} registros)
                            </h5>
                        </div>
                        <div class="card-body">
                            @if($expedientes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table align-middle table-striped">
                                        <thead>
                                            <tr>
                                                <th><i class="bi bi-list-task"></i></th>
                                                <th>No. Expediente</th>
                                                <th>Cliente</th>
                                                <th>No. Programa</th>
                                                <th>Gerencia</th>
                                                <th>Estado</th>
                                                <th>Resultado</th>
                                                <th>Usuario</th>
                                                <th>Fecha</th>
                                                <th>Audiencias</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($expedientes as $expediente)
                                                <tr>
                                                    <td align="center">
                                                        <a class="btn btn-sm btn-info" href="{{ url('show-pat/' . $expediente->id) }}" target="_blank">
                                                            <i class="bi bi-eye text-white"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <strong>{{ $expediente->no_expediente }}</strong>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <strong>{{ $expediente->cuenta->razon_social }}</strong>
                                                            <br>
                                                            <small class="text-muted">{{ $expediente->cuenta->codigo }}</small>
                                                        </div>
                                                    </td>
                                                    <td>{{ $expediente->no_programa }}</td>
                                                    <td>{{ $expediente->gerencia }}</td>
                                                    <td>
                                                        @if($expediente->estado == 'Activo')
                                                            <span class="badge bg-success">{{ $expediente->estado }}</span>
                                                        @elseif($expediente->estado == 'Cerrado')
                                                            <span class="badge bg-danger">{{ $expediente->estado }}</span>
                                                        @elseif($expediente->estado == 'Archivo')
                                                            <span class="badge bg-warning">{{ $expediente->estado }}</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ $expediente->estado }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($expediente->resultado)
                                                            <span class="badge bg-info">{{ $expediente->resultado }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $expediente->usuario->name ?? 'N/A' }}</td>
                                                    <td>
                                                        <small>{{ $expediente->created_at->format('d/m/Y') }}</small>
                                                    </td>
                                                    <td align="center">
                                                        <div>
                                                            @if($expediente->audiencias->count() > 0)
                                                                <span class="badge bg-primary">VA: {{ $expediente->audiencias->count() }}</span>
                                                            @endif
                                                            @if($expediente->audienciasPa->count() > 0)
                                                                <span class="badge bg-success">PA: {{ $expediente->audienciasPa->count() }}</span>
                                                            @endif
                                                            @if($expediente->audiencias->count() == 0 && $expediente->audienciasPa->count() == 0)
                                                                <span class="text-muted">0</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ url('show-pat/' . $expediente->id) }}" class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            @if($expediente->audiencias->count() > 0)
                                                                <a href="{{ url('show-va/' . $expediente->id) }}" class="btn btn-sm btn-outline-info">
                                                                    VA
                                                                </a>
                                                            @endif
                                                            @if($expediente->audienciasPa->count() > 0)
                                                                <a href="{{ url('show-pa/' . $expediente->id) }}" class="btn btn-sm btn-outline-success">
                                                                    PA
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Paginación -->
                                <div class="d-flex justify-content-center">
                                    {{ $expedientes->withQueryString()->links() }}
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-folder2-open display-1 text-muted"></i>
                                    <h4 class="text-muted">No se encontraron expedientes</h4>
                                    <p class="text-muted">Intenta ajustar los filtros de búsqueda</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Content wrapper end -->

    </div>
    <!-- Content wrapper scroll end -->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Auto-envío cuando cambia el estado
        $('#estado').on('change', function() {
            $(this).closest('form').submit();
        });

        // Funcionalidad para la búsqueda de cuenta con datalist
        $('#cuenta_busqueda').on('input', function() {
            var value = $(this).val();
            var datalistOptions = $('#cuentas_list option');
            var hiddenInput = $('#cuenta_id_hidden');
            
            // Buscar si el valor coincide con alguna opción del datalist
            var matchedOption = datalistOptions.filter(function() {
                return $(this).val() === value;
            });
            
            if (matchedOption.length > 0) {
                // Si encuentra coincidencia exacta, establecer el ID
                hiddenInput.val(matchedOption.data('id'));
            } else {
                // Si no hay coincidencia exacta, limpiar el ID
                hiddenInput.val('');
            }
        });

        // Auto-envío cuando se selecciona una cuenta (con un pequeño delay)
        $('#cuenta_busqueda').on('change', function() {
            setTimeout(function() {
                $('#cuenta_busqueda').closest('form').submit();
            }, 100);
        });
    });
</script>
@endpush