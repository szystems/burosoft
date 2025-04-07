@extends('layouts.empresa')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-file-text"></i>
                </div>
                <div class="page-title">
                    <h5>RSI</h5>
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

            @include('empresa.rsi.search')

            <!-- Row start -->
            <div class="row gx-3">
                <div class="col-sm-12 col-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="card-title">
                                Listado de Cuentas RSI
                                <br>

                                <br>
                                <small class="text-secondary"><u>Filtros:</u></small>
                                <small class="text-muted">

                                    Encontrados: <small class="text-info">{{ $movimientos->count() }},</small>

                                    @if (request('cuenta_id'))
                                        @php
                                            $cuenta = \App\Models\Cuenta::find( request('cuenta_id') );
                                        @endphp
                                        Cuenta:  <small class="text-info">{{ $cuenta->razon_social }},</small>
                                    @endif

                                    @if (request('saldo'))
                                        Saldo:  <small class="text-info">{{ $request->saldo }},</small>
                                    @endif
                                </small>
                            </div>

                        </div>
                        @include('empresa.rsi.print')

                        <div class="card-body">
                            <!-- Sistema de pestañas para separar la lista de las estadísticas -->
                            <ul class="nav nav-tabs mb-3" id="rsiTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="lista-tab" data-bs-toggle="tab" data-bs-target="#lista"
                                        type="button" role="tab" aria-controls="lista" aria-selected="true">
                                        <i class="bi bi-list-ul"></i> Listado de Cuentas
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="estadisticas-tab" data-bs-toggle="tab" data-bs-target="#estadisticas"
                                        type="button" role="tab" aria-controls="estadisticas" aria-selected="false">
                                        <i class="bi bi-bar-chart-line"></i> Estadísticas y Resumen
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="graficos-tab" data-bs-toggle="tab" data-bs-target="#graficos"
                                        type="button" role="tab" aria-controls="graficos" aria-selected="false">
                                        <i class="bi bi-pie-chart-fill"></i> Gráficos
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content" id="rsiTabContent">
                                <!-- Primera pestaña: Listado de cuentas -->
                                <div class="tab-pane fade show active" id="lista" role="tabpanel" aria-labelledby="lista-tab">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-striped flex-column">
                                            <thead>
                                                <tr>
                                                    <td align="center">Cuenta</td>
                                                    <td align="center">Cargo</td>
                                                    <td align="center">Estado Saldo</td>
                                                    <td align="center">Pagado/Saldo</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $tmonto = 0;
                                                    $tpagado = 0;
                                                    $tsaldo = 0;

                                                    // Arrays para estadísticas
                                                    $cuentas_data = [];
                                                    $estado_pagos = ['Pagado' => 0, 'Pendiente' => 0];
                                                @endphp
                                                @foreach ($movimientos as $movimiento)
                                                    <tr>
                                                        <td align="center">
                                                            <a href="{{ url('show-cuenta/'.$movimiento->cuenta_id) }}">
                                                                <strong class="text-blue">{{ $movimiento->codigo }} {{ $movimiento->cuenta }}</strong>
                                                            </a>
                                                        </td>

                                                        <td align="center">
                                                            <p><strong>Q.{{ number_format($movimiento->total_monto_q,2, '.', ',') }}</strong></p>
                                                        </td>

                                                        <td align="center">
                                                            <p>
                                                                @if($movimiento->total_monto_q > $movimiento->total_pagado)
                                                                    <span class="badge shade-light-yellow">Pendiente</span>
                                                                    @php $estado_pagos['Pendiente']++; @endphp
                                                                @elseif ($movimiento->total_monto_q <= $movimiento->total_pagado)
                                                                    <span class="badge shade-light-green">Pagado</span>
                                                                    @php $estado_pagos['Pagado']++; @endphp
                                                                @endif
                                                            </p>
                                                        </td>
                                                        <td align="center">
                                                            <p>
                                                                <font class="text-success">Q.{{ number_format($movimiento->total_pagado,2, '.', ',') }}</font>/

                                                                @if ($movimiento->saldo == 0 and ($movimiento->total_pagado !=  $movimiento->total_monto_q))
                                                                    <font class="text-warning">Q.{{ number_format($movimiento->total_monto_q,2, '.', ',') }}</font>
                                                                @else
                                                                    <font class="text-warning">Q.{{ number_format($movimiento->saldo,2, '.', ',') }}</font></p>
                                                                @endif

                                                        </td>
                                                    </tr>
                                                    @php
                                                        $tmonto += $movimiento->total_monto_q;
                                                        $tpagado += $movimiento->total_pagado;

                                                        if ($movimiento->saldo == 0 and ($movimiento->total_pagado !=  $movimiento->total_monto_q)) {
                                                            $tsaldo += $movimiento->total_monto_q;
                                                        } else {
                                                            $tsaldo += $movimiento->saldo;
                                                        }

                                                        // Datos para estadísticas
                                                        $cuentaNombre = $movimiento->cuenta;
                                                        $cuentas_data[$cuentaNombre] = [
                                                            'monto' => $movimiento->total_monto_q,
                                                            'pagado' => $movimiento->total_pagado,
                                                            'saldo' => ($movimiento->saldo == 0 && $movimiento->total_pagado != $movimiento->total_monto_q)
                                                                      ? $movimiento->total_monto_q
                                                                      : $movimiento->saldo,
                                                            'codigo' => $movimiento->codigo
                                                        ];
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td align="right"><p><strong>Total Cargos:</strong></p></td>
                                                    <td align="center"><p><strong class="text-blue">Q.{{ number_format($tmonto,2, '.', ',') }}</strong></p></td>
                                                    <td align="right"><p><strong>Pagado/Saldo:</strong></p></td>
                                                    <td align="center"><p><strong class="text-success">Q.{{ number_format($tpagado,2, '.', ',') }}</strong>/<strong class="text-warning">Q.{{ number_format($tsaldo,2, '.', ',') }}</strong></p></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <!-- Segunda pestaña: Estadísticas y resumen -->
                                <div class="tab-pane fade" id="estadisticas" role="tabpanel" aria-labelledby="estadisticas-tab">
                                    <!-- Botón de exportación a PDF -->
                                    <div class="text-end mb-3">
                                        <a href="{{ url('pdf-rsi-estadisticas?' . http_build_query(request()->all())) }}" target="_blank" class="btn btn-danger">
                                            <i class="bi bi-file-pdf"></i> Exportar Estadísticas a PDF
                                        </a>
                                    </div>

                                    <!-- Tarjetas de resumen -->
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h5 class="card-title">Total Cuentas</h5>
                                                    <h2 class="mb-0 text-primary">{{ count($movimientos) }}</h2>
                                                    <div class="text-muted small">Filtradas por la consulta actual</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h5 class="card-title">Total Monto</h5>
                                                    <h2 class="mb-0 text-blue">Q.{{ number_format($tmonto,2, '.', ',') }}</h2>
                                                    <div class="text-muted small">Quetzales</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h5 class="card-title">Pagado</h5>
                                                    <h2 class="mb-0 text-success">Q.{{ number_format($tpagado,2, '.', ',') }}</h2>
                                                    <div class="text-muted small">({{ $tmonto > 0 ? number_format(($tpagado/$tmonto)*100, 1) : 0 }}% del total)</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h5 class="card-title">Pendiente</h5>
                                                    <h2 class="mb-0 text-warning">Q.{{ number_format($tsaldo,2, '.', ',') }}</h2>
                                                    <div class="text-muted small">({{ $tmonto > 0 ? number_format(($tsaldo/$tmonto)*100, 1) : 0 }}% del total)</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gráfico de estado de pagos -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title">Distribución por Estado de Pago</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="progress" style="height: 30px; width: 100%;">
                                                            @php
                                                                $porcentaje_pagado = $tmonto > 0 ? ($tpagado/$tmonto)*100 : 0;
                                                                $porcentaje_pendiente = $tmonto > 0 ? ($tsaldo/$tmonto)*100 : 0;
                                                            @endphp
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: {{ $porcentaje_pagado }}%"
                                                                aria-valuenow="{{ $porcentaje_pagado }}"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                Pagado: Q.{{ number_format($tpagado,2, '.', ',') }}
                                                            </div>
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: {{ $porcentaje_pendiente }}%"
                                                                aria-valuenow="{{ $porcentaje_pendiente }}"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                Pendiente: Q.{{ number_format($tsaldo,2, '.', ',') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-3">
                                                        <span class="badge shade-light-green">Pagado: {{ $estado_pagos['Pagado'] }} cuentas</span>
                                                        <span class="badge shade-light-yellow">Pendiente: {{ $estado_pagos['Pendiente'] }} cuentas</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title">Porcentaje de Avance de Pagos</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-center" style="height: 100px;">
                                                        <div class="text-center">
                                                            <h1 class="mb-0">{{ $tmonto > 0 ? number_format(($tpagado/$tmonto)*100, 1) : 0 }}%</h1>
                                                            <p class="text-muted">del total ha sido pagado</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabla de cuentas -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title">Detalle por Cuentas</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Código</th>
                                                                    <th>Cuenta</th>
                                                                    <th>Total</th>
                                                                    <th>Pagado</th>
                                                                    <th>Pendiente</th>
                                                                    <th>% Pagado</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($cuentas_data as $cuenta => $data)
                                                                    @php
                                                                        $porcentaje = $data['monto'] > 0 ? ($data['pagado']/$data['monto'])*100 : 0;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $data['codigo'] }}</td>
                                                                        <td>{{ $cuenta }}</td>
                                                                        <td>Q.{{ number_format($data['monto'],2, '.', ',') }}</td>
                                                                        <td class="text-success">Q.{{ number_format($data['pagado'],2, '.', ',') }}</td>
                                                                        <td class="text-warning">Q.{{ number_format($data['saldo'],2, '.', ',') }}</td>
                                                                        <td>
                                                                            <div class="progress" style="height: 15px;">
                                                                                <div class="progress-bar bg-info" role="progressbar"
                                                                                    style="width: {{ $porcentaje }}%"
                                                                                    aria-valuenow="{{ $porcentaje }}"
                                                                                    aria-valuemin="0" aria-valuemax="100">
                                                                                    {{ number_format($porcentaje, 1) }}%
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
                                </div>

                                <!-- Tercera pestaña: Gráficos -->
                                <div class="tab-pane fade" id="graficos" role="tabpanel" aria-labelledby="graficos-tab">
                                    <!-- Incluir Chart.js -->
                                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                                    <!-- Incluir librerías para exportar a PDF -->
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

                                    <!-- Botón de exportación a PDF -->
                                    <div class="text-end mb-3">
                                        <button id="exportGraficosPDF" class="btn btn-danger">
                                            <i class="bi bi-file-pdf"></i> Exportar Gráficos a PDF
                                        </button>
                                    </div>

                                    <!-- Contenedor de gráficos para exportación -->
                                    <div id="graficos-container">
                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title">Distribución por Estado de Pago</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div style="height: 300px;">
                                                            <canvas id="estadoPagosChart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title">Distribución de Montos</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div style="height: 300px;">
                                                            <canvas id="montosDistribucionChart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title">Top 5 Cuentas por Monto</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div style="height: 300px;">
                                                            <canvas id="cuentasBarChart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        // Datos para el gráfico de estado de pagos
                                        $estadoPagosLabels = ['Pagado', 'Pendiente'];
                                        $estadoPagosData = [$tpagado, $tsaldo];
                                        $estadoPagosColors = ['#1cc88a', '#f6c23e'];

                                        // Datos para el gráfico de distribución de montos
                                        $montosTotalesLabels = ['Pagado', 'Por pagar'];
                                        $montosTotalesData = [$tpagado, $tsaldo];
                                        $montosTotalesColors = ['#1cc88a', '#f6c23e'];

                                        // Datos para el gráfico de cuentas top
                                        $cuentasLabels = [];
                                        $cuentasMontosData = [];
                                        $cuentasPagadoData = [];
                                        $cuentasPendienteData = [];

                                        // Ordenar por monto y tomar los primeros 5
                                        $cuentas_data_array = [];
                                        foreach ($cuentas_data as $cuenta => $data) {
                                            $cuentas_data_array[] = ['cuenta' => $cuenta, 'data' => $data];
                                        }

                                        // Ordenar el array por monto de mayor a menor
                                        usort($cuentas_data_array, function($a, $b) {
                                            return $b['data']['monto'] - $a['data']['monto'];
                                        });

                                        // Tomar los primeros 5
                                        $top_cuentas = array_slice($cuentas_data_array, 0, 5);
                                        foreach ($top_cuentas as $item) {
                                            $cuenta = $item['cuenta'];
                                            $data = $item['data'];

                                            // Límite de longitud para nombres de cuenta
                                            $cuenta_display = strlen($cuenta) > 15 ? substr($cuenta, 0, 15) . '...' : $cuenta;

                                            $cuentasLabels[] = $cuenta_display;
                                            $cuentasMontosData[] = $data['monto'];
                                            $cuentasPagadoData[] = $data['pagado'];
                                            $cuentasPendienteData[] = $data['saldo'];
                                        }
                                    @endphp

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Configuración de colores
                                            Chart.defaults.color = '#858796';

                                            // Gráfico de Estado de Pagos (Doughnut)
                                            var estadoPagosCtx = document.getElementById('estadoPagosChart').getContext('2d');
                                            var estadoPagosChart = new Chart(estadoPagosCtx, {
                                                type: 'doughnut',
                                                data: {
                                                    labels: @json($estadoPagosLabels),
                                                    datasets: [{
                                                        data: @json($estadoPagosData),
                                                        backgroundColor: @json($estadoPagosColors),
                                                        hoverOffset: 4
                                                    }]
                                                },
                                                options: {
                                                    maintainAspectRatio: false,
                                                    cutout: '60%',
                                                    plugins: {
                                                        legend: {
                                                            position: 'bottom',
                                                        },
                                                        tooltip: {
                                                            callbacks: {
                                                                label: function(context) {
                                                                    const value = context.raw;
                                                                    const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                                                    const percentage = ((value / total) * 100).toFixed(1);
                                                                    return `Q${value.toLocaleString()} (${percentage}%)`;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            });

                                            // Gráfico de Distribución de Montos (Pie)
                                            var montosDistribucionCtx = document.getElementById('montosDistribucionChart').getContext('2d');
                                            var montosDistribucionChart = new Chart(montosDistribucionCtx, {
                                                type: 'pie',
                                                data: {
                                                    labels: @json($montosTotalesLabels),
                                                    datasets: [{
                                                        data: @json($montosTotalesData),
                                                        backgroundColor: @json($montosTotalesColors),
                                                        hoverOffset: 4
                                                    }]
                                                },
                                                options: {
                                                    maintainAspectRatio: false,
                                                    plugins: {
                                                        legend: {
                                                            position: 'bottom',
                                                        },
                                                        tooltip: {
                                                            callbacks: {
                                                                label: function(context) {
                                                                    const value = context.raw;
                                                                    const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                                                                    const percentage = ((value / total) * 100).toFixed(1);
                                                                    return `Q${value.toLocaleString()} (${percentage}%)`;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            });

                                            // Gráfico de Cuentas (Bar)
                                            var cuentasCtx = document.getElementById('cuentasBarChart').getContext('2d');
                                            var cuentasBarChart = new Chart(cuentasCtx, {
                                                type: 'bar',
                                                data: {
                                                    labels: @json($cuentasLabels),
                                                    datasets: [
                                                        {
                                                            label: 'Monto Total',
                                                            data: @json($cuentasMontosData),
                                                            backgroundColor: 'rgba(78, 115, 223, 0.8)',
                                                            borderWidth: 1
                                                        },
                                                        {
                                                            label: 'Pagado',
                                                            data: @json($cuentasPagadoData),
                                                            backgroundColor: 'rgba(28, 200, 138, 0.8)',
                                                            borderWidth: 1
                                                        },
                                                        {
                                                            label: 'Pendiente',
                                                            data: @json($cuentasPendienteData),
                                                            backgroundColor: 'rgba(246, 194, 62, 0.8)',
                                                            borderWidth: 1
                                                        }
                                                    ]
                                                },
                                                options: {
                                                    maintainAspectRatio: false,
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true,
                                                            ticks: {
                                                                callback: function(value) {
                                                                    return 'Q' + value.toLocaleString();
                                                                }
                                                            }
                                                        }
                                                    },
                                                    plugins: {
                                                        tooltip: {
                                                            callbacks: {
                                                                label: function(context) {
                                                                    return context.dataset.label + ': Q' + context.raw.toLocaleString();
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            });

                                            // Exportación de gráficos a PDF
                                            document.getElementById('exportGraficosPDF').addEventListener('click', function() {
                                                // Definir el PDF con jsPDF
                                                window.jspdf = window.jspdf || {};
                                                window.jspdf.jsPDF = window.jspdf.jsPDF || window.jsPDF;

                                                const { jsPDF } = window.jspdf;
                                                // Formato carta, orientación vertical
                                                const doc = new jsPDF('p', 'mm', 'letter');

                                                // Variables para posicionamiento
                                                let yPos = 15;
                                                const pageWidth = doc.internal.pageSize.getWidth();
                                                const margin = 15;
                                                const columnWidth = pageWidth - (margin * 2);

                                                // Agregar encabezado con logo si está disponible
                                                @if(isset($config) && $config->logo)
                                                    const logoData = "{{ asset('assets/uploads/logos/'.$config->logo) }}";
                                                    doc.addImage(logoData, 'PNG', (pageWidth / 2) - 15, yPos, 30, 15);
                                                    yPos += 20;
                                                @endif

                                                // Título y fecha del reporte
                                                doc.setFontSize(16);
                                                doc.setFont('helvetica', 'bold');
                                                doc.text('Informe Gráfico de RSI', pageWidth / 2, yPos, { align: 'center' });
                                                yPos += 8;

                                                doc.setFontSize(12);
                                                doc.setFont('helvetica', 'normal');
                                                doc.text('Empresa: {{ Auth::user()->empresa->nombre ?? "Empresa" }}', pageWidth / 2, yPos, { align: 'center' });
                                                yPos += 6;

                                                const fecha = new Date().toLocaleDateString('es-ES');
                                                doc.text(`Fecha de generación: ${fecha}`, pageWidth / 2, yPos, { align: 'center' });
                                                yPos += 6;

                                                // Información de filtros aplicados
                                                doc.setFontSize(10);
                                                doc.setFont('helvetica', 'bold');
                                                doc.text('Filtros aplicados:', margin, yPos);
                                                yPos += 5;

                                                doc.setFont('helvetica', 'normal');

                                                @if(request('cuenta_id'))
                                                    doc.text('Cuenta: {{ \App\Models\Cuenta::find(request("cuenta_id"))->razon_social ?? "N/A" }}', margin, yPos);
                                                    yPos += 5;
                                                @endif

                                                @if(request('saldo'))
                                                    doc.text('Saldo: {{ request("saldo") }}', margin, yPos);
                                                    yPos += 5;
                                                @endif

                                                // Agregar resumen de datos
                                                yPos += 5;
                                                doc.setFontSize(12);
                                                doc.setFont('helvetica', 'bold');
                                                doc.text('Resumen de Datos:', margin, yPos);
                                                yPos += 8;

                                                doc.setFontSize(10);
                                                doc.setFont('helvetica', 'normal');
                                                doc.text(`Total Cuentas: {{ count($movimientos) }}`, margin, yPos);
                                                yPos += 5;
                                                doc.text(`Monto Total: Q.{{ number_format($tmonto,2, '.', ',') }}`, margin, yPos);
                                                yPos += 5;
                                                doc.text(`Pagado: Q.{{ number_format($tpagado,2, '.', ',') }} ({{ $tmonto > 0 ? number_format(($tpagado/$tmonto)*100, 1) : 0 }}%)`, margin, yPos);
                                                yPos += 5;
                                                doc.text(`Pendiente: Q.{{ number_format($tsaldo,2, '.', ',') }} ({{ $tmonto > 0 ? number_format(($tsaldo/$tmonto)*100, 1) : 0 }}%)`, margin, yPos);
                                                yPos += 10;

                                                // Función para procesar cada gráfico
                                                const graficos = document.querySelectorAll('#graficos-container canvas');

                                                const captureNext = (index) => {
                                                    if (index >= graficos.length) {
                                                        // Todos los gráficos han sido procesados, guardar PDF
                                                        doc.save('RSI_Graficos.pdf');
                                                        return;
                                                    }

                                                    const grafico = graficos[index];
                                                    const titulo = grafico.closest('.card').querySelector('.card-title').textContent;

                                                    // Agregar título de sección
                                                    if (yPos > 230) {
                                                        doc.addPage();
                                                        yPos = 20;
                                                    }

                                                    doc.setFontSize(12);
                                                    doc.setFont('helvetica', 'bold');
                                                    doc.text(titulo, margin, yPos);
                                                    yPos += 8;

                                                    // Capturar el gráfico como imagen
                                                    html2canvas(grafico).then(canvas => {
                                                        // Convertir canvas a imagen
                                                        const imgData = canvas.toDataURL('image/png');

                                                        // Ajustar ancho de la imagen al ancho entre márgenes
                                                        const imgWidth = columnWidth;
                                                        const imgHeight = canvas.height * imgWidth / canvas.width;

                                                        // Si la imagen no cabe en la página actual, añadir nueva página
                                                        if (yPos + imgHeight > 260) {
                                                            doc.addPage();
                                                            yPos = 20;
                                                        }

                                                        // Agregar imagen al PDF
                                                        doc.addImage(imgData, 'PNG', margin, yPos, imgWidth, imgHeight);

                                                        // Actualizar posición vertical para el siguiente gráfico
                                                        yPos += imgHeight + 15;

                                                        // Procesar el siguiente gráfico
                                                        captureNext(index + 1);
                                                    });
                                                };

                                                // Iniciar el proceso de captura
                                                captureNext(0);
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row end -->

        </div>
        <!-- Content wrapper end -->

    </div>
    <!-- Content wrapper scroll end -->

    <!-- Script para garantizar el funcionamiento de las pestañas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('#rsiTab button');
            tabs.forEach(tab => {
                tab.addEventListener('click', function(event) {
                    event.preventDefault();
                    const target = this.getAttribute('data-bs-target');

                    // Desactivar todas las pestañas
                    tabs.forEach(t => {
                        t.classList.remove('active');
                        t.setAttribute('aria-selected', 'false');
                    });

                    // Activar la pestaña actual
                    this.classList.add('active');
                    this.setAttribute('aria-selected', 'true');

                    // Mostrar el contenido correspondiente
                    document.querySelectorAll('.tab-pane').forEach(pane => {
                        pane.classList.remove('show', 'active');
                    });
                    document.querySelector(target).classList.add('show', 'active');
                });
            });
        });
    </script>
@endsection
