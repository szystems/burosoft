@extends('layouts.frontend')
{{-- Trending products --}}
@section('content')

    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <img class="img-fluid rounded mb-4 mb-lg-0" src="{{ asset('frontend/imgs/404.png') }}" alt="">
                </div>
                <div class="col-lg-7">
                    <div class="text-left mb-4">
                        <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">La sesion expiro regresa a inicio y intenta nuevamente</h5>
                        {{-- <h1>Regresar a la pagina Principal</h1> --}}
                    </div>
                    {{-- <p>Quieres regresar a</p> --}}
                    <a href="{{ url('/') }}" class="btn btn-primary py-md-2 px-md-4 font-weight-semi-bold mt-2">Ir a inicio...</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

@endsection
