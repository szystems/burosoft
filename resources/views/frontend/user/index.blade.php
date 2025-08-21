@extends('layouts.frontend')
{{-- Acoount index --}}
@section('content')
    <section class="ftco-section">
        <div class="container">
            <div class="row">

                @php
                    $usuario = Auth::user()->name; $nombre = explode(' ',trim($usuario));
                    $names =str_word_count($usuario);
                @endphp

                <div class="col-md-4 sidebar ftco-animate">
                    <div class="sidebar-box ftco-animate">
                        <div class="categories">
                            <h3>
                                <font color="fa9932">Hola</font>  {{ ucwords($nombre[0]) }}! <br>
                            </h3>

                            <ul class="list-group">
                                <li class="list-group-item active"><a class="h4" href="{{ url('my-account') }}"><font color="white">{{ __('Mi Cuenta') }}</font></a></li>
                                <li class="list-group-item"><a href="{{ url('user-details/'.Auth::id()) }}">- {{ __('Detalles de Cuenta') }}</a></li>
                                {{-- <li class="list-group-item"><a href="{{ url('user-subscription/'.Auth::id()) }}">- {{ __('Suscripción') }}</a></li> --}}
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
                    <h2 class="mb-3">{{ __('Bienvenido a tu cuenta') }} {{ ucwords($nombre[0]) }}. </h2>
                    <p>
                        {{-- {{ __('Aqui puedes ver tus ') }} <a href="{{ url('my-orders') }}" class="tab-trigger-link link-underline">{{ __('ordenes recientes') }}</a>  --}}
                        {{ __('Aquí podrás manejar tu cuenta como tu') }} <a href="{{ url('user-details/'.Auth::id()) }}" class="tab-trigger-link">{{ __('información personal.') }}</a>
                    </p>
                    <p>
                        {{ __('¿No eres el usuario?') }}
                        <a href="javascript:; {{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Cerrar Sesión') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </p>
                </div> <!-- .col-md-8 -->

            </div>
        </div>
    </section> <!-- .section -->
@endsection
