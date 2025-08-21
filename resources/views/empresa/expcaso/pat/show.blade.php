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
                                                                        <a class="nav-link active" id="tab-pf" data-bs-toggle="tab" href="#pf" role="tab"
                                                                            aria-controls="pf" aria-selected="true">PF</a>
                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link" href="{{ url('show-va/'.$pat->id) }}">
                                                                            VA
                                                                            <span class="badge rounded-pill blue ms-2">{{ $audiencias->count() }}</span>
                                                                        </a>

                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link" href="{{ url('show-pa/'.$pat->id) }}">
                                                                            PA
                                                                            <span class="badge rounded-pill green ms-2">{{ $pat->audienciasPa->count() }}</span>
                                                                        </a>

                                                                    </li>
                                                                    <li class="nav-item" role="presentation">
                                                                        <a class="nav-link" id="tab-vp" data-bs-toggle="tab" href="#vp" role="tab"
                                                                            aria-controls="vp" aria-selected="false">VP</a>
                                                                    </li>
                                                                </ul>
                                                                <div class="tab-content" id="customTabContent">

                                                                    <div class="tab-pane fade show active" id="pf" role="tabpanel">
                                                                        <h4>Procedimineto de Fiscalización (PF)</h4>
                                                                        <hr>
                                                                        {{-- Inicio Tab --}}
                                                                        <div class="col-xxl-12">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <div class="custom-tabs-container">
                                                                                        <ul class="nav nav-tabs" id="patTab" role="tablist">
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link active" id="tab-nombramientos" data-bs-toggle="tab" href="#nombramientos" role="tab"
                                                                                                    aria-controls="nombramientos" aria-selected="true">Nombramientos
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $nombramientos->count() }}</span></a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-notificaciones" data-bs-toggle="tab" href="#notificaciones" role="tab"
                                                                                                    aria-controls="notificaciones" aria-selected="false">Notificaciones<span
                                                                                                        class="badge rounded-pill primary ms-2">{{ $notificaciones->count() }}</span></a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-requerimientos" data-bs-toggle="tab" href="#requerimientos" role="tab"
                                                                                                    aria-controls="requerimientos" aria-selected="false">Requerimientos
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $requerimientos->count() }}</span></a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-atencionrequerimientos" data-bs-toggle="tab" href="#atencionrequerimientos" role="tab"
                                                                                                    aria-controls="atencionrequerimientos" aria-selected="false"> Atención de Requerimientos
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $atencionrequerimientos->count() }}</span></a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-providenciaar" data-bs-toggle="tab" href="#providenciaar" role="tab"
                                                                                                    aria-controls="providenciaar" aria-selected="false"> Providencia (AR)
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $providencias->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-nulidades" data-bs-toggle="tab" href="#nulidades" role="tab"
                                                                                                    aria-controls="nulidades" aria-selected="false"> Nulidades
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $nulidades->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-actasadministrativas" data-bs-toggle="tab" href="#actasadministrativas" role="tab"
                                                                                                    aria-controls="actasadministrativas" aria-selected="false"> Actas Administrativas
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $actasadministrativas->count() }}</span></a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-expedientes" data-bs-toggle="tab" href="#expedientes" role="tab"
                                                                                                    aria-controls="expedientes" aria-selected="false">Expedientes/Antecedentes
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $expedientes->count() }}</span></a>
                                                                                            </li>
                                                                                            <li class="nav-item" role="presentation">
                                                                                                <a class="nav-link" id="tab-raf" data-bs-toggle="tab" href="#raf" role="tab"
                                                                                                    aria-controls="raf" aria-selected="false">Providencias de urgencia (PRAF)
                                                                                                    <span class="badge rounded-pill primary ms-2">{{ $rafs->count() }}</span>
                                                                                                </a>
                                                                                            </li>
                                                                                        </ul>
                                                                                        <div class="tab-content" id="customTabContent2">
                                                                                            <div class="tab-pane fade show active" id="nombramientos" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Nombramientos</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addNombramientoModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Nombramiento
                                                                                                        </button>
                                                                                                    @endif


                                                                                                    @include('empresa.expcaso.pat.nombramiento.addnombramientomodal')

                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td align="center">Fecha</td>
                                                                                                                    <td align="center">No.</td>
                                                                                                                    <td align="left">Nombramientos</td>
                                                                                                                    <td align="left">Período</td>
                                                                                                                    <td align="center">Usuario</td>
                                                                                                                    <td align="center">Archivo</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($nombramientos as $nombramiento)
                                                                                                                <tr>
                                                                                                                    <td align="center">

                                                                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pat/nombramientos'.$nombramiento->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}
                                                                                                                        @if ($cuenta->estado == 1)
                                                                                                                            <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                                                                                data-bs-target="#editarNombramientoModal{{ $nombramiento->id }}">
                                                                                                                                <i class="bi bi-pencil"></i>
                                                                                                                            </button>

                                                                                                                            @if (Auth::user()->role_as == 0)
                                                                                                                                <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteNombramientoModal-{{ $nombramiento->id }}">
                                                                                                                                    <i class="bi bi-trash-fill text-white"></i>
                                                                                                                                </button>
                                                                                                                            @endif

                                                                                                                            @include('empresa.expcaso.pat.nombramiento.editnombramientomodal')
                                                                                                                            @include('empresa.expcaso.pat.nombramiento.deletenombramientomodal')
                                                                                                                        @endif

                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $fecha = date('d/m/Y', strtotime($nombramiento->fecha));
                                                                                                                        @endphp
                                                                                                                        <p class=" text-info">{{ $fecha }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{ $nombramiento->no }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="left">
                                                                                                                        <p>{{ $nombramiento->nombrado_1 }}</p>
                                                                                                                        <p>{{ $nombramiento->nombrado_2 }}</p>
                                                                                                                        <p>{{ $nombramiento->nombrado_3 }}</p>
                                                                                                                        <p>{{ $nombramiento->nombrado_4 }}</p>
                                                                                                                        <p>{{ $nombramiento->nombrado_5 }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="left">
                                                                                                                        <p>{{  $nombramiento->periodo}}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $usuario = \App\Models\User::find( $nombramiento->usuario_id );
                                                                                                                        @endphp
                                                                                                                        <p>{{ $pat->usuario->name }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <strong><a href="{{ asset('assets/uploads/pat/nombramientos/'.$nombramiento->archivo) }}" target="_blank" class="text-blue">{{ $nombramiento->tipo }}</a></strong>
                                                                                                                    </td>


                                                                                                                </tr>
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        @if ($nombramientos->count() == 0)
                                                                                                            <div class="alert alert-warning text-white" role="alert">
                                                                                                                <ul align="center">
                                                                                                                    <p>No se han ingresado nombramientos.</p>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        @endif
                                                                                                        {{-- {{ $Movimientos->links() }} --}}
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="notificaciones" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Notificaciones</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addNotificacionModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Notificación
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pat.notificacion.addnotificacionmodal')

                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td align="center">Fecha/Hora</td>
                                                                                                                    <td align="center">Tipo Notificación</td>
                                                                                                                    <td align="center">Recibió</td>
                                                                                                                    <td align="center">Domicilio Notificación</td>
                                                                                                                    <td align="center">Acto Notificado</td>
                                                                                                                    <td align="center">Plazo de Atención</td>
                                                                                                                    <td align="center">Vencimiento de Plazo</td>
                                                                                                                    <td align="center">Usuario</td>
                                                                                                                    <td align="center">Archivo</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($notificaciones as $notificacion)
                                                                                                                <tr>
                                                                                                                    <td align="center">

                                                                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pat/notificaciones'.$notificacion->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}
                                                                                                                        @if ($cuenta->estado == 1)
                                                                                                                            <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                                                                                data-bs-target="#editarNotificacionModal{{ $notificacion->id }}">
                                                                                                                                <i class="bi bi-pencil"></i>
                                                                                                                            </button>

                                                                                                                            @if (Auth::user()->role_as == 0)
                                                                                                                                <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteNotificacionModal-{{ $notificacion->id }}">
                                                                                                                                    <i class="bi bi-trash-fill text-white"></i>
                                                                                                                                </button>
                                                                                                                            @endif

                                                                                                                            @include('empresa.expcaso.pat.notificacion.editnotificacionmodal')
                                                                                                                            @include('empresa.expcaso.pat.notificacion.deletenotificacionmodal')
                                                                                                                        @endif

                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $fecha = date('d/m/Y', strtotime($notificacion->fecha));
                                                                                                                            $vencimiento_plazo = date('d/m/Y', strtotime($notificacion->vencimiento_plazo));
                                                                                                                        @endphp
                                                                                                                        <p>{{ $fecha }} <font class="text-info"> {{ date('H:i', strtotime($notificacion->hora)) }}</font> </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            <span class="badge shade-light-{{ in_array($notificacion->tipo_notificacion, ["Personalmente", "Por Otro Procedimiento Idóneo"]) ? "green" : "red" }}">{{ $notificacion->tipo_notificacion }}</span>
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            @if ($notificacion->persona_idonea == "No")
                                                                                                                                <span class="badge shade-light-red">Solicitar Nulidad</span>
                                                                                                                                <br>
                                                                                                                            @endif
                                                                                                                            {{ $notificacion->recibio }}

                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            @if ($notificacion->domicilio_notificacion_es)
                                                                                                                                {{ $notificacion->domicilio_notificacion_es }}
                                                                                                                                <br>
                                                                                                                            @endif
                                                                                                                            @if ($notificacion->domicilio_notificacion_es == "Otro")
                                                                                                                                {{ $notificacion->domicilio_notificacion_otro }}
                                                                                                                                <br>
                                                                                                                            @endif
                                                                                                                            @if ($notificacion->domicilio_notificacion)
                                                                                                                                {{ $notificacion->domicilio_notificacion }}
                                                                                                                            @endif
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{  $notificacion->acto_notificado}}
                                                                                                                            @if ($notificacion->folios_notificados != "0")
                                                                                                                                <br>
                                                                                                                                FN:{{ $notificacion->folios_notificados }}
                                                                                                                            @endif
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{  $notificacion->plazo_atencion}}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{  $vencimiento_plazo}}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $usuario = \App\Models\User::find( $notificacion->usuario_id );
                                                                                                                        @endphp
                                                                                                                        <p>{{ $pat->usuario->name }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <strong><a href="{{ asset('assets/uploads/pat/notificaciones/'.$notificacion->archivo) }}" target="_blank" class="text-blue"><p class=" text-info"><u>{{ $notificacion->tipo }}</u></p></a></strong>
                                                                                                                    </td>


                                                                                                                </tr>
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        @if ($notificaciones->count() == 0)
                                                                                                            <div class="alert alert-warning text-white" role="alert">
                                                                                                                <ul align="center">
                                                                                                                    <p>No se han ingresado notificaciones.</p>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        @endif
                                                                                                        {{-- {{ $Movimientos->links() }} --}}
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="requerimientos" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Requerimientos</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addRequerimientoModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Requerimiento
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pat.requerimiento.addrequerimientomodal')

                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td align="center">No</td>
                                                                                                                    <td align="center">Fecha Requerimiento / Fecha Maxima</td>
                                                                                                                    <td align="center">Tipo de Requerimiento</td>
                                                                                                                    <td align="center">Lugar Para Atender</td>
                                                                                                                    <td align="center">Plazo de Atención</td>
                                                                                                                    <td align="center">Tipo de Revisión</td>
                                                                                                                    <td align="center">Usuario</td>
                                                                                                                    <td align="center">Archivo</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($requerimientos as $requerimiento)
                                                                                                                <tr>
                                                                                                                    <td align="center">

                                                                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pat/requerimientos'.$requerimiento->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}
                                                                                                                        @if ($cuenta->estado == 1)
                                                                                                                            <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                                                                                data-bs-target="#editarRequerimientoModal{{ $requerimiento->id }}">
                                                                                                                                <i class="bi bi-pencil"></i>
                                                                                                                            </button>

                                                                                                                            @if (Auth::user()->role_as == 0)
                                                                                                                                <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteRequerimientoModal-{{ $requerimiento->id }}">
                                                                                                                                    <i class="bi bi-trash-fill text-white"></i>
                                                                                                                                </button>
                                                                                                                            @endif

                                                                                                                            @include('empresa.expcaso.pat.requerimiento.editrequerimientomodal')
                                                                                                                            @include('empresa.expcaso.pat.requerimiento.deleterequerimientomodal')
                                                                                                                        @endif

                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{ $requerimiento->no }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $fecha = date('d/m/Y', strtotime($requerimiento->fecha));
                                                                                                                            $fecha_maxima = date('d/m/Y', strtotime($requerimiento->fecha_maxima));
                                                                                                                        @endphp
                                                                                                                        <p><font class="text-info">{{ $fecha }}</font> / <font class="text-warning">{{ $fecha_maxima }}</font></p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{ $requerimiento->tipo_requerimiento }}
                                                                                                                            @if ($requerimiento->tipo_requerimiento == "Otro")
                                                                                                                                <br>
                                                                                                                                {{ $requerimiento->tipo_requerimiento_otro }}
                                                                                                                            @endif
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{  $requerimiento->lugar_atender}}
                                                                                                                            @if ($requerimiento->lugar_atender == "Otro")
                                                                                                                                <br>
                                                                                                                                {{ $requerimiento->lugar_atender_otro }}
                                                                                                                            @endif
                                                                                                                            <br>
                                                                                                                            {{ $requerimiento->domicilio }}
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{  $requerimiento->plazo_atencion}}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{  $requerimiento->tipo_revision}}
                                                                                                                            @if ($requerimiento->tipo_revision == "Otro")
                                                                                                                                <br>
                                                                                                                                {{ $requerimiento->tipo_revision_otro }}
                                                                                                                            @endif
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $usuario = \App\Models\User::find( $requerimiento->usuario_id );
                                                                                                                        @endphp
                                                                                                                        <p>{{ $pat->usuario->name }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <strong><a href="{{ asset('assets/uploads/pat/requerimientos/'.$requerimiento->archivo) }}" target="_blank" class="text-blue">{{ $requerimiento->tipo }}</a></strong>
                                                                                                                    </td>


                                                                                                                </tr>
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        @if ($requerimientos->count() == 0)
                                                                                                            <div class="alert alert-warning text-white" role="alert">
                                                                                                                <ul align="center">
                                                                                                                    <p>No se han ingresado requerimientos.</p>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        @endif
                                                                                                        {{-- {{ $Movimientos->links() }} --}}
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="atencionrequerimientos" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Atención de Requerimientos</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addAtencionRequerimientoModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Atención de Requerimiento
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pat.atencionrequerimiento.addatencionrequerimientomodal')

                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td align="center">No</td>
                                                                                                                    <td align="center">Fecha</td>
                                                                                                                    <td align="center">Forma de Atención</td>
                                                                                                                    <td align="center">Acta Administratíva</td>
                                                                                                                    <td align="center">Atendio</td>
                                                                                                                    <td align="center">Observaciones</td>
                                                                                                                    <td align="center">Usuario</td>
                                                                                                                    <td align="center">Archivo</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($atencionrequerimientos as $atencion)
                                                                                                                <tr>
                                                                                                                    <td align="center">

                                                                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pat/requerimientos'.$requerimiento->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}
                                                                                                                        @if ($cuenta->estado == 1)
                                                                                                                            <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                                                                                data-bs-target="#editarAtencionRequerimientoModal{{ $atencion->id }}">
                                                                                                                                <i class="bi bi-pencil"></i>
                                                                                                                            </button>

                                                                                                                            @if (Auth::user()->role_as == 0)
                                                                                                                                <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteAtencionRequerimientoModal-{{ $atencion->id }}">
                                                                                                                                    <i class="bi bi-trash-fill text-white"></i>
                                                                                                                                </button>
                                                                                                                            @endif

                                                                                                                            @include('empresa.expcaso.pat.atencionrequerimiento.editatencionrequerimientomodal')
                                                                                                                            @include('empresa.expcaso.pat.atencionrequerimiento.deleteatencionrequerimientomodal')
                                                                                                                        @endif
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{ $atencion->no }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $fecha = date('d/m/Y', strtotime($atencion->fecha));
                                                                                                                        @endphp
                                                                                                                        <p><font class="text-info">{{ $fecha }}</font></p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{ $atencion->forma_atencion }}
                                                                                                                            @if ($atencion->forma_atencion == "Otro")
                                                                                                                                <br>
                                                                                                                                {{ $atencion->forma_atencion_otro }}
                                                                                                                            @endif
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{  $atencion->acta_administrativa}}
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{  $atencion->quien_atendio}}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{  $atencion->observaciones}}
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $usuario = \App\Models\User::find( $atencion->usuario_id );
                                                                                                                        @endphp
                                                                                                                        <p>{{ $pat->usuario->name }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <strong><a href="{{ asset('assets/uploads/pat/atencionrequerimientos/'.$atencion->archivo) }}" target="_blank" class="text-blue">{{ $atencion->tipo }}</a></strong>
                                                                                                                    </td>


                                                                                                                </tr>
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        @if ($atencionrequerimientos->count() == 0)
                                                                                                            <div class="alert alert-warning text-white" role="alert">
                                                                                                                <ul align="center">
                                                                                                                    <p>No se han ingresado atenciones de requerimientos.</p>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        @endif
                                                                                                        {{-- {{ $Movimientos->links() }} --}}
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="providenciaar" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Providencia (AR)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addProvidenciaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Providencia
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pat.providencia.addprovidenciamodal')

                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td align="center">No</td>
                                                                                                                    <td align="center">Fecha Providencia</td>
                                                                                                                    <td align="center">Tipo de Providencia</td>
                                                                                                                    <td align="center">Se Admite</td>
                                                                                                                    <td align="center">Observaciones</td>
                                                                                                                    <td align="center">Usuario</td>
                                                                                                                    <td align="center">Archivo</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($providencias as $providencia)
                                                                                                                <tr>
                                                                                                                    <td align="center">

                                                                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pat/providencias'.$providencia->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}
                                                                                                                        @if ($cuenta->estado == 1)
                                                                                                                            <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                                                                                data-bs-target="#editarProvidenciaModal{{ $providencia->id }}">
                                                                                                                                <i class="bi bi-pencil"></i>
                                                                                                                            </button>

                                                                                                                            @if (Auth::user()->role_as == 0)
                                                                                                                                <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteProvidenciaModal-{{ $providencia->id }}">
                                                                                                                                    <i class="bi bi-trash-fill text-white"></i>
                                                                                                                                </button>
                                                                                                                            @endif

                                                                                                                            @include('empresa.expcaso.pat.providencia.editprovidenciamodal')
                                                                                                                            @include('empresa.expcaso.pat.providencia.deleteprovidenciamodal')
                                                                                                                        @endif

                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{ $providencia->no }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $fecha = date('d/m/Y', strtotime($providencia->fecha));
                                                                                                                        @endphp
                                                                                                                        <p><font class="text-info">{{ $fecha }}</font></p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{ $providencia->tipo_providencia }}
                                                                                                                            @if ($providencia->tipo_providencia == "Otro")
                                                                                                                                <br>
                                                                                                                                {{ $providencia->tipo_providencia_otro }}
                                                                                                                            @endif
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{  $providencia->admite}}
                                                                                                                            @if ($providencia->admite == "Otro")
                                                                                                                                <br>
                                                                                                                                {{ $providencia->admite_otro }}
                                                                                                                            @endif
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{  $providencia->observaciones}}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $usuario = \App\Models\User::find( $providencia->usuario_id );
                                                                                                                        @endphp
                                                                                                                        <p>{{ $pat->usuario->name }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <strong><a href="{{ asset('assets/uploads/pat/providencias/'.$providencia->archivo) }}" target="_blank" class="text-blue">{{ $providencia->tipo }}</a></strong>
                                                                                                                    </td>


                                                                                                                </tr>
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        @if ($providencias->count() == 0)
                                                                                                            <div class="alert alert-warning text-white" role="alert">
                                                                                                                <ul align="center">
                                                                                                                    <p>No se han ingresado providencias.</p>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        @endif
                                                                                                        {{-- {{ $Movimientos->links() }} --}}
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="nulidades" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Nulidades</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addNulidadModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Nulidad
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pat.nulidad.addnulidadmodal')

                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td align="center">No</td>
                                                                                                                    <td align="center">Fecha Nulidad</td>
                                                                                                                    <td align="center">Tipo de Nulidad</td>
                                                                                                                    <td align="center">Nueva Notificacion</td>
                                                                                                                    <td align="center">Usuario</td>
                                                                                                                    <td align="center">Archivo</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($nulidades as $nulidad)
                                                                                                                <tr>
                                                                                                                    <td align="center">

                                                                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pat/providencias'.$providencia->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}
                                                                                                                        @if ($cuenta->estado == 1)
                                                                                                                            <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                                                                                data-bs-target="#editarNulidadModal{{ $nulidad->id }}">
                                                                                                                                <i class="bi bi-pencil"></i>
                                                                                                                            </button>

                                                                                                                            @if (Auth::user()->role_as == 0)
                                                                                                                                <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteNulidadModal-{{ $nulidad->id }}">
                                                                                                                                    <i class="bi bi-trash-fill text-white"></i>
                                                                                                                                </button>
                                                                                                                            @endif

                                                                                                                            @include('empresa.expcaso.pat.nulidad.editnulidadmodal')
                                                                                                                            @include('empresa.expcaso.pat.nulidad.deletenulidadmodal')
                                                                                                                        @endif

                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{ $nulidad->no }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $fecha = date('d/m/Y', strtotime($nulidad->fecha));
                                                                                                                        @endphp
                                                                                                                        <p><font class="text-info">{{ $fecha }}</font></p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{ $nulidad->tipo_nulidad }}
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{  $nulidad->nueva_notificacion}}
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $usuario = \App\Models\User::find( $nulidad->usuario_id );
                                                                                                                        @endphp
                                                                                                                        <p>{{ $nulidad->usuario->name }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <strong><a href="{{ asset('assets/uploads/pat/nulidades/'.$nulidad->archivo) }}" target="_blank" class="text-blue">{{ $nulidad->tipo }}</a></strong>
                                                                                                                    </td>


                                                                                                                </tr>
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        @if ($nulidades->count() == 0)
                                                                                                            <div class="alert alert-warning text-white" role="alert">
                                                                                                                <ul align="center">
                                                                                                                    <p>No se han ingresado nulidades.</p>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        @endif
                                                                                                        {{-- {{ $Movimientos->links() }} --}}
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="actasadministrativas" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Actas Administrativas</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addActaAdministrativaModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Acta Administrativa
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pat.actaadministrativa.addactaadministrativamodal')

                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td align="center">Fecha</td>
                                                                                                                    <td align="center">¿Quiénes intervinieron?</td>
                                                                                                                    <td align="center">Tipo Acta</td>
                                                                                                                    <td align="center">Observaciones</td>
                                                                                                                    <td align="center">Usuario</td>
                                                                                                                    <td align="center">Archivo</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($actasadministrativas as $acta)
                                                                                                                <tr>
                                                                                                                    <td align="center">

                                                                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pat/requerimientos'.$requerimiento->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}
                                                                                                                        @if ($cuenta->estado == 1)
                                                                                                                            <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                                                                                data-bs-target="#editarActaAdministrativaModal{{ $acta->id }}">
                                                                                                                                <i class="bi bi-pencil"></i>
                                                                                                                            </button>

                                                                                                                            @if (Auth::user()->role_as == 0)
                                                                                                                                <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteActaAdministrativaModal-{{ $acta->id }}">
                                                                                                                                    <i class="bi bi-trash-fill text-white"></i>
                                                                                                                                </button>
                                                                                                                            @endif

                                                                                                                            @include('empresa.expcaso.pat.actaadministrativa.editactaadministrativamodal')
                                                                                                                            @include('empresa.expcaso.pat.actaadministrativa.deleteactaadministrativamodal')
                                                                                                                        @endif
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $fecha = date('d/m/Y', strtotime($acta->fecha));
                                                                                                                        @endphp
                                                                                                                        <p><font class="text-info">{{ $fecha }}</font></p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{  $acta->quienes_intervinieron}}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{ $acta->tipo_acta }}
                                                                                                                            @if ($acta->tipo_acta_otro == "Otro")
                                                                                                                                <br>
                                                                                                                                {{ $acta->tipo_acta_otro }}
                                                                                                                            @endif
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{  $acta->observaciones}}
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $usuario = \App\Models\User::find( $acta->usuario_id );
                                                                                                                        @endphp
                                                                                                                        <p>{{ $pat->usuario->name }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <strong><a href="{{ asset('assets/uploads/pat/actasadministrativas/'.$acta->archivo) }}" target="_blank" class="text-blue">{{ $acta->tipo }}</a></strong>
                                                                                                                    </td>


                                                                                                                </tr>
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        @if ($actasadministrativas->count() == 0)
                                                                                                            <div class="alert alert-warning text-white" role="alert">
                                                                                                                <ul align="center">
                                                                                                                    <p>No se han ingresado actas administrativas.</p>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        @endif
                                                                                                        {{-- {{ $Movimientos->links() }} --}}
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="expedientes" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Expedientes/Antecedentes</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addExpedienteModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar Expediente/Antecedente
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pat.expediente.addexpedientemodal')

                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td align="center">Fecha</td>
                                                                                                                    <td align="center">Nombre</td>
                                                                                                                    <td align="center">Descripción</td>
                                                                                                                    <td align="center">Usuario</td>
                                                                                                                    <td align="center">Archivo</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($expedientes as $expediente)
                                                                                                                <tr>
                                                                                                                    <td align="center">

                                                                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pat/requerimientos'.$requerimiento->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}
                                                                                                                        @if ($cuenta->estado == 1)
                                                                                                                            <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                                                                                data-bs-target="#editarExpedienteModal{{ $expediente->id }}">
                                                                                                                                <i class="bi bi-pencil"></i>
                                                                                                                            </button>

                                                                                                                            @if (Auth::user()->role_as == 0)
                                                                                                                                <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteExpedienteModal-{{ $expediente->id }}">
                                                                                                                                    <i class="bi bi-trash-fill text-white"></i>
                                                                                                                                </button>
                                                                                                                            @endif

                                                                                                                            @include('empresa.expcaso.pat.expediente.editexpedientemodal')
                                                                                                                            @include('empresa.expcaso.pat.expediente.deleteexpedientemodal')
                                                                                                                        @endif
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $fecha = date('d/m/Y', strtotime($expediente->created_at));
                                                                                                                        @endphp
                                                                                                                        <p>{{ $fecha }} </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{ $expediente->nombre }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{ $expediente->descripcion }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $usuario = \App\Models\User::find( $expediente->usuario_id );
                                                                                                                        @endphp
                                                                                                                        <p>{{ $pat->usuario->name }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <strong><a href="{{ asset('assets/uploads/pat/expedientes/'.$expediente->archivo) }}" target="_blank" class="text-blue">{{ $expediente->tipo }}</a></strong>
                                                                                                                    </td>


                                                                                                                </tr>
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        @if ($expedientes->count() == 0)
                                                                                                            <div class="alert alert-warning text-white" role="alert">
                                                                                                                <ul align="center">
                                                                                                                    <p>No se han ingresado expedientes.</p>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        @endif
                                                                                                        {{-- {{ $Movimientos->links() }} --}}
                                                                                                    </div>

                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade" id="raf" role="tabpanel">
                                                                                                <div class="row gx-3">

                                                                                                    <h4>Providencia de Urgencia (PRAF)</h4>
                                                                                                    <hr>
                                                                                                    @if ($cuenta->estado == 1)
                                                                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                                                            data-bs-target="#addRafModal">
                                                                                                            <i class="bi bi-plus-square"></i> Agregar PRAF
                                                                                                        </button>
                                                                                                    @endif

                                                                                                    @include('empresa.expcaso.pat.raf.addrafmodal')

                                                                                                    <div class="table-responsive">
                                                                                                        <table class="table align-middle table-striped flex-column">
                                                                                                            <thead>
                                                                                                                <tr>
                                                                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                                                                    <td align="center">No</td>
                                                                                                                    <td align="center">Fecha Providencia</td>
                                                                                                                    <td align="center">Tipo de Providencia</td>
                                                                                                                    <td align="center">Se Admite</td>
                                                                                                                    <td align="center">Observaciones</td>
                                                                                                                    <td align="center">Usuario</td>
                                                                                                                    <td align="center">Archivo</td>
                                                                                                                </tr>
                                                                                                            </thead>
                                                                                                            <tbody>
                                                                                                                @foreach ($rafs as $raf)
                                                                                                                <tr>
                                                                                                                    <td align="center">

                                                                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pat/providencias'.$providencia->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}
                                                                                                                        @if ($cuenta->estado == 1)
                                                                                                                            <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                                                                                data-bs-target="#editarRafModal{{ $raf->id }}">
                                                                                                                                <i class="bi bi-pencil"></i>
                                                                                                                            </button>

                                                                                                                            @if (Auth::user()->role_as == 0)
                                                                                                                                <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteRafModal-{{ $raf->id }}">
                                                                                                                                    <i class="bi bi-trash-fill text-white"></i>
                                                                                                                                </button>
                                                                                                                            @endif

                                                                                                                            @include('empresa.expcaso.pat.raf.editrafmodal')
                                                                                                                            @include('empresa.expcaso.pat.raf.deleterafmodal')
                                                                                                                        @endif

                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{ $raf->no }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $fecha = date('d/m/Y', strtotime($raf->fecha));
                                                                                                                        @endphp
                                                                                                                        <p><font class="text-info">{{ $fecha }}</font></p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{ $raf->tipo_providencia }}
                                                                                                                            @if ($raf->tipo_providencia == "Otro")
                                                                                                                                <br>
                                                                                                                                {{ $raf->tipo_providencia_otro }}
                                                                                                                            @endif
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>
                                                                                                                            {{  $raf->admite}}
                                                                                                                            @if ($raf->admite == "Otro")
                                                                                                                                <br>
                                                                                                                                {{ $raf->admite_otro }}
                                                                                                                            @endif
                                                                                                                        </p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <p>{{  $raf->observaciones}}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        @php
                                                                                                                            $usuario = \App\Models\User::find( $raf->usuario_id );
                                                                                                                        @endphp
                                                                                                                        <p>{{ $pat->usuario->name }}</p>
                                                                                                                    </td>
                                                                                                                    <td align="center">
                                                                                                                        <strong><a href="{{ asset('assets/uploads/pat/rafs/'.$raf->archivo) }}" target="_blank" class="text-blue">{{ $raf->tipo }}</a></strong>
                                                                                                                    </td>


                                                                                                                </tr>
                                                                                                                @endforeach
                                                                                                            </tbody>
                                                                                                        </table>
                                                                                                        @if ($rafs->count() == 0)
                                                                                                            <div class="alert alert-warning text-white" role="alert">
                                                                                                                <ul align="center">
                                                                                                                    <p>No se han ingresado PRAF's.</p>
                                                                                                                </ul>
                                                                                                            </div>
                                                                                                        @endif
                                                                                                        {{-- {{ $Movimientos->links() }} --}}
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
                                                                    <div class="tab-pane fade" id="va" role="tabpanel">
                                                                        <h4>Vía Administrativa (VA)</h4>
                                                                        <hr>
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
