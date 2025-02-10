@extends('layouts.empresa')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="page-title">
                    <h5>Usuarios de {{ Auth::user()->empresa->nombre }}</h5>
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

            @include('empresa.usuario.search')
            @php
                $today = now();
                $fecha_vencimiento = Auth::user()->empresa->fecha_vencimiento;
                $fecha_gracia = date("Y-m-d", strtotime("+".$config->gracia." months", strtotime($fecha_vencimiento)));

            @endphp
            <!-- Row start -->
            <div class="row gx-3">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        @if ($fecha_gracia >= $today)
                            <div class="card-header">
                                <div class="card-title">
                                    Listado de Usuarios
                                    <a href="{{ url('add-empresa-usuario') }}" type="button" class="btn btn-success float-end">
                                        <i class="bi bi-plus-square"></i> Agregar
                                    </a>
                                </div>

                            </div>
                        @endif

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-striped flex-column">
                                    <thead>
                                        <tr>
                                            <td align="center"><i class="bi bi-list-task"></i></td>
                                            <td>Usuario</td>
                                            <td>Dirección</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <div class="btn-group dropend">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                        <i class="bi bi-list-task"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ url('show-empresa-usuario/'.$user->id) }}"><i class="bi bi-eye-fill text-blue"></i> Información</a>
                                                        </li>
                                                        @if ($fecha_gracia >= $today)
                                                            @if ($Auth::user()->role_as == "0")
                                                                <li>

                                                                    <a class="dropdown-item" href="{{ url('edit-empresa-usuario/'.$user->id) }}"><i class="bi bi-pencil-fill text-warning"></i> Editar</a>
                                                                </li>
                                                                <li>
                                                                    <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $user->id }}">
                                                                        <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endif

                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($user->fotografia != null)
                                                        <img src="{{ asset('assets/uploads/users/'.$user->fotografia) }}" class="img-4x rounded-5 me-3" alt="Usuario" />
                                                    @else
                                                        <img src="{{ asset('assets/uploads/users/userdefault.png') }}" class="img-4x rounded-5 me-3" alt="Usuario" />
                                                    @endif

                                                    <p class="m-0">
                                                        <a class="text-primary" href="{{ url('show-empresa-usuario/'.$user->id) }}"><b>{{ $user->name }}</b></a>

                                                        <br>
                                                        <small>
                                                            <a class="text-info" href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                                            <br>
                                                            <a class="text-light" href="tel:+502{{ $user->telefono }}">{{ $user->telefono }}</a>
                                                            @if ($user->celular != null)
                                                            / <a class="text-light" href="tel:+502{{ $user->celular }}">{{ $user->celular }}</a>

                                                            / <a class="text-success" href="https://wa.me/502{{ $user->celular }}" target="_blank"><i class="bi bi-whatsapp"></i></a>
                                                            @endif
                                                        </small>

                                                    </p>

                                                </div>
                                            </td>
                                            <td><small>{{ $user->direccion }}</small></td>

                                        </tr>
                                        @include('empresa.usuario.deletemodal')
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $users->links() }}
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

