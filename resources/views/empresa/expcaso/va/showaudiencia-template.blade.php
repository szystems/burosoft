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
                                                            <label for="fullName" class="form-label">Razón Social (Cuenta)</label>
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

                                                    <h3><u>Expediente Digital</u></h3>
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
                                                                            VA
                                                                            <span class="badge rounded-pill blue ms-2">{{ $audienciasVaCount }}</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link active" id="tab-pa" data-bs-toggle="tab" href="#pa" role="tab"
                                                                            aria-controls="pa" aria-selected="true">PA
                                                                            <span class="badge rounded-pill green ms-2">{{ $audienciasPa->count() }}</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link" href="#" onclick="alert('CAT - En desarrollo')">CAT</a>
                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link" href="#" onclick="alert('CSJ - En desarrollo')">CSJ</a>
                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link" href="#" onclick="alert('CC - En desarrollo')">CC</a>
                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link" href="#" onclick="alert('VP - En desarrollo')">VP</a>
                                                                    </li>
                                                                </ul>
                                                                <div class="tab-content" id="customTabContent">

                                                                    <div class="tab-pane fade" id="pf" role="tabpanel">
                                                                        <h4>Procedimineto de Fiscalización (PF)</h4>
                                                                        <hr>
                                                                        {{-- Inicio Tab --}}

                                                                    </div>
                                                                    <div class="tab-pane fade show active" id="pa" role="tabpanel">
                                                                        <h4>Procedimiento Ampliado (PA)</h4>
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

                                                                        @if (session('success'))
                                                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                                <i class="bi bi-check-circle"></i> {{ session('success') }}
                                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                                            </div>
                                                                        @endif

                                                                        @if (session('error'))
                                                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                                            </div>
                                                                        @endif

                                                                        <div class="col-sm-12 col-12">
                                                                            <div class="row gx-3">
                                                                                <h4><strong>Audiencia</strong></h4>
                                                                                {{-- <hr> --}}
                                                                                <div class="col-md-12 mb-3">
                                                                                    <!-- Form Field Start -->
                                                                                    <div class="mb-3">
                                                                                        <button type="button" class="btn btn-warning float-end m-1" data-bs-toggle="modal" data-bs-target="#editAudienciaModal-{{ $audienciaPa->id }}">
                                                                                            <i class="bi bi-pencil"></i> Editar
                                                                                        </button>
                                                                                        <button type="button" class="btn btn-danger float-end m-1" data-bs-toggle="modal" data-bs-target="#deleteAudienciaModal-{{ $audienciaPa->id }}">
                                                                                            <i class="bi bi-trash"></i> Eliminar
                                                                                        </button>
                                                                                    </div>
                                                                                </div>

                                                                                @include('empresa.expcaso.pa.editaudienciamodal')
                                                                                @include('empresa.expcaso.pa.deleteaudienciamodal')


                                                                                <div class="col-md-4 mb-3">
                                                                                    <!-- Form Field Start -->
                                                                                    <div class="mb-3">
                                                                                        <label for="fecha" class="form-label">Fecha de la Audiencia</label>
                                                                                        <p>
                                                                                            @php
                                                                                                $fecha = date('d/m/Y', strtotime($audienciaPa->fecha));
                                                                                            @endphp
                                                                                            {{ $fecha }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="noaudiencia" class="form-label">No. Audiencia</label>
                                                                                        <p>
                                                                                            {{ $audienciaPa->numero_audiencia }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="tipo" class="form-label">Tipo</label>
                                                                                        <p class="text-primary">
                                                                                            <strong>{{ $audienciaPa->tipo_audiencia }}</strong>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="impuestos" class="form-label">Monto</label>
                                                                                        <p>
                                                                                            {{ $config->currency_simbol }}.{{ number_format($audienciaPa->impuestos,2, '.', ',') }}
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="impuestos" class="form-label">Archivo</label>
                                                                                        {{-- <p><strong><a href="{{ asset('uploads/pa/audiencias/'.$audienciaPa->archivo) }}" target="_blank" class="text-blue">{{ $audienciaPa->tipo_archivo }}</a></strong></p> --}}
                                                                                        <p><a class="btn btn-primary" target="blank__" href="{{ asset('uploads/pa/audiencias/'.$audienciaPa->archivo) }}"><i class="bi bi-eye-fill"></i> {{ $audienciaPa->tipo_archivo }}</a></p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="fecha_notificacion" class="form-label">Fecha de Notificación</label>
                                                                                        <p>
                                                                                            @if($audienciaPa->fecha_notificacion)
                                                                                                <strong class="text-secondary">
                                                                                                    {{ $audienciaPa->fecha_notificacion instanceof \Carbon\Carbon ? $audienciaPa->fecha_notificacion->format('d/m/Y') : date('d/m/Y', strtotime($audienciaPa->fecha_notificacion)) }}
                                                                                                </strong>
                                                                                            @else
                                                                                                <span class="text-muted">No especificada</span>
                                                                                            @endif
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="plazo_evacuar" class="form-label">Plazo para Evacuar</label>
                                                                                        <p>
                                                                                            @if($audienciaPa->plazo_evacuar)
                                                                                                @if($audienciaPa->plazo_evacuar == 'Otro' && $audienciaPa->plazo_evacuar_otro)
                                                                                                    <strong class="text-primary">{{ $audienciaPa->plazo_evacuar_otro }}</strong>
                                                                                                @else
                                                                                                    <strong class="text-primary">{{ $audienciaPa->plazo_evacuar }}</strong>
                                                                                                @endif
                                                                                            @else
                                                                                                <span class="text-muted">No especificado</span>
                                                                                            @endif
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="impuestos" class="form-label">Usuario</label>
                                                                                        <p>
                                                                                            {{ $audienciaPa->usuario->name }}
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
                                                                                                <a class="nav-link active" id="tab-aceptacion" data-bs-toggle="tab" href="#aceptacion" role="tab"
                                                                                                    aria-controls="aceptacion" aria-selected="true">Aceptación
                                                                                                    <span class="badge rounded-pill primary ms-2">0</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-ev" data-bs-toggle="tab" href="#ev" role="tab"
                                                                                                    aria-controls="ev" aria-selected="false">EA
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $evacuacionesPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-pp" data-bs-toggle="tab" href="#pp" role="tab"
                                                                                                    aria-controls="pp" aria-selected="false">PP
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $periodosPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-dpmr" data-bs-toggle="tab" href="#dpmr" role="tab"
                                                                                                    aria-controls="dpmr" aria-selected="false">DPMR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $dpmrsPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-adpmr" data-bs-toggle="tab" href="#adpmr" role="tab"
                                                                                                    aria-controls="adpmr" aria-selected="false">ADPMR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $adpmrsPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-resolucion" data-bs-toggle="tab" href="#resolucion" role="tab"
                                                                                                    aria-controls="resolucion" aria-selected="false"> R-SAT
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $rsatPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-rr" data-bs-toggle="tab" href="#rr" role="tab"
                                                                                                    aria-controls="rr" aria-selected="false"> RR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $recursosPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-ntrr" data-bs-toggle="tab" href="#ntrr" role="tab"
                                                                                                    aria-controls="ntrr" aria-selected="false">NTRR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $ntrrsPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-ocurso" data-bs-toggle="tab" href="#ocurso" role="tab"
                                                                                                    aria-controls="ocurso" aria-selected="false">Ocurso
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $ocursosPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-ro" data-bs-toggle="tab" href="#ro" role="tab"
                                                                                                    aria-controls="ro" aria-selected="false">RO
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $rosPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-mpmr" data-bs-toggle="tab" href="#mpmr" role="tab"
                                                                                                    aria-controls="mpmr" aria-selected="false">MPMR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $mpmrsPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-ampmr" data-bs-toggle="tab" href="#ampmr" role="tab"
                                                                                                    aria-controls="ampmr" aria-selected="false">AMPMR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $ampmrsPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-rtributa" data-bs-toggle="tab" href="#rtributa" role="tab"
                                                                                                    aria-controls="rtributa" aria-selected="false"> R-Tributa
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $rtributaPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-nulidad" data-bs-toggle="tab" href="#nulidad" role="tab"
                                                                                                    aria-controls="nulidad" aria-selected="false"> Nulidad
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $nulidadesPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-ec" data-bs-toggle="tab" href="#ec" role="tab"
                                                                                                    aria-controls="ec" aria-selected="false"> EC
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $ecsPa->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                        </ul>
                                                                                        <div class="tab-content" id="customTabContent2">
                                                                                            <div class="tab-pane fade show active" id="aceptacion" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Aceptación</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addAceptacionPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Aceptación
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Documento</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                {{-- Aquí se mostrarán las aceptaciones cuando se implemente --}}
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="ev" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Evacuación  de Audiencia (EA)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addEvPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Evacuación de Audiencia
                                                                                                        </button>
                                                                                                    @endif


                                                                                                    @include('empresa.expcaso.pa.ev.addevmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Documento</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Oficina Presentación</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($evacuacionesPa as $ev)
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
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editEvPaModal-{{ $ev->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteEvPaModal-{{ $ev->id }}">
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
                                                                                                                        <td>{{ $ev->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ev->observaciones }}</td>
                                                                                                                        <td>{{ $ev->oficina_presentacion ?: 'N/A' }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/evacuaciones/'.$ev->archivo) }}" target="_blank"><strong class="text-primary">{{ $ev->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $ev->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                @endforeach
                                                                                                                @foreach($evacuacionesPa as $ev)
                                                                                                                    @include('empresa.expcaso.pa.ev.deleteevmodal')
                                                                                                                    @include('empresa.expcaso.pa.ev.addevmodal')
                                                                                                                    @include('empresa.expcaso.pa.ev.editevmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="pp" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Período de Prueba (PP)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addPpPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Período de Prueba
                                                                                                        </button>
                                                                                                    @endif


                                                                                                    @include('empresa.expcaso.pa.pp.addppmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Documento</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Oficina Presentación</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($periodosPa as $pp)
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
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editPpPaModal-{{ $pp->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deletePpPaModal-{{ $pp->id }}">
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
                                                                                                                        <td>{{ $pp->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $pp->observaciones }}</td>
                                                                                                                        <td>{{ $pp->oficina_presentacion ?: 'N/A' }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/periodos/'.$pp->archivo) }}" target="_blank"><strong class="text-primary">{{ $pp->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $pp->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.pa.pp.deleteppmodal')
                                                                                                                    @include('empresa.expcaso.pa.pp.addppmodal')
                                                                                                                    @include('empresa.expcaso.pa.pp.editppmodal')
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
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDpmrPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Diligencia Para Mejor Resolver
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pa.dpmr.adddpmrmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($dpmrsPa as $dpmr)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editDpmrPaModal-{{ $dpmr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteDpmrPaModal-{{ $dpmr->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($dpmr->fecha_hora)) }}</strong>
                                                                                                                            <span class="text-warning">{{ date('h:i A', strtotime($dpmr->fecha_hora)) }}</span>
                                                                                                                        </td>
                                                                                                                        <td>{{ $dpmr->numero_resolucion }}</td>
                                                                                                                        <td>{{ $dpmr->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $dpmr->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/dpmrs/'.$dpmr->archivo) }}" target="_blank"><strong class="text-primary">{{ $dpmr->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $dpmr->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.pa.dpmr.deletedpmrmodal')
                                                                                                                    @include('empresa.expcaso.pa.dpmr.editdpmrmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="adpmr" role="tabpanel">
                                                                                                <div class="row gx-3">
                                                                                                    <h4>Atención de Diligencias Para Mejor Resolver (ADPMR)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAdpmrPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Atención de Diligencia Para Mejor Resolver
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pa.adpmr.addadpmrmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Documento</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Oficina Presentación</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($adpmrsPa as $adpmr)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editAdpmrPaModal-{{ $adpmr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteAdpmrPaModal-{{ $adpmr->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($adpmr->fecha_hora_presentacion)) }}</strong>
                                                                                                                            <span class="text-warning">{{ date('h:i A', strtotime($adpmr->fecha_hora_presentacion)) }}</span>
                                                                                                                        </td>
                                                                                                                        <td>{{ $adpmr->numero_documento }}</td>
                                                                                                                        <td>{{ $adpmr->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $adpmr->observaciones }}</td>
                                                                                                                        <td>{{ $adpmr->oficina_presentacion ?: 'N/A' }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/adpmrs/'.$adpmr->archivo) }}" target="_blank"><strong class="text-primary">{{ $adpmr->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $adpmr->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.pa.adpmr.deleteadpmrmodal')
                                                                                                                    @include('empresa.expcaso.pa.adpmr.editadpmrmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="resolucion" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>R-SAT</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addResolucionPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar R-SAT
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pa.resolucion.addresolucionmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha de Notificación</td>
                                                                                                                    <td>Fecha de Resolución</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td>Tipo de Resolución</td>
                                                                                                                    <td>PpRR</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($rsatPa as $resolucion)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editResolucionPaModal-{{ $resolucion->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteResolucionPaModal-{{ $resolucion->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            @if($resolucion->fecha_notificacion)
                                                                                                                                <strong class="text-secondary">{{ date('d/m/Y H:i', strtotime($resolucion->fecha_notificacion)) }}</strong>
                                                                                                                            @else
                                                                                                                                <span class="text-muted">N/A</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            @if($resolucion->fecha_resolucion)
                                                                                                                                <strong class="text-primary">{{ date('d/m/Y', strtotime($resolucion->fecha_resolucion)) }}</strong>
                                                                                                                            @else
                                                                                                                                <span class="text-muted">N/A</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>{{ $resolucion->numero_resolucion }}</td>
                                                                                                                        <td>
                                                                                                                            @if($resolucion->tipo_resolucion == 'total a favor')
                                                                                                                                <span class="badge bg-success">Total a favor</span>
                                                                                                                            @elseif($resolucion->tipo_resolucion == 'total en contra')
                                                                                                                                <span class="badge bg-danger">Total en contra</span>
                                                                                                                            @elseif($resolucion->tipo_resolucion == 'parcial')
                                                                                                                                <span class="badge bg-warning">Parcial</span>
                                                                                                                            @elseif($resolucion->tipo_resolucion == 'nulidad')
                                                                                                                                <span class="badge bg-info">Nulidad</span>
                                                                                                                            @elseif($resolucion->tipo_resolucion == 'penal')
                                                                                                                                <span class="badge bg-dark">Penal</span>
                                                                                                                            @elseif($resolucion->tipo_resolucion == 'otro')
                                                                                                                                <span class="badge bg-secondary">{{ $resolucion->tipo_resolucion_otro ?: 'Otro' }}</span>
                                                                                                                            @else
                                                                                                                                <span class="badge bg-secondary">No definido</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            @if($resolucion->plazo_revocatoria)
                                                                                                                                @if($resolucion->plazo_revocatoria == 'otro')
                                                                                                                                    <span class="badge bg-primary">{{ $resolucion->plazo_revocatoria_otro ?: 'Otro' }}</span>
                                                                                                                                @else
                                                                                                                                    <span class="badge bg-primary">{{ $resolucion->plazo_revocatoria }}</span>
                                                                                                                                @endif
                                                                                                                            @else
                                                                                                                                <span class="text-muted">N/A</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>{{ $resolucion->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $resolucion->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/resoluciones/'.$resolucion->archivo) }}" target="_blank"><strong class="text-primary">{{ $resolucion->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $resolucion->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.pa.resolucion.deleteresolucionmodal')
                                                                                                                    @include('empresa.expcaso.pa.resolucion.editresolucionmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="rtributa" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>R-Tributa (Resolución Tribunal Administrativo Tributario y Aduanero)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRtributaPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar R-Tributa
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pa.rtributa.addrtributamodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha de Notificación</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td>Tipo de Resolución</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($rtributaPa as $rtributa)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editRtributaPaModal-{{ $rtributa->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteRtributaPaModal-{{ $rtributa->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($rtributa->fecha)) }}</strong>
                                                                                                                        </td>
                                                                                                                        <td>{{ $rtributa->numero_resolucion }}</td>
                                                                                                                        <td>
                                                                                                                            @if($rtributa->tipo_resolucion == 'total a favor')
                                                                                                                                <span class="badge bg-success">Total a favor</span>
                                                                                                                            @elseif($rtributa->tipo_resolucion == 'total en contra')
                                                                                                                                <span class="badge bg-danger">Total en contra</span>
                                                                                                                            @elseif($rtributa->tipo_resolucion == 'parcial')
                                                                                                                                <span class="badge bg-warning">Parcial</span>
                                                                                                                            @elseif($rtributa->tipo_resolucion == 'nulidad')
                                                                                                                                <span class="badge bg-info">Nulidad</span>
                                                                                                                            @elseif($rtributa->tipo_resolucion == 'penal')
                                                                                                                                <span class="badge bg-dark">Penal</span>
                                                                                                                            @else
                                                                                                                                <span class="badge bg-secondary">No definido</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>{{ $rtributa->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $rtributa->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/rtributas/'.$rtributa->archivo) }}" target="_blank"><strong class="text-primary">{{ $rtributa->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $rtributa->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.pa.rtributa.deletertributamodal')
                                                                                                                    @include('empresa.expcaso.pa.rtributa.editrtributamodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="nulidad" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Nulidad</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNulidadPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Nulidad
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pa.nulidad.addnulidadmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha de Notificación</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td>Tipo de Nulidad</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($nulidadesPa as $nulidad)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editNulidadPaModal-{{ $nulidad->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteNulidadPaModal-{{ $nulidad->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($nulidad->fecha)) }}</strong>
                                                                                                                        </td>
                                                                                                                        <td>{{ $nulidad->numero_resolucion }}</td>
                                                                                                                        <td>
                                                                                                                            @if($nulidad->tipo_nulidad == 'Absoluta')
                                                                                                                                <span class="badge bg-danger">Absoluta</span>
                                                                                                                            @elseif($nulidad->tipo_nulidad == 'Relativa')
                                                                                                                                <span class="badge bg-warning">Relativa</span>
                                                                                                                            @else
                                                                                                                                <span class="badge bg-secondary">No definido</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>{{ $nulidad->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $nulidad->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/nulidades/'.$nulidad->archivo) }}" target="_blank"><strong class="text-primary">{{ $nulidad->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $nulidad->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                @endforeach
                                                                                                                @foreach($nulidadesPa as $nulidad)
                                                                                                                    @include('empresa.expcaso.pa.nulidad.deletenulidadmodal')
                                                                                                                    @include('empresa.expcaso.pa.nulidad.editnulidadmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="ec" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>EC (Económico Coactivo)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEcPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar EC (Económico Coactivo)
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pa.ec.addecmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Número de Resolución</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                    <td>Fecha de Creación</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($ecsPa as $ec)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-info" data-bs-toggle="modal" data-bs-target="#showEcModal-{{ $ec->id }}">
                                                                                                                                            <i class="bi bi-eye-fill text-info"></i> Ver
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editEcPaModal-{{ $ec->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteEcPaModal-{{ $ec->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>{{ $ec->numero_resolucion }}</td>
                                                                                                                        <td>{{ $ec->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ec->observaciones ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ec->usuario->name }}</td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ $ec->created_at->format('d/m/Y H:i') }}</strong>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                @endforeach
                                                                                                                @foreach($ecsPa as $ec)
                                                                                                                    @include('empresa.expcaso.pa.ec.showecmodal')
                                                                                                                    @include('empresa.expcaso.pa.ec.editecmodal')
                                                                                                                    @include('empresa.expcaso.pa.ec.deleteecmodal')
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
                                                                                                            data-bs-target="#addRrPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Recurso de Revocatoria
                                                                                                        </button>
                                                                                                    @endif


                                                                                                    @include('empresa.expcaso.pa.rr.addrrmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Documento</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($recursosPa as $rr)
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
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editRrPaModal-{{ $rr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteRrPaModal-{{ $rr->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif

                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($rr->fecha)) }}</strong>
                                                                                                                            <span class="text-warning">{{ date('h:i A', strtotime($rr->fecha)) }}</span>
                                                                                                                        </td>
                                                                                                                        <td>{{ $rr->numero_escrito }}</td>
                                                                                                                        <td>{{ $rr->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $rr->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/rrs/'.$rr->archivo) }}" target="_blank"><strong class="text-primary">{{ $rr->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $rr->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.pa.rr.deleterrmodal')
                                                                                                                    @include('empresa.expcaso.pa.rr.addrrmodal')
                                                                                                                    @include('empresa.expcaso.pa.rr.editrrmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="ntrr" role="tabpanel">
                                                                                                <div class="row gx-3">
                                                                                                    <h4>Negativa de Trámite Recurso de Revocatoria (NTRR)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNtrrPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Negativa de Trámite Recurso de Revocatoria
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pa.ntrr.addntrrmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha de Notificación</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($ntrrsPa as $ntrr)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editNtrrPaModal-{{ $ntrr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteNtrrPaModal-{{ $ntrr->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($ntrr->fecha)) }}</strong>
                                                                                                                        </td>
                                                                                                                        <td>{{ $ntrr->numero_resolucion }}</td>
                                                                                                                        <td>{{ $ntrr->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ntrr->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/ntrrs/'.$ntrr->archivo) }}" target="_blank"><strong class="text-primary">{{ $ntrr->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $ntrr->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.pa.ntrr.deletentrrmodal')
                                                                                                                    @include('empresa.expcaso.pa.ntrr.editntrrmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="ocurso" role="tabpanel">
                                                                                                <div class="row gx-3">
                                                                                                    <h4>Ocurso</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addOcursoPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Ocurso
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pa.ocurso.addocursomodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Documento</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($ocursosPa as $ocurso)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editOcursoPaModal-{{ $ocurso->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteOcursoPaModal-{{ $ocurso->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($ocurso->fecha)) }}</strong>
                                                                                                                            <span class="text-warning">{{ date('h:i A', strtotime($ocurso->fecha)) }}</span>
                                                                                                                        </td>
                                                                                                                        <td>{{ $ocurso->numero_escrito }}</td>
                                                                                                                        <td>{{ $ocurso->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ocurso->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/ocursos/'.$ocurso->archivo) }}" target="_blank"><strong class="text-primary">{{ $ocurso->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $ocurso->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.pa.ocurso.deleteocursomodal')
                                                                                                                    @include('empresa.expcaso.pa.ocurso.editocursomodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="ro" role="tabpanel">
                                                                                                <div class="row gx-3">
                                                                                                    <h4>Resolución de Ocurso (RO)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRoPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Resolución de Ocurso
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pa.ro.addromodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td>Tipo de Resolución</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($rosPa as $ro)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editRoPaModal-{{ $ro->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteRoPaModal-{{ $ro->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($ro->fecha)) }}</strong>
                                                                                                                        </td>
                                                                                                                        <td>{{ $ro->numero_resolucion }}</td>
                                                                                                                        <td>
                                                                                                                            @if($ro->tipo_resolucion == 'Procede tramite')
                                                                                                                                <span class="badge bg-success">Procede trámite</span>
                                                                                                                            @elseif($ro->tipo_resolucion == 'No procede tramite')
                                                                                                                                <span class="badge bg-danger">No procede trámite (Analizar Amparo)</span>
                                                                                                                            @else
                                                                                                                                <span class="badge bg-secondary">No definido</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>{{ $ro->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ro->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/ros/'.$ro->archivo) }}" target="_blank"><strong class="text-primary">{{ $ro->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $ro->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.pa.ro.deleteromodal')
                                                                                                                    @include('empresa.expcaso.pa.ro.editromodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="mpmr" role="tabpanel">
                                                                                                <div class="row gx-3">
                                                                                                    <h4>Medidas Para Mejor Resolver (MPMR)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMpmrPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Medida Para Mejor Resolver
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pa.mpmr.addmpmrmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($mpmrsPa as $mpmr)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editMpmrPaModal-{{ $mpmr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteMpmrPaModal-{{ $mpmr->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($mpmr->fecha_hora)) }}</strong>
                                                                                                                            <span class="text-warning">{{ date('h:i A', strtotime($mpmr->fecha_hora)) }}</span>
                                                                                                                        </td>
                                                                                                                        <td>{{ $mpmr->numero_resolucion }}</td>
                                                                                                                        <td>{{ $mpmr->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $mpmr->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/mpmrs/'.$mpmr->archivo) }}" target="_blank"><strong class="text-primary">{{ $mpmr->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $mpmr->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.pa.mpmr.deletempmrmodal')
                                                                                                                    @include('empresa.expcaso.pa.mpmr.editmpmrmodal')
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="ampmr" role="tabpanel">
                                                                                                <div class="row gx-3">
                                                                                                    <h4>Atención Medidas Para Mejor Resolver (AMPMR)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAmpmrPaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Atención Medidas Para Mejor Resolver
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pa.ampmr.addampmrmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Documento</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($ampmrsPa as $ampmr)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editAmpmrPaModal-{{ $ampmr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteAmpmrPaModal-{{ $ampmr->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($ampmr->fecha)) }}</strong>
                                                                                                                            <span class="text-warning">{{ date('h:i A', strtotime($ampmr->fecha)) }}</span>
                                                                                                                        </td>
                                                                                                                        <td>{{ $ampmr->numero_contestacion }}</td>
                                                                                                                        <td>{{ $ampmr->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ampmr->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/ampmrs/'.$ampmr->archivo) }}" target="_blank"><strong class="text-primary">{{ $ampmr->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $ampmr->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.pa.ampmr.deleteampmrmodal')
                                                                                                                    @include('empresa.expcaso.pa.ampmr.editampmrmodal')
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
                                                                        <h4>Vía Penal (VP)</h4>
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

<script>
    // Auto-close alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert.alert-dismissible');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>

@endsection
