@extends('layouts.empresa')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-fingerprint"></i>
                </div>
                <div class="page-title">
                    <h5>Bitácora</h5>
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

            @include('empresa.bitacora.search')

            <!-- Row start -->
            <div class="row gx-3">
                <div class="col-sm-12 col-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="card-title">
                                Listado de Registros
                                <br>
                                <small class="text-secondary"><u>Filtros:</u></small>
                                <small class="text-muted">

                                    Encontrados: <small class="text-info">{{ $bitacoras->count() }},</small>
                                    @if ($fechaDesdeVista)
                                        Desde: <small class="text-info">{{ $fechaDesdeVista }},</small>
                                    @endif
                                    @if ($fechaHastaVista)
                                        Hasta: <small class="text-info"">{{ $fechaHastaVista }},</small>
                                    @endif
                                    @if (request('usuario_id'))
                                        @php
                                            $usuario = \App\Models\User::find( request('usuario_id') );
                                        @endphp
                                        Usuario:  <small class="text-info">{{ $usuario->name }},</small>
                                    @endif
                                    @if (request('tipo'))
                                        Tipo:  <small class="text-info">{{ request('tipo') }},</small>
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
                                            <td align="center">Fecha</td>
                                            <td align="center">Usuario</td>
                                            <td align="center">Tipo</td>
                                            <td align="left">Descripcion</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bitacoras as $bitacora)
                                        <tr>
                                            <td align="center">
                                                <div class="btn-group dropend">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                        <i class="bi bi-list-task"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ url('show-bitacora/'.$bitacora->id) }}"><i class="bi bi-eye-fill text-blue"></i> Información</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td align="center">
                                                @php
                                                    $fecha = date('d/m/Y', strtotime($bitacora->fecha));
                                                @endphp
                                                <small>{{ $fecha }}</small>
                                            </td>
                                            <td align="center">
                                                @php
                                                    $usuario = \App\Models\User::find( $bitacora->usuario_id );
                                                @endphp
                                                <p>{{ $usuario->name }}</p>
                                            </td>
                                            <td align="center">
                                                <p>{{ $bitacora->tipo}}</p>
                                            </td>
                                            <td align="left">
                                                <p>{{  $bitacora->descripcion}}</p>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- {{ $Bitácoras->links() }} --}}
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

