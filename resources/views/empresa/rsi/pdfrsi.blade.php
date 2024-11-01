<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Pure css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">


    <title>RSI</title>

</head>

<body>
    <center>
        <img align="center" src="{{ $imagen }}" alt="" height="100">
    </center>
    <h3 align="center"><u>RSI</u></h3>
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
            @if ($request->input('ffcuenta') != null)
                @php
                    $cuenta = \App\Models\Cuenta::find($request->input('ffcuenta'));
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
            @if ($request->input('ffsaldo') != null)
                {{ $request->input('ffsaldo') }}
            @else
                Todos
            @endif
        </font>
    </label>

    <h5><u>Listado de Cuentas RSI:</u></h5>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>

                <th>
                    <font size="1">Cuenta</font>
                </th>

                <th>
                    <font size="1">Cargo</font>
                </th>


                <th>
                    <font size="1">Estado</font>
                </th>

                <th>
                    <font size="1">Pagado/Saldo</font>
                </th>

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

                    <td align="center">
                        <font size="1">
                            {{ $movimiento->codigo }} {{ $movimiento->cuenta}}
                        </font>
                    </td>

                    <td align="center">
                        <font size="1" color="gray">
                            <strong>Q.{{ number_format($movimiento->total_monto_q,2, '.', ',') }}</strong>
                        </font>
                    </td>

                    <td align="center">
                        <font size="1">
                            @if($movimiento->total_monto_q > $movimiento->total_pagado)
                                <font color="orange">Pendiente</font>

                            @elseif ($movimiento->total_monto_q <= $movimiento->total_pagado)
                            <font color="limegreen">Pagado</font>
                            @endif
                        </font>
                    </td>

                    <td align="center">
                        <font size="1" color="gray">
                            <strong class="text-success">Q.{{ number_format($movimiento->total_pagado,2, '.', ',') }}</strong>/
                            @if ($movimiento->saldo == 0 and ($movimiento->total_pagado !=  $movimiento->total_monto_q))
                                <strong class="text-warning">Q.{{ number_format($movimiento->total_monto_q,2, '.', ',') }}</strong>
                            @else
                            <strong class="text-warning">Q.{{ number_format($movimiento->saldo,2, '.', ',') }}</strong>
                            @endif
                        </font>
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
        {{-- <tfoot>
            <tr align="right">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right"><p><strong>Total:</strong></p></td>
                <td align="center"><p><strong><font color="blue">Q.{{ number_format($monto_total_q,2, '.', ',') }}</font></strong>/<font color="orange"> $.{{ number_format($monto_total_d,2, '.', ',') }}</font></p></td>
                <td align="right"><p><strong>Pagado/Saldo:</strong></p></td>
                <td align="center"><p><strong><font color="limegreen">Q.{{ number_format($pagado_total,2, '.', ',') }}</font></strong>/<strong class="text-warning"><font color="orange">Q.{{ number_format($saldo_total,2, '.', ',') }}</font></strong></p></td>
                <td></td>
            </tr>
        </tfoot> --}}
    </table>
    <br>
    <h4><strong><u>Resumen</u></strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th>
                    <font size="1">Monto Total</font>
                </th>
                <th>
                    <font size="1">Pagado/Saldo</font>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center">
                    <h2><strong><font color="blue">Q.{{ number_format($tmonto,2, '.', ',') }}</font></strong></h2>
                </td>
                <td align="center">
                    <h2><strong><font color="limegreen">Q.{{ number_format($tpagado,2, '.', ',') }}</font></strong> / <strong class="text-warning"><font color="orange">Q.{{ number_format($tsaldo,2, '.', ',') }}</font></strong></font></h2>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
