@extends('layouts.empresa')

@section('content')
    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-layout-text-window-reverse"></i>
                </div>
                <div class="page-title">
                    @php
                        $usuario = Auth::user()->name;
                        $nombre = explode(' ', trim($usuario));
                    @endphp
                    <h6>Hola!<strong> {{ ucwords($nombre[0]) }}</strong></h6>
                    {{-- <p class="float-end" id="reloj"></p> --}}
                </div>
            </div>
            <ul class="updates d-none d-md-block align-items-baseline flex-column overflow-hidden" id="updates">
                <li>
                    <a href="javascript:void(3)">
                        <i class="bi bi-layout-text-window-reverse text-blue font-1x me-2"></i>
                        <span>Panel de control de {{ Auth::user()->empresa->nombre }}</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(3)">
                        @php
                            $today = now();
                            $fecha_vencimiento = date("d/m/Y", strtotime(Auth::user()->empresa->fecha_vencimiento));
                        @endphp
                        <i class="bi bi-{{ Auth::user()->empresa->fecha_vencimiento >= $today ? "patch-check-fill" : "patch-exclamation-fill" }} text-{{ Auth::user()->empresa->fecha_vencimiento >= $today ? "green" : "red" }} font-1x me-2"></i>

                        <span>Licencia Hasta: {{ $fecha_vencimiento }}</span>
                    </a>
                </li>
                @if (Auth::user()->empresa->fecha_vencimiento <= $today)
                    <li>
                        <a href="javascript:void(3)">
                            @php
                                    $fecha_vencimiento = Auth::user()->empresa->fecha_vencimiento;
                                    $fecha_gracia = date("d/m/Y", strtotime("+".$config->gracia." months", strtotime($fecha_vencimiento)));
                            @endphp
                            <i class="bi bi-patch-exclamation-fill text-warning font-1x me-2"></i>

                            <span>Podras ver tus registros Hasta: {{ $fecha_gracia }}  </span>
                        </a>
                    </li>
                @endif
                {{-- <li>
                    <a href="javascript:void(0)">
                        <i class="bi bi-folder-check text-yellow font-1x me-2"></i>
                        <span>The media folder is created successfully.</span>
                    </a>
                </li> --}}
            </ul>
            <!-- Date range start -->
            <div class="d-flex align-items-end d-none d-sm-block">
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
                    <a href="{{ url('empresa-dashboard') }}">
                    <div class="stats-tile d-flex align-items-center position-relative tile-blue">
                        <div class="sale-icon icon-box xl rounded-5 me-3">
                            <i class="bi bi-layout-text-window-reverse font-2x text-blue"></i>
                        </div>
                        <div class="sale-details">
                            <h6 class="text-light">Panel de {{ Auth::user()->empresa->nombre }}</h6>
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
                                <h6 class="text-light">Sitio Web</h6>
                                {{-- <h3>368</h3> --}}
                            </div>
                            <div class="tile-count d-flex align-items-center justify-content-center flex-column fw-bold blue">
                                {{-- <i class="bi bi-arrow-up-circle-fill font-1x"></i>
                                <span>5%</span> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xxl-3 col-sm-6 col-12">
                    <a href="#">
                        <div class="stats-tile d-flex align-items-center position-relative tile-blue">
                            <div class="sale-icon icon-box xl rounded-5 me-3">
                                <i class="bi bi-building font-2x text-blue"></i>
                            </div>
                            <div class="sale-details">
                                <h6 class="text-light"><u><a href="{{ url('show-empresa-info/'.Auth::user()->empresa_id) }}" class="text-primary">{{ Auth::user()->empresa->nombre }}</a></u></h6>
                                <a href="{{ url('empresa-usuarios') }}" class="text-primary"><i class="bi bi-chevron-compact-right"></i> <i class="bi bi-people-fill"></i> <u>Usuarios</u></a>
                                <br>
                                <a href="{{ url('cuentas') }}" class="text-primary"><i class="bi bi-chevron-compact-right"></i> <i class="bi bi-journal-bookmark"></i> <u>Cuentas</u></a>
                            </div>
                            {{-- <div class="tile-count d-flex align-items-center justify-content-center flex-column fw-bold blue">

                            </div> --}}
                        </div>
                    </a>
                </div>
                <hr>
                <div class="col-xxl-3 col-sm-6 col-12">
                    <a href="{{ url('financieros') }}">
                        <div class="stats-tile d-flex align-items-center position-relative tile-green">
                            <div class="sale-icon icon-box xl rounded-5 me-3">
                                <i class="bi bi-cash-coin font-2x text-green"></i>
                            </div>
                            <div class="sale-details">
                                <h6 class="text-light">Financiero</h6>
                                <a href="{{ url('rubros') }}" class="text-primary"><i class="bi bi-chevron-compact-right"></i> <i class="bi bi-coin"></i> <u>Rubros</u></a>
                                <br>
                                <a href="{{ url('movimientos') }}" class="text-primary"><i class="bi bi-chevron-compact-right"></i> <i class="bi bi-cash-stack"></i> <u>Movimientos</u></a>
                            </div>
                            <div class="tile-count d-flex align-items-center justify-content-center flex-column fw-bold green">
                                {{-- <i class="bi bi-arrow-up-circle-fill font-1x"></i>
                                <span>5%</span> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <hr>
                <div class="col-xxl-3 col-sm-6 col-12">
                    <a href="{{ url('bitacoras') }}">
                        <div class="stats-tile d-flex align-items-center position-relative tile-yellow">
                            <div class="sale-icon icon-box xl rounded-5 me-3">
                                <i class="bi bi-fingerprint font-2x text-yellow"></i>
                            </div>
                            <div class="sale-details">
                                <h6 class="text-light">Bitácora</h6>
                                {{-- <h3>368</h3> --}}
                            </div>
                            <div class="tile-count d-flex align-items-center justify-content-center flex-column fw-bold yellow">
                                {{-- <i class="bi bi-arrow-up-circle-fill font-1x"></i>
                                <span>5%</span> --}}
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xxl-3 col-sm-6 col-12">
                    <a href="{{ url('empresa-config') }}">
                        <div class="stats-tile d-flex align-items-center position-relative tile-yellow">
                            <div class="sale-icon icon-box xl rounded-5 me-3">
                                <i class="bi bi-gear font-2x text-yellow"></i>
                            </div>
                            <div class="sale-details">
                                <h6 class="text-light">Configuración</h6>
                                {{-- <h3>368</h3> --}}
                            </div>
                            <div class="tile-count d-flex align-items-center justify-content-center flex-column fw-bold yellow">
                                {{-- <i class="bi bi-arrow-up-circle-fill font-1x"></i>
                                <span>5%</span> --}}
                            </div>
                        </div>
                    </a>
                </div>
                {{-- <div class="col-xxl-3 col-sm-6 col-12">
                    <a href="{{ url('users') }}">
                        <div class="stats-tile d-flex align-items-center position-relative tile-green">
                            <div class="sale-icon icon-box xl rounded-5 me-3">
                                <i class="bi bi-shield font-2x text-green"></i>
                            </div>
                            <div class="sale-details">
                                <h6 class="text-light">Administradores</h6>

                            </div>
                            <div class="tile-count d-flex align-items-center justify-content-center flex-column fw-bold green">

                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-xxl-3 col-sm-6 col-12">
                    <a href="#">
                        <div class="stats-tile d-flex align-items-center position-relative tile-green">
                            <div class="sale-icon icon-box xl rounded-5 me-3">
                                <i class="bi bi-building font-2x text-green"></i>
                            </div>
                            <div class="sale-details">
                                <h6 class="text-light">Empresas</h6>
                                <a href="{{ url('usuarios') }}" class="text-primary"><i class="bi bi-chevron-compact-right"></i> <i class="bi bi-people-fill"></i> <u>Usuarios</u></a>
                                <br>
                                <a href="{{ url('empresas') }}" class="text-primary"><i class="bi bi-chevron-compact-right"></i> <i class="bi bi-building"></i> <u>Empresas</u></a>
                            </div>
                            <div class="tile-count d-flex align-items-center justify-content-center flex-column fw-bold green">

                            </div>
                        </div>
                    </a>
                </div>
                <hr>
                <div class="col-xxl-3 col-sm-6 col-12">
                    <a href="{{ url('config') }}">
                        <div class="stats-tile d-flex align-items-center position-relative tile-yellow">
                            <div class="sale-icon icon-box xl rounded-5 me-3">
                                <i class="bi bi-gear font-2x text-yellow"></i>
                            </div>
                            <div class="sale-details">
                                <h6 class="text-light">Configuración</h6>
                            </div>
                            <div class="tile-count d-flex align-items-center justify-content-center flex-column fw-bold reyellowd">

                            </div>
                        </div>
                    </a>
                </div> --}}
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
