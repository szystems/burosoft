@extends('layouts.frontend')
{{-- Account Details --}}
@section('content')
    <section class="ftco-section">
        <div class="container">
            <div class="row">

                @php
                    $usuario = Auth::user()->name;
                    $nombre = explode(' ', trim($usuario));
                    $names = str_word_count($usuario);
                @endphp

                <div class="col-md-4 sidebar ftco-animate">
                    <div class="sidebar-box ftco-animate">
                        <div class="categories">
                            <h3>
                                <font color="fa9932">Hola</font>  {{ ucwords($nombre[0]) }}! <br>
                            </h3>

                            <ul class="list-group">
                                <li class="list-group-item"><a class="h4" href="{{ url('my-account') }}"><font color="fa9932">{{ __('Mi Cuenta') }}</font></a></li>
                                <li class="list-group-item active"><a class="h6" href="{{ url('user-details/'.Auth::id()) }}"><font color="white">- {{ __('Detalles de Cuenta') }}</font></a></li>
                                <li class="list-group-item"><a href="{{ url('user-subscription/'.Auth::id()) }}">- {{ __('Suscripción') }}</a></li>
                                <li class="list-group-item">
                                    <a href="javascript:; {{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-primary py-2 px-4 ml-auto d-none d-lg-block"><span>{{ __('Cerrar Sesión') }}</span></a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 ftco-animate">


                    <div class="row">
                        <div class="col-sm-12">
                            <h3>{{ __('Detalles de Cuenta') }}</h3>
                        </div><!-- End .col-sm-6 -->
                        <div class="col-sm-4">
                            <label>{{ __('Nombre') }}</label>
                            <input readonly name="name" type="text" class="form-control" value="{{ $user->name }}">
                        </div><!-- End .col-sm-6 -->
                        {{-- <div class="col-sm-4">
                            <label>{{ __('Teléfono') }}</label>
                            <input readonly name="phone" type="text" class="form-control" value="{{ $user->phone }}">
                        </div> --}}
                        <div class="col-sm-4">
                            <label>Email</label>
                            <input readonly name="email" type="text" class="form-control" value="{{ $user->email }}">
                        </div><!-- End .col-sm-6 -->
                        {{-- <div class="col-sm-3">
                            <label>{{ __('Pais') }}</label>
                            <input readonly name="country" type="text" class="form-control" value="{{ $user->country }}">
                        </div>
                        <div class="col-sm-3">
                            <label>{{ __('Departamento/Estado') }}</label>
                            <input readonly name="state" type="text" class="form-control" value="{{ $user->state }}">
                        </div>
                        <div class="col-sm-3">
                            <label>{{ __('Ciudad') }}</label>
                            <input readonly name="city" type="text" class="form-control" value="{{ $user->city }}">
                        </div>
                        <div class="col-sm-3">
                            <label>{{ __('Codigo Postal') }}</label>
                            <input readonly name="zipcode" type="text" class="form-control" value="{{ $user->zipcode }}">
                        </div>
                        <div class="col-sm-12">
                            <label>{{ __('Dirección') }} 1</label>
                            <input readonly name="address1" type="text" class="form-control" value="{{ $user->address1 }}">
                        </div>
                        <div class="col-sm-12">
                            <label>{{ __('Dirección') }} 2</label>
                            <input readonly name="address2" type="text" class="form-control" value="{{ $user->address2 }}">
                        </div>
                        <div class="col-sm-6">
                            <label>{{ __('Zona Horaria') }}</label>
                            <input readonly name="timezone" type="text" class="form-control" value="{{ $user->timezone }}">
                        </div> --}}
                    </div>
                    <p>
                        <a href="{{ url('user-edit/'.Auth::id()) }}" class="btn btn-primary m-2 py-2 px-4">{{ __('Editar datos de cuenta') }}</a>
                    </p>
                </div> <!-- .col-md-8 -->

            </div>
        </div>
    </section> <!-- .section -->
@endsection
