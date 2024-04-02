@extends('layouts.frontend')
{{-- Contact View --}}
@section('content')

    <!-- Header Start -->
    <div class="container-fluid page-header" style="margin-bottom: 90px;">
        <div class="container">
            <div class="d-flex flex-column justify-content-center" style="min-height: 300px">
                <h3 class="display-4 text-white text-uppercase">Nosotros</h3>
                {{-- <p class="h7" href=""><font="white">{{ $category->description }}</font></p> --}}
                {{-- <p class="h7" href=""><font color="fa9932">{{ $categoryCourses->count() }} Cursos</font></p> --}}
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Inicio</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Nosotros</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <img class="img-fluid rounded mb-4 mb-lg-0" src="{{ asset('elearning/img/logos/logo.png') }}" alt="">
                </div>
                <div class="col-lg-7">
                    <div class="text-left mb-4">
                        <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">Nosotros</h5>
                        <h1>Expertos en consultoria Tributaria y defensa fiscal</h1>
                    </div>
                    <p>Consultores de empresas con más de 10 años de experiencia en el mercado de servicios relacionados con: consultoría tributaria, defensa fiscal, auditoría y otros; atendiendo a clientes de diversas actividades económicas.</p>
                    <p>La experiencia adquirida nos permite prestar un servicio de primer orden y calidad de los trabajos que realizamos, cuyo objetivo es el oportuno consejo profesional.</p>
                    {{-- <a href="" class="btn btn-primary py-md-2 px-md-4 font-weight-semi-bold mt-2">Learn More</a> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

@endsection
