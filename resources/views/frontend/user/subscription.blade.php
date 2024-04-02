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
                                <li class="list-group-item"><a href="{{ url('user-details/'.Auth::id()) }}">- {{ __('Detalles de Cuenta') }}</a></li>
                                <li class="list-group-item active"><a href="{{ url('user-subscription/'.Auth::id()) }}"><font color="white">- {{ __('Suscripción') }}</font></a></li>
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
                            <h3>{{ __('Suscripción') }}</h3>
                        </div><!-- End .col-sm-6 -->
                        {{-- @if($subscripcion)

                        @else

                        @endif --}}
                        @isset($subscription)
                            <div class="col-sm-3">
                                @if ($subscription->status == null)
                                    <label><b>{{ __('Gratis hasta') }}</b></label>
                                @elseif ($subscription->status == 'ACTIVE')
                                    <label><b>{{ __('Proximo Cobro') }}</b></label>
                                @elseif ($subscription->status == 'SUSPENDED')
                                    <label><b>{{ __('Activa Hasta') }}</b></label>
                                @endif
                                @php
                                    $active_until = date("d-m-Y", strtotime($subscription->active_until));
                                    $plan = App\Models\Plan::find($subscription->plan_id);
                                @endphp
                                <p>{{ $active_until }}</p>
                            </div>
                            <div class="col-sm-3">
                                <label><b>{{ __('Plan') }}</b></label>
                                <p>{{ $plan->slug }}</p>
                            </div>
                            <div class="col-sm-3">
                                <label><b>{{ __('Precio') }}</b></label>
                                <p>{{ $plan->visual_price }}</p>
                            </div>
                            <div class="col-sm-3">
                                <label><b>{{ __('Estado') }}</b></label>
                                @if ($subscription->status == null)
                                    <p><span class="badge bg-info text-white">Gratis</span></p>
                                @elseif ($subscription->status == 'ACTIVE')
                                    <p><span class="badge bg-success text-white">ACTIVA</span></p>
                                @elseif ($subscription->status == 'SUSPENDED')
                                    <p><span class="badge bg-warning text-white">SUSPENDIDA</span></p>
                                @endif
                            </div>
                            <div class="col-sm-12">

                                <form action="{{ url('update-status') }}" method="POST">
                                    @csrf
                                    <div class="text-center mt-3">
                                        <input type="hidden" name="subscription_id" value="{{ $subscription->subscription_id }}">
                                        <input type="hidden" name="payment_platform" value="1">
                                        <input type="hidden" name="status" value="{{ $subscription->status }}">
                                        @if ($subscription->status == "ACTIVE")
                                            <button type="submit" class="btn btn-primary btn-lg text-white">Suspender Suscripción</button>
                                        @endif
                                        @if ($subscription->status == "SUSPENDED")
                                            <button type="submit" class="btn btn-success btn-lg text-white">Activar Suscripción</button>
                                        @endif

                                    </div>
                                </form>
                            </div>
                            @if ($subscription->status == "ACTIVE" or $subscription->status == "SUSPENDED")
                            <div class="col-sm-12" align="center">
                                <hr>
                                {{-- <form action="{{ url('cancel-subscription') }}" method="POST">
                                    @csrf
                                    <div class="text-center mt-3">
                                        <input type="hidden" name="subscription_id" value="{{ $subscription->subscription_id }}">
                                        <input type="hidden" name="payment_platform" value="1">
                                        <button type="submit" class="btn btn-danger btn-lg text-white">Cancelar Suscripción</button>
                                    </div>
                                </form> --}}
                                {{-- <button type="button" class="btn btn-danger btn-lg text-white" data-bs-toggle="modal" data-bs-target="#cancelSubscriptionModal">Cancelar Suscripción</button> --}}
                                <button type="button" class="btn btn-danger btn-lg text-white" data-toggle="modal" data-target="#cancelSubscriptionModal">
                                    Cancelar Suscripción
                                </button>
                                @include('frontend.user.cancelsubscriptionmodal')
                            </div>
                            @endif
                            @if ($subscription->status == null)
                            <div class="col-sm-12" align="center">
                                <hr>
                                <button type="button" class="btn btn-danger btn-lg text-white" data-toggle="modal" data-target="#cancelSubscriptionGratisModal">
                                    Cancelar Suscripción
                                </button>
                                @include('frontend.user.cancelsubscriptiongratismodal')
                            </div>
                            @endif
                        @else
                            <div class="col-sm-12">
                                <p>No tienes una suscripción activa.</p>
                            </div>
                        @endisset


                    </div>
                </div> <!-- .col-md-8 -->

            </div>
        </div>
    </section> <!-- .section -->
@endsection
