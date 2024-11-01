@extends('layouts.empresa')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-journal-bookmark"></i>
                </div>
                <div class="page-title">
                    <h5>Cuentas</h5>
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

            @include('empresa.cuenta.search')

            <!-- Row start -->
            <div class="row gx-3">
                <div class="col-sm-12 col-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="card-title">
                                Listado de Cuentas
                                <br>
                                <a target="_blank" href="{{ url('pdf-cuentas') }}" type="button" class="btn btn-danger btn-sm">
                                    <i class="bi bi-file-pdf-fill"></i> PDF
                                </a>
                                <a arget="_blank" href="{{ url('exportcuentas') }}" type="button" class="btn btn-success btn-sm">
                                    <i class="bi bi-file-earmark-excel-fill"></i> Excel
                                </a>

                                <a href="{{ url('add-cuenta') }}" type="button" class="btn btn-success float-end">
                                    <i class="bi bi-plus-square"></i> Agregar
                                </a>

                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-striped flex-column">
                                    <thead>
                                        <tr>
                                            <td align="center"><i class="bi bi-list-task"></i></td>
                                            <td align="center">Código</td>
                                            <td>Cuenta</td>
                                            <td>Nit / DPI</td>
                                            <td>Intermediario</td>
                                            <td>Propietario</td>
                                            <td class="text-center">Estado</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cuentas as $cuenta)
                                        <tr>
                                            <td align="center">
                                                <div class="btn-group dropend">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                        <i class="bi bi-list-task"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ url('show-cuenta/'.$cuenta->id) }}"><i class="bi bi-eye-fill text-blue"></i> Información</a>
                                                        </li>
                                                        @if ($cuenta->estado == 1)
                                                            <li>
                                                                <a class="dropdown-item" href="{{ url('edit-cuenta/'.$cuenta->id) }}"><i class="bi bi-pencil-fill text-warning"></i> Editar</a>
                                                            </li>
                                                        @endif

                                                        @if ($cuenta->estado == 1)
                                                            <li>
                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $cuenta->id }}">
                                                                    <i class="bi bi-x-circle-fill text-danger"></i> Cancelar
                                                                </a>
                                                            </li>
                                                        @elseif ($cuenta->estado == 0)
                                                            <li>
                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#activateModal-{{ $cuenta->id }}">
                                                                    <i class="bi bi-bookmark-check-fill text-success"></i> Activar
                                                                </a>
                                                            </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </td>
                                            <td class=" text-center">
                                                <small><strong>{{ $cuenta->codigo }}</strong></small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">

                                                    <p class="m-0">
                                                        <a class="text-primary" href="{{ url('show-cuenta/'.$cuenta->id) }}"><b>{{ $cuenta->razon_social }}</b></a>
                                                        <small>
                                                            <br>
                                                            <a class="text-info" href="mailto:{{ $cuenta->correo }}">{{ $cuenta->correo }}</a>
                                                            <br>
                                                            <a class="text-light" href="tel:+502{{ $cuenta->telefono }}">{{ $cuenta->telefono }}</a>
                                                            <br>
                                                            {{ $cuenta->otra_forma_contacto }}
                                                        </small>
                                                    </p>

                                                </div>
                                            </td>
                                            <td>
                                                <small>Nit: {{ $cuenta->nit }}</small>
                                                <br>
                                                <small>DPI: {{ $cuenta->dpi }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">

                                                    <p class="m-0">
                                                        <b>{{ $cuenta->datos_intermediario_nombre }}</b>
                                                        <small>
                                                            <br>
                                                            <a class="text-info" href="mailto:{{ $cuenta->datos_intermediario_correo }}">{{ $cuenta->datos_intermediario_correo }}</a>
                                                            <br>
                                                            <a class="text-light" href="tel:+502{{ $cuenta->datos_intermediario_telefono }}">{{ $cuenta->datos_intermediario_telefono }}</a>
                                                            {{-- @if ($cuenta->celular != null)
                                                            / <a class="text-light" href="tel:+502{{ $cuenta->celular }}">{{ $cuenta->celular }}</a>

                                                            / <a class="text-success" href="https://wa.me/502{{ $cuenta->celular }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
                                                            @endif --}}
                                                        </small>
                                                    </p>

                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">

                                                    <p class="m-0">
                                                        <b>{{ $cuenta->datos_propietario_nombre }}</b>
                                                        <small>
                                                            <br>
                                                            <a class="text-info" href="mailto:{{ $cuenta->datos_propietario_correo }}">{{ $cuenta->datos_propietario_correo }}</a>
                                                            <br>
                                                            <a class="text-light" href="tel:+502{{ $cuenta->datos_propietario_telefono }}">{{ $cuenta->datos_propietario_telefono }}</a>
                                                            {{-- @if ($cuenta->celular != null)
                                                            / <a class="text-light" href="tel:+502{{ $cuenta->celular }}">{{ $cuenta->celular }}</a>

                                                            / <a class="text-success" href="https://wa.me/502{{ $cuenta->celular }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
                                                            @endif --}}
                                                        </small>
                                                    </p>

                                                </div>
                                            </td>
                                            <td align="center">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    @if($cuenta->estado == 0)
                                                        <span class="badge shade-light-red">Cancelada</span>
                                                    @elseif ($cuenta->estado == 1)
                                                        <span class="badge shade-light-green">Activa</span>
                                                    @endif
                                                </div>
                                            </td>

                                        </tr>
                                        @include('empresa.cuenta.deletemodal')
                                        @include('empresa.cuenta.activatemodal')
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $cuentas->links() }}
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

