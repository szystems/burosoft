@extends('layouts.empresa')
@section('content')

    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-journal-bookmark"></i>
                </div>
                <div class="page-title">
                    <h5>Cuentas</h5>
                </div>
            </div>
            <!-- Date range start -->
            <div class="d-flex align-items-end d-none d-sm-block">
                <h6 class="float-end text-light" id="reloj"></h6>
            </div>
        </div>
        <!-- Main header ends -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">


            <!-- Row start -->
            <div class="row gx-3">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="custom-tabs-container">
                                <ul class="nav nav-tabs" id="customTab2" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA" role="tab"
                                            aria-controls="oneA" aria-selected="true">Editar Información</a>
                                    </li>
                                </ul>
                                <div class="tab-content h-350">
                                    <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                                        <!-- Row start -->
                                        <div class="row gx-3">
                                            <div class="col-sm-12 col-12">
                                                @if (count($errors)>0)
                                                    <div class="alert alert-danger text-white" role="alert">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{$error}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                @endif
                                                <form action="{{ url('update-cuenta/'.$cuenta->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row gx-3">

                                                        <h3><u>Cuenta</u></h3>

                                                        <div class="col-md-3 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label for="razon_social" class="form-label">Razon Social</label>
                                                                <input name="razon_social" type="text" class="form-control" placeholder="Razon social..." value="{{ $cuenta->razon_social }}" />
                                                                @if ($errors->has('razon_social'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('razon_social') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label for="dpi" class="form-label">DPI</label>
                                                                <input name="dpi" type="text" class="form-control" placeholder="Dpi de la cuenta..." value="{{ $cuenta->dpi }}" />
                                                                @if ($errors->has('dpi'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('dpi') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label for="nit" class="form-label">Nit</label>
                                                                <input name="nit" type="text" class="form-control" placeholder="Nit de la cuenta..." value="{{ $cuenta->nit }}" />
                                                                @if ($errors->has('nit'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('nit') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label for="telefono" class="form-label">Teléfono</label>
                                                                <input name="telefono" type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');" class="form-control" placeholder="Teléfono de la cuenta..." value="{{ $cuenta->telefono }}" />
                                                                @if ($errors->has('telefono'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('telefono') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label for="correo" class="form-label">Email</label>
                                                                <input name="correo" type="text" class="form-control" placeholder="Correo electronico de la cuenta..." value="{{ $cuenta->correo }}" />
                                                                @if ($errors->has('correo'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('correo') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label for="ototra_forma_contactoa" class="form-label">Otra forma de contacto</label>
                                                                <input name="otra_forma_contacto" type="text" class="form-control" placeholder="Otra forma contacto..." value="{{ $cuenta->otra_forma_contacto }}" />
                                                                @if ($errors->has('otra_forma_contacto'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('otra_forma_contacto') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Dirección</label>
                                                                <textarea name="direccion" class="form-control" rows="3" placeholder="Dirección de la cuenta...">{{ $cuenta->direccion }}</textarea>
                                                                @if ($errors->has('direccion'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('direccion') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <h3><u>Intermediario</u></h3>

                                                        <div class="col-md-6 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Nombre</label>
                                                                <input name="datos_intermediario_nombre" type="text" class="form-control" placeholder="Nombre del intermediario..." value="{{ $cuenta->datos_intermediario_nombre }}" />
                                                                @if ($errors->has('datos_intermediario_nombre'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('datos_intermediario_nombre') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Teléfono</label>
                                                                <input name="datos_intermediario_telefono" type="text" class="form-control" placeholder="Teléfono del intermediario..." value="{{ $cuenta->datos_intermediario_telefono }}" />
                                                                @if ($errors->has('datos_intermediario_telefono'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('datos_intermediario_telefono') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Email</label>
                                                                <input name="datos_intermediario_correo" type="text" class="form-control" placeholder="Correo del intermediario..." value="{{ $cuenta->datos_intermediario_correo }}" />
                                                                @if ($errors->has('datos_intermediario_correo'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('datos_intermediario_correo') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <hr>

                                                        <h3><u>Propietario</u></h3>

                                                        <div class="col-md-6 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Nombre</label>
                                                                <input name="datos_propietario_nombre" type="text" class="form-control" placeholder="Nombre del propietario..." value="{{ $cuenta->datos_propietario_nombre }}" />
                                                                @if ($errors->has('datos_propietario_nombre'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('datos_propietario_nombre') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Teléfono</label>
                                                                <input name="datos_propietario_telefono" type="text" class="form-control" placeholder="Teléfono del propietario..." value="{{ $cuenta->datos_propietario_telefono }}" />
                                                                @if ($errors->has('datos_propietario_telefono'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('datos_propietario_telefono') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Email</label>
                                                                <input name="datos_propietario_correo" type="text" class="form-control" placeholder="Correo del propietario..." value="{{ $cuenta->datos_propietario_correo }}" />
                                                                @if ($errors->has('datos_propietario_correo'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('datos_propietario_correo') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ url('cuentas') }}" type="button" class="btn btn-danger">
                                                            <i class="bi bi-x-circle"></i> Cancelar
                                                        </a>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="bi bi-check2-square"></i> Grabar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Row end -->
                                    </div>

                                </div>
                                {{-- <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ url('edit-user/'.$user->id) }}" type="button" class="btn btn-outline-secondary">
                                        Cancelar
                                    </a>
                                    <button type="button" class="btn btn-success">
                                        Update
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row end -->
        </div>
        <!-- Content wrapper end -->
    </div>
    <!-- Content wrapper scroll end -->


@endsection
