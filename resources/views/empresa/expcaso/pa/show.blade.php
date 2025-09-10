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
                                                                        <a class="nav-link" href="{{ url('show-va/'.$pat->id) }}">VA
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

                                                                        <div class="col-sm-12 col-12">
                                                                            <div class="row gx-3">
                                                                                <h4><strong>Listado de Audiencias PA</strong></h4>
                                                                                @if ($cuenta->estado == 1)
                                                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                        data-bs-target="#addAudienciaModal">
                                                                                        <i class="bi bi-plus-square"></i> Agregar Audiencia
                                                                                    </button>
                                                                                @endif


                                                                                @include('empresa.expcaso.pa.addaudienciamodal')

                                                                                <br>

                                                                                <div class="table-responsive">
                                                                                    <table class="table align-middle table-striped flex-column">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                <td align="center">Fecha de la Audiencia</td>
                                                                                                <td align="center">No.Audiencia</td>
                                                                                                <td align="center">Tipo Audiencia</td>
                                                                                                <td align="center">Monto</td>
                                                                                                <td align="center">Fecha Notificación</td>
                                                                                                <td align="center">Plazo Evacuar</td>
                                                                                                <td align="center">Archivo</td>
                                                                                                <td align="center">Usuario</td>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            @foreach ($audienciasPa as $audienciaPa)
                                                                                                <tr>
                                                                                                    <td align="center">
                                                                                                        <div class="btn-group dropend">
                                                                                                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                                                <i class="bi bi-list-task"></i>
                                                                                                            </button>
                                                                                                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                                                <li>
                                                                                                                    <a class="dropdown-item" href="{{ url('show-audiencia-pa/'.$audienciaPa->id) }}"><i class="bi bi-eye-fill text-blue"></i> Información</a>
                                                                                                                </li>
                                                                                                                <li>
                                                                                                                    <a type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editAudienciaModal-{{ $audienciaPa->id }}">
                                                                                                                        <i class="bi bi-pencil-fill text-warning"></i> Editar
                                                                                                                    </a>
                                                                                                                </li>
                                                                                                                @if ($cuenta->estado == 1)
                                                                                                                    @if (Auth::user()->role_as == 0)
                                                                                                                        <li>
                                                                                                                            <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteAudienciaModal-{{ $audienciaPa->id }}">
                                                                                                                                <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                                                                            </a>
                                                                                                                        </li>
                                                                                                                    @endif
                                                                                                                @endif

                                                                                                            </ul>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td align="center">
                                                                                                        @php
                                                                                                            $fecha = date('d/m/Y', strtotime($audienciaPa->fecha));
                                                                                                        @endphp
                                                                                                        <a class="dropdown-item" href="{{ url('show-audiencia-pa/'.$audienciaPa->id) }}">
                                                                                                                <strong class="text-info">{{ $fecha }}</strong>
                                                                                                        </a>
                                                                                                    </td>
                                                                                                    <td align="center">
                                                                                                        <a class="dropdown-item" href="{{ url('show-audiencia-pa/'.$audienciaPa->id) }}">
                                                                                                            <p>{{ $audienciaPa->numero_audiencia }}</p>
                                                                                                        </a>
                                                                                                    </td>
                                                                                                    <td align="center">
                                                                                                        <a class="dropdown-item" href="{{ url('show-audiencia-pa/'.$audienciaPa->id) }}">
                                                                                                            <p class="text-primary">
                                                                                                                <strong>
                                                                                                                    @if($audienciaPa->tipo_audiencia == 'Otro' && $audienciaPa->tipo_audiencia_otro)
                                                                                                                        {{ $audienciaPa->tipo_audiencia_otro }}
                                                                                                                    @else
                                                                                                                        {{ $audienciaPa->tipo_audiencia }}
                                                                                                                    @endif
                                                                                                                </strong>
                                                                                                            </p>
                                                                                                        </a>
                                                                                                    </td>
                                                                                                    <td align="center">
                                                                                                        <p>{{ $config->currency_simbol }}.{{ number_format($audienciaPa->impuestos,2, '.', ',') }}</p>
                                                                                                    </td>
                                                                                                    <td align="center">
                                                                                                        @if($audienciaPa->fecha_notificacion)
                                                                                                            <p class="text-secondary"><strong>
                                                                                                                {{ $audienciaPa->fecha_notificacion instanceof \Carbon\Carbon ? $audienciaPa->fecha_notificacion->format('d/m/Y') : date('d/m/Y', strtotime($audienciaPa->fecha_notificacion)) }}
                                                                                                            </strong></p>
                                                                                                        @else
                                                                                                            <span class="text-muted">-</span>
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    <td align="center">
                                                                                                        @if($audienciaPa->plazo_evacuar)
                                                                                                            @if($audienciaPa->plazo_evacuar == 'Otro' && $audienciaPa->plazo_evacuar_otro)
                                                                                                                <span class="badge bg-primary">{{ $audienciaPa->plazo_evacuar_otro }}</span>
                                                                                                            @else
                                                                                                                <span class="badge bg-info">{{ $audienciaPa->plazo_evacuar }}</span>
                                                                                                            @endif
                                                                                                        @else
                                                                                                            <span class="text-muted">-</span>
                                                                                                        @endif
                                                                                                    </td>
                                                                                                    <td align="center">
                                                                                                        <p><strong><a href="{{ asset('uploads/pa/audiencias/'.$audienciaPa->archivo) }}" target="_blank" class="text-blue">{{ $audienciaPa->tipo_archivo }}</a></strong></p>

                                                                                                    </td>
                                                                                                    <td align="center">
                                                                                                        <a class="dropdown-item" href="{{ url('show-audiencia-pa/'.$audienciaPa->id) }}">
                                                                                                            <p>{{ $audienciaPa->usuario->name }}</p>
                                                                                                        </a>
                                                                                                    </td>

                                                                                                </tr>
                                                                                                @include('empresa.expcaso.pa.deleteaudienciamodal')
                                                                                                @include('empresa.expcaso.pa.addaudienciamodal')
                                                                                                @include('empresa.expcaso.pa.editaudienciamodal')

                                                                                            @endforeach
                                                                                        </tbody>

                                                                                    </table>
                                                                                    {{ $audienciasPa->links() }}
                                                                                </div>
                                                                            </div>
                                                                        </div>


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
@endsection
