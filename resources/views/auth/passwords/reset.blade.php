@extends('layouts.frontend')
{{-- Register --}}
@section('content')
    <section class="ftco-section">
        <div class="container">
            <div class="row">

                <div class="col-xl-3 sidebar ftco-animate">

                </div>

                <div class="col-xl-6 ftco-animate">
                    <form method="POST" action="{{ route('password.update') }}" class="billing-form ftco-bg-dark p-3 p-md-5">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <h3 class="mb-4 billing-heading">{{ __('Resetear Password') }}</h3>
                        <div class="row align-items-end">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="firstname">{{ __('Email') }}</label>
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
                                    <label for="lastname">{{ __('Password') }}</label>
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
                                    <label for="lastname">{{  __('Confirmar Contraseña') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <input type="checkbox" onclick="showpassword(); showpasswordconfirm()">{{ __('Show Password') }}
                            </div>

                            <div class="w-100"></div>
                            <div class="col-md-12">

                                <div class="form-group">

                                    <p><button type="submit" class="btn btn-primary py-3 px-4 w-100">
                                            <font color="white"><strong>{{ __('Resetear Password') }}</strong></font>
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
