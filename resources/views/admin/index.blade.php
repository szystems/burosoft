@extends('layouts.admin')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-house"></i>
                </div>
                <div class="page-title d-none d-md-block">
                    @php
                        $usuario = Auth::user()->name;
                        $nombre = explode(' ', trim($usuario));
                    @endphp
                    <h6>Hola!<strong> {{ ucwords($nombre[0]) }}</strong></h6>
                    {{-- <p class="float-end" id="reloj"></p> --}}
                </div>
            </div>
            <!-- Date range start -->
            <div class="d-flex align-items-end">
                <h6 class="float-end text-light" id="reloj"></h6>
            </div>
            <!-- Date range end -->
        </div>
        <!-- Main header ends -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">

            <!-- Row start -->
            <div class="row gx-3">

                <div class="col-xxl-3 col-sm-6 col-12">
                    <a href="{{ url('/dashboard') }}">
                    <div class="stats-tile d-flex align-items-center position-relative tile-blue">
                        <div class="sale-icon icon-box xl rounded-5 me-3">
                            <i class="bi bi-house-fill font-2x text-blue"></i>
                        </div>
                        <div class="sale-details">
                            <h5 class="text-light">Panel de Control</h5>
                            {{-- <h3>296</h3> --}}
                        </div>
                        <div class="tile-count d-flex align-items-center justify-content-center flex-column fw-bold blue">
                            {{-- <i class="bi bi-arrow-up-circle-fill font-1x"></i>
                            <span>100%</span> --}}
                        </div>
                    </div>
                    </a>
                </div>

                <div class="col-xxl-3 col-sm-6 col-12">
                    <a href="{{ url('/') }}">
                        <div class="stats-tile d-flex align-items-center position-relative tile-blue">
                            <div class="sale-icon icon-box xl rounded-5 me-3">
                                <i class="bi bi-globe font-2x text-blue"></i>
                            </div>
                            <div class="sale-details">
                                <h5 class="text-light">Sitio Web</h5>
                                {{-- <h3>368</h3> --}}
                            </div>
                            <div class="tile-count d-flex align-items-center justify-content-center flex-column fw-bold blue">
                                {{-- <i class="bi bi-arrow-up-circle-fill font-1x"></i>
                                <span>5%</span> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <hr>
                <div class="col-xxl-3 col-sm-6 col-12">
                    <a href="{{ url('/') }}">
                        <div class="stats-tile d-flex align-items-center position-relative tile-red">
                            <div class="sale-icon icon-box xl rounded-5 me-3">
                                <i class="bi bi-shield font-2x text-red"></i>
                            </div>
                            <div class="sale-details">
                                <h5 class="text-light">Administradores</h5>
                                {{-- <h3>368</h3> --}}
                            </div>
                            <div class="tile-count d-flex align-items-center justify-content-center flex-column fw-bold red">
                                {{-- <i class="bi bi-arrow-up-circle-fill font-1x"></i>
                                <span>5%</span> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xxl-3 col-sm-6 col-12">
                    <a href="#">
                        <div class="stats-tile d-flex align-items-center position-relative tile-red">
                            <div class="sale-icon icon-box xl rounded-5 me-3">
                                <i class="bi bi-building font-2x text-red"></i>
                            </div>
                            <div class="sale-details">
                                <h5 class="text-light">Empresas</h5>
                                <a href="#" class="text-primary"><i class="bi bi-chevron-compact-right"></i> <i class="bi bi-people-fill"></i> Usuarios</a>
                                <br>
                                <a href="{{ url('empresas') }}" class="text-primary"><i class="bi bi-chevron-compact-right"></i> <i class="bi bi-building"></i> Empresas</a>
                                {{-- <h3>95%</h3> --}}
                            </div>
                            <div class="tile-count d-flex align-items-center justify-content-center flex-column fw-bold red">
                                {{-- <i class="bi bi-arrow-down-circle-fill font-1x"></i>
                                <span>9%</span> --}}
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Row end -->

        </div>
        <!-- Content wrapper end -->

    </div>
    <!-- Content wrapper scroll end -->

    <script>
        function actualizarReloj() {
            const ahora = new Date();
            const horas = ahora.getHours();
            const minutos = ahora.getMinutes();
            const segundos = ahora.getSeconds();

            // Calcula si es AM o PM
            const amPm = horas >= 12 ? 'PM' : 'AM';
            const hora12 = horas % 12 || 12; // Convierte a formato de 12 horas

            // Formatea la hora con dos dígitos
            const horaFormateada = `${hora12.toString().padStart(2, '0')}:${minutos.toString().padStart(2, '0')}:${segundos.toString().padStart(2, '0')} ${amPm}`;

            // Obtiene la fecha actual
            const dia = ahora.getDate();
            const mes = ahora.getMonth() + 1; // Los meses en JavaScript son base 0 (enero = 0)
            const anio = ahora.getFullYear();
            const fechaFormateada = `${dia}/${mes}/${anio}`;

            // Actualiza el contenido del elemento con la fecha y la hora
            document.getElementById('reloj').textContent = `${fechaFormateada} ${horaFormateada}`;
        }

        // Actualiza la hora y la fecha cada segundo
        setInterval(actualizarReloj, 1000);
    </script>
@endsection

{{-- <div class="row">
            <div class="row mb-4">
                <div class="col-xl-12">
                    <div class="row">

                        <div class="col-md-3 col-6 p-2">
                            <div class="card">
                                <a href="{{ url('instructors') }}">
                                    <div class="card-header mx-4 p-3 text-center">
                                        <div
                                            class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                                            <i class="material-icons opacity-10">school</i>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 p-3 text-center">
                                        <hr class="horizontal dark my-3">
                                        <h5 class="mb-0">{{ __('Instructores') }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-3 col-6 p-2">
                            <div class="card">
                                <a href="{{ url('course-categories') }}">
                                    <div class="card-header mx-4 p-3 text-center">
                                        <div
                                            class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                                            <i class="material-icons opacity-10">category</i>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 p-3 text-center">
                                        <hr class="horizontal dark my-3">
                                        <h5 class="mb-0">{{ __('Categorías de Contenidos') }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 p-2">
                            <div class="card">
                                <a href="{{ url('index-courses') }}">
                                    <div class="card-header mx-4 p-3 text-center">
                                        <div
                                            class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                                            <i class="material-icons opacity-10">local_library</i>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 p-3 text-center">
                                        <hr class="horizontal dark my-3">
                                        <h5 class="mb-0">{{ __('Contenidos') }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 p-2">
                            <div class="card">
                                <a href="{{ url('index-subscriptions') }}">
                                    <div class="card-header mx-4 p-3 text-center">
                                        <div
                                            class="icon icon-shape icon-lg bg-gradient-info shadow text-center border-radius-lg">
                                            <i class="material-icons opacity-10">workspace_premium</i>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 p-3 text-center">
                                        <hr class="horizontal dark my-3">
                                        <h5 class="mb-0">{{ __('Suscripciones') }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 p-2">
                            <div class="card">
                                <a href="{{ url('users') }}">
                                    <div class="card-header mx-4 p-3 text-center">
                                        <div
                                            class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                            <i class="material-icons opacity-10">people_alt</i>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 p-3 text-center">
                                        <hr class="horizontal dark my-3">
                                        <h5 class="mb-0">{{ __('Usuarios') }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-6  p-2">
                            <div class="card">
                                <a href="{{ url('config') }}">
                                    <div class="card-header mx-4 p-3 text-center">
                                        <div
                                            class="icon icon-shape icon-lg bg-gradient-primary shadow text-center border-radius-lg">
                                            <i class="material-icons opacity-10">settings</i>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 p-3 text-center">
                                        <hr class="horizontal dark my-3">
                                        <h5 class="mb-0">{{ __('Configuración') }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 p-2">
                            <div class="card">
                                <a href="{{ url('show-user/'.Auth::id()) }}">
                                    <div class="card-header mx-4 p-3 text-center">
                                        <div
                                            class="icon icon-shape icon-lg bg-gradient-success shadow text-center border-radius-lg">
                                            <i class="material-icons opacity-10">person</i>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 p-3 text-center">
                                        <hr class="horizontal dark my-3">
                                        <h5 class="mb-0">{{ __('Mi Perfil') }}</h5>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="horizontal dark my-3">

</div> --}}
