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


            <!-- Row start -->
            <div class="row gx-3">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="custom-tabs-container">
                                <ul class="nav nav-tabs" id="customTab2" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA" role="tab"
                                            aria-controls="oneA" aria-selected="true">Cuenta</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-pat/'.$cuenta->id) }}">
                                                Expedientes
                                            <span class="badge rounded-pill green ms-2">{{ $patscount }}</span>
                                        </a>
                                    </li>
                                    {{-- <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-cat/'.$cuenta->id) }}">
                                                CAT
                                            <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-csj-a/'.$cuenta->id) }}">
                                                CSJ-A
                                            <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-cc-a/'.$cuenta->id) }}">
                                                CC-A
                                            <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-ec/'.$cuenta->id) }}">
                                                EC
                                            <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-pt/'.$cuenta->id) }}">
                                                PT
                                            <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-otros/'.$cuenta->id) }}">
                                                Otros
                                            <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span>
                                        </a>
                                    </li> --}}

                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                                        <!-- Row start -->
                                        <div class="row gx-3">



                                            <div class="col-sm-12 col-12">
                                                <div class="row gx-3">

                                                    <h3><u>Cuenta</u></h3>

                                                    <div class="col-md-12 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            @if ($cuenta->estado == 1)


                                                                {{-- <h5 class="card-title"><u>Informacíon de Paciente</u></h5> --}}
                                                                <a href="{{ url('edit-cuenta/'.$cuenta->id) }}" class="btn btn-warning" aria-current="page"><i class="bi bi-pencil"></i> Editar</a>
                                                                @if (Auth::user()->role_as == 0)
                                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $cuenta->id }}">
                                                                        <i class="bi bi-trash"></i> Eliminar
                                                                    </button>
                                                                    @include('empresa.cuenta.deletemodal')
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Código</label>
                                                            <p>
                                                                <strong>{{ $cuenta->codigo }}</strong>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Razon Social</label>
                                                            <p>
                                                                {{ $cuenta->razon_social }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Nit</label>
                                                            <p>
                                                                {{ $cuenta->nit }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">DPI</label>
                                                            <p>
                                                                {{ $cuenta->dpi }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="contactNumber" class="form-label">Teléfono</label>
                                                            <p>
                                                                <a class="text-info" href="tel:+502{{ $cuenta->telefono }}">{{ $cuenta->telefono }}</a>
                                                            </p>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="emailId" class="form-label">Email</label>
                                                            <p><a class="link-info" href="mailto:{{ $cuenta->correo }}">{{ $cuenta->correo }}</a></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Otra forma de contacto:</label>
                                                            <p>{{ $cuenta->otra_forma_contacto }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Dirección</label>
                                                            <p>{{ $cuenta->direccion }}</p>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <h3><u>Intermediario</u></h3>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Nombre</label>
                                                            <p>
                                                                {{ $cuenta->datos_intermediario_nombre }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="contactNumber" class="form-label">Teléfono</label>
                                                            <p>
                                                                <a class="text-info" href="tel:+502{{ $cuenta->datos_intermediario_telefono }}">{{ $cuenta->datos_intermediario_telefono }}</a>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="emailId" class="form-label">Email</label>
                                                            <p><a class="link-info" href="mailto:{{ $cuenta->datos_intermediario_correo }}">{{ $cuenta->datos_intermediario_correo }}</a></p>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <h3><u>Propietario</u></h3>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Nombre</label>
                                                            <p>
                                                                {{ $cuenta->datos_propietario_nombre }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="contactNumber" class="form-label">Teléfono</label>
                                                            <p>
                                                                <a class="text-info" href="tel:+502{{ $cuenta->datos_propietario_telefono }}">{{ $cuenta->datos_propietario_telefono }}</a>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="emailId" class="form-label">Email</label>
                                                            <p><a class="link-info" href="mailto:{{ $cuenta->datos_propietario_correo }}">{{ $cuenta->datos_propietario_correo }}</a></p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Row end -->
                                    </div>

                                </div>
                                {{-- <div class="tab-pane fade" id="movimientos" role="tabpanel">
                                    <div class="col-md-12 mb-3">
                                        <!-- Form Field Start -->
                                        <div class="mb-3">
                                            <h5 class="form-label">Listado de movimientos</h5>
                                            <p>Cuenta: <strong class="text-primary">{{ $cuenta->razon_social }}</strong></p>
                                            <a href="{{ url('add-movimiento') }}" type="button" class="btn btn-success float-end">
                                                <i class="bi bi-plus-square"></i> Agregar Movimiento
                                            </a>
                                        </div>
                                    </div>

                                        <div class="card-header">
                                            <div class="card-title">


                                            </div>

                                        </div>
                                        <div class="card-body">


                                        </div>

                                </div> --}}
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
