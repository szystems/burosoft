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

            @if (count($errors)>0)
                <div class="alert alert-danger text-white" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>

            @endif

            <!-- Row start -->
            <div class="row gx-3">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="custom-tabs-container">
                                <ul class="nav nav-tabs" id="patTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('show-expcaso/'.$cuenta->id) }}">Cuenta</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" href="{{ url('index-pat/'.$cuenta->id) }}">
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
                                    <div class="tab-pane fade show active" id="pat" role="tabpanel">
                                        <!-- Row start -->
                                        <div class="row gx-3">

                                            <div class="col-md-12 mb-3">
                                                <!-- Form Field Start -->
                                                <div class="mb-3">
                                                    @include('empresa.expcaso.pat.print')
                                                </div>
                                            </div>

                                            <div class="col-sm-12 col-12">
                                                <div class="row gx-3">

                                                    <h3><u>Cuenta</u></h3>
                                                    <hr>

                                                    {{-- <div class="col-md-12 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <a href="{{ url('edit-cuenta/'.$cuenta->id) }}" class="btn btn-warning" aria-current="page"><i class="bi bi-pencil"></i> Editar</a>
                                                            @if ($cuenta->id != 1)
                                                                @if (Auth::user()->role_as == 0)
                                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $cuenta->id }}">
                                                                        <i class="bi bi-trash"></i> Eliminar
                                                                    </button>
                                                                    @include('empresa.cuenta.deletemodal')
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div> --}}

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
                                                            <label for="fullName" class="form-label">Razon Social (Cuenta)</label>
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

                                                    {{-- <div class="col-md-4 mb-3">
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
                                                    </div> --}}

                                                    <h3><u>Expediente</u></h3>
                                                    <hr>
                                                    @if ($cuenta->estado == 1)


                                                        <div class="col-md-12 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <button type="button" class="btn btn-warning float-end m-1" data-bs-toggle="modal" data-bs-target="#editPatModal">
                                                                    <i class="bi bi-pencil"></i> Editar
                                                                </button>
                                                                <button type="button" class="btn btn-danger float-end m-1" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $pat->id }}">
                                                                    <i class="bi bi-trash"></i> Eliminar
                                                                </button>
                                                            </div>
                                                        </div>

                                                        @include('empresa.expcaso.pat.editpatmodal')
                                                        @include('empresa.expcaso.pat.deletemodal')

                                                    @endif

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="no_expediente" class="form-label">No. Expediente</label>
                                                            <p>
                                                                {{ $pat->no_expediente }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="no_programa" class="form-label">No. Programa</label>
                                                            <p>
                                                                {{ $pat->no_programa }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="gerencia" class="form-label">Gerencia</label>
                                                            <p>
                                                                {{ $pat->gerencia }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="tipo_contribuyente" class="form-label">Tipo Contribuyente</label>
                                                            <p>
                                                                {{ $pat->tipo_contribuyente }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="estado" class="form-label">Estado</label>
                                                            <p>
                                                                @if($pat->estado == "Activo")
                                                                    <span class="badge shade-light-green">{{ $pat->estado }}</span>
                                                                @elseif ($pat->estado == "Cerrado")
                                                                    <span class="badge shade-light-red">{{ $pat->estado }}</span>
                                                                @elseif ($pat->estado == "Archivo")
                                                                    <span class="badge shade-light-yellow">{{ $pat->estado }}</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="resultado" class="form-label">Resultado</label>
                                                            <p>
                                                                {{ $pat->resultado }}
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="custom-tabs-container">
                                                                <ul class="nav nav-tabs justify-content-center" id="expTap" role="tablist">
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link" href="{{ url('show-pat/'.$pat->id) }}">PF</a>
                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link" href="{{ url('show-va/'.$pat->id) }}">
                                                                            Va
                                                                            <span class="badge rounded-pill green ms-2">{{ $audiencias->count() }}</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link" id="tab-vp" data-bs-toggle="tab" href="#vp" role="tab"
                                                                            aria-controls="vp" aria-selected="false">VP</a>
                                                                    </li>
                                                                </ul>
                                                                <div class="tab-content" id="customTabContent">

                                                                    <div class="tab-pane fade" id="pf" role="tabpanel">
                                                                        <h4>Procedimineto de Fiscalización (PF)</h4>
                                                                        <hr>
                                                                        {{-- Inicio Tab --}}

                                                                    </div>
                                                                    <div class="tab-pane fade show active" id="va" role="tabpanel">
                                                                        <h4>Vía Administrativa (VA)</h4>
                                                                        <hr>
                                                                        @if (count($errors)>0)
                                                                            <div class="alert alert-danger text-white" role="alert">
                                                                                <ul>
                                                                                    @foreach ($errors->all() as $error)
                                                                                        <li>{{$error}}</li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>

                                                                        @endif

                                                                        <div class="col-sm-12 col-12">
                                                                            <div class="row gx-3">
                                                                                <h4><strong>Audiencia</strong></h4>
                                                                                {{-- <hr> --}}
                                                                                <div class="col-md-12 mb-3">
                                                                                    <!-- Form Field Start -->
                                                                                    <div class="mb-3">
                                                                                        <button type="button" class="btn btn-warning float-end m-1" data-bs-toggle="modal" data-bs-target="#editAudienciaModal-{{ $audiencia->id }}">
                                                                                            <i class="bi bi-pencil"></i> Editar
                                                                                        </button>
                                                                                        <button type="button" class="btn btn-danger float-end m-1" data-bs-toggle="modal" data-bs-target="#deleteAudienciaModal-{{ $audiencia->id }}">
                                                                                            <i class="bi bi-trash"></i> Eliminar
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                                @include('empresa.expcaso.va.editaudienciamodal')
                                                                                @include('empresa.expcaso.va.deleteaudienciamodal')


                                                                                <div class="col-md-4 mb-3">
                                                                                    <!-- Form Field Start -->
                                                                                    <div class="mb-3">
                                                                                        <label for="fecha" class="form-label">Fecha</label>
                                                                                        <p>
                                                                                            @php
                                                                                                $fecha = date('d/m/Y', strtotime($audiencia->fecha));
                                                                                            @endphp
                                                                                            {{ $fecha }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="noaudiencia" class="form-label">No. Audiencia</label>
                                                                                        <p>
                                                                                            {{ $audiencia->numero_audiencia }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="tipo" class="form-label">Tipo</label>
                                                                                        <p class="text-primary">
                                                                                            <strong>{{ $audiencia->tipo_audiencia }}</strong>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="impuestos" class="form-label">Impuestos</label>
                                                                                        <p>
                                                                                            {{ $config->currency_simbol }}.{{ $audiencia->impuestos }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="impuestos" class="form-label">Archivo</label>
                                                                                        {{-- <p><strong><a href="{{ asset('uploads/va/audiencias/'.$audiencia->archivo) }}" target="_blank" class="text-blue">{{ $audiencia->tipo_archivo }}</a></strong></p> --}}
                                                                                        <p><a class="btn btn-primary" target="blank__" href="{{ asset('uploads/va/audiencias/'.$audiencia->archivo) }}"><i class="bi bi-eye-fill"></i> {{ $audiencia->tipo_archivo }}</a></p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="impuestos" class="form-label">Usuario</label>
                                                                                        <p>
                                                                                            {{ $audiencia->usuario->name }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-xxl-12">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <div class="custom-tabs-container">
                                                                                        <ul class="nav nav-tabs" id="patTab" role="tablist">
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link active" id="tab-ev" data-bs-toggle="tab" href="#ev" role="tab"
                                                                                                    aria-controls="ev" aria-selected="true">EV
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $evacuaciones->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-pp" data-bs-toggle="tab" href="#pp" role="tab"
                                                                                                    aria-controls="pp" aria-selected="false">PP
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $periodos->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-dpmr" data-bs-toggle="tab" href="#dpmr" role="tab"
                                                                                                    aria-controls="dpmr" aria-selected="false">DPMR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $dpmrs->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-resolucion" data-bs-toggle="tab" href="#resolucion" role="tab"
                                                                                                    aria-controls="resolucion" aria-selected="false"> Resoluciones
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $resoluciones->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-rr" data-bs-toggle="tab" href="#rr" role="tab"
                                                                                                    aria-controls="rr" aria-selected="false"> RR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $recursos->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                        </ul>
                                                                                        <div class="tab-content" id="customTabContent2">
                                                                                            <div class="tab-pane fade show active" id="ev" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Evacuación  de Audiencia (EV)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addEvModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Evacuación de Audiencia
                                                                                                        </button>
                                                                                                    @endif


                                                                                                    @include('empresa.expcaso.va.ev.addevmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Documento</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($evacuaciones as $ev)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    {{-- <li>
                                                                                                                                        <a class="dropdown-item" href="{{ url('show-ev/'.$ev->id) }}"><i class="bi bi-eye-fill text-blue"></i> Información</a>
                                                                                                                                    </li> --}}
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editEvModal-{{ $ev->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteEvModal-{{ $ev->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif

                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($ev->fecha_hora_presentacion)) }}</strong>
                                                                                                                            <span class="text-warning">{{ date('h:i A', strtotime($ev->fecha_hora_presentacion)) }}</span>
                                                                                                                        </td>
                                                                                                                        <td>{{ $ev->numero_documento }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/evacuaciones/'.$ev->archivo) }}" target="_blank"><strong class="text-primary">{{ $ev->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $ev->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.va.ev.deleteevmodal')
                                                                                                                    @include('empresa.expcaso.va.ev.addevmodal')
                                                                                                                    @include('empresa.expcaso.va.ev.editevmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="pp" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Periodo de Prueba (PP)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addPpModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Periodo de Prueba
                                                                                                        </button>
                                                                                                    @endif


                                                                                                    @include('empresa.expcaso.va.pp.addppmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Documento</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($periodos as $pp)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    {{-- <li>
                                                                                                                                        <a class="dropdown-item" href="{{ url('show-pp/'.$pp->id) }}"><i class="bi bi-eye-fill text-blue"></i> Información</a>
                                                                                                                                    </li> --}}
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editPpModal-{{ $pp->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deletePpModal-{{ $pp->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif

                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($pp->fecha_hora_presentacion)) }}</strong>
                                                                                                                            <span class="text-warning">{{ date('h:i A', strtotime($pp->fecha_hora_presentacion)) }}</span>
                                                                                                                        </td>
                                                                                                                        <td>{{ $pp->numero_documento }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/periodos/'.$pp->archivo) }}" target="_blank"><strong class="text-primary">{{ $pp->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $pp->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.va.pp.deleteppmodal')
                                                                                                                    @include('empresa.expcaso.va.pp.addppmodal')
                                                                                                                    @include('empresa.expcaso.va.pp.editppmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>


                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="dpmr" role="tabpanel">
                                                                                                <div class="row gx-3">
                                                                                                    <h4>Diligencias Para Mejor Resolver (DPMR)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDpmrModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Diligencia Para Mejor Resolver
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.va.dpmr.adddpmrmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($dpmrs as $dpmr)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editDpmrModal-{{ $dpmr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteDpmrModal-{{ $dpmr->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($dpmr->fecha)) }}</strong>
                                                                                                                        </td>
                                                                                                                        <td>{{ $dpmr->numero_resolucion }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/dpmrs/'.$dpmr->archivo) }}" target="_blank"><strong class="text-primary">{{ $dpmr->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $dpmr->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.va.dpmr.deletedpmrmodal')
                                                                                                                    @include('empresa.expcaso.va.dpmr.editdpmrmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="resolucion" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Resoluciones</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addResolucionModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Resolución
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.va.resolucion.addresolucionmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($resoluciones as $resolucion)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editResolucionModal-{{ $resolucion->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteResolucionModal-{{ $resolucion->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($resolucion->fecha)) }}</strong>
                                                                                                                        </td>
                                                                                                                        <td>{{ $resolucion->numero_resolucion }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/resoluciones/'.$resolucion->archivo) }}" target="_blank"><strong class="text-primary">{{ $resolucion->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $resolucion->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.va.resolucion.deleteresolucionmodal')
                                                                                                                    @include('empresa.expcaso.va.resolucion.editresolucionmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="rr" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Recurso de Revocatorias (RR)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addRrModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Recurso de Revocatoria
                                                                                                        </button>
                                                                                                    @endif


                                                                                                    @include('empresa.expcaso.va.rr.addrrmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Documento</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($recursos as $rr)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    {{-- <li>
                                                                                                                                        <a class="dropdown-item" href="{{ url('show-pp/'.$pp->id) }}"><i class="bi bi-eye-fill text-blue"></i> Información</a>
                                                                                                                                    </li> --}}
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editRrModal-{{ $rr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteRrModal-{{ $rr->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif

                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($rr->fecha_hora_presentacion)) }}</strong>
                                                                                                                            <span class="text-warning">{{ date('h:i A', strtotime($rr->fecha_hora_presentacion)) }}</span>
                                                                                                                        </td>
                                                                                                                        <td>{{ $rr->numero_documento }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/rrs/'.$rr->archivo) }}" target="_blank"><strong class="text-primary">{{ $rr->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $rr->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.va.rr.deleterrmodal')
                                                                                                                    @include('empresa.expcaso.va.rr.addrrmodal')
                                                                                                                    @include('empresa.expcaso.va.rr.editrrmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        {{-- Fin Tab --}}
                                                                    </div>
                                                                    <div class="tab-pane fade" id="vp" role="tabpanel">
                                                                        <h4>Vía Procedural (VP)</h4>
                                                                        <hr>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Row end -->
                                    </div>

                                </div>

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
