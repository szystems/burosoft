@extends('layouts.admin')
@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-building"></i>
                </div>
                <div class="page-title">
                    <h5>Empresas</h5>
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

                                <div class="col-12 col-md-auto float-end">
                                    <div class="btn-group-sm m-3">
                                        <a href="{{ url('edit-empresa/'.$empresa->id) }}" class="btn btn-warning" aria-current="page"><i class="bi bi-pencil"></i> Editar</a>
                                        @if ($empresa->id != 1)
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $empresa->id }}">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                            @include('admin.empresa.deletemodal')
                                        @endif
                                    </div>
                                </div>


                                <ul class="nav nav-tabs" id="customTab2" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA" role="tab"
                                            aria-controls="oneA" aria-selected="true">Información</a>
                                    </li>
                                </ul>
                                <div class="tab-content h-350">
                                    <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                                        <!-- Row start -->
                                        <div class="row gx-3">
                                            <div class="col-sm-12 col-12">
                                                <div class="row gx-3">

                                                    <div class="col-md-2 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="emailId" class="form-label">Licencia</label>
                                                            <p>
                                                                @php
                                                                    $today = now();
                                                                    $fecha_vencimiento = date("d/m/Y", strtotime($empresa->fecha_vencimiento));
                                                                @endphp
                                                                <small>
                                                                    <span class="badge shade-light-{{ $empresa->fecha_vencimiento >= $today ? "green" : "yellow" }}">
                                                                        {{ $fecha_vencimiento }}
                                                                    </span>

                                                                </small>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="emailId" class="form-label">Periodo de Gracia</label>
                                                            <p>
                                                                @php
                                                                     $fecha_gracia = date("d/m/Y", strtotime("+".$config->gracia." months", strtotime($empresa->fecha_vencimiento)));
                                                                @endphp
                                                                <small>
                                                                    <span class="badge shade-light-yellow">
                                                                        {{ $fecha_gracia }} ({{ $config->gracia }} Meses)
                                                                    </span>

                                                                </small>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Código de Empresa</label>
                                                            <p>
                                                                <strong>{{ $empresa->id }}</strong>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="fullName" class="form-label">Nombre</label>
                                                            <p>
                                                                {{ $empresa->nombre }}
                                                            </p>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="emailId" class="form-label">Email</label>
                                                            <p><a class="link-info" href="mailto:{{ $empresa->email }}">{{ $empresa->email }}</a></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="contactNumber" class="form-label">Teléfono / Celular / Whatsapp</label>
                                                            <p>
                                                                <a class="text-info" href="tel:+502{{ $empresa->telefono }}">{{ $empresa->telefono }}</a>
                                                                @if ($empresa->celular != null)
                                                                    <a class="text-info" href="tel:+502{{ $empresa->celular }}">/ {{ $empresa->celular }}</a>
                                                                    <a class="text-success" href="https://wa.me/502{{ $empresa->celular }}" target="_blank">/ <i class="bi bi-whatsapp"></i></a>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Dirección</label>
                                                            <p>{{ $empresa->direccion }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Descripción</label>
                                                            <p>{{ $empresa->descripcion }}</p>
                                                        </div>
                                                    </div>
                                                    @if ($empresa->fotografia != null)
                                                    <div class="col-md-12 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label class="form-label">Imágen</label>
                                                            <div align="left" class="brand">
                                                                <img src="{{ asset('assets/uploads/empresas/'.$empresa->fotografia) }}" class="img-thumbnail" style="height: 200px;" alt="Logo" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif



                                                </div>
                                            </div>
                                        </div>
                                        <!-- Row end -->
                                    </div>

                                </div>
                                {{-- <div class="d-flex gap-2 justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary">
                                        Cancel
                                    </button>
                                    <button type="button" class="btn btn-success">
                                        Update
                                    </button>
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
