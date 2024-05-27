@extends('layouts.empresa')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-coin"></i>
                </div>
                <div class="page-title">
                    <h5>Rubros</h5>
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

            @include('empresa.rubro.search')

            <!-- Row start -->
            <div class="row gx-3">
                <div class="col-sm-12 col-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="card-title">
                                Listado de Rubros
                                {{-- <br>
                                <a target="_blank" href="{{ url('pdf-rubros') }}" type="button" class="btn btn-danger btn-sm">
                                    <i class="bi bi-file-pdf-fill"></i> PDF
                                </a>
                                <a arget="_blank" href="{{ url('exportrubros') }}" type="button" class="btn btn-success btn-sm">
                                    <i class="bi bi-file-earmark-excel-fill"></i> Excel
                                </a> --}}

                                <a href="{{ url('add-rubro') }}" type="button" class="btn btn-success float-end">
                                    <i class="bi bi-plus-square"></i> Agregar
                                </a>

                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-striped flex-column">
                                    <thead>
                                        <tr>
                                            <td align="center"><i class="bi bi-list-task"></i></td>
                                            <td>Rubro</td>
                                            <td>Descripción</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rubros as $rubro)
                                        <tr>
                                            <td align="center">
                                                <div class="btn-group dropend">
                                                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                                        <i class="bi bi-list-task"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-start">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ url('show-rubro/'.$rubro->id) }}"><i class="bi bi-eye-fill text-blue"></i> Información</a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="{{ url('edit-rubro/'.$rubro->id) }}"><i class="bi bi-pencil-fill text-warning"></i> Editar</a>
                                                        </li>
                                                        @if (Auth::user()->principal == 1)
                                                            <li>
                                                                <a type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $rubro->id }}">
                                                                    <i class="bi bi-trash-fill text-danger"></i> Eliminar
                                                                </a>
                                                            </li>
                                                        @endif

                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">

                                                    <p class="m-0">
                                                        <a class="text-primary" href="{{ url('show-rubro/'.$rubro->id) }}"><b>{{ $rubro->nombre }}</b></a>
                                                    </p>

                                                </div>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">

                                                    <p class="m-0">
                                                        <small>
                                                            {{ $rubro->descripcion }}
                                                        </small>
                                                    </p>

                                                </div>
                                            </td>

                                        </tr>
                                        @include('empresa.rubro.deletemodal')
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $rubros->links() }}
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

