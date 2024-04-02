@extends('layouts.frontend')


@section('content')
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
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Suscribirse</div>

                <div class="card-body">
                    <form action="{{ route('subscribe.store') }}" method="POST" id="paymentForm">
                        @csrf

                        <div class="row mt-3">
                            <div class="col">
                                <label>Selecciona un Plan:</label>
                                <div class="form-group" align="center">
                                    <div class="btn-group-vertical btn-group-toggle" data-toggle="buttons">
                                        @foreach ($plans as $plan)
                                            @if ($plan->slug != "gratis")
                                                <label class="btn btn-outline-info rounded m-2 p-3">
                                                    <input
                                                        type="radio"
                                                        name="plan"
                                                        value="{{ $plan->slug }}"
                                                        required
                                                    >
                                                    <p class="h2 font-weight-bold text-capitalize">
                                                        {{ $plan->slug }}
                                                    </p>

                                                    <p class="display-4 text-capitalize">
                                                        {{ $plan->visual_price }}
                                                    </p>
                                                </label>
                                            @endif

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col" align="center">
                                <label>Selecciona la plataforma de pago:</label>





                                <div class="form-group" id="toggler">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        @foreach ($paymentPlatforms as $paymentPlatform)
                                            <label class="btn btn-outline-secondary rounded m-2 p-1" data-bs-toggle="collapse" href="#{{ $paymentPlatform->name }}Collapse" role="button" aria-expanded="false" aria-controls="{{ $paymentPlatform->name }}Collapse">
                                                <input class="form-check-input " type="radio" name="payment_platform" value="{{ $paymentPlatform->id }}" required>
                                                <img class="img-thumbnail" src="{{ asset($paymentPlatform->image) }}">
                                            </label>
                                        @endforeach
                                    </div>
                                    @foreach ($paymentPlatforms as $paymentPlatform)
                                        <div class="collapse" id="{{ $paymentPlatform->name }}Collapse" data-bs-parent="#toggler">
                                            <div class="card card-body">
                                                @includeIf('components.' . strtolower($paymentPlatform->name) . '-collapse')
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <button type="submit" id="payButton" class="btn btn-primary btn-lg">Suscribirse</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
