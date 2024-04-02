@extends('layouts.frontend')
{{-- Contact View --}}
@section('content')

    <!-- Header Start -->
    <div class="container-fluid page-header" style="margin-bottom: 90px;">
        <div class="container">
            <div class="d-flex flex-column justify-content-center" style="min-height: 300px">
                <h3 class="display-4 text-white text-uppercase">Contacto</h3>
                {{-- <p class="h7" href=""><font color="white">{{ $category->description }}</font></p> --}}
                {{-- <p class="h7" href=""><font color="fa9932">{{ $categoryCourses->count() }} Cursos</font></p> --}}
                <div class="d-inline-flex text-white">
                    <p class="m-0 text-uppercase"><a class="text-white" href="{{ url('/') }}">Inicio</a></p>
                    <i class="fa fa-angle-double-right pt-1 px-3"></i>
                    <p class="m-0 text-uppercase">Contacto</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <section class="ftco-section contact-section">
        <div class="container mt-5">
            <div class="row block-9">
                <div class="col-md-4 contact-info ftco-animate">
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <h2 class="h4">{{ __('Información de Contacto') }}</h2>
                        </div>
                        <div class="col-md-12 mb-3">
                            <p><span>{{ __('Email') }}:</span><a href="mailto:eventos.buro@hotmail.com"> eventos.buro@hotmail.com</a></p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <p><span>{{ __('Teléfono') }}:</span> <a href="tel://50259893119">+502 5989 3119</a></p>
                        </div>
                        <!-- <div class="col-md-12 mb-3">
                            <p><span>Email:</span> <a href="mailto:info@yoursite.com">	info@bocacostacoffee.com</a></p>
                        </div> -->
                        <!-- <div class="col-md-12 mb-3">
                            <p><span>Website:</span> <a href="#">www.bocacostacoffee.com</a></p>
                        </div> -->
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-6 ftco-animate">
                    @if(Session::has('message'))
                        <div class="alert {{ Session::get('alert-class', 'alert-info') }}" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                    <form action="{{ url('send-contact') }}" class="contact-form" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="{{ __('Nombre') }}" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="{{ __('Asunto') }}" name="subject" required>
                        </div>
                        <div class="form-group">
                            <textarea name="mensaje" cols="30" rows="7" class="form-control" placeholder="{{ __('Mensaje') }}" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="{{ __('Enviar Mensaje') }}" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
