@extends('layouts.frontend')
{{-- Sign in --}}
@section('content')
    <!-- Registration Start -->
    <div class="container-fluid bg-registration py-5" style="margin: 15px 0;">
        <div class="container py-1">
            <div class="row align-items-center justify-content-center">

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



            </div>
        </div>
    </div>

@endsection

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
