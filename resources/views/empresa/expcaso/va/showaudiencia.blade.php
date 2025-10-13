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
{{--                                                     @include('empresa.expcaso.pat.print') --}}
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
                                                                        <a class="nav-link active" href="{{ url('show-audiencia/'.$audiencia->id) }}">
                                                                            VA
                                                                            <span class="badge rounded-pill blue ms-2">{{ $audienciasVaCount }}</span>
                                                                        </a>
                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link" href="{{ url('show-pa/'.$pat->id) }}">PA
                                                                            <span class="badge rounded-pill green ms-2">{{ $audienciasPaCount }}</span>
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
                                                                <div class="content-section">
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
                                                                                        <label for="fecha" class="form-label">Fecha de la Audiencia</label>
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
                                                                                            <strong>
                                                                                                @if($audiencia->tipo_audiencia == 'Otro' && $audiencia->tipo_audiencia_otro)
                                                                                                    {{ $audiencia->tipo_audiencia_otro }}
                                                                                                @else
                                                                                                    {{ $audiencia->tipo_audiencia }}
                                                                                                @endif
                                                                                            </strong>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4 mb-3">
                                                                                    <div class="mb-3">
                                                                                        <label for="impuestos" class="form-label">Monto</label>
                                                                                        <p>
                                                                                            {{ $config->currency_simbol }}.{{ number_format($audiencia->impuestos,2, '.', ',') }}
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
                                                                                        <label for="fecha_notificacion" class="form-label">Fecha de Notificación</label>
                                                                                        <p>
                                                                                            @if($audiencia->fecha_notificacion)
                                                                                                <strong class="text-secondary">
                                                                                                    {{ $audiencia->fecha_notificacion instanceof \Carbon\Carbon ? $audiencia->fecha_notificacion->format('d/m/Y') : date('d/m/Y', strtotime($audiencia->fecha_notificacion)) }}
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
                                                                                            @if($audiencia->plazo_evacuar)
                                                                                                @if($audiencia->plazo_evacuar == 'Otro' && $audiencia->plazo_evacuar_otro)
                                                                                                    <strong class="text-primary">{{ $audiencia->plazo_evacuar_otro }}</strong>
                                                                                                @else
                                                                                                    <strong class="text-primary">{{ $audiencia->plazo_evacuar }}</strong>
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
                                                                                                <a class="nav-link active" id="tab-aceptacion" data-bs-toggle="tab" href="#aceptacion" role="tab"
                                                                                                    aria-controls="aceptacion" aria-selected="true">Aceptación
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $aceptaciones->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-ev" data-bs-toggle="tab" href="#ev" role="tab"
                                                                                                    aria-controls="ev" aria-selected="false">EA
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
                                                                                                <a class="nav-link" id="tab-adpmr" data-bs-toggle="tab" href="#adpmr" role="tab"
                                                                                                    aria-controls="adpmr" aria-selected="false">ADPMR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $adpmrs->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-resolucion" data-bs-toggle="tab" href="#resolucion" role="tab"
                                                                                                    aria-controls="resolucion" aria-selected="false"> R-SAT
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $resoluciones->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-rr" data-bs-toggle="tab" href="#rr" role="tab"
                                                                                                    aria-controls="rr" aria-selected="false"> RR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $recursos->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-ntrr" data-bs-toggle="tab" href="#ntrr" role="tab"
                                                                                                    aria-controls="ntrr" aria-selected="false">NTRR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $ntrrs->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-ocurso" data-bs-toggle="tab" href="#ocurso" role="tab"
                                                                                                    aria-controls="ocurso" aria-selected="false">Ocurso
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $ocursos->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-ro" data-bs-toggle="tab" href="#ro" role="tab"
                                                                                                    aria-controls="ro" aria-selected="false">RO
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $ros->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-mpmr" data-bs-toggle="tab" href="#mpmr" role="tab"
                                                                                                    aria-controls="mpmr" aria-selected="false">MPMR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $mpmrs->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-ampmr" data-bs-toggle="tab" href="#ampmr" role="tab"
                                                                                                    aria-controls="ampmr" aria-selected="false">AMPMR
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $ampmrs->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-rtributa" data-bs-toggle="tab" href="#rtributa" role="tab"
                                                                                                    aria-controls="rtributa" aria-selected="false"> R-Tributa
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $rtributas->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-nulidad" data-bs-toggle="tab" href="#nulidad" role="tab"
                                                                                                    aria-controls="nulidad" aria-selected="false"> Nulidad
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $nulidades->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-ec" data-bs-toggle="tab" href="#ec" role="tab"
                                                                                                    aria-controls="ec" aria-selected="false"> EC
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $ecs->count() }}</span>
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
                                                                                                            data-bs-target="#addAceptacionVaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Aceptación
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.va.aceptacion.addaceptacionmodal')

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
                                                                                                                @foreach($aceptaciones as $aceptacion)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        <li>
                                                                                                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editAceptacionVaModal"
                                                                                                                                                data-id="{{ $aceptacion->id }}"
                                                                                                                                                data-fecha_hora_presentacion="{{ $aceptacion->fecha_hora_presentacion }}"
                                                                                                                                                data-numero_documento="{{ $aceptacion->numero_documento }}"
                                                                                                                                                data-observaciones="{{ $aceptacion->observaciones }}"
                                                                                                                                                data-oficina_presentacion="{{ $aceptacion->oficina_presentacion }}"
                                                                                                                                                data-numero_folios="{{ $aceptacion->numero_folios }}"
                                                                                                                                                data-archivo="{{ $aceptacion->archivo }}"
                                                                                                                                                data-audiencia_id="{{ $aceptacion->audiencia_id }}"><i class="bi bi-pencil-square text-warning"></i> Editar</a>
                                                                                                                                        </li>
                                                                                                                                        <li>
                                                                                                                                            <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteAceptacionVaModal"
                                                                                                                                                data-id="{{ $aceptacion->id }}"
                                                                                                                                                data-numero_documento="{{ $aceptacion->numero_documento }}"
                                                                                                                                                data-fecha_hora="{{ $aceptacion->fecha_hora_presentacion }}"><i class="bi bi-trash text-danger"></i> Eliminar</a>
                                                                                                                                        </li>
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>{{ \Carbon\Carbon::parse($aceptacion->fecha_hora_presentacion)->format('d/m/Y H:i') }}</td>
                                                                                                                        <td>{{ $aceptacion->numero_documento }}</td>
                                                                                                                        <td>{{ $aceptacion->numero_folios ?? 'N/A' }}</td>
                                                                                                                        <td>{{ $aceptacion->observaciones ?? 'N/A' }}</td>
                                                                                                                        <td>{{ $aceptacion->oficina_presentacion ?? 'N/A' }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/aceptacions/' . $aceptacion->archivo) }}" target="_blank"><strong class="text-primary">{{ $aceptacion->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $aceptacion->usuario->name ?? 'N/A' }}</td>
                                                                                                                    </tr>
                                                                                                                    @include('empresa.expcaso.va.aceptacion.deleteaceptacionmodal')
                                                                                                                    @include('empresa.expcaso.va.aceptacion.editaceptacionmodal')
                                                                                                                @endforeach
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
                                                                                                            data-bs-target="#addEvVaModal">
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
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Oficina Presentación</td>
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
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editEvVaModal-{{ $ev->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteEvVaModal-{{ $ev->id }}">
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
                                                                                                                    @include('empresa.expcaso.va.ev.deleteevmodal')
                                                                                                                    @include('empresa.expcaso.va.ev.editevmodal')
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
                                                                                                            data-bs-target="#addPpVaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Período de Prueba
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
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Oficina Presentación</td>
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
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editPpVaModal-{{ $pp->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deletePpVaModal-{{ $pp->id }}">
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
                                                                                                                    @include('empresa.expcaso.va.pp.deleteppmodal')
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
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDpmrVaModal">
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
                                                                                                                    <td>Fecha y Hora</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
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
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editDpmrVaModal-{{ $dpmr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteDpmrVaModal-{{ $dpmr->id }}">
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
                                                                                                                    @include('empresa.expcaso.va.dpmr.deletedpmrmodal')
                                                                                                                    @include('empresa.expcaso.va.dpmr.editdpmrmodal')
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
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAdpmrVaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Atención de Diligencia Para Mejor Resolver
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.va.adpmr.addadpmrmodal')

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
                                                                                                                @foreach($adpmrs as $adpmr)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editAdpmrVaModal-{{ $adpmr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteAdpmrVaModal-{{ $adpmr->id }}">
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
                                                                                                                    @include('empresa.expcaso.va.adpmr.deleteadpmrmodal')
                                                                                                                    @include('empresa.expcaso.va.adpmr.editadpmrmodal')
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
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addResolucionVaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar R-SAT
                                                                                                        </button>
                                                                                                    @endif

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
                                                                                                                @foreach($resoluciones as $resolucion)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editResolucionVaModal-{{ $resolucion->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteResolucionVaModal-{{ $resolucion->id }}">
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
                                                                                                                     @include('empresa.expcaso.va.resolucion.deleteresolucionmodal')
                                                                                                                     @include('empresa.expcaso.va.resolucion.editresolucionmodal')
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
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRtributaVaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar R-Tributa
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha de Notificación</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td>Tipo de Resolución</td>
                                                                                                                    <td>Fecha de Resolución</td>
                                                                                                                    <td>Plazo CAT</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($rtributas as $rtributa)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editRtributaVaModal-{{ $rtributa->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteRtributaVaModal-{{ $rtributa->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            @if($rtributa->fecha_hora_notificacion)
                                                                                                                                <strong class="text-secondary">{{ date('d/m/Y H:i', strtotime($rtributa->fecha_hora_notificacion)) }}</strong>
                                                                                                                            @else
                                                                                                                                <span class="text-muted">No definida</span>
                                                                                                                            @endif
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
                                                                                                                            @elseif($rtributa->tipo_resolucion == 'otro')
                                                                                                                                <span class="badge bg-secondary text-white" title="Valor: {{ $rtributa->tipo_resolucion_otro }}">{{ $rtributa->tipo_resolucion_otro ?: 'Otro (sin especificar)' }}</span>
                                                                                                                            @else
                                                                                                                                <span class="badge bg-secondary">No definido</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            @if($rtributa->fecha_resolucion)
                                                                                                                                <strong class="text-info">{{ date('d/m/Y', strtotime($rtributa->fecha_resolucion)) }}</strong>
                                                                                                                            @else
                                                                                                                                <span class="text-muted">N/A</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            @if($rtributa->plazo_cat == 'otro')
                                                                                                                                <span class="badge bg-warning text-dark">{{ $rtributa->plazo_cat_otro ?: 'Otro (sin especificar)' }}</span>
                                                                                                                            @elseif($rtributa->plazo_cat)
                                                                                                                                <span class="badge bg-primary">{{ $rtributa->plazo_cat }}</span>
                                                                                                                            @else
                                                                                                                                <span class="text-muted">N/A</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>{{ $rtributa->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $rtributa->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/rtributas/'.$rtributa->archivo) }}" target="_blank"><strong class="text-primary">{{ $rtributa->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $rtributa->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                     @include('empresa.expcaso.va.rtributa.deletertributamodal')
                                                                                                                     @include('empresa.expcaso.va.rtributa.editrtributamodal')
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
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNulidadVaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Nulidad
                                                                                                        </button>
                                                                                                    @endif

                                                                                                     @include('empresa.expcaso.va.nulidad.addnulidadmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora de Notificación</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td>Fecha de Resolución</td>
                                                                                                                    <td>Tipo de Nulidad</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($nulidades as $nulidad)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editNulidadVaModal-{{ $nulidad->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteNulidadVaModal-{{ $nulidad->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            @if($nulidad->fecha_hora_notificacion)
                                                                                                                                <strong class="text-secondary">
                                                                                                                                    {{ $nulidad->fecha_hora_notificacion instanceof \Carbon\Carbon ? $nulidad->fecha_hora_notificacion->format('d/m/Y H:i') : date('d/m/Y H:i', strtotime($nulidad->fecha_hora_notificacion)) }}
                                                                                                                                </strong>
                                                                                                                            @else
                                                                                                                                <span class="text-muted">No especificada</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>{{ $nulidad->numero_resolucion }}</td>
                                                                                                                        <td>
                                                                                                                            @if($nulidad->fecha_resolucion)
                                                                                                                                <strong class="text-info">{{ date('d/m/Y', strtotime($nulidad->fecha_resolucion)) }}</strong>
                                                                                                                            @else
                                                                                                                                <span class="text-muted">N/A</span>
                                                                                                                            @endif
                                                                                                                        </td>
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
                                                                                                                    @include('empresa.expcaso.va.nulidad.deletenulidadmodal')
                                                                                                                    @include('empresa.expcaso.va.nulidad.editnulidadmodal')
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
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEcVaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar EC (Económico Coactivo)
                                                                                                        </button>
                                                                                                    @endif

                                                                                                     @include('empresa.expcaso.va.ec.addecmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Número de Resolución</td>
                                                                                                                    <td>Fecha y Hora de Notificación</td>
                                                                                                                    <td>Fecha de Resolución</td>
                                                                                                                    <td>Juzgado que Conoce</td>
                                                                                                                    <td>Medidas Decretadas</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                    <td>Fecha de Creación</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($ecs as $ec)
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
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editEcVaModal-{{ $ec->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteEcVaModal-{{ $ec->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>{{ $ec->numero_resolucion }}</td>
                                                                                                                        <td>
                                                                                                                            @if($ec->fecha_hora_notificacion)
                                                                                                                                <strong class="text-secondary">{{ $ec->fecha_hora_notificacion->format('d/m/Y H:i') }}</strong>
                                                                                                                            @else
                                                                                                                                <span class="text-muted">N/A</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            @if($ec->fecha_resolucion)
                                                                                                                                <strong class="text-secondary">{{ $ec->fecha_resolucion->format('d/m/Y') }}</strong>
                                                                                                                            @else
                                                                                                                                <span class="text-muted">N/A</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>{{ $ec->juzgado_que_conoce ?: 'N/A' }}</td>
                                                                                                                        <td>
                                                                                                                            @if($ec->medidas_decretadas && is_array($ec->medidas_decretadas) && count($ec->medidas_decretadas) > 0)
                                                                                                                                @php
                                                                                                                                    $medidas = $ec->medidas_decretadas;
                                                                                                                                    $medidasTexto = [];
                                                                                                                                    foreach($medidas as $medida) {
                                                                                                                                        if($medida === 'Otro' && $ec->medidas_decretadas_otro) {
                                                                                                                                            $medidasTexto[] = 'Otro: ' . $ec->medidas_decretadas_otro;
                                                                                                                                        } else {
                                                                                                                                            $medidasTexto[] = $medida;
                                                                                                                                        }
                                                                                                                                    }
                                                                                                                                @endphp
                                                                                                                                <small class="text-secondary">{{ implode(', ', $medidasTexto) }}</small>
                                                                                                                            @else
                                                                                                                                <span class="text-muted">N/A</span>
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>{{ $ec->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ec->observaciones ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ec->usuario->name }}</td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ $ec->created_at->format('d/m/Y H:i') }}</strong>
                                                                                                                        </td>
                                                                                                                    </tr>
                                                                                                                @endforeach
                                                                                                                @foreach($ecs as $ec)
                                                                                                                     @include('empresa.expcaso.va.ec.showecmodal')
                                                                                                                     @include('empresa.expcaso.va.ec.editecmodal')
                                                                                                                     @include('empresa.expcaso.va.ec.deleteecmodal')
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
                                                                                                            data-bs-target="#addRrVaModal">
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
                                                                                                                    <td>Oficina/Agencia</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
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
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editRrVaModal-{{ $rr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteRrVaModal-{{ $rr->id }}">
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
                                                                                                                        <td>{{ $rr->oficina_agencia_ea ?? 'N/A' }}</td>
                                                                                                                        <td>{{ $rr->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $rr->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/rrs/'.$rr->archivo) }}" target="_blank"><strong class="text-primary">{{ $rr->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $rr->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                     @include('empresa.expcaso.va.rr.deleterrmodal')
                                                                                                                     @include('empresa.expcaso.va.rr.editrrmodal')
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
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNtrrVaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Negativa de Trámite Recurso de Revocatoria
                                                                                                        </button>
                                                                                                    @endif

                                                                                                     @include('empresa.expcaso.va.ntrr.addntrrmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora de Notificación</td>
                                                                                                                    <td>Fecha de Resolución</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($ntrrs as $ntrr)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <button type="button" class="btn bg-gradient-warning dropdown-item" data-bs-toggle="modal" data-bs-target="#editNtrrVaModal-{{ $ntrr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </button>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <button type="button" class="btn bg-gradient-danger dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteNtrrVaModal-{{ $ntrr->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </button>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ $ntrr->fecha_hora_notificacion ? \Carbon\Carbon::parse($ntrr->fecha_hora_notificacion)->format('d/m/Y H:i') : 'N/A' }}</strong>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ $ntrr->fecha_resolucion ? \Carbon\Carbon::parse($ntrr->fecha_resolucion)->format('d/m/Y') : 'N/A' }}</strong>
                                                                                                                        </td>
                                                                                                                        <td>{{ $ntrr->numero_resolucion }}</td>
                                                                                                                        <td>{{ $ntrr->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ntrr->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/ntrrs/'.$ntrr->archivo) }}" target="_blank"><strong class="text-primary">{{ $ntrr->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $ntrr->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                     @include('empresa.expcaso.va.ntrr.deletentrrmodal')
                                                                                                                     @include('empresa.expcaso.va.ntrr.editntrrmodal')
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
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addOcursoVaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Ocurso
                                                                                                        </button>
                                                                                                    @endif

                                                                                                     @include('empresa.expcaso.va.ocurso.addocursomodal')

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
                                                                                                                    <td>Oficina/Agencia</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($ocursos as $ocurso)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editOcursoVaModal-{{ $ocurso->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteOcursoVaModal-{{ $ocurso->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($ocurso->fecha_hora_presentacion)) }}</strong>
                                                                                                                            <span class="text-warning">{{ date('h:i A', strtotime($ocurso->fecha_hora_presentacion)) }}</span>
                                                                                                                        </td>
                                                                                                                        <td>{{ $ocurso->numero_documento }}</td>
                                                                                                                        <td>{{ $ocurso->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ocurso->observaciones }}</td>
                                                                                                                        <td>{{ $ocurso->oficina_agencia_ea ?: 'N/A' }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/ocursos/'.$ocurso->archivo) }}" target="_blank"><strong class="text-primary">{{ $ocurso->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $ocurso->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                     @include('empresa.expcaso.va.ocurso.deleteocursomodal')
                                                                                                                     @include('empresa.expcaso.va.ocurso.editocursomodal')
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
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRoVaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Resolución de Ocurso
                                                                                                        </button>
                                                                                                    @endif

                                                                                                     @include('empresa.expcaso.va.ro.addromodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha (Original)</td>
                                                                                                                    <td>Fecha y Hora de Notificación</td>
                                                                                                                    <td>Fecha de Resolución</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td>Tipo de Resolución</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($ros as $ro)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editRoVaModal-{{ $ro->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteRoVaModal-{{ $ro->id }}">
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
                                                                                                                        <td>
                                                                                                                            @if($ro->fecha_notificacion)
                                                                                                                                <strong class="text-secondary">{{ date('d/m/Y', strtotime($ro->fecha_notificacion)) }}</strong>
                                                                                                                                <span class="text-warning">{{ date('h:i A', strtotime($ro->fecha_notificacion)) }}</span>
                                                                                                                            @else
                                                                                                                                N/A
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            @if($ro->fecha_resolucion)
                                                                                                                                <strong class="text-secondary">{{ date('d/m/Y', strtotime($ro->fecha_resolucion)) }}</strong>
                                                                                                                            @else
                                                                                                                                N/A
                                                                                                                            @endif
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
                                                                                                                     @include('empresa.expcaso.va.ro.deleteromodal')
                                                                                                                     @include('empresa.expcaso.va.ro.editromodal')
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
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMpmrVaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Medida Para Mejor Resolver
                                                                                                        </button>
                                                                                                    @endif

                                                                                                     @include('empresa.expcaso.va.mpmr.addmpmrmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha y Hora de Notificación</td>
                                                                                                                    <td>Fecha de Resolución</td>
                                                                                                                    <td>No. de Resolución</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($mpmrs as $mpmr)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editMpmrVaModal-{{ $mpmr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteMpmrVaModal-{{ $mpmr->id }}">
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
                                                                                                                        <td>
                                                                                                                            @if($mpmr->fecha_resolucion)
                                                                                                                                <strong class="text-secondary">{{ date('d/m/Y', strtotime($mpmr->fecha_resolucion)) }}</strong>
                                                                                                                            @else
                                                                                                                                N/A
                                                                                                                            @endif
                                                                                                                        </td>
                                                                                                                        <td>{{ $mpmr->numero_resolucion }}</td>
                                                                                                                        <td>{{ $mpmr->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $mpmr->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/mpmrs/'.$mpmr->archivo) }}" target="_blank"><strong class="text-primary">{{ $mpmr->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $mpmr->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                     @include('empresa.expcaso.va.mpmr.deletempmrmodal')
                                                                                                                     @include('empresa.expcaso.va.mpmr.editmpmrmodal')
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
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addAmpmrVaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Atención Medidas Para Mejor Resolver
                                                                                                        </button>
                                                                                                    @endif

                                                                                                     @include('empresa.expcaso.va.ampmr.addampmrmodal')

                                                                                                    <br>
                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td>Fecha/Hora Notificación</td>
                                                                                                                    <td>No. de Documento</td>
                                                                                                                    <td>Oficina</td>
                                                                                                                    <td># Folios</td>
                                                                                                                    <td>Observaciones</td>
                                                                                                                    <td>Archivo</td>
                                                                                                                    <td>Usuario</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach($ampmrs as $ampmr)
                                                                                                                    <tr>
                                                                                                                        <td>
                                                                                                                            <div class="btn-group dropend">
                                                                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                                    <i class="bi bi-list-task"></i>
                                                                                                                                </button>
                                                                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                                    <li>
                                                                                                                                        <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editAmpmrVaModal-{{ $ampmr->id }}">
                                                                                                                                            <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                                        </a>
                                                                                                                                    </li>
                                                                                                                                    @if ($cuenta->estado == 1)
                                                                                                                                        @if (Auth::user()->role_as == 0)
                                                                                                                                            <li>
                                                                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteAmpmrVaModal-{{ $ampmr->id }}">
                                                                                                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                                                </a>
                                                                                                                                            </li>
                                                                                                                                        @endif
                                                                                                                                    @endif
                                                                                                                                </ul>
                                                                                                                            </div>
                                                                                                                        </td>
                                                                                                                        <td>
                                                                                                                            <strong class="text-secondary">{{ date('d/m/Y', strtotime($ampmr->fecha_hora_presentacion)) }}</strong>
                                                                                                                            <span class="text-warning">{{ date('h:i A', strtotime($ampmr->fecha_hora_presentacion)) }}</span>
                                                                                                                        </td>
                                                                                                                        <td>{{ $ampmr->numero_documento }}</td>
                                                                                                                        <td>{{ $ampmr->oficina_ea ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ampmr->numero_folios ?: 'N/A' }}</td>
                                                                                                                        <td>{{ $ampmr->observaciones }}</td>
                                                                                                                        <td><a href="{{ asset('uploads/ampmrs/'.$ampmr->archivo) }}" target="_blank"><strong class="text-primary">{{ $ampmr->tipo_archivo }}</strong></a></td>
                                                                                                                        <td>{{ $ampmr->usuario->name }}</td>
                                                                                                                    </tr>
                                                                                                                     @include('empresa.expcaso.va.ampmr.deleteampmrmodal')
                                                                                                                     @include('empresa.expcaso.va.ampmr.editampmrmodal')
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

<!-- MODALES FUERA DEL CONTENEDOR DE TABS -->
@include('empresa.expcaso.va.resolucion.addresolucionmodal')
@include('empresa.expcaso.va.rtributa.addrtributamodal')
@include('empresa.expcaso.va.nulidad.addnulidadmodal')
@include('empresa.expcaso.va.ec.addecmodal')
@include('empresa.expcaso.va.rr.addrrmodal')
@include('empresa.expcaso.va.ntrr.addntrrmodal')
@include('empresa.expcaso.va.ocurso.addocursomodal')
@include('empresa.expcaso.va.ro.addromodal')
@include('empresa.expcaso.va.mpmr.addmpmrmodal')
@include('empresa.expcaso.va.ampmr.addampmrmodal')

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

    // Script para manejar checkboxes "Otro" en modales EC
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.medida-otro-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const targetId = this.getAttribute('data-target');
                const inputId = this.getAttribute('data-input');
                const targetField = document.getElementById(targetId);
                const inputField = document.getElementById(inputId);
                
                if (this.checked) {
                    targetField.style.display = 'block';
                } else {
                    targetField.style.display = 'none';
                    if (inputField) {
                        inputField.value = '';
                    }
                }
            });
        });
    });

    // Script específico para modales NTRR
    $(document).ready(function() {
        // Manejar clicks en botones de editar NTRR
        $(document).on('click', '[data-bs-target*="editNtrrVaModal"]', function(e) {
            e.preventDefault();
            var modalTarget = $(this).attr('data-bs-target');
            $(modalTarget).modal('show');
        });
        
        // Manejar clicks en botones de eliminar NTRR
        $(document).on('click', '[data-bs-target*="deleteNtrrVaModal"]', function(e) {
            e.preventDefault();
            var modalTarget = $(this).attr('data-bs-target');
            $(modalTarget).modal('show');
        });
    });

    // Script para manejar modales de Aceptación VA
    $(document).on('show.bs.modal', '#editAceptacionVaModal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var fecha_hora = button.data('fecha_hora_presentacion');
        var numero_documento = button.data('numero_documento');
        var observaciones = button.data('observaciones');
        var oficina_presentacion = button.data('oficina_presentacion');
        var numero_folios = button.data('numero_folios');
        var archivo = button.data('archivo');
        var audiencia_id = button.data('audiencia_id');

        var modal = $(this);
        modal.find('#edit_fecha_hora_presentacion').val(fecha_hora);
        modal.find('#edit_numero_documento').val(numero_documento);
        modal.find('#edit_observaciones').val(observaciones);
        modal.find('#edit_oficina_presentacion').val(oficina_presentacion);
        modal.find('#edit_numero_folios').val(numero_folios);
        modal.find('#edit_audiencia_id').val(audiencia_id);
        
        if (archivo) {
            modal.find('#current_archivo').html('<small class="text-info">Archivo actual: ' + archivo + '</small>');
        } else {
            modal.find('#current_archivo').html('');
        }

        modal.find('#editAceptacionVaForm').attr('action', '/update-aceptacion/' + id);
    });

    $(document).on('show.bs.modal', '#deleteAceptacionVaModal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var numero_documento = button.data('numero_documento');
        var fecha_hora = button.data('fecha_hora');

        var modal = $(this);
        modal.find('#delete_numero_documento').text(numero_documento);
        modal.find('#delete_fecha_hora').text(fecha_hora);
        modal.find('#deleteAceptacionVaForm').attr('action', '/delete-aceptacion/' + id);
    });
</script>

@endsection
