@extends('layouts.empresa')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-bar-chart"></i>
                </div>
                <div class="page-title">
                    <h5>Estadísticas de Expedientes</h5>
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

            <!-- Navegación -->
            <div class="row gx-3 mb-3">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('resumen-expedientes') }}">Resumen de Expedientes</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Estadísticas</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Tarjetas de estadísticas generales -->
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
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="icon-box md bg-light rounded-5">
                                    <i class="bi bi-people text-info"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="text-white mb-1">{{ number_format($estadisticas['total_cuentas']) }}</h2>
                                    <p class="text-white opacity-75 m-0">Clientes</p>
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
                                    <i class="bi bi-calendar-month text-warning"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="text-dark mb-1">{{ number_format($estadisticas['expedientes_este_mes']) }}</h2>
                                    <p class="text-dark opacity-75 m-0">Este Mes</p>
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
                                    <i class="bi bi-percent text-success"></i>
                                </div>
                                <div class="text-end">
                                    <h2 class="text-white mb-1">
                                        {{ $estadisticas['total_expedientes'] > 0 ? number_format(($estadisticas['expedientes_activos'] / $estadisticas['total_expedientes']) * 100, 1) : 0 }}%
                                    </h2>
                                    <p class="text-white opacity-75 m-0">Activos</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráficos por estado -->
            <div class="row gx-3 mb-4">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Expedientes por Estado</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="estadoChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Distribución por Estado</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <div class="text-center p-3 border rounded">
                                        <h3 class="text-success">{{ number_format($estadisticas['expedientes_activos']) }}</h3>
                                        <p class="text-muted m-0">Activos</p>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="text-center p-3 border rounded">
                                        <h3 class="text-danger">{{ number_format($estadisticas['expedientes_cerrados']) }}</h3>
                                        <p class="text-muted m-0">Cerrados</p>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="text-center p-3 border rounded">
                                        <h3 class="text-warning">{{ number_format($estadisticas['expedientes_archivo']) }}</h3>
                                        <p class="text-muted m-0">Archivo</p>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="text-center p-3 border rounded">
                                        <h3 class="text-primary">{{ number_format($estadisticas['total_expedientes']) }}</h3>
                                        <p class="text-muted m-0">Total</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico de resultados -->
            @if(!empty($estadisticas['expedientes_por_resultado']))
            <div class="row gx-3 mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Expedientes por Resultado</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Resultado</th>
                                            <th>Cantidad</th>
                                            <th>Porcentaje</th>
                                            <th>Gráfico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($estadisticas['expedientes_por_resultado'] as $resultado => $cantidad)
                                        <tr>
                                            <td>
                                                @if($resultado)
                                                    <span class="badge bg-info">{{ $resultado }}</span>
                                                @else
                                                    <span class="text-muted">Sin resultado</span>
                                                @endif
                                            </td>
                                            <td><strong>{{ number_format($cantidad) }}</strong></td>
                                            <td>
                                                {{ $estadisticas['total_expedientes'] > 0 ? number_format(($cantidad / $estadisticas['total_expedientes']) * 100, 1) : 0 }}%
                                            </td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: {{ $estadisticas['total_expedientes'] > 0 ? ($cantidad / $estadisticas['total_expedientes']) * 100 : 0 }}%">
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Botones de acción -->
            <div class="row gx-3">
                <div class="col-12 text-center">
                    <a href="{{ url('resumen-expedientes') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Volver al Resumen
                    </a>
                    <a href="{{ url('resumen-expedientes/exportar-pdf') }}" class="btn btn-danger" target="_blank">
                        <i class="bi bi-file-pdf"></i> Exportar PDF
                    </a>
                </div>
            </div>

        </div>
        <!-- Content wrapper end -->

    </div>
    <!-- Content wrapper scroll end -->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Esperar a que la página esté completamente cargada
    window.addEventListener('load', function() {
        // Verificar que el canvas existe
        const canvas = document.getElementById('estadoChart');
        if (!canvas) {
            console.error('Canvas no encontrado');
            return;
        }

        // Datos del gráfico
        const datos = [
            {{ $estadisticas['expedientes_activos'] }},
            {{ $estadisticas['expedientes_cerrados'] }},
            {{ $estadisticas['expedientes_archivo'] }}
        ];

        // Crear gráfico
        const ctx = canvas.getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Activos', 'Cerrados', 'Archivo'],
                datasets: [{
                    data: datos,
                    backgroundColor: [
                        '#28a745',
                        '#dc3545', 
                        '#ffc107'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
@endpush