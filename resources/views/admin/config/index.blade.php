@extends('layouts.admin')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">settings</i>
                    </div>
                    <div class="text-center pt-1">
                        {{-- <p class="text-sm mb-0 text-capitalize">Today's Money</p> --}}
                        <h4 class="mb-0">{{ __('Configuración') }}</h4>
                    </div>
                    <hr class="dark horizontal my-0">
                </div>
                <div class="card-body p-3 pt-2">
                    <h4><u>{{ __('Configuración') }}</u></h4>
                    <!-- .flash-message -->
                    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                        @if(Session::has('alert-' . $msg))
                            <div class="alert alert-{{ $msg }} alert-dismissible text-white fade show" role="alert">
                                <span class="alert-text"><strong>Success!</strong> {{ Session::get('alert-' . $msg) }}</span>
                                <span class="alert-icon align-middle">
                                    <span class="material-icons text-md">
                                    thumb_up_off_alt
                                    </span>
                                </span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                     @endforeach
                    <!-- fin .flash-message -->
                    <form action="{{ url('update-config')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="">{{ __('Moneda') }}</label>
                                <select class="form-select px-2" aria-label="Default select example" name="currency">
                                    <option selected value="{{ $config->currency }}">{{ $config->currency }}</option>
                                    <option value="USD $">USD ($)</option>
                                    <option value="GTQ Q">GTQ (Q)</option>
                                </select>
                                <label><font color="orange">{{ __('Escoge la moneda que se mostrara') }}</font></label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="">Email</label>
                                <div class="input-group input-group-dynamic mb-4">
                                    <input type="email" name="email" class="form-control" placeholder="emails@bocacostacoffee.com" aria-describedby="basic-addon1" value="{{ $config->email }}" required>
                                </div>
                                <label><font color="orange">{{ __('Escribe el correo donde recibiras las notificaciones') }}</font></label>
                                @if ($errors->has('email'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('email') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>

                            {{-- <div class="col-md-3 mb-3">
                                <label for="">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="tax_status" {{ $config->tax_status == 1 ? 'checked':'' }}>
                                        <label class="form-check-label" for="flexSwitchCheckDefault">{{ __('Tax Status') }}</label>
                                    </div>
                                </label>

                                <div class="input-group input-group-dynamic mb-4">
                                    <span class="input-group-text" id="basic-addon1">%</span>
                                    <input type="number" name="tax" class="form-control" placeholder="Example:12%" aria-describedby="basic-addon1" value="{{ $config->tax }}" required>
                                </div>
                                <label><font color="orange">{{ __('Enable tax and percentage in order') }}</font></label>
                                @if ($errors->has('tax'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('tax') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="paypal" {{ $config->paypal == 1 ? 'checked':'' }}>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">{{ __('PayPal Status') }}</label>
                                </div>
                                <label><font color="orange">{{ __('Enable PayPal payment') }}</font></label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="dbt" {{ $config->dbt == 1 ? 'checked':'' }}>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">{{ __('POD/DBT Status') }}</label>
                                </div>
                                <label><font color="orange">{{ __('Enable Payment per Direct Bank Transfer') }}r</font></label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="store" {{ $config->store == 1 ? 'checked':'' }}>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">{{ __('Store Status') }}</label>
                                </div>
                                <label><font color="orange">{{ __('Enable Store') }}</font></label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="shopify" {{ $config->shopify == 1 ? 'checked':'' }}>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">{{ __('Shopify Link') }}</label>
                                </div>
                                <div class="input-group input-group-dynamic mb-4">
                                    <input type="text" name="shopify_link" class="form-control" placeholder="URL" aria-describedby="basic-addon1" value="{{ $config->shopify_link }}">
                                </div>
                                <label><font color="orange">{{ __('Enable Shopify Link') }}</font></label>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="amazon" {{ $config->amazon == 1 ? 'checked':'' }}>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">{{ __('Amazon Link') }}</label>
                                </div>
                                <div class="input-group input-group-dynamic mb-4">
                                    <input type="text" name="amazon_link" class="form-control" placeholder="URL" aria-describedby="basic-addon1" value="{{ $config->amazon_link }}">
                                </div>
                                <label><font color="orange">{{ __('Enable Amazon Link') }}</font></label>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="">{{ __('Shipping Price') }}</label>
                                <div class="input-group input-group-dynamic mb-4">
                                    <span class="input-group-text">{{ $config->currency_simbol }}</span>
                                    <input type="number" step=".01" class="form-control" aria-label="Amount (to the nearest dollar)" name="shipping" value="{{ number_format($config->shipping, 2, '.', ',') }}">
                                </div>
                                @if ($errors->has('shipping'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('shipping') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                            <div class="col-md-10 mb-3">
                                <label for="">{{ __('Shipping Description') }}</label>
                                <textarea name="shipping_description" cols="30" rows="5" class="form-control border px-2 ">{{ $config->shipping_description }}</textarea>
                                @if ($errors->has('shipping_description'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('shipping_description') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-3 mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="advertisement" {{ $config->advertisement == 1 ? 'checked':'' }}>
                                    <label class="form-check-label" for="flexSwitchCheckDefault">{{ __('Advertisement Status') }}</label>
                                </div>
                                <div class="input-group input-group-dynamic mb-4">
                                    <input type="text" name="advertisement_link" class="form-control" placeholder="{{ __('Advertisement URL') }}" aria-describedby="basic-addon1" value="{{ $config->advertisement_link }}">
                                </div>
                                <label><font color="orange">{{ __('Enable Advertisement') }}</font></label>
                            </div>

                            @if ($config->advertisement_image)
                            <div class="col-md-12 mb-3">
                                <label for="">{{ __('Advertisement Image') }}</label>
                                <img class="border-radius-md w-25" src="{{ asset('assets/uploads/advertisements/'.$config->advertisement_image) }}" alt="Advertisement Image">
                            </div>
                            @endif
                            <div class="col-md-12 mb-3">
                                <label for="">{{ __('Change advertisement image') }}</label>
                                <input type="file" name="advertisement_image" class="form-control border">
                            </div> --}}

                            @if ($config->logo)
                            <div class="col-md-12 mb-3">
                                <label for="">{{ __('Logo Imagen') }}</label>
                                <img class="border-radius-md w-25" src="{{ asset('assets/uploads/logos/'.$config->logo) }}" alt="Logo Imagen">
                            </div>
                            @endif
                            <div class="col-md-12 mb-3">
                                <label for="">{{ __('Cambiar Imagen') }}</label>
                                <input type="file" name="logo" class="form-control border">
                            </div>
                            <div class="col-md-12 mb-3" >
                                <button type="submit" class="btn btn-primary"><i class="material-icons">save</i> {{ __('Grabar') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p> --}}
                </div>
            </div>
        </div>

    </div>
@endsection
