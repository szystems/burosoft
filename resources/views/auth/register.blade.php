@extends('layouts.frontend')
{{-- Register --}}
@section('content')
    <!-- Registration Start -->
    <div class="container-fluid bg-registration py-5" style="margin: 15px 0;">
        <div class="container py-1">
            <div class="row align-items-center justify-content-center">

                <div class="col-lg-6">
                    <div class="card border-0">
                        <div class="card-header bg-light text-center p-2">
                            <h1 class="m-0">Registrarse</h1>
                        </div>
                        <div class="card-body rounded-bottom bg-primary p-0">
                            <form method="POST" action="{{ route('register') }}" class="billing-form ftco-bg-dark p-3 p-md-5">
                                @csrf
                                <h3 class="mb-4 billing-heading"> {{ __('Crear Cuenta') }}</h3>
                                <div class="row align-items-end">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="firstname" class="h6">{{ __('Nombre') }}</label>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="firstname" class="h6">{{ __('Email') }}</label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
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
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="lastname" class="h6">{{  __('Confirmar Contraseña') }}</label>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                        <input type="checkbox" onclick="showpassword(); showpasswordconfirm()"> <label for="" class="h6"> {{ __('Show Password') }}</label>
                                    </div>
                                    {{-- <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="firstname">{{ __('Timezone') }}</label>
                                            <select class="form-control" name="timezone" id="timezone">
                                                <option selected value="UTC">UTC (UTC +00:00)</option>
                                                @foreach(Helpers::getTimeZoneList() as $timezone => $timezone_gmt_diff)
                                                    <option value="{{ $timezone }}" {{ ( $timezone === old('timezone')) ? 'selected' : '' }}>
                                                        {{ $timezone_gmt_diff }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    <input type="hidden" name="timezone" id="timezone" value="UTC">
                                    <div class="w-100"></div>
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
                                                <label class="custom-control-label h6" for="register-policy-2">{{ __('Estoy de acuerdo con los') }} <a href="#"><font color="white">{{ __('términos y condiciones') }}</font></a> *</label>
                                            </div><!-- End .custom-checkbox -->
                                            <p><button type="submit" class="btn btn-dark py-3 px-4 w-100">
                                                    <font color="white"><strong>{{ __('Registrarse') }}</strong></font>
                                                </button></p>
                                        </div>
                                        <a class="btn btn-link" href="{{ route('login') }}">
                                            {{ __('¿Ya tienes una cuenta? Entrar') }}
                                        </a>

                                    </div>


                                </div>
                            </form><!-- END -->
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>
    <!-- Registration End -->
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

      function showpasswordconfirm() {
        var x = document.getElementById("password-confirm");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }
</Script>

