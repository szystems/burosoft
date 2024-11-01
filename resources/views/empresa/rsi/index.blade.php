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

                                                        @elseif ($movimiento->total_monto_q <= $movimiento->total_pagado)
                                                            <span class="badge shade-light-green">Pagado</span>
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
                                    <tfoot>
                                        <tr>
                                            <td align="right"><p><strong>Total Cargos:</strong></p></td>
                                            <td align="center"><p><strong class="text-blue">Q.{{ number_format($tmonto,2, '.', ',') }}</strong></p></td>
                                            <td align="right"><p><strong>Pagado/Saldo:</strong></p></td>
                                            <td align="center"><p><strong class="text-success">Q.{{ number_format($tpagado,2, '.', ',') }}</strong>/<strong class="text-warning">Q.{{ number_format($tsaldo,2, '.', ',') }}</strong></p></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                {{-- {{ $movimientos->links() }} --}}
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
@endsection

