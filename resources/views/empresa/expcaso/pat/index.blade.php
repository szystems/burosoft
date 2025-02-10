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
                                        <a class="nav-link active" id="tab-pat" data-bs-toggle="tab" href="#pat" role="tab"
                                            aria-controls="pat" aria-selected="false">
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

                                                    <h3><u>PAT (Procedimiento de Administración Tributaria)</u></h3>

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

                                                    @include('empresa.expcaso.pat.search')

                                                    <h4><strong>Listado de PAT</strong></h4>
                                                    @if ($cuenta->estado == 1)
                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                            data-bs-target="#addPatModal">
                                                            <i class="bi bi-plus-square"></i> Agregar PAT
                                                        </button>
                                                    @endif


                                                    @include('empresa.expcaso.pat.addpatmodal')

                                                    <br>

                                                    <div class="table-responsive">
                                                        <table class="table align-middle table-striped flex-column">
                                                            <thead>
                                                                <tr>
                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                    <td align="center">Fecha</td>
                                                                    <td align="center">No.Expediente</td>
                                                                    <td align="center">No.Programa</td>
                                                                    <td align="center">Gerencia</td>
                                                                    <td align="center">T.Contribuyente</td>
                                                                    <td align="center">Estado</td>
                                                                    <td align="center">Resultado</td>
                                                                    <td align="center">Usuario</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($pats as $pat)
                                                                    <tr>
                                                                        <td align="center">
                                                                            <div class="btn-group dropend">
                                                                                <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                                                    <i class="bi bi-list-task"></i>
                                                                                </button>
                                                                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                                                    <li>
                                                                                        <a class="dropdown-item" href="{{ url('show-pat/'.$pat->id) }}"><i class="bi bi-eye-fill text-blue"></i> Información</a>
                                                                                    </li>
                                                                                    {{-- <li>
                                                                                        <a class="dropdown-item" href="{{ url('edit-pat/'.$pat->id) }}"><i class="bi bi-pencil-fill text-warning"></i> Editar</a>
                                                                                    </li> --}}
                                                                                    @if ($cuenta->estado == 1)
                                                                                        @if (Auth::user()->role_as == 0)
                                                                                            <li>
                                                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $pat->id }}">
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
                                                                                $created = date('d/m/Y', strtotime($pat->created_at));
                                                                                $updated = date('d/m/Y', strtotime($pat->updated_at));
                                                                            @endphp
                                                                            <small>
                                                                                <strong class="text-info">{{ $created }}</strong>
                                                                                {{-- / <strong class="text-warning">{{ $updated }}</strong> --}}
                                                                            </small>
                                                                        </td>
                                                                        <td align="center">
                                                                            <p>{{ $pat->no_expediente }}</p>
                                                                        </td>
                                                                        <td align="center">
                                                                            <p>{{  $pat->no_programa }}</p>
                                                                        </td>
                                                                        <td align="center">
                                                                            <p>{{ $pat->gerencia }}</p>
                                                                        </td>
                                                                        <td align="center">
                                                                            <p>{{ $pat->tipo_contribuyente }}</p>
                                                                        </td>
                                                                        <td align="center">
                                                                            <p>
                                                                                {{-- {{ $pat->estado }} --}}
                                                                                <p>
                                                                                    @if($pat->estado == "Activo")
                                                                                        <span class="badge shade-light-green">{{ $pat->estado }}</span>
                                                                                    @elseif ($pat->estado == "Cerrado")
                                                                                        <span class="badge shade-light-red">{{ $pat->estado }}</span>
                                                                                    @elseif ($pat->estado == "Archivo")
                                                                                        <span class="badge shade-light-yellow">{{ $pat->estado }}</span>
                                                                                    @endif
                                                                                </p>
                                                                            </p>
                                                                        </td>
                                                                        <td align="center">
                                                                            <p>{{ $pat->resultado }}</p>
                                                                        </td>
                                                                        <td align="center">
                                                                            <p>{{ $pat->usuario->name }}</p>
                                                                        </td>

                                                                    </tr>
                                                                    @include('empresa.expcaso.pat.deletemodal')

                                                                @endforeach
                                                            </tbody>

                                                        </table>
                                                        {{ $pats->links() }}
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
