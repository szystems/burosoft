@extends('layouts.empresa')
@section('content')

    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="page-title">
                    <h5>Movimientos</h5>
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
                                            aria-controls="oneA" aria-selected="true">Editar Movimiento</a>
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
                                                <form action="{{ url('update-movimiento/'.$movimiento->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row gx-3">

                                                        <h3><u>Movimiento</u></h3>

                                                        <div class="col-md-3 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label for="cuenta" class="form-label">Cuenta</label>
                                                                <select name="cuenta_id" class="form-select" aria-label="Default select example">
                                                                    @foreach($cuentas as $cuenta)
                                                                        <option value="{{ $cuenta->id }}"{{ $movimiento->cuenta_id == $cuenta->id ? ' selected' : '' }}>{{ $cuenta->razon_social }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('cuenta_id'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('cuenta_id') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                                <a href="{{ url('add-cuenta') }}" class="text-primary"><i class="bi bi-plus-square"></i> Agregar Cuenta</a>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label for="rubro" class="form-label">Rubro</label>
                                                                <select name="rubro_id" class="form-select" aria-label="Default select example">
                                                                    @foreach($rubros as $rubro)
                                                                        <option value="{{ $rubro->id }}"{{ $movimiento->rubro_id == $rubro->id ? ' selected' : '' }}>{{ $rubro->nombre }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('cuenta_id'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('cuenta_id') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                                <a href="{{ url('add-rubro') }}" class="text-primary"><i class="bi bi-plus-square"></i> Agregar Rubro</a>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label class="form-label">Monto (Quetzales)</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">Q.</span>
                                                                <input name="monto_q" type="number" step="0.01" class="form-control" id="monto_q" placeholder="0.00"  value="{{ $movimiento->monto_q }}">
                                                            </div>
                                                            @if ($errors->has('monto_q'))
                                                                <span class="help-block opacity-7">
                                                                        <strong>
                                                                            <font color="red">{{ $errors->first('monto_q') }}</font>
                                                                        </strong>
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-3 mb-3">
                                                            <label class="form-label">Monto (Dolares)</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text">$.</span>
                                                                <input name="monto_d" type="number" step="0.01" class="form-control" id="monto_d" placeholder="0.00"  value="{{ $movimiento->monto_d }}">
                                                            </div>
                                                            @if ($errors->has('monto_d'))
                                                                <span class="help-block opacity-7">
                                                                        <strong>
                                                                            <font color="red">{{ $errors->first('monto_d') }}</font>
                                                                        </strong>
                                                                </span>
                                                            @endif
                                                        </div>

                                                        <div class="col-md-12 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Descripción</label>
                                                                <textarea name="descripcion" class="form-control" rows="3" placeholder="Descripción del movimiento...">{{ $movimiento->descripcion }}</textarea>
                                                                @if ($errors->has('descripcion'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('descripcion') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                                                        <input type="hidden" name="empresa_id" value="{{ Auth::user()->empresa_id }}">

                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ url('movimientos') }}" type="button" class="btn btn-danger">
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
