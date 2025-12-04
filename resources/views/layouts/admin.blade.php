<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

		<!-- Meta -->
		<meta name="description" content="Buro, software, finanzas, tibutario" />
		<meta name="author" content="Szystems" />
		<link rel="canonical" href="https://www.szystems.com">
		<meta property="og:url" content="https://www.szystems.com">
		<meta property="og:title" content="Buro">
		<meta property="og:description" content="Software control financiero de empresas">
		<meta property="og:type" content="Web App">
		<meta property="og:site_name" content="https://www.burosoft.com">
		<link rel="shortcut icon" href="assets/uploads/logos/favicon.ico" />
        <!-- Favicon -->
        <link href="{{ asset('elearning/img/logos/favico.ico') }}" rel="icon">

		<!-- Title -->
		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- *************
			************ Common Css Files *************
		************ -->
		<!-- Bootstrap css -->
		<link rel="stylesheet" href="{{ asset('dashboardtemplate/design/assets/css/bootstrap.min.css') }}" />

		<!-- Bootstrap font icons css -->
		<link rel="stylesheet" href="{{ asset('dashboardtemplate/design/assets/fonts/bootstrap/bootstrap-icons.css') }}" />

		<!-- Main css -->
		<link rel="stylesheet" href="{{ asset('dashboardtemplate/design/assets/css/main.min.css') }}" />

		<!-- CSS Fix para Dashboard Invisible y Sidebar Scroll -->
		<link rel="stylesheet" href="{{ asset('assets/css/fix-dashboard.css') }}" />

		<!-- *************
			************ Vendor Css Files *************
		************ -->

		<!-- Scrollbar CSS -->
		<link rel="stylesheet" href="{{ asset('dashboardtemplate/design/assets/vendor/overlay-scroll/OverlayScrollbars.min.css') }}" />

        <!-- Date Range CSS -->
		{{-- <link rel="stylesheet" href="{{ asset('dashboardtemplate/design/assets/vendor/daterange/daterange.css') }}" /> --}}

		<!-- Dropzone CSS -->
		<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />

        {{-- Datepicker --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        {{-- Datepicker end --}}

        {{-- CDEditor 5 --}}
        <script src="assets/ckeditor5/ckeditor.js"></script>
	</head>

	<body>

		<!-- Loading wrapper start -->
		{{-- <div id="loading-wrapper">
			<div class="spinner">
				<div class="line1"></div>
				<div class="line2"></div>
				<div class="line3"></div>
				<div class="line4"></div>
				<div class="line5"></div>
				<div class="line6"></div>
			</div>
		</div> --}}
		<!-- Loading wrapper end -->

		<!-- Page wrapper start -->
		<div class="page-wrapper">
            @php
                $config = \App\Models\Config::find(1);
                $empresa = \App\Models\Empresa::find($config->empresa_id);
            @endphp

			@include('layouts.incadmin.nav')

			<!-- Main container start -->
			<div class="main-container">

				@include('layouts.incadmin.sidebar')

				@yield('content')

				@include('layouts.incadmin.footer')

			</div>
			<!-- Main container end -->

		</div>
		<!-- Page wrapper end -->

		<!--  Required JavaScript Files  -->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
		<script src="{{ asset('dashboardtemplate/design/assets/js/jquery.min.js') }}"></script>
		<script src="{{ asset('dashboardtemplate/design/assets/js/bootstrap.bundle.min.js') }}"></script>
		{{-- Modernizr deshabilitado: causa problemas con Tracking Prevention --}}
		{{-- <script src="{{ asset('dashboardtemplate/design/assets/js/modernizr.js') }}"></script> --}}
		<script src="{{ asset('dashboardtemplate/design/assets/js/moment.js') }}"></script>

		<!--  Vendor Js Files  -->

		<!-- Overlay Scroll JS -->
		<script src="{{ asset('dashboardtemplate/design/assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js') }}"></script>
		{{-- Script de scrollbar deshabilitado: causa que el contenido desaparezca --}}
		{{-- <script src="{{ asset('dashboardtemplate/design/assets/vendor/overlay-scroll/custom-scrollbar.js') }}"></script> --}}

		<!-- News ticker -->
		<script src="{{ asset('dashboardtemplate/design/assets/vendor/newsticker/newsTicker.min.js') }}"></script>
		<script src="{{ asset('dashboardtemplate/design/assets/vendor/newsticker/custom-newsTicker.js') }}"></script>

        <!-- Date Range JS -->
		{{-- <script src="{{ asset('dashboardtemplate/design/assets/vendor/daterange/daterange.js') }}"></script>
		<script src="{{ asset('dashboardtemplate/design/assets/vendor/daterange/custom-daterange.js') }}"></script> --}}

		<!-- Dropzone JS -->
		<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

		<!-- Main Js Required -->
		<script src="{{ asset('dashboardtemplate/design/assets/js/main.js') }}"></script>

		<!-- Apex Charts -->
		{{-- <script src="{{ asset('dashboardtemplate/design/assets/vendor/apex/apexcharts.min.js') }}"></script>
		<script src="{{ asset('dashboardtemplate/design/assets/vendor/apex/custom/dash1/analytics.js') }}"></script>
		<script src="{{ asset('dashboardtemplate/design/assets/vendor/apex/custom/dash1/visitors.js') }}"></script>
		<script src="{{ asset('dashboardtemplate/design/assets/vendor/apex/custom/dash1/income.js') }}"></script>
		<script src="{{ asset('dashboardtemplate/design/assets/vendor/apex/custom/dash1/orders.js') }}"></script>
		<script src="{{ asset('dashboardtemplate/design/assets/vendor/apex/custom/dash1/sales.js') }}"></script>
		<script src="{{ asset('dashboardtemplate/design/assets/vendor/apex/custom/dash1/sparkline.js') }}"></script>
		<script src="{{ asset('dashboardtemplate/design/assets/vendor/apex/custom/dash1/conversion.js') }}"></script> --}}

		<!-- Main Js Required -->
		{{-- <script src="{{ asset('dashboardtemplate/design/assets/js/main.js') }}"></script> --}}

        {{-- sweet alert --}}
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        @if (session('status'))
            <script>
                swal("{{ session('status') }}");
            </script>
        @endif

        {{-- Hora y fecha --}}
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

		<!-- Fix para Dashboard Invisible -->
		<script>
			// Forzar visibilidad del contenido del dashboard
			$(document).ready(function() {
				// Esperar un momento para que el DOM esté completamente listo
				setTimeout(function() {
					// Forzar visibilidad de todos los elementos principales
					$('.content-wrapper, .content-wrapper-scroll, .os-content, .os-viewport').css({
						'opacity': '1 !important',
						'visibility': 'visible !important',
						'display': 'block !important',
						'height': 'auto !important',
						'min-height': '100vh'
					});
					
					// Remover cualquier clase que oculte el contenido
					$('.content-wrapper-scroll').removeClass('os-host os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-transition');
					
					console.log('✅ Visibilidad del dashboard forzada correctamente');
				}, 100);
			});
		</script>
	</body>

</html>
