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
                                    <i class="bi bi-plus-square"></i> Agregar
                                </a>
                                <br>
                                <small class="text-secondary"><u>Filtros:</u></small>
                                <small class="text-muted">

                                    Encontrados: <small class="text-info">{{ $movimientos->count() }},</small>
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
                                    @if (request('usuario_id'))
                                        @php
                                            $usuario = \App\Models\User::find( request('usuario_id') );
                                        @endphp
                                        Usuario:  <small class="text-info">{{ $usuario->name }},</small>
                                    @endif
                                </small>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-striped flex-column">
                                    <thead>
                                        <tr>
                                            <td align="center"><i class="bi bi-list-task"></i></td>
                                            <td align="center">ID</td>
                                            <td align="center">Fecha</td>
                                            <td align="center">Cuenta</td>
                                            <td align="center">Rubro</td>
                                            <td align="center">Monto Q.</td>
                                            <td align="center">Monto $.</td>
                                            <td align="center">Usuario</td>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                                        <li>
                                                            <a class="dropdown-item" href="{{ url('edit-movimiento/'.$movimiento->id) }}"><i class="bi bi-pencil-fill text-warning"></i> Editar</a>
                                                        </li>
                                                        @if (Auth::user()->principal == 1)
                                                            <li>
                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $movimiento->id }}">
                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                </a>
                                                            </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </td>
                                            <td align="center">
                                                <strong>{{ $movimiento->id }}</strong>
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
                                                <p><strong>Q.{{ number_format($movimiento->monto_q,2, '.', ',') }}</strong></p>
                                            </td>
                                            <td align="center">
                                                <p>$.{{ number_format($movimiento->monto_d,2, '.', ',') }}</p>
                                            </td>
                                            <td align="center">
                                                @php
                                                    $usuario = \App\Models\User::find( $movimiento->usuario_id );
                                                @endphp
                                                <p>{{ $usuario->name }}</p>
                                            </td>


                                        </tr>
                                        @include('empresa.movimiento.deletemodal')
                                        @endforeach
                                    </tbody>
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

