<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Pure css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">

    <title>Estadísticas de Movimientos</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-success {
            color: green;
        }
        .text-warning {
            color: orange;
        }
        .text-blue {
            color: blue;
        }
        .progress-bar {
            height: 20px;
            background-color: #f0f0f0;
            border-radius: 4px;
            margin-bottom: 5px;
            overflow: hidden;
        }
        .progress-bar-fill-success {
            height: 100%;
            background-color: #28a745;
            float: left;
            display: flex;
            align-items: center;
            color: white;
            padding-left: 5px;
            box-sizing: border-box;
        }
        .progress-bar-fill-warning {
            height: 100%;
            background-color: #ffc107;
            float: left;
            display: flex;
            align-items: center;
            color: white;
            padding-left: 5px;
            box-sizing: border-box;
        }
        .progress-bar-fill-info {
            height: 100%;
            background-color: #17a2b8;
            float: left;
            display: flex;
            align-items: center;
            color: white;
            padding-left: 5px;
            box-sizing: border-box;
        }
        .section {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .bg-success {
            background-color: #28a745;
            color: white;
        }
        .bg-warning {
            background-color: #ffc107;
            color: black;
        }
        .bg-info {
            background-color: #17a2b8;
            color: white;
        }
        .bg-secondary {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>

<body>
    <center>
        <img align="center" src="{{ $imagen }}" alt="" height="100">
    </center>
    <h3 align="center"><u>Estadísticas de Movimientos</u></h3>
    <label>
        <font size="1">Fecha Reporte:</font>
        <font color="blue" size="1">
            @php
                $horafecha = new DateTime("now", new DateTimeZone('America/Guatemala'));
                $horafecha = $horafecha->format('d-m-Y, H:i:s')
            @endphp
            {{ $horafecha }} (America/Guatemala)
        </font>
    </label>
    <br>
    <label for="">
        <font size="1"><strong><u>{{ __('Filtros:') }}</u></strong></font>
    </label>
    <br>
    <label for="">
        <font size="1">Desde: </font>
        <font size="1" color="blue">{{ $fechaDesdeVista }}</font>
    </label>
    <label for="">
        <font size="1">Hasta: </font>
        <font size="1" color="blue">{{ $fechaHastaVista }}</font>
    </label>
    <label for="">
        <font size="1">Cuenta:</font>
        <font size="1" color="blue">
            @if (request('cuenta_id'))
                @php
                    $cuenta = \App\Models\Cuenta::find(request('cuenta_id'));
                @endphp
                {{ $cuenta->razon_social }}
            @else
                Todas
            @endif
        </font>
    </label>
    <label for="">
        <font size="1">Rubro:</font>
        <font size="1" color="blue">
            @if (request('rubro_id'))
                @php
                    $rubro = \App\Models\Rubro::find(request('rubro_id'));
                @endphp
                {{ $rubro->nombre }}
            @else
                Todos
            @endif
        </font>
    </label>
    <label for="">
        <font size="1">Saldo:</font>
        <font size="1" color="blue">
            @if (request('saldo'))
                {{ request('saldo') }}
            @else
                Todos
            @endif
        </font>
    </label>
    <label for="">
        <font size="1">Usuario: </font>
        <font size="1" color="blue">
            @if (request('usuario_id'))
                @php
                    $usuario = \App\Models\User::find(request('usuario_id'));
                @endphp
                {{ $usuario->name }}
            @else
                Todos
            @endif
        </font>
    </label>

    <!-- Resumen General -->
    <div class="section">
        <h4><u>Resumen General</u></h4>
        <table class="pure-table pure-table-bordered" Width=100%>
            <tr>
                <th>Total Movimientos</th>
                <th>Monto Total</th>
                <th>Pagado</th>
                <th>Pendiente</th>
            </tr>
            <tr>
                <td align="center"><h2>{{ count($movimientos) }}</h2></td>
                <td align="center"><h2><font color="blue">Q.{{ number_format($monto_total_q,2, '.', ',') }}</font></h2></td>
                <td align="center"><h2><font color="green">Q.{{ number_format($pagado_total,2, '.', ',') }}</font></h2></td>
                <td align="center"><h2><font color="orange">Q.{{ number_format($saldo_total,2, '.', ',') }}</font></h2></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td align="center">{{ $pagado_total > 0 ? number_format(($pagado_total/$monto_total_q)*100, 1) : 0 }}% del total</td>
                <td align="center">{{ $saldo_total > 0 ? number_format(($saldo_total/$monto_total_q)*100, 1) : 0 }}% del total</td>
            </tr>
        </table>
    </div>

    <!-- Estado de Pagos -->
    <div class="section">
        <h4><u>Estado de Pagos</u></h4>
        <table class="pure-table pure-table-bordered" Width=100%>
            <tr>
                <td width="20%">Estado</td>
                <td width="80%">Distribución</td>
            </tr>
            <tr>
                <td>
                    <p>Pagado: {{ $estado_pagos['Pagado'] }} movimientos</p>
                    <p>Pendiente: {{ $estado_pagos['Pendiente'] }} movimientos</p>
                </td>
                <td>
                    <div class="progress-bar">
                        @php
                            $porcentaje_pagado = $monto_total_q > 0 ? ($pagado_total/$monto_total_q)*100 : 0;
                            $porcentaje_pendiente = $monto_total_q > 0 ? ($saldo_total/$monto_total_q)*100 : 0;
                        @endphp
                        <div class="progress-bar-fill-success" style="width: {{ $porcentaje_pagado }}%">
                            Pagado: Q.{{ number_format($pagado_total,2, '.', ',') }} ({{ number_format($porcentaje_pagado, 1) }}%)
                        </div>
                        <div class="progress-bar-fill-warning" style="width: {{ $porcentaje_pendiente }}%">
                            Pendiente: Q.{{ number_format($saldo_total,2, '.', ',') }} ({{ number_format($porcentaje_pendiente, 1) }}%)
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Montos por Mes -->
    <div class="section">
        <h4><u>Totales por Mes</u></h4>
        <table class="pure-table pure-table-bordered" Width=100%>
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Movimientos</th>
                    <th>Monto Total</th>
                    <th>Pagado</th>
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
                        <td align="center">{{ $data['count'] }}</td>
                        <td align="right">Q.{{ number_format($data['monto_q'],2, '.', ',') }}</td>
                        <td align="right">Q.{{ number_format($data['pagado_q'],2, '.', ',') }}</td>
                        <td align="center">{{ number_format($porcentaje, 1) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tabla de Rubros -->
    <div class="section">
        <h4><u>Totales por Rubros</u></h4>
        <table class="pure-table pure-table-bordered" Width=100%>
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
                        <td align="right">Q.{{ number_format($data['monto_q'],2, '.', ',') }}</td>
                        <td align="right"><font color="green">Q.{{ number_format($data['pagado_q'],2, '.', ',') }}</font></td>
                        <td align="right"><font color="orange">Q.{{ number_format($data['saldo_q'],2, '.', ',') }}</font></td>
                        <td align="center">{{ $data['count'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tabla de Usuarios -->
    <div class="section">
        <h4><u>Totales por Usuarios</u></h4>
        <table class="pure-table pure-table-bordered" Width=100%>
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
                        <td align="right">Q.{{ number_format($data['monto_q'],2, '.', ',') }}</td>
                        <td align="right"><font color="green">Q.{{ number_format($data['pagado_q'],2, '.', ',') }}</font></td>
                        <td align="right"><font color="orange">Q.{{ number_format($data['saldo_q'],2, '.', ',') }}</font></td>
                        <td align="center">{{ $data['count'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Tabla de Cuentas -->
    <div class="section">
        <h4><u>Totales por Cuentas</u></h4>
        <table class="pure-table pure-table-bordered" Width=100%>
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
                        <td align="right">Q.{{ number_format($data['monto_q'],2, '.', ',') }}</td>
                        <td align="right"><font color="green">Q.{{ number_format($data['pagado_q'],2, '.', ',') }}</font></td>
                        <td align="right"><font color="orange">Q.{{ number_format($data['saldo_q'],2, '.', ',') }}</font></td>
                        <td align="center">{{ number_format($porcentaje, 1) }}%</td>
                        <td align="center">{{ $data['count'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
