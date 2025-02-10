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
                                                    @endphp
                                                    <small>{{ $fecha }}</small>
                                                </td>
                                                <td align="center">
                                                    <p>{{ $movimiento->cuenta->razon_social}}</p>
                                                </td>
                                                <td align="center">
                                                    <p>{{  $movimiento->rubro->nombre}}</p>
                                                </td>
                                                <td align="center">
                                                    <p><strong>Q.{{ number_format($movimiento->monto_q,2, '.', ',') }}</strong>/$.{{ number_format($movimiento->monto_d,2, '.', ',') }}</p>
                                                </td>
                                                @php
                                                    $monto_pagado_q = \App\Models\MovimientoPago::where('movimiento_id', $movimiento->id)
                                                    ->sum('monto_q');
                                                    $saldo = $movimiento->monto_q - $monto_pagado_q;
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


                                                // $pagado_total = $pagado_total + $monto_pagado_q;
                                                // $saldo_total = $saldo_total + $saldo;
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
                                {{-- {{ $Movimientos->links() }} --}}
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

