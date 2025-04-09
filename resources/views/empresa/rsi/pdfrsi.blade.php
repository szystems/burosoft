<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RSI</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: center;
            font-size: 9px;
        }
        th {
            background-color: #f2f2f2;
        }
        .green { color: #32CD32; }
        .orange { color: #FFA500; }
        .blue { color: #0000FF; }
        .gray { color: #808080; }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header img {
            max-height: 80px;
        }
        h3, h5 {
            margin: 8px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        @if($imagen)
            <img src="{{ $imagen }}" alt="Logo">
        @endif
        <h3><u>RSI</u></h3>
    </div>

    <div>
        <span>Fecha Reporte: </span>
        <span class="blue">
            @php
                $horafecha = new DateTime("now", new DateTimeZone('America/Guatemala'));
                $horafecha = $horafecha->format('d-m-Y, H:i:s')
            @endphp
            {{ $horafecha }} (America/Guatemala)
        </span>
    </div>

    <div>
        <strong><u>{{ __('Filtros:') }}</u></strong><br>
        <span>Cuenta:
            <span class="blue">
                @if ($request->input('ffcuenta') != null)
                    @php
                        $cuenta = \App\Models\Cuenta::find($request->input('ffcuenta'));
                    @endphp
                    {{ $cuenta->razon_social }}
                @else
                    Todas
                @endif
            </span>
        </span>
        <span>Saldo:
            <span class="blue">
                @if ($request->input('ffsaldo') != null)
                    {{ $request->input('ffsaldo') }}
                @else
                    Todos
                @endif
            </span>
        </span>
    </div>

    <h5><u>Listado de Cuentas RSI:</u></h5>
    <table>
        <thead>
            <tr>
                <th>Cuenta</th>
                <th>Cargo</th>
                <th>Estado</th>
                <th>Pagado/Saldo</th>
            </tr>
        </thead>
        <tbody>
            @php
                $tmonto = 0;
                $tpagado = 0;
                $tsaldo = 0;
            @endphp
            @foreach ($movimientos as $movimiento)
                <tr>
                    <td>
                        {{ $movimiento->codigo }} {{ $movimiento->cuenta}}
                    </td>
                    <td>
                        <span class="gray">
                            <strong>Q.{{ number_format($movimiento->total_monto_q,2, '.', ',') }}</strong>
                        </span>
                    </td>
                    <td>
                        @if($movimiento->total_monto_q > $movimiento->total_pagado)
                            <span class="orange">Pendiente</span>
                        @else
                            <span class="green">Pagado</span>
                        @endif
                    </td>
                    <td>
                        <span class="green">
                            <strong>Q.{{ number_format($movimiento->total_pagado,2, '.', ',') }}</strong>
                        </span>/
                        @if ($movimiento->saldo == 0 && ($movimiento->total_pagado != $movimiento->total_monto_q))
                            <span class="orange">
                                <strong>Q.{{ number_format($movimiento->total_monto_q,2, '.', ',') }}</strong>
                            </span>
                        @else
                            <span class="orange">
                                <strong>Q.{{ number_format($movimiento->saldo,2, '.', ',') }}</strong>
                            </span>
                        @endif
                    </td>
                </tr>
                @php
                    $tmonto += $movimiento->total_monto_q;
                    $tpagado += $movimiento->total_pagado;
                    if ($movimiento->saldo == 0 and ($movimiento->total_pagado !=  $movimiento->total_monto_q))
                    {
                        $tsaldo += $movimiento->total_monto_q;
                    }

                    else
                    {
                        $tsaldo += $movimiento->saldo;
                    }
                @endphp
            @endforeach
        </tbody>
    </table>

    <h4><strong><u>Resumen</u></strong></h4>
    <table>
        <thead>
            <tr>
                <th>Monto Total</th>
                <th>Pagado/Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center">
                    <h2><span class="blue"><strong>Q.{{ number_format($tmonto,2, '.', ',') }}</strong></span></h2>
                </td>
                <td align="center">
                    <h2>
                        <span class="green"><strong>Q.{{ number_format($tpagado,2, '.', ',') }}</strong></span> /
                        <span class="orange"><strong>Q.{{ number_format($tsaldo,2, '.', ',') }}</strong></span>
                    </h2>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
