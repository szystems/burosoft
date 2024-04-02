@extends('layouts.frontend')
{{-- Email --}}
@section('content')
    <section class="ftco-section">
        <div class="container">
            <div class="row">

                <div class="col-xl-3 sidebar ftco-animate">

                </div>

                <div class="col-xl-6 ftco-animate">
                    <form method="POST" action="{{ route('password.email') }}" class="billing-form ftco-bg-dark p-3 p-md-5">
                        @csrf
                        <h3 class="mb-4 billing-heading"> {{ __('¿Olvidaste tu contraseña?') }}</h3>

                        <div class="row align-items-end">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="firstname">{{ __('Email') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="w-100"></div>
                            <div class="col-md-12">

                                <div class="form-group">
                                    <p><button type="submit" class="btn btn-primary py-3 px-4 w-100">
                                            <font color="white"><strong>{{ __('Enviar enlace de restablecimiento de contraseña') }}</strong></font>
                                        </button></p>
                                </div>

                            </div>


                        </div>
                    </form><!-- END -->
                </div> <!-- .col-md-6 -->




                <div class="col-xl-3 sidebar ftco-animate">

                </div>

            </div>
        </div>
    </section> <!-- .section -->
@endsection
