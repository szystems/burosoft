@extends('layouts.empresa')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-folder2-open"></i>
                </div>
                <div class="page-title">
                    <h5>Exp/Caso</h5>
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

            @include('empresa.expcaso.search')

            <!-- Row start -->
            <div class="row gx-3">
                <div class="col-sm-12 col-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="card-title">
                                Seleccione una cuenta:
                                <br>

                                <a href="{{ url('add-cuenta') }}" type="button" class="btn btn-success float-end">
                                    <i class="bi bi-plus-square"></i> Agregar Cuenta
                                </a>

                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-striped flex-column">
                                    <thead>
                                        <tr>
                                            <td align="center"><i class="bi bi-list-task"></i></td>
                                            <td>Cuenta</td>
                                            <td>Nit / DPI</td>
                                            <td>Intermediario</td>
                                            <td>Propietario</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cuentas as $cuenta)
                                        <tr>
                                            <td align="center">
                                                <a type="button" class="btn btn-info m-1" href="{{ url('show-expcaso/'.$cuenta->id) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">

                                                    <p class="m-0">
                                                        <a class="text-primary" href="{{ url('show-expcaso/'.$cuenta->id) }}"><b>{{ $cuenta->codigo }}<br>{{ $cuenta->razon_social }}</b></a>
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

                                        </tr>
                                        @include('empresa.cuenta.deletemodal')
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

