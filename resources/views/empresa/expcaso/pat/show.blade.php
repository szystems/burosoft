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
                                        <a class="nav-link" href="{{ url('show-expcaso/'.$cuenta->id) }}">Cuenta</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" href="{{ url('index-pat/'.$cuenta->id) }}">
                                                PAT
                                            {{-- <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span> --}}
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-cat/'.$cuenta->id) }}">
                                                CAT
                                            {{-- <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span> --}}
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-csj-a/'.$cuenta->id) }}">
                                                CSJ-A
                                            {{-- <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span> --}}
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-cc-a/'.$cuenta->id) }}">
                                                CC-A
                                            {{-- <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span> --}}
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-ec/'.$cuenta->id) }}">
                                                EC
                                            {{-- <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span> --}}
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-pt/'.$cuenta->id) }}">
                                                PT
                                            {{-- <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span> --}}
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" href="{{ url('index-otros/'.$cuenta->id) }}">
                                                Otros
                                            {{-- <span class="badge rounded-pill green ms-2">{{ $movimientos->count() }}</span> --}}
                                        </a>
                                    </li>

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
                                                                @if (Auth::user()->principal == 1)
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

                                                    <h3><u>PAT (Procedimiento de Administración Tributaria)</u></h3>
                                                    <hr>

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

                                                    <h4>Nombramientos</h4>
                                                    <hr>

                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#addNombramientoModal">
                                                        <i class="bi bi-plus-square"></i> Agregar Nombramiento
                                                    </button>

                                                    @include('empresa.expcaso.pat.nombramiento.addnombramientomodal')

                                                    <div class="table-responsive">
                                                        <table class="table align-middle table-striped flex-column">
                                                            <thead>
                                                                <tr>
                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                    <td align="center">Fecha</td>
                                                                    <td align="center">No.</td>
                                                                    <td align="left">Nombramientos</td>
                                                                    <td align="left">Periodo</td>
                                                                    <td align="center">Usuario</td>
                                                                    <td align="center">Archivo</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($nombramientos as $nombramiento)
                                                                <tr>
                                                                    <td align="center">

                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pat/nombramientos'.$nombramiento->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}

                                                                        <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                            data-bs-target="#editarNombramientoModal{{ $nombramiento->id }}">
                                                                            <i class="bi bi-pencil"></i>
                                                                        </button>

                                                                        @if (Auth::user()->principal == 1)
                                                                            <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteNombramientoModal-{{ $nombramiento->id }}">
                                                                                <i class="bi bi-trash-fill text-white"></i>
                                                                            </button>
                                                                        @endif

                                                                        @include('empresa.expcaso.pat.nombramiento.editnombramientomodal')
                                                                        @include('empresa.expcaso.pat.nombramiento.deletenombramientomodal')

                                                                    </td>
                                                                    <td align="center">
                                                                        @php
                                                                            $fecha = date('d/m/Y', strtotime($nombramiento->created_at));
                                                                        @endphp
                                                                        <p>{{ $fecha }} - <strong><a href="{{ asset('assets/uploads/pat/nombramientos/'.$nombramiento->archivo) }}" target="_blank" class="text-blue">{{ $nombramiento->nombre }}</a></strong></p>
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

                                                    <h4>Notificaciones</h4>
                                                    <hr>

                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#addNotificacionModal">
                                                        <i class="bi bi-plus-square"></i> Agregar Notificacion
                                                    </button>

                                                    @include('empresa.expcaso.pat.notificacion.addnotificacionmodal')

                                                    <div class="table-responsive">
                                                        <table class="table align-middle table-striped flex-column">
                                                            <thead>
                                                                <tr>
                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                    <td align="center">Fecha</td>
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

                                                                        <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                            data-bs-target="#editarNotificacionModal{{ $notificacion->id }}">
                                                                            <i class="bi bi-pencil"></i>
                                                                        </button>

                                                                        @if (Auth::user()->principal == 1)
                                                                            <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteNotificacionModal-{{ $notificacion->id }}">
                                                                                <i class="bi bi-trash-fill text-white"></i>
                                                                            </button>
                                                                        @endif

                                                                        @include('empresa.expcaso.pat.notificacion.editnotificacionmodal')
                                                                        @include('empresa.expcaso.pat.notificacion.deletenotificacionmodal')

                                                                    </td>
                                                                    <td align="center">
                                                                        @php
                                                                            $fecha = date('d/m/Y', strtotime($notificacion->created_at));
                                                                            $vencimiento_plazo = date('d/m/Y', strtotime($notificacion->vencimiento_plazo));
                                                                        @endphp
                                                                        <p>{{ $fecha }} </p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{ $notificacion->tipo_notificacion }}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{ $notificacion->recibio }}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{  $notificacion->domicilio_notificacion}}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{  $notificacion->acto_notificado}}</p>
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
                                                                        <strong><a href="{{ asset('assets/uploads/pat/notificaciones/'.$notificacion->archivo) }}" target="_blank" class="text-blue">{{ $notificacion->tipo }}</a></strong>
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

                                                    <h4>Requerimientos</h4>
                                                    <hr>

                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#addRequerimientoModal">
                                                        <i class="bi bi-plus-square"></i> Agregar Requerimiento
                                                    </button>

                                                    @include('empresa.expcaso.pat.requerimiento.addrequerimientomodal')

                                                    <div class="table-responsive">
                                                        <table class="table align-middle table-striped flex-column">
                                                            <thead>
                                                                <tr>
                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                    <td align="center">Fecha</td>
                                                                    <td align="center">No</td>
                                                                    <td align="center">Tipo de Requerimiento</td>
                                                                    <td align="center">Lugar Para Atender</td>
                                                                    <td align="center">Plazo de Atención</td>
                                                                    <td align="center">Tipo de Revision</td>
                                                                    <td align="center">Usuario</td>
                                                                    <td align="center">Archivo</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($requerimientos as $requerimiento)
                                                                <tr>
                                                                    <td align="center">

                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pat/requerimientos'.$requerimiento->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}

                                                                        <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                            data-bs-target="#editarRequerimientoModal{{ $requerimiento->id }}">
                                                                            <i class="bi bi-pencil"></i>
                                                                        </button>

                                                                        @if (Auth::user()->principal == 1)
                                                                            <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteRequerimientoModal-{{ $requerimiento->id }}">
                                                                                <i class="bi bi-trash-fill text-white"></i>
                                                                            </button>
                                                                        @endif

                                                                        @include('empresa.expcaso.pat.requerimiento.editrequerimientomodal')
                                                                        @include('empresa.expcaso.pat.requerimiento.deleterequerimientomodal')

                                                                    </td>
                                                                    <td align="center">
                                                                        @php
                                                                            $fecha = date('d/m/Y', strtotime($requerimiento->created_at));
                                                                        @endphp
                                                                        <p>{{ $fecha }} </p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{ $requerimiento->no }}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{ $requerimiento->tipo_requerimiento }}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{  $requerimiento->lugar_atender}}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{  $requerimiento->plazo_atencion}}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{  $requerimiento->tipo_revision}}</p>
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


                                                    <h4>Expediente Digital</h4>
                                                    <hr>

                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#addExpedienteModal">
                                                        <i class="bi bi-plus-square"></i> Agregar Expediente
                                                    </button>

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

                                                                        <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                            data-bs-target="#editarExpedienteModal{{ $expediente->id }}">
                                                                            <i class="bi bi-pencil"></i>
                                                                        </button>

                                                                        @if (Auth::user()->principal == 1)
                                                                            <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteExpedienteModal-{{ $expediente->id }}">
                                                                                <i class="bi bi-trash-fill text-white"></i>
                                                                            </button>
                                                                        @endif

                                                                        @include('empresa.expcaso.pat.expediente.editexpedientemodal')
                                                                        @include('empresa.expcaso.pat.expediente.deleteexpedientemodal')

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
                                                        @if ($requerimientos->count() == 0)
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
