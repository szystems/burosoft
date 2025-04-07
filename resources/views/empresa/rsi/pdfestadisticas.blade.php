<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Pure css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">


    <title>Estadísticas RSI</title>

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
    </style>
</head>

<body>
    <center>
        <img align="center" src="{{ $imagen }}" alt="" height="100">
    </center>
    <h3 align="center"><u>Estadísticas RSI</u></h3>
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
        <font size="1">Saldo:</font>
        <font size="1" color="blue">
            @if (request('saldo'))
                {{ request('saldo') }}
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
                <th>Total Cuentas</th>
                <th>Monto Total</th>
                <th>Pagado</th>
                <th>Pendiente</th>
            </tr>
            <tr>
                <td align="center"><h2>{{ count($movimientos) }}</h2></td>
                <td align="center"><h2><font color="blue">Q.{{ number_format($tmonto,2, '.', ',') }}</font></h2></td>
                <td align="center"><h2><font color="green">Q.{{ number_format($tpagado,2, '.', ',') }}</font></h2></td>
                <td align="center"><h2><font color="orange">Q.{{ number_format($tsaldo,2, '.', ',') }}</font></h2></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td align="center">{{ $tpagado > 0 ? number_format(($tpagado/$tmonto)*100, 1) : 0 }}% del total</td>
                <td align="center">{{ $tsaldo > 0 ? number_format(($tsaldo/$tmonto)*100, 1) : 0 }}% del total</td>
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
                    <p>Pagado: {{ $estado_pagos['Pagado'] }} cuentas</p>
                    <p>Pendiente: {{ $estado_pagos['Pendiente'] }} cuentas</p>
                </td>
                <td>
                    <div class="progress-bar">
                        @php
                            $porcentaje_pagado = $tmonto > 0 ? ($tpagado/$tmonto)*100 : 0;
                            $porcentaje_pendiente = $tmonto > 0 ? ($tsaldo/$tmonto)*100 : 0;
                        @endphp
                        <div class="progress-bar-fill-success" style="width: {{ $porcentaje_pagado }}%">
                            Pagado: Q.{{ number_format($tpagado,2, '.', ',') }} ({{ number_format($porcentaje_pagado, 1) }}%)
                        </div>
                        <div class="progress-bar-fill-warning" style="width: {{ $porcentaje_pendiente }}%">
                            Pendiente: Q.{{ number_format($tsaldo,2, '.', ',') }} ({{ number_format($porcentaje_pendiente, 1) }}%)
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Tabla de cuentas -->
    <div class="section">
        <h4><u>Detalle por Cuentas</u></h4>
        <table class="pure-table pure-table-bordered" Width=100%>
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
                        <td align="right">Q.{{ number_format($data['monto'],2, '.', ',') }}</td>
                        <td align="right"><font color="green">Q.{{ number_format($data['pagado'],2, '.', ',') }}</font></td>
                        <td align="right"><font color="orange">Q.{{ number_format($data['saldo'],2, '.', ',') }}</font></td>
                        <td align="center">{{ number_format($porcentaje, 1) }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
