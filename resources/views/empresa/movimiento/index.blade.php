@extends('layouts.empresa')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="page-title">
                    <h5>Movimientos</h5>
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

            @include('empresa.movimiento.search')

            <!-- Row start -->
            <div class="row gx-3">
                <div class="col-sm-12 col-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="card-title">
                                Listado de Movimientos
                                <br>
                                {{-- <a target="_blank" href="{{ url('pdf-movimientos') }}" type="button" class="btn btn-danger btn-sm">
                                    <i class="bi bi-file-pdf-fill"></i> PDF
                                </a>
                                <a arget="_blank" href="{{ url('exportmovimientos') }}" type="button" class="btn btn-success btn-sm">
                                    <i class="bi bi-file-earmark-excel-fill"></i> Excel
                                </a> --}}

                                <a href="{{ url('add-movimiento') }}" type="button" class="btn btn-success float-end">
                                    <i class="bi bi-plus-square"></i> Agregar Movimiento
                                </a>
                                <br>
                                <small class="text-secondary"><u>Filtros:</u></small>
                                <small class="text-muted">

                                    Encontrados: <small class="text-info">{{ count($movimientos ?? []) }},</small>
                                    @if ($fechaDesdeVista)
                                        Desde: <small class="text-info">{{ $fechaDesdeVista }},</small>
                                    @endif
                                    @if ($fechaHastaVista)
                                        Hasta: <small class="text-info"">{{ $fechaHastaVista }},</small>
                                    @endif
                                    @if (request('cuenta_id'))
                                        @php
                                            $cuenta = \App\Models\Cuenta::find( request('cuenta_id') );
                                        @endphp
                                        Cuenta:  <small class="text-info">{{ $cuenta->razon_social }},</small>
                                    @endif
                                    @if (request('rubro_id'))
                                        @php
                                            $rubro = \App\Models\Rubro::find( request('rubro_id') );
                                        @endphp
                                        Rubro:  <small class="text-info">{{ $rubro->nombre }},</small>
                                    @endif
                                    @if (request('saldo'))
                                        Saldo:  <small class="text-info">{{ $request->saldo }},</small>
                                    @endif
                                    @if (request('usuario_id'))
                                        @php
                                            $usuario = \App\Models\User::find( request('usuario_id') );
                                        @endphp
                                        Usuario:  <small class="text-info">{{ $usuario->name }},</small>
                                    @endif
                                </small>
                            </div>

                        </div>
                        @include('empresa.movimiento.print')
                        @include('empresa.movimiento.search2')

                        <div class="card-body">
                            <!-- Sistema de pestañas para separar la lista de las estadísticas -->
                            <ul class="nav nav-tabs mb-3" id="movimientosTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="lista-tab" data-bs-toggle="tab" data-bs-target="#lista"
                                        type="button" role="tab" aria-controls="lista" aria-selected="true">
                                        <i class="bi bi-list-ul"></i> Listado de Movimientos
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

                            <div class="tab-content" id="movimientosTabContent">
                                <!-- Primera pestaña: Listado de movimientos -->
                                <div class="tab-pane fade show active" id="lista" role="tabpanel" aria-labelledby="lista-tab">
                                    <div class="table-responsive">
                                        <table class="table align-middle table-striped flex-column">
                                            <thead>
                                                <tr>
                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                    <td align="center">Código</td>
                                                    <td align="center">Fecha</td>
                                                    <td align="center">Cuenta</td>
                                                    <td align="center">Rubro</td>
                                                    <td align="center">Cargo Q/$</td>
                                                    <td align="center">Pagado/Saldo/Estado</td>
                                                    <td align="center">Usuario</td>
                                                    <td align="center">Datos Pagos</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $monto_total_q = 0;
                                                    $monto_total_d = 0;
                                                    $monto_total_q_eliminado = 0;
                                                    $monto_total_d_eliminado = 0;
                                                    $pagado_total = 0;
                                                    $saldo_total = 0;
                                                    $pagado_total_eliminado = 0;
                                                    $saldo_total_eliminado = 0;

                                                    // Arrays para estadísticas
                                                    $rubros_data = [];
                                                    $cuentas_data = [];
                                                    $usuarios_data = [];
                                                    $estado_pagos = ['Pagado' => 0, 'Pendiente' => 0];
                                                    $meses_data = [];
                                                @endphp
                                                @foreach ($movimientos as $movimiento)
                                                    <tr>
                                                        <td align="center">
                                                            <div class="btn-group dropend">
                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                    <i class="bi bi-list-task"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ url('show-movimiento/'.$movimiento->id) }}"><i class="bi bi-eye-fill text-blue"></i> Información</a>
                                                                    </li>
                                                                    @if ($movimiento->cuenta->estado == 1)
                                                                        <li>
                                                                            <a class="dropdown-item" href="{{ url('edit-movimiento/'.$movimiento->id) }}"><i class="bi bi-pencil-fill text-warning"></i> Editar</a>
                                                                        </li>
                                                                        @if ($movimiento->estado == 1)
                                                                            @if (Auth::user()->role_as == 0)
                                                                                <li>
                                                                                    <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $movimiento->id }}">
                                                                                        <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                    </a>
                                                                                </li>
                                                                            @endif
                                                                        @endif

                                                                    @endif
                                                                </ul>
                                                            </div>
                                                        </td>
                                                        <td align="center">
                                                            <p>
                                                                <strong><a class="text-info" href="{{ url('show-movimiento/'.$movimiento->id) }}">{{ $movimiento->codigo }}</a></strong>
                                                                @if($movimiento->estado == 0)
                                                                    <span class="badge shade-light-red">Eliminado</span>
                                                                @elseif ($movimiento->estado == 1)
                                                                    <span class="badge shade-light-green">Activo</span>
                                                                @endif
                                                            </p>
                                                        </td>
                                                        <td align="center">
                                                            @php
                                                                $fecha = date('d/m/Y', strtotime($movimiento->fecha));

                                                                // Para estadísticas
                                                                $mes = date('Y-m', strtotime($movimiento->fecha));
                                                                if (!isset($meses_data[$mes])) {
                                                                    $meses_data[$mes] = [
                                                                        'monto_q' => 0,
                                                                        'pagado_q' => 0,
                                                                        'saldo_q' => 0,
                                                                        'count' => 0
                                                                    ];
                                                                }
                                                            @endphp
                                                            <small>{{ $fecha }}</small>
                                                        </td>
                                                        <td align="center">
                                                            <p>{{ $movimiento->cuenta->razon_social}}</p>
                                                            @php
                                                                // Para estadísticas
                                                                $cuenta = $movimiento->cuenta->razon_social;
                                                                if (!isset($cuentas_data[$cuenta])) {
                                                                    $cuentas_data[$cuenta] = [
                                                                        'monto_q' => 0,
                                                                        'pagado_q' => 0,
                                                                        'saldo_q' => 0,
                                                                        'count' => 0
                                                                    ];
                                                                }
                                                            @endphp
                                                        </td>
                                                        <td align="center">
                                                            <p>{{  $movimiento->rubro->nombre}}</p>
                                                            @php
                                                                // Para estadísticas
                                                                $rubro = $movimiento->rubro->nombre;
                                                                if (!isset($rubros_data[$rubro])) {
                                                                    $rubros_data[$rubro] = [
                                                                        'monto_q' => 0,
                                                                        'pagado_q' => 0,
                                                                        'saldo_q' => 0,
                                                                        'count' => 0
                                                                    ];
                                                                }
                                                            @endphp
                                                        </td>
                                                        <td align="center">
                                                            <p><strong>Q.{{ number_format($movimiento->monto_q,2, '.', ',') }}</strong>/$.{{ number_format($movimiento->monto_d,2, '.', ',') }}</p>
                                                        </td>
                                                        @php
                                                            $monto_pagado_q = \App\Models\MovimientoPago::where('movimiento_id', $movimiento->id)
                                                            ->sum('monto_q');
                                                            $saldo = $movimiento->monto_q - $monto_pagado_q;

                                                            // Estadísticas de usuario
                                                            $usuario = $movimiento->usuario->name ?? 'Sin Usuario';
                                                            if (!isset($usuarios_data[$usuario])) {
                                                                $usuarios_data[$usuario] = [
                                                                    'monto_q' => 0,
                                                                    'pagado_q' => 0,
                                                                    'saldo_q' => 0,
                                                                    'count' => 0
                                                                ];
                                                            }

                                                            // Agregar datos para estadísticas
                                                            if ($movimiento->estado == 1) {
                                                                $cuentas_data[$cuenta]['monto_q'] += $movimiento->monto_q;
                                                                $cuentas_data[$cuenta]['pagado_q'] += $monto_pagado_q;
                                                                $cuentas_data[$cuenta]['saldo_q'] += $saldo;
                                                                $cuentas_data[$cuenta]['count']++;

                                                                $rubros_data[$rubro]['monto_q'] += $movimiento->monto_q;
                                                                $rubros_data[$rubro]['pagado_q'] += $monto_pagado_q;
                                                                $rubros_data[$rubro]['saldo_q'] += $saldo;
                                                                $rubros_data[$rubro]['count']++;

                                                                $usuarios_data[$usuario]['monto_q'] += $movimiento->monto_q;
                                                                $usuarios_data[$usuario]['pagado_q'] += $monto_pagado_q;
                                                                $usuarios_data[$usuario]['saldo_q'] += $saldo;
                                                                $usuarios_data[$usuario]['count']++;

                                                                $meses_data[$mes]['monto_q'] += $movimiento->monto_q;
                                                                $meses_data[$mes]['pagado_q'] += $monto_pagado_q;
                                                                $meses_data[$mes]['saldo_q'] += $saldo;
                                                                $meses_data[$mes]['count']++;

                                                                if ($movimiento->monto_q <= $monto_pagado_q) {
                                                                    $estado_pagos['Pagado']++;
                                                                } else {
                                                                    $estado_pagos['Pendiente']++;
                                                                }
                                                            }
                                                        @endphp
                                                        <td align="center">
                                                            <p>
                                                                <font class="text-success">Q.{{ number_format($monto_pagado_q,2, '.', ',') }}</font>/<font class="text-warning">Q.{{ number_format($saldo,2, '.', ',') }}</font>
                                                                @if($movimiento->monto_q > $monto_pagado_q)
                                                                    <span class="badge shade-light-yellow">Pendiente</span>

                                                                @elseif ($movimiento->monto_q <= $monto_pagado_q)
                                                                    <span class="badge shade-light-green">Pagado</span>
                                                                @endif
                                                            </p>
                                                        </td>

                                                        <td align="center">
                                                            @php
                                                                $usuario = \App\Models\User::find( $movimiento->usuario_id );
                                                            @endphp
                                                            <p>{{ $usuario->name }}</p>
                                                        </td>

                                                        <td align="center">
                                                            @php
                                                                $datos_pagos = \App\Models\MovimientoPago::where('movimiento_id', $movimiento->id)->orderBy('fecha_documento','asc')->get();
                                                            @endphp
                                                            @if ($datos_pagos->count() > 0)
                                                                <div class="table-responsive">
                                                                    <table class="table align-middle table-striped flex-column">
                                                                        <thead>
                                                                            <tr>
                                                                                <td align="center"><small>Monto</small></td>
                                                                                <td align="center"><small>Forma Pago</small></td>
                                                                                <td align="center"><small>No.Documento</small></td>
                                                                                <td align="center"><small>Banco</small></td>
                                                                                <td align="center"><small>No.Cuenta</small></td>
                                                                                <td align="center"><small>Fecha</small></td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($datos_pagos as $dp)
                                                                                <tr>
                                                                                    <td align="center">
                                                                                        <p><small>Q.{{ number_format($dp->monto_q,2, '.', ',') }}</small></p>
                                                                                    </td>
                                                                                    <td align="center">
                                                                                        <p><small>{{ $dp->forma_pago }}</small></p>
                                                                                    </td>
                                                                                    <td align="center">
                                                                                        <p><small>{{ $dp->numero_documento }}</small></p>
                                                                                    </td>
                                                                                    <td align="center">
                                                                                        <p><small>{{ $dp->banco }}</small></p>
                                                                                    </td>
                                                                                    <td align="center">
                                                                                        <p><small>{{ $dp->numero_cuenta }}</small></p>
                                                                                    </td>
                                                                                    <td align="center">
                                                                                        <p>
                                                                                            @php
                                                                                                $fechaDoc = date('d/m/Y', strtotime($dp->fecha_documento));
                                                                                            @endphp
                                                                                            <small>{{ $fechaDoc }}</small>
                                                                                        </p>
                                                                                    </td>


                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @endif
                                                        </td>


                                                    </tr>
                                                    @include('empresa.movimiento.deletemodal')
                                                    @php
                                                        if ($movimiento->estado == 1) {
                                                            $monto_total_q = $monto_total_q + $movimiento->monto_q;
                                                            $monto_total_d = $monto_total_d + $movimiento->monto_d;
                                                            $pagado_total = $pagado_total + $monto_pagado_q;
                                                            $saldo_total = $saldo_total + $saldo;
                                                        }else{
                                                            $monto_total_q_eliminado = $monto_total_q_eliminado + $movimiento->monto_q;
                                                            $monto_total_d_eliminado = $monto_total_d_eliminado + $movimiento->monto_d;
                                                            $pagado_total_eliminado = $pagado_total_eliminado + $monto_pagado_q;
                                                            $saldo_total_eliminado = $saldo_total_eliminado + $saldo;
                                                        }
                                                    @endphp
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td align="right"><p><strong>Total:</strong></p></td>

                                                    <td align="center"><p><strong class="text-blue">Q.{{ number_format($monto_total_q,2, '.', ',') }}</strong>/$.{{ number_format($monto_total_d,2, '.', ',') }}</p></td>
                                                    <td align="right"><p><strong>Pagado/Saldo:</strong></p></td>
                                                    <td align="center"><p><strong class="text-success">Q.{{ number_format($pagado_total,2, '.', ',') }}</strong>/<strong class="text-warning">Q.{{ number_format($saldo_total,2, '.', ',') }}</strong></p></td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td align="right"><p><strong>Total Eliminado:</strong></p></td>

                                                    <td align="center"><p><strong class="text-danger">Q.{{ number_format($monto_total_q_eliminado,2, '.', ',') }}</strong>/$.{{ number_format($monto_total_d_eliminado,2, '.', ',') }}</p></td>
                                                    <td align="right"><p><strong>Pagado/Saldo:</strong></p></td>
                                                    <td align="center"><p><strong class="text-success">Q.{{ number_format($pagado_total_eliminado,2, '.', ',') }}</strong>/<strong class="text-warning">Q.{{ number_format($saldo_total_eliminado,2, '.', ',') }}</strong></p></td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                                <!-- Segunda pestaña: Estadísticas y resumen de datos -->
                                <div class="tab-pane fade" id="estadisticas" role="tabpanel" aria-labelledby="estadisticas-tab">
                                    <!-- Botón de exportación a PDF -->
                                    <div class="text-end mb-3">
                                        <a href="{{ url('pdf-estadisticas-movimientos?' . http_build_query(request()->all())) }}" target="_blank" class="btn btn-danger">
                                            <i class="bi bi-file-pdf"></i> Exportar Estadísticas a PDF
                                        </a>
                                    </div>

                                    <!-- Tarjetas de resumen -->
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h5 class="card-title">Total Movimientos</h5>
                                                    <h2 class="mb-0 text-primary">{{ count($movimientos) }}</h2>
                                                    <div class="text-muted small">Filtrados por la consulta actual</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h5 class="card-title">Total Monto</h5>
                                                    <h2 class="mb-0 text-blue">Q.{{ number_format($monto_total_q,2, '.', ',') }}</h2>
                                                    <div class="text-muted small">Quetzales (activos)</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h5 class="card-title">Pagado</h5>
                                                    <h2 class="mb-0 text-success">Q.{{ number_format($pagado_total,2, '.', ',') }}</h2>
                                                    <div class="text-muted small">({{ $pagado_total > 0 ? number_format(($pagado_total/$monto_total_q)*100, 1) : 0 }}% del total)</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-light">
                                                <div class="card-body">
                                                    <h5 class="card-title">Pendiente</h5>
                                                    <h2 class="mb-0 text-warning">Q.{{ number_format($saldo_total,2, '.', ',') }}</h2>
                                                    <div class="text-muted small">({{ $saldo_total > 0 ? number_format(($saldo_total/$monto_total_q)*100, 1) : 0 }}% del total)</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Gráfico de estado de pagos -->
                                    <div class="row mb-4">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title">Distribución por Estado de Pago</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="progress" style="height: 30px; width: 100%;">
                                                            @php
                                                                $porcentaje_pagado = $monto_total_q > 0 ? ($pagado_total/$monto_total_q)*100 : 0;
                                                                $porcentaje_pendiente = $monto_total_q > 0 ? ($saldo_total/$monto_total_q)*100 : 0;
                                                            @endphp
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: {{ $porcentaje_pagado }}%"
                                                                aria-valuenow="{{ $porcentaje_pagado }}"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                Pagado: Q.{{ number_format($pagado_total,2, '.', ',') }}
                                                            </div>
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: {{ $porcentaje_pendiente }}%"
                                                                aria-valuenow="{{ $porcentaje_pendiente }}"
                                                                aria-valuemin="0" aria-valuemax="100">
                                                                Pendiente: Q.{{ number_format($saldo_total,2, '.', ',') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mt-3">
                                                        <span class="badge shade-light-green">Pagado: {{ $estado_pagos['Pagado'] }} movimientos</span>
                                                        <span class="badge shade-light-yellow">Pendiente: {{ $estado_pagos['Pendiente'] }} movimientos</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Tablas de estadísticas por rubros y cuentas -->
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title">Totales por Mes</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Mes</th>
                                                                    <th>Movimientos</th>
                                                                    <th>Monto Total</th>
                                                                    <th>% Pagado</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    ksort($meses_data);
                                                                @endphp
                                                                @foreach($meses_data as $mes => $data)
                                                                    @php
                                                                        $mes_formato = date('M Y', strtotime($mes));
                                                                        $porcentaje = $data['monto_q'] > 0 ? ($data['pagado_q']/$data['monto_q'])*100 : 0;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $mes_formato }}</td>
                                                                        <td>{{ $data['count'] }}</td>
                                                                        <td>Q.{{ number_format($data['monto_q'],2, '.', ',') }}</td>
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
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title">Totales por Rubros</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Rubro</th>
                                                                    <th>Total</th>
                                                                    <th>Pagado</th>
                                                                    <th>Pendiente</th>
                                                                    <th>Cant.</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($rubros_data as $rubro => $data)
                                                                    <tr>
                                                                        <td>{{ $rubro }}</td>
                                                                        <td>Q.{{ number_format($data['monto_q'],2, '.', ',') }}</td>
                                                                        <td class="text-success">Q.{{ number_format($data['pagado_q'],2, '.', ',') }}</td>
                                                                        <td class="text-warning">Q.{{ number_format($data['saldo_q'],2, '.', ',') }}</td>
                                                                        <td><span class="badge bg-secondary">{{ $data['count'] }}</span></td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title">Totales por Usuarios</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th>Usuario</th>
                                                                    <th>Total</th>
                                                                    <th>Pagado</th>
                                                                    <th>Pendiente</th>
                                                                    <th>Cant.</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($usuarios_data as $usuario => $data)
                                                                    <tr>
                                                                        <td>{{ $usuario }}</td>
                                                                        <td>Q.{{ number_format($data['monto_q'],2, '.', ',') }}</td>
                                                                        <td class="text-success">Q.{{ number_format($data['pagado_q'],2, '.', ',') }}</td>
                                                                        <td class="text-warning">Q.{{ number_format($data['saldo_q'],2, '.', ',') }}</td>
                                                                        <td><span class="badge bg-secondary">{{ $data['count'] }}</span></td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabla de cuentas más grandes -->
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h5 class="card-title">Totales por Cuentas</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Cuenta</th>
                                                                    <th>Total</th>
                                                                    <th>Pagado</th>
                                                                    <th>Pendiente</th>
                                                                    <th>% Pagado</th>
                                                                    <th>Cant.</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    // Ordenar cuentas por monto
                                                                    arsort($cuentas_data);
                                                                @endphp
                                                                @foreach($cuentas_data as $cuenta => $data)
                                                                    @php
                                                                        $porcentaje = $data['monto_q'] > 0 ? ($data['pagado_q']/$data['monto_q'])*100 : 0;
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $cuenta }}</td>
                                                                        <td>Q.{{ number_format($data['monto_q'],2, '.', ',') }}</td>
                                                                        <td class="text-success">Q.{{ number_format($data['pagado_q'],2, '.', ',') }}</td>
                                                                        <td class="text-warning">Q.{{ number_format($data['saldo_q'],2, '.', ',') }}</td>
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
                                                                        <td><span class="badge bg-secondary">{{ $data['count'] }}</span></td>
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
                                                        <h5 class="card-title">Distribución por Rubros</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div style="height: 300px;">
                                                            <canvas id="rubrosPieChart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title">Estado de Pagos</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div style="height: 300px;">
                                                            <canvas id="estadoPagosChart"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title">Evolución de Movimientos por Mes</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div style="height: 300px;">
                                                            <canvas id="evolucionLineChart"></canvas>
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
                                        // Preparar datos para los gráficos

                                        // Datos para el gráfico de rubros
                                        $rubrosLabels = [];
                                        $rubrosData = [];
                                        $rubrosColors = [
                                            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                                            '#5a5c69', '#6610f2', '#6f42c1', '#fd7e14', '#20c9a6',
                                            '#858796', '#17a673', '#2c9faf', '#f8f9fc', '#e74a3b'
                                        ];

                                        $i = 0;
                                        foreach($rubros_data as $rubro => $data) {
                                            if ($data['monto_q'] > 0) {
                                                $rubrosLabels[] = $rubro;
                                                $rubrosData[] = $data['monto_q'];
                                                $i++;
                                                if ($i >= 10) break; // Limitar a 10 rubros para mejor visualización
                                            }
                                        }

                                        // Datos para el gráfico de estado de pagos
                                        $estadoPagosLabels = ['Pagado', 'Pendiente'];
                                        $estadoPagosData = [$pagado_total, $saldo_total];
                                        $estadoPagosColors = ['#1cc88a', '#f6c23e'];

                                        // Datos para el gráfico de evolución
                                        $mesesOrdenados = [];
                                        $montosPorMes = [];
                                        $pagadosPorMes = [];

                                        ksort($meses_data); // Ordenar por fecha

                                        foreach($meses_data as $mes => $data) {
                                            $mesesOrdenados[] = date('M Y', strtotime($mes));
                                            $montosPorMes[] = $data['monto_q'];
                                            $pagadosPorMes[] = $data['pagado_q'];
                                        }

                                        // Datos para el gráfico de cuentas
                                        $cuentasLabels = [];
                                        $cuentasData = [];
                                        $cuentasPagadoData = [];

                                        // Ordenar por monto y tomar los primeros 5
                                        arsort($cuentas_data);
                                        $i = 0;
                                        foreach($cuentas_data as $cuenta => $data) {
                                            $cuentasLabels[] = mb_substr($cuenta, 0, 20) . (mb_strlen($cuenta) > 20 ? '...' : '');
                                            $cuentasData[] = $data['monto_q'];
                                            $cuentasPagadoData[] = $data['pagado_q'];
                                            $i++;
                                            if ($i >= 5) break; // Top 5
                                        }
                                    @endphp

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Configuración de colores
                                            Chart.defaults.color = '#858796';

                                            // Gráfico de Rubros (Pie)
                                            var rubrosCtx = document.getElementById('rubrosPieChart').getContext('2d');
                                            var rubrosPieChart = new Chart(rubrosCtx, {
                                                type: 'pie',
                                                data: {
                                                    labels: @json($rubrosLabels),
                                                    datasets: [{
                                                        data: @json($rubrosData),
                                                        backgroundColor: @json($rubrosColors),
                                                        hoverOffset: 4
                                                    }]
                                                },
                                                options: {
                                                    maintainAspectRatio: false,
                                                    plugins: {
                                                        legend: {
                                                            position: 'right',
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

                                            // Gráfico de Evolución de Movimientos (Line)
                                            var evolucionCtx = document.getElementById('evolucionLineChart').getContext('2d');
                                            var evolucionLineChart = new Chart(evolucionCtx, {
                                                type: 'line',
                                                data: {
                                                    labels: @json($mesesOrdenados),
                                                    datasets: [
                                                        {
                                                            label: 'Monto Total',
                                                            data: @json($montosPorMes),
                                                            borderColor: '#4e73df',
                                                            backgroundColor: 'rgba(78, 115, 223, 0.05)',
                                                            fill: true,
                                                            tension: 0.3
                                                        },
                                                        {
                                                            label: 'Pagado',
                                                            data: @json($pagadosPorMes),
                                                            borderColor: '#1cc88a',
                                                            backgroundColor: 'rgba(28, 200, 138, 0.05)',
                                                            fill: true,
                                                            tension: 0.3
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

                                            // Gráfico de Cuentas (Bar)
                                            var cuentasCtx = document.getElementById('cuentasBarChart').getContext('2d');
                                            var cuentasBarChart = new Chart(cuentasCtx, {
                                                type: 'bar',
                                                data: {
                                                    labels: @json($cuentasLabels),
                                                    datasets: [
                                                        {
                                                            label: 'Monto Total',
                                                            data: @json($cuentasData),
                                                            backgroundColor: 'rgba(78, 115, 223, 0.8)',
                                                            borderWidth: 1
                                                        },
                                                        {
                                                            label: 'Pagado',
                                                            data: @json($cuentasPagadoData),
                                                            backgroundColor: 'rgba(28, 200, 138, 0.8)',
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
                                                doc.text('Reporte de Gráficos - Movimientos', pageWidth / 2, yPos, { align: 'center' });
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

                                                @if(isset($fechaDesdeVista) && isset($fechaHastaVista))
                                                    doc.text(`Período: desde ${@json($fechaDesdeVista)} hasta ${@json($fechaHastaVista)}`, margin, yPos);
                                                    yPos += 5;
                                                @endif

                                                @if(request('cuenta_id'))
                                                    doc.text('Cuenta: {{ \App\Models\Cuenta::find(request("cuenta_id"))->razon_social ?? "N/A" }}', margin, yPos);
                                                    yPos += 5;
                                                @endif

                                                @if(request('rubro_id'))
                                                    doc.text('Rubro: {{ \App\Models\Rubro::find(request("rubro_id"))->nombre ?? "N/A" }}', margin, yPos);
                                                    yPos += 5;
                                                @endif

                                                @if(request('saldo'))
                                                    doc.text('Saldo: {{ request("saldo") }}', margin, yPos);
                                                    yPos += 5;
                                                @endif

                                                @if(request('usuario_id'))
                                                    doc.text('Usuario: {{ \App\Models\User::find(request("usuario_id"))->name ?? "N/A" }}', margin, yPos);
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
                                                doc.text(`Total Movimientos: {{ count($movimientos) }}`, margin, yPos);
                                                yPos += 5;
                                                doc.text(`Monto Total: Q.{{ number_format($monto_total_q,2, '.', ',') }}`, margin, yPos);
                                                yPos += 5;
                                                doc.text(`Pagado: Q.{{ number_format($pagado_total,2, '.', ',') }} ({{ $pagado_total > 0 ? number_format(($pagado_total/$monto_total_q)*100, 1) : 0 }}%)`, margin, yPos);
                                                yPos += 5;
                                                doc.text(`Pendiente: Q.{{ number_format($saldo_total,2, '.', ',') }} ({{ $saldo_total > 0 ? number_format(($saldo_total/$monto_total_q)*100, 1) : 0 }}%)`, margin, yPos);
                                                yPos += 10;

                                                // Función para procesar cada gráfico
                                                const captureNext = (index) => {
                                                    if (index >= graficos.length) {
                                                        // Todos los gráficos han sido procesados, guardar PDF
                                                        doc.save('Graficos_Movimientos.pdf');
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

                                                // Obtener todos los gráficos del contenedor
                                                const graficos = document.querySelectorAll('#graficos-container canvas');

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

    <!-- Agrega los scripts necesarios para los gráficos si decides implementarlos en el futuro -->
    <script>
        // Asegúrate de que las pestañas funcionen correctamente
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('#movimientosTab button');
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

