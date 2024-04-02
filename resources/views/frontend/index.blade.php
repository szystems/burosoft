@extends('layouts.frontend')
{{-- Trending products --}}
@section('content')

    <!-- Carousel Start -->
    {{-- <div class="container-fluid p-0 pb-5 mb-5">
        <div id="header-carousel" class="carousel slide carousel-fade" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                <li data-target="#header-carousel" data-slide-to="1"></li>
                <li data-target="#header-carousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active" style="min-height: 300px;">
                    <img class="position-relative w-100" src="{{ asset('elearning/img/slide/slide1.jpg') }}" style="min-height: 300px; object-fit: cover;">
                    <div class="carousel-caption d-flex align-items-center justify-content-center">
                        <div class="p-5" style="width: 100%; max-width: 900px;">
                            <h5 class="text-white text-uppercase mb-md-3">Los mejores cursos</h5>
                            <h1 class="display-3 text-white mb-md-4">Expertos en consultoria Tributaria y defensa fiscal</h1>
                            <a href="" class="btn btn-primary py-md-2 px-md-4 font-weight-semi-bold mt-2">Suscribirse</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="min-height: 300px;">
                    <img class="position-relative w-100" src="{{ asset('elearning/img/slide/slide2.jpg') }}" style="min-height: 300px; object-fit: cover;">
                    <div class="carousel-caption d-flex align-items-center justify-content-center">
                        <div class="p-5" style="width: 100%; max-width: 900px;">
                            <h5 class="text-white text-uppercase mb-md-3">Los mejores cursos</h5>
                            <h1 class="display-3 text-white mb-md-4">Expertos en consultoria Tributaria y defensa fiscal</h1>
                            <a href="" class="btn btn-primary py-md-2 px-md-4 font-weight-semi-bold mt-2">Suscribirse</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" style="min-height: 300px;">
                    <img class="position-relative w-100" src="{{ asset('elearning/img/carousel-3.jpg') }}" style="min-height: 300px; object-fit: cover;">
                    <div class="carousel-caption d-flex align-items-center justify-content-center">
                        <div class="p-5" style="width: 100%; max-width: 900px;">
                            <h5 class="text-white text-uppercase mb-md-3">Best Online Courses</h5>
                            <h1 class="display-3 text-white mb-md-4">New Way To Learn From Home</h1>
                            <a href="" class="btn btn-primary py-md-2 px-md-4 font-weight-semi-bold mt-2">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Carousel End -->
    <div class="container">
        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success">
                <ul>
                    @foreach (session()->get('success') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    @if (Auth::guest())
        <!-- Registration Start -->
        <div class="container-fluid bg-registration py-5" style="margin: 15px 0;">
            <div class="container py-5">
                <div class="row align-items-center">

                    <div class="col-lg-6">
                        <div class="card border-0">
                            <div class="card-header bg-light text-center p-2">
                                <h1 class="m-0">Login</h1>
                            </div>
                            <div class="card-body rounded-bottom bg-primary p-0">
                                <form method="POST" action="{{ route('login') }}" class="billing-form ftco-bg-dark p-3 p-md-5">
                                    @csrf
                                    {{-- <h3 class="mb-4 billing-heading"> {{ __('Login') }}</h3> --}}
                                    <div class="row align-items-end">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="firstname" class="h6">{{ __('Email') }}</label>
                                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="lastname" class="h6">{{ __('Password') }}</label>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <input type="checkbox" onclick="showpassword()"> <label for="" class="h6">{{ __('Mostrar Password') }}</label>
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label h6" for="remember">
                                                    {{ __('Recordar mis datos') }}
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <p><button type="submit" class="btn btn-dark py-3 px-4 w-100"><font color="white"><strong>{{ __('Login') }}</strong></font></button></p>
                                            </div>
                                            <a class="h6" href="{{ route('register') }}">{{ __('Crear una cuenta') }}</a><br>
                                            @if (Route::has('password.request'))
                                                <a class="h6" href="{{ route('password.request') }}">{{ __('¿Olvidaste tu contraseña?') }}</a>
                                            @endif


                                        </div>


                                    </div>
                                </form><!-- END -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 mb-5 mb-lg-0 m-3">
                        <div class="mb-4">
                            <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">Buro Soft</h5>
                            <h1 class="text-white">El software de control mas completo</h1>
                        </div>
                        <p class="text-white">Modulos:</p>
                        <ul class="list-inline text-white m-0">
                            <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Financiero</li>
                            {{-- <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Acceso a todos los contenidos</li>
                            <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Aprendizaje comprobado</li> --}}
                        </ul>
                    </div>
                    {{-- <div class="col-lg-4">
                        <div class="card border-0">
                            <div class="card-header bg-light text-center p-4">
                                <h1 class="m-0">Suscripción</h1>
                            </div>
                            <div class="card-body rounded-bottom bg-primary p-5">
                                <form>
                                    <div>
                                        <a href="{{ url('register') }}" class="btn btn-dark btn-block border-0 py-3">Mensual $.9.99</a>
                                    </div>
                                    <br>
                                    <div>
                                        <a href="{{ url('register') }}" class="btn btn-dark btn-block border-0 py-3">Semestral $.53.99</a>
                                    </div>
                                    <br>
                                    <div>
                                        <a href="{{ url('register') }}" class="btn btn-dark btn-block border-0 py-3" >Anual $.99.99</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> --}}


                </div>
            </div>
        </div>
        <!-- Registration End -->
    @else
        <!-- Registration Start -->
        <div class="container-fluid bg-registration py-5" style="margin: 15px 0;">
            <div class="container py-5">
                <div class="row align-items-center">

                    {{-- <div class="col-lg-6">
                        <div class="card border-0">
                            <div class="card-header bg-light text-center p-2">
                                <h1 class="m-0">Login</h1>
                            </div>
                            <div class="card-body rounded-bottom bg-primary p-0">
                                <form method="POST" action="{{ route('login') }}" class="billing-form ftco-bg-dark p-3 p-md-5">
                                    @csrf
                                    <div class="row align-items-end">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="firstname" class="h6">{{ __('Email') }}</label>
                                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="lastname" class="h6">{{ __('Password') }}</label>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <input type="checkbox" onclick="showpassword()"> <label for="" class="h6">{{ __('Mostrar Password') }}</label>
                                        </div>
                                        <div class="w-100"></div>
                                        <div class="col-md-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label h6" for="remember">
                                                    {{ __('Recordar mis datos') }}
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <p><button type="submit" class="btn btn-dark py-3 px-4 w-100"><font color="white"><strong>{{ __('Login') }}</strong></font></button></p>
                                            </div>
                                            <a class="h6" href="{{ route('register') }}">{{ __('Crear una cuenta') }}</a><br>
                                            @if (Route::has('password.request'))
                                                <a class="h6" href="{{ route('password.request') }}">{{ __('¿Olvidaste tu contraseña?') }}</a>
                                            @endif


                                        </div>


                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-lg-5 mb-5 mb-lg-0 m-3">
                        <div class="mb-4">
                            <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">Buro Soft</h5>
                            <h1 class="text-white">El software de control mas completo</h1>
                        </div>
                        <p class="text-white">Modulos:</p>
                        <ul class="list-inline text-white m-0">
                            <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Financiero</li>
                            {{-- <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Acceso a todos los contenidos</li>
                            <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Aprendizaje comprobado</li> --}}
                        </ul>
                    </div>
                    {{-- <div class="col-lg-4">
                        <div class="card border-0">
                            <div class="card-header bg-light text-center p-4">
                                <h1 class="m-0">Suscripción</h1>
                            </div>
                            <div class="card-body rounded-bottom bg-primary p-5">
                                <form>
                                    <div>
                                        <a href="{{ url('register') }}" class="btn btn-dark btn-block border-0 py-3">Mensual $.9.99</a>
                                    </div>
                                    <br>
                                    <div>
                                        <a href="{{ url('register') }}" class="btn btn-dark btn-block border-0 py-3">Semestral $.53.99</a>
                                    </div>
                                    <br>
                                    <div>
                                        <a href="{{ url('register') }}" class="btn btn-dark btn-block border-0 py-3" >Anual $.99.99</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> --}}


                </div>
            </div>
        </div>
        <!-- Registration End -->
        @if (! optional(auth()->user())->hasActiveSubscription())
            <!-- Registration Start -->
            {{-- <div class="container-fluid bg-registration py-5" style="margin: 15px 0;">
                <div class="container py-5">
                    <div class="row align-items-center">


                        <div class="col-lg-5 mb-5 mb-lg-0 m-3">
                            <div class="mb-4">
                                <h5 class="text-primary text-uppercase mb-3" style="letter-spacing: 5px;">Suscribirse</h5>
                                <h1 class="text-white">10% de descuento en suscripción anual</h1>
                            </div>
                            <p class="text-white">Escoge el plan que mas se adecue a tus necesidades</p>
                            <ul class="list-inline text-white m-0">
                                <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Acceso sin limites</li>
                                <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Acceso a todos los contenidos</li>
                                <li class="py-2"><i class="fa fa-check text-primary mr-3"></i>Aprendizaje comprobado</li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <div class="card border-0">
                                <div class="card-header bg-light text-center p-4">
                                    <h1 class="m-0">Suscripción</h1>
                                </div>
                                <div class="card-body rounded-bottom bg-primary p-5">
                                    <form>
                                        <div>
                                            <a href="{{ url('subscribe') }}" class="btn btn-dark btn-block border-0 py-3">Mensual $.9.99</a>
                                        </div>
                                        <br>
                                        <div>
                                            <a href="{{ url('subscribe') }}" class="btn btn-dark btn-block border-0 py-3">Semestral $.53.99</a>
                                        </div>
                                        <br>
                                        <div>
                                            <a href="{{ url('subscribe') }}" class="btn btn-dark btn-block border-0 py-3">Anual $.99.99</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div> --}}
            <!-- Registration End -->
        @endif
    @endif

    @if (! optional(auth()->user())->hasActiveSubscription())
        <!-- About Start -->
        {{-- <div class="container-fluid py-5">
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
                        <a href="{{ url('about') }}" class="btn btn-primary py-md-2 px-md-4 font-weight-semi-bold mt-2">Ver mas...</a>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- About End -->
    @endif


    <Script>
        function showpassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
              x.type = "text";
            } else {
              x.type = "password";
            }
          }
    </Script>



@endsection


