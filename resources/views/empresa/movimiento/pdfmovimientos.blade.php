<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Pure css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/purecss@3.0.0/build/pure-min.css"
        integrity="sha384-X38yfunGUhNzHpBaEBsWLO+A0HDYOQi8ufWDkZ0k9e0eXz/tH3II7uKZ9msv++Ls" crossorigin="anonymous">


    <title>Cuentas Por Cobrar</title>

</head>

<body>
    <center>
        <img align="center" src="{{ $imagen }}" alt="" height="100">
    </center>
    <h3 align="center"><u>Cuentas Por Cobrar</u></h3>
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
        <font size="1">Rubro:</font>
        <font size="1" color="blue">
            @if ($request->input('ffrubro') != null)
                @php
                    $rubro = \App\Models\Rubro::find($request->input('ffrubro'));
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
            @if ($request->input('ffsaldo') != null)
                {{ $request->input('ffsaldo') }}
            @else
                Todos
            @endif
        </font>
    </label>
    <label for="">
        <font size="1">Usuario: </font>
        <font size="1" color="blue">
            @if ($request->input('ffusuario') != null)
                @php
                    $usuario = \App\Models\User::find($request->input('ffusuario'));
                @endphp
                {{ $usuario->name }}
            @else
                Todos
            @endif
        </font>
    </label>

    <h5><u>Cuentas:</u></h5>
    <table class="pure-table pure-table-bordered" Width=100%>
        <thead>
            <tr>
                @if ($request->has('fid'))
                    <th>
                        <font size="1">Código</font>
                    </th>
                @endif

                @if ($request->has('ffecha'))
                <th>
                    <font size="1">Fecha</font>
                </th>
                @endif

                @if ($request->has('fcuenta'))
                <th>
                    <font size="1">Cuenta</font>
                </th>
                @endif

                @if ($request->has('frubro'))
                <th>
                    <font size="1">Rubro</font>
                </th>
                @endif

                @if ($request->has('fcargo'))
                <th>
                    <font size="1">Cargo</font>
                </th>
                @endif

                @if ($request->has('festadosaldo'))
                <th>
                    <font size="1">Pagado/Saldo</font>
                </th>
                @endif

                @if ($request->has('fpagadosaldo'))
                <th>
                    <font size="1">Estado</font>
                </th>
                @endif

                @if ($request->has('fusuario'))
                <th>
                    <font size="1">Usuario</font>
                </th>
                @endif

                @if ($request->has('fpagos'))
                <th>
                    <font size="1">Pagos</font>
                </th>
                @endif

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
            @endphp
            @foreach ($movimientos as $movimiento)
                <tr>
                    @if ($request->has('fid'))
                        <td align="center">
                            <font size="1">
                                <b>{{ $movimiento->codigo }}</b>
                            </font>
                            <font size="1">
                                <p>
                                    @if ($movimiento->estado == 1)
                                        <font color="limegreen">Activo</font>

                                    @elseif ($movimiento->estado == 0)
                                        <font color="red">Eliminado</font>
                                    @endif
                                </p>
                            </font>
                        </td>
                    @endif
                    @if ($request->has('ffecha'))
                    <td align="center">
                        <font size="1">
                            @php
                                $fecha = date('d/m/Y', strtotime($movimiento->fecha));
                            @endphp
                            {{ $fecha }}
                        </font>
                    </td>
                    @endif

                    @if ($request->has('fcuenta'))
                    <td align="center">
                        <font size="1">
                            {{ $movimiento->cuenta->razon_social}}
                        </font>
                    </td>
                    @endif

                    @if ($request->has('frubro'))
                    <td align="center">
                        <font size="1">
                            {{  $movimiento->rubro->nombre}}
                        </font>
                    </td>
                    @endif

                    @if ($request->has('fcargo'))
                    <td align="center">
                        <font size="1" color="gray">
                            <strong>Q.{{ number_format($movimiento->monto_q,2, '.', ',') }}</strong>/$.{{ number_format($movimiento->monto_d,2, '.', ',') }}
                        </font>
                    </td>
                    @endif

                    @php
                        $monto_pagado_q = \App\Models\MovimientoPago::where('movimiento_id', $movimiento->id)->sum('monto_q');
                        $saldo = $movimiento->monto_q - $monto_pagado_q;
                    @endphp

                    @if ($request->has('festadosaldo'))
                    <td align="center">
                        <p>
                            <font size="1" color="limegreen">
                                Q.{{ number_format($monto_pagado_q,2, '.', ',') }}
                            </font>/
                            <font size="1" color="orange">
                                Q.{{ number_format($saldo,2, '.', ',') }}
                            </font>
                        </p>
                    </td>
                    @endif

                    @if ($request->has('fpagadosaldo'))
                    <td align="center">
                        <font size="1">
                            @if($movimiento->monto_q > $monto_pagado_q)
                                <font color="orange">Pendiente</font>

                            @elseif ($movimiento->monto_q <= $monto_pagado_q)
                            <font color="limegreen">Pagado</font>
                            @endif
                        </font>
                    </td>
                    @endif

                    @if ($request->has('fusuario'))
                    <td align="center">
                        <font size="1">
                            @php
                                $usuario = \App\Models\User::find( $movimiento->usuario_id );
                            @endphp
                            <p>{{ $usuario->name }}</p>
                        </font>
                    </td>
                    @endif

                    @php
                        $datos_pagos = \App\Models\MovimientoPago::where('movimiento_id', $movimiento->id)->orderBy('fecha_documento','asc')->get();
                    @endphp

                    @if ($request->has('fpagos'))
                    <td align="center">
                        @if ($datos_pagos->count() > 0)
                        <table class="pure-table pure-table-bordered" Width=100%>
                            <thead>
                                <tr>
                                    <th>
                                        <font size="1">Monto</font>
                                    </th>
                                    <th>
                                        <font size="1">Forma Pago</font>
                                    </th>
                                    <th>
                                        <font size="1">No.Documento</font>
                                    </th>
                                    <th>
                                        <font size="1">Banco</font>
                                    </th>
                                    <th>
                                        <font size="1">No.Cuenta</font>
                                    </th>
                                    <th>
                                        <font size="1">Fecha</font>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($datos_pagos as $dp)
                                    <tr>
                                        <td align="center">
                                            <font size="1">
                                                Q.{{ number_format($dp->monto_q,2, '.', ',') }}
                                            </font>
                                        </td>
                                        <td align="center">
                                            <font size="1">
                                                {{ $dp->forma_pago }}
                                            </font>
                                        </td>
                                        <td align="center">
                                            <font size="1">
                                                {{ $dp->numero_documento }}
                                            </font>
                                        </td>
                                        <td align="center">
                                            <font size="1" color="blue">
                                                {{ $dp->banco }}
                                            </font>
                                        </td>
                                        <td align="center">
                                            <font size="1" color="gray">
                                                {{ $dp->numero_cuenta }}
                                            </font>
                                        </td>
                                        <td align="center">
                                            <font size="1">
                                                @php
                                                    $fechaDoc = date('d/m/Y', strtotime($dp->fecha_documento));
                                                @endphp
                                                <small>{{ $fechaDoc }}</small>
                                            </font>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        @endif
                    </td>
                    @endif

                </tr>
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


                    // $pagado_total = $pagado_total + $monto_pagado_q;
                    // $saldo_total = $saldo_total + $saldo;
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
                    <font size="1">Total</font>
                </th>
                <th>
                    <font size="1">Pagado/Saldo</font>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center">
                    <h2>Total: <font><strong><font color="blue">Q.{{ number_format($monto_total_q,2, '.', ',') }}</font></strong> / <font color="gray">$.{{ number_format($monto_total_d,2, '.', ',') }}</font></strong></font></h2>
                </td>
                <td align="center">
                    <h2><font><strong><font color="limegreen">Q.{{ number_format($pagado_total,2, '.', ',') }}</font></strong> / <strong class="text-warning"><font color="orange">Q.{{ number_format($saldo_total,2, '.', ',') }}</font></strong></font></h2>
                </td>
            </tr>
            {{-- <tr>
                <td align="center">
                    <h2>Total Eliminado: <font><strong><font color="red">Q.{{ number_format($monto_total_q_eliminado,2, '.', ',') }}</font></strong> / <font color="gray">$.{{ number_format($monto_total_d_eliminado,2, '.', ',') }}</font></strong></font></h2>
                </td>
                <td align="center">
                    <h2><font><strong><font color="limegreen">Q.{{ number_format($pagado_total_eliminado,2, '.', ',') }}</font></strong> / <strong class="text-warning"><font color="orange">Q.{{ number_format($saldo_total_eliminado,2, '.', ',') }}</font></strong></font></h2>
                </td>
            </tr> --}}
        </tbody>
    </table>
</body>

</html>
