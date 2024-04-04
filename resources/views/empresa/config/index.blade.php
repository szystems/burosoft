@extends('layouts.empresa')

@section('content')


    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-gear"></i>
                </div>
                <div class="page-title">
                    <h5>Configuración</h5>
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

                        {{-- <div class="card-header">
                            <div class="card-title">
                                Configuración
                            </div>

                        </div> --}}
                        <div class="card-body">

                            <div class="custom-tabs-container">
                                <ul class="nav nav-tabs" id="customTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="tab-config" data-bs-toggle="tab" href="#config" role="tab"
                                            aria-controls="config" aria-selected="true">General</a>
                                    </li>
                                    {{-- <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="tab-two" data-bs-toggle="tab" href="#two" role="tab"
                                            aria-controls="two" aria-selected="false">Tab Two</a>
                                    </li> --}}
                                </ul>
                                <div class="tab-content" id="customTabContent">

                                    <div class="tab-pane fade show active" id="config" role="tabpanel">
                                        <div class="p-0 text-left">
                                            {{-- <h1 class="display-5 fw-bold text-green">
                                                General
                                            </h1> --}}
                                            <p class="text-yellow">Cambia los valores generales que utilizara la aplicación:</p>
                                            <div class="col-lg-12 mx-auto">

                                                @if (count($errors)>0)
                                                    <div class="alert alert-danger text-white" role="alert">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{$error}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                @endif
                                                <form action="{{ url('empresa-update-config')}}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row gx-3">

                                                        <div class="col-md-12 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label for="moneda" class="form-label">Moneda</label>
                                                                <select name="currency" class="form-select">
                                                                    <option selected value="{{ $config->currency }}">{{ $config->currency }}</option>
                                                                    <option value="USD $">USD ($)</option>
                                                                    <option value="GTQ Q">GTQ (Q)</option>
                                                                </select>
                                                                @if ($errors->has('currency'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('currency') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>



                                                        <div class="col-md-12 mb-3">
                                                            @if ($config->logo)
                                                                <div align="center" class="brand">
                                                                    <img src="{{ asset('assets/uploads/logos/'.$config->logo) }}" class="img-thumbnail" style="height: 100px;" alt="Logo" />
                                                                </div>
                                                            @endif
                                                            <div class="mb-3">
                                                                <label class="form-label">Cambiar Imágen</label>
                                                                <input type="file" name="logo" class="form-control border">
                                                                @if ($errors->has('logo'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('logo') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>



                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ url('config') }}" type="button" class="btn btn-danger">
                                                            <i class="bi bi-x-circle"></i> Cancelar
                                                        </a>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="bi bi-check2-square"></i> Grabar
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="tab-pane fade" id="two" role="tabpanel">
                                        <div class="p-5">
                                            <h1 class="display-5 fw-bold text-green">
                                                Tab Two
                                            </h1>
                                            <div class="col-lg-6">
                                                <p class="lead mb-4">
                                                    Quickly design and customize responsive
                                                    mobile-first sites with Bootstrap, the world’s
                                                    most popular front-end open source toolkit,
                                                    featuring Sass variables and mixins, responsive
                                                    grid system, extensive prebuilt components, and
                                                    powerful JavaScript plugins.
                                                </p>
                                                <div class="d-grid gap-2 d-sm-flex">
                                                    <button type="button" class="btn btn-success btn-lg">
                                                        Button
                                                    </button>
                                                    <button type="button" class="btn btn-secondary btn-lg">
                                                        Button
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

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
