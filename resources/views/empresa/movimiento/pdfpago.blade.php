<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Pure css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">


    <title>Movimiento</title>

</head>

<body>
    <center>
        <img align="center" src="{{ $imagen }}" alt="" height="100">
    </center>
    <h3 align="center"><u>Movimiento</u></h3>
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

    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th align="right">
                    <font size="1">Código:</font>
                </th>
                <td colspan="2">
                    <font size="1">{{ $movimiento->codigo }}</font>
                </td>
                <th align="right">
                    <font size="1">Creado / Actualizacion:</font>
                </th>
                <td colspan="2">
                    @php
                        $fecha = date("d/m/Y", strtotime($movimiento->fecha));
                        $ultimaActualizacion = date("d/m/Y", strtotime($movimiento->updated_at));
                    @endphp
                    <font size="1">{{ $fecha }} - {{ $ultimaActualizacion }}</font>
                </td>
            </tr>
            <tr>
                <th align="right">
                    <font size="1">Cuenta:</font>
                </th>
                <td colspan="5">
                    <font size="1">{{ $movimiento->cuenta->razon_social }}</font>
                </td>
            </tr>
            <tr>
                <th align="right">
                    <font size="1">Rubro:</font>
                </th>
                <td colspan="2">
                    <font size="1">{{ $movimiento->rubro->nombre }}</font>
                </td>
                <th align="right">
                    <font size="1">Usuario:</font>
                </th>
                <td colspan="2">
                    @php
                        $usuario = \App\Models\User::find( $movimiento->usuario_id );
                    @endphp
                    <font size="1">{{ $usuario->name }}</font>
                </td>
            </tr>
            <tr>

                <th align="right">
                    <font size="1">Descripción:</font>
                </th>
                <td colspan="5">
                    <font size="1">{{ $movimiento->descripcion }}</font>
                </td>
            </tr>
            <tr>
                <th align="right">
                    <font size="1">Monto (Quetzaltes):</font>
                </th>
                <td>
                    <font size="1" color="blue"><strong>Q.{{ number_format($movimiento->monto_q,2, '.', ',') }}</strong></font>
                </td>
                <th align="right">
                    <font size="1">Abonado/Saldo (Quetzaltes):</font>
                </th>
                <td>
                    @php
                        $saldoQ = $movimiento->monto_q - $totalAbonadoQ;
                    @endphp
                    <font size="1"><strong><font color="limegreen">Q.{{ number_format($totalAbonadoQ,2, '.', ',') }}</font></strong> / <strong><font color="orange">Q.{{ number_format($saldoQ,2, '.', ',') }}</font></strong></font>
                </td>
                @php
                    $monto_pagado_q = \App\Models\MovimientoPago::where('movimiento_id', $movimiento->id)
                    ->where('estado', 1)
                    ->sum('monto_q');
                    $saldo_q = $movimiento->monto_q - $monto_pagado_q;

                    $monto_pagado_d = \App\Models\MovimientoPago::where('movimiento_id', $movimiento->id)
                    ->where('estado', 1)
                    ->sum('monto_d');
                    $saldo_d = $movimiento->monto_d - $monto_pagado_d;
                @endphp
                <th align="right">
                    <font size="1">Estado Saldo:</font>
                </th>
                <td>
                    <font size="1">
                        @if($movimiento->monto_q > $monto_pagado_q)
                            <font color="orange"><b>Pendiente</b></font>
                        @elseif ($movimiento->monto_q <= $monto_pagado_q)
                            <font color="limegreen"><b>Pagado</b></font>
                        @endif</font>
                </td>
            </tr>
            <tr>
                <th align="right">
                    <font size="1">Monto (Dolares):</font>
                </th>
                <td>
                    <font size="1" color="blue"><strong>$.{{ number_format($movimiento->monto_d,2, '.', ',') }}</strong></font>
                </td>
                <th align="right">
                    <font size="1">Abonado/Saldo (Dolares):</font>
                </th>
                <td>
                    @php
                        $saldoD = $movimiento->monto_d - $totalAbonadoD;
                    @endphp
                    <font size="1"><strong><font color="limegreen">$.{{ number_format($totalAbonadoD,2, '.', ',') }}</font></strong> / <strong><font color="orange">$.{{ number_format($saldoD,2, '.', ',') }}</font></strong></font>
                </td>
                <th align="right">
                    <font size="1">Estado Saldo:</font>
                </th>
                <td>
                    <font size="1">
                        @if($movimiento->monto_d > $monto_pagado_d)
                            <font color="orange"><b>Pendiente</b></font>
                        @elseif ($movimiento->monto_d <= $monto_pagado_d)
                            <font color="limegreen"><b>Pagado</b></font>
                        @endif</font>
                </td>
            </tr>
        </thead>
        {{-- <tbody>
            <tr>
                <td align="center">
                    <font size="1">hola</font>
                </td>
                <td align="center">
                    <font size="1">hola 2</font>
                </td>
            </tr>
        </tbody> --}}
    </table>

    <br>
    <h4><strong><u>Pago</u></strong></h4>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                <th align="right">
                    <font size="1">Código:</font>
                </th>
                <th>
                    <font size="1">Fecha</font>
                </th>
                <th>
                    <font size="1">Monto Q/$</font>
                </th>
                <th>
                    <font size="1">Descripción</font>
                </th>
                <th>
                    <font size="1">Forma Pago</font>
                </th>
                {{-- <th>
                    <font size="1">Imagen</font>
                </th> --}}
                <th>
                    <font size="1">Datos</font>
                </th>
                <th>
                    <font size="1">Usuario</font>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center">
                    <font size="1">{{ $pago->codigo }}</font>
                    <br>
                    @if ($pago->estado == 0)
                        <font size="1" color="red">Eliminado</font>
                    @endif
                </td>
                <td align="center">
                    @php
                        $fecha = date('d/m/Y', strtotime($pago->created_at));
                    @endphp
                    <font size="1">{{ $fecha }}</font>
                </td>
                <td align="center">
                    <font size="1"><strong>Q.{{ number_format($pago->monto_q,2, '.', ',') }}</strong> / $.{{ number_format($pago->monto_d,2, '.', ',') }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $pago->descripcion }}</font>
                </td>
                <td align="center">
                    <font size="1">{{ $pago->forma_pago }}</font>
                </td>
                {{-- <td align="center">
                    @if ($pago->imagen)
                        <img src="{{ asset('assets/uploads/pagos/'.$pago->imagen) }}" class="img-thumbnail" style="height: 100px;" alt="Imagen pago" />
                    @endif
                </td> --}}
                <td align="center">
                    <font size="1">
                        @if ($pago->numero_documento)
                            <strong>No. Documento:</strong> {{ $pago->numero_documento }}
                            <br>
                        @endif
                        @if ($pago->banco)
                            <strong>Banco:</strong> {{ $pago->banco }}
                            <br>
                        @endif
                        @if ($pago->numero_cuenta)
                            <strong>Numero Cuenta:</strong> {{ $pago->numero_cuenta }}
                            <br>
                        @endif
                        @if ($pago->fecha_documento)
                            @php
                                $fecha_documento = date("d-m-Y", strtotime($pago->fecha_documento));
                            @endphp
                            <strong>Fecha:</strong><br> {{ $fecha_documento }}

                        @endif
                    </font>
                </td>
                <td align="center">
                    <font size="1">{{ $pago->usuario->name }}</font>
                </td>
            </tr>
        </tbody>
    </table>

</body>

</html>
