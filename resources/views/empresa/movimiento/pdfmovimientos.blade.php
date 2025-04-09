<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cuentas Por Cobrar</title>
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
        .red { color: #FF0000; }
    </style>
</head>

<body>
    @if($imagen)
    <center>
        <img align="center" src="{{ $imagen }}" alt="" height="80">
    </center>
    @endif
    <h3 align="center"><u>Cuentas Por Cobrar</u></h3>
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
        <strong><u>{{ __('Filtros:') }}</u></strong>
        <span>Desde: <span class="blue">{{ $fechaDesdeVista }}</span></span>
        <span>Hasta: <span class="blue">{{ $fechaHastaVista }}</span></span>
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
        <span>Rubro:
            <span class="blue">
                @if ($request->input('ffrubro') != null)
                    @php
                        $rubro = \App\Models\Rubro::find($request->input('ffrubro'));
                    @endphp
                    {{ $rubro->nombre }}
                @else
                    Todos
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
        <span>Usuario:
            <span class="blue">
                @if ($request->input('ffusuario') != null)
                    @php
                        $usuario = \App\Models\User::find($request->input('ffusuario'));
                    @endphp
                    {{ $usuario->name }}
                @else
                    Todos
                @endif
            </span>
        </span>
    </div>

    <h5><u>Cuentas:</u></h5>
    <table>
        <thead>
            <tr>
                @if ($request->has('fid'))
                    <th>Código</th>
                @endif

                @if ($request->has('ffecha'))
                    <th>Fecha</th>
                @endif

                @if ($request->has('fcuenta'))
                    <th>Cuenta</th>
                @endif

                @if ($request->has('frubro'))
                    <th>Rubro</th>
                @endif

                @if ($request->has('fcargo'))
                    <th>Cargo</th>
                @endif

                @if ($request->has('festadosaldo'))
                    <th>Pagado/Saldo</th>
                @endif

                @if ($request->has('fpagadosaldo'))
                    <th>Estado</th>
                @endif

                @if ($request->has('fusuario'))
                    <th>Usuario</th>
                @endif

                @if ($request->has('fpagos'))
                    <th>Pagos</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $pagado_total = 0;
                $saldo_total = 0;
            @endphp
            @foreach ($movimientos as $movimiento)
                @php
                    $monto_pagado_q = $pagosPorMovimiento[$movimiento->id] ?? 0;
                    $saldo = $movimiento->monto_q - $monto_pagado_q;

                    if ($movimiento->estado == 1) {
                        $pagado_total += $monto_pagado_q;
                        $saldo_total += $saldo;
                    }
                @endphp
                <tr>
                    @if ($request->has('fid'))
                        <td>
                            <b>{{ $movimiento->codigo }}</b>
                            <p>
                                @if ($movimiento->estado == 1)
                                    <span class="green">Activo</span>
                                @elseif ($movimiento->estado == 0)
                                    <span class="red">Eliminado</span>
                                @endif
                            </p>
                        </td>
                    @endif

                    @if ($request->has('ffecha'))
                        <td>
                            {{ date('d/m/Y', strtotime($movimiento->fecha)) }}
                        </td>
                    @endif

                    @if ($request->has('fcuenta'))
                        <td>
                            {{ $movimiento->cuenta->razon_social }}
                        </td>
                    @endif

                    @if ($request->has('frubro'))
                        <td>
                            {{ $movimiento->rubro->nombre }}
                        </td>
                    @endif

                    @if ($request->has('fcargo'))
                        <td>
                            <span class="gray">
                                <strong>Q.{{ number_format($movimiento->monto_q,2, '.', ',') }}</strong>/$.{{ number_format($movimiento->monto_d,2, '.', ',') }}
                            </span>
                        </td>
                    @endif

                    @if ($request->has('festadosaldo'))
                        <td>
                            <span class="green">
                                Q.{{ number_format($monto_pagado_q,2, '.', ',') }}
                            </span>/
                            <span class="orange">
                                Q.{{ number_format($saldo,2, '.', ',') }}
                            </span>
                        </td>
                    @endif

                    @if ($request->has('fpagadosaldo'))
                        <td>
                            @if($movimiento->monto_q > $monto_pagado_q)
                                <span class="orange">Pendiente</span>
                            @elseif ($movimiento->monto_q <= $monto_pagado_q)
                                <span class="green">Pagado</span>
                            @endif
                        </td>
                    @endif

                    @if ($request->has('fusuario'))
                        <td>
                            {{ $movimiento->usuario->name ?? 'N/A' }}
                        </td>
                    @endif

                    @if ($request->has('fpagos') && isset($pagosDetallados[$movimiento->id]))
                        <td>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Monto</th>
                                        <th>Forma Pago</th>
                                        <th>Documento</th>
                                        <th>Banco</th>
                                        <th>Cuenta</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pagosDetallados[$movimiento->id] as $dp)
                                        <tr>
                                            <td>Q.{{ number_format($dp->monto_q,2, '.', ',') }}</td>
                                            <td>{{ $dp->forma_pago }}</td>
                                            <td>{{ $dp->numero_documento }}</td>
                                            <td class="blue">{{ $dp->banco }}</td>
                                            <td class="gray">{{ $dp->numero_cuenta }}</td>
                                            <td>{{ date('d/m/Y', strtotime($dp->fecha_documento)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    @elseif ($request->has('fpagos'))
                        <td>Sin pagos</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4><strong><u>Resumen</u></strong></h4>
    <table>
        <thead>
            <tr>
                <th>Total</th>
                <th>Pagado/Saldo</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center">
                    <h3>Total: <span class="blue">Q.{{ number_format($monto_total_q,2, '.', ',') }}</span> / <span class="gray">$.{{ number_format($monto_total_d,2, '.', ',') }}</span></h3>
                </td>
                <td align="center">
                    <h3><span class="green">Q.{{ number_format($pagado_total,2, '.', ',') }}</span> / <span class="orange">Q.{{ number_format($saldo_total,2, '.', ',') }}</span></h3>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
