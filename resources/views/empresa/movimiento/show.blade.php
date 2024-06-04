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
                                            aria-controls="oneA" aria-selected="true">Información</a>
                                    </li>
                                </ul>
                                <div class="tab-content h-350">
                                    <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                                        <!-- Row start -->
                                        <div class="row gx-3">
                                            <div class="col-sm-12 col-12">
                                                <div class="row gx-3">

                                                    @if (count($errors)>0)
                                                        <div class="alert alert-danger text-white" role="alert">
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{$error}}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    <h4>Movimiento</h4>
                                                    <hr>

                                                    <div class="col-md-12 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <a href="{{ url('edit-movimiento/'.$movimiento->id) }}" class="btn btn-warning float-end m-1" aria-current="page"><i class="bi bi-pencil"></i> Editar</a>
                                                            <button type="button" class="btn btn-danger float-end m-1" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $movimiento->id }}">
                                                                <i class="bi bi-trash"></i> Eliminar
                                                            </button>
                                                            @include('empresa.movimiento.deletemodal')
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="rubro" class="form-label">ID</label>
                                                            <p><strong class=" text-info-emphasis">{{ $movimiento->id }}</strong></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="fecha" class="form-label">Creado / Actualizacion</label>
                                                            @php
                                                                $fecha = date("d/m/Y", strtotime($movimiento->fecha));
                                                                $ultimaActualizacion = date("d/m/Y", strtotime($movimiento->updated_at));
                                                            @endphp
                                                            <p class="text-info">{{ $fecha }} - {{ $ultimaActualizacion }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="cuenta" class="form-label">Cuenta</label>
                                                            <p>{{ $movimiento->cuenta->razon_social }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="rubro" class="form-label">Rubro</label>
                                                            <p>{{ $movimiento->rubro->nombre }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="usuario" class="form-label">Usuario</label>
                                                            @php
                                                                $usuario = \App\Models\User::find( $movimiento->usuario_id );
                                                            @endphp
                                                            <p><a href="{{ url('show-empresa-usuario/'.$movimiento->usuario_id) }}"></a>{{ $usuario->name }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="proveedor" class="form-label">Descripción</label>
                                                            <p>{{ $movimiento->descripcion }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="monto_q" class="form-label">Monto (Quetzaltes)</label>
                                                            <p><strong>Q.{{ number_format($movimiento->monto_q,2, '.', ',') }}</strong></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="monto_q" class="form-label">Abonado/Saldo (Quetzaltes)</label>
                                                            @php
                                                                $saldoQ = $movimiento->monto_q - $totalAbonadoQ;
                                                            @endphp
                                                            <p class="text-success"><strong>Q.{{ number_format($totalAbonadoQ,2, '.', ',') }}</strong> / <font class="text-danger">Q.{{ number_format($saldoQ,2, '.', ',') }}</font></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="monto_d" class="form-label">Monto (Dolares)</label>
                                                            <p>$.{{ number_format($movimiento->monto_d,2, '.', ',') }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="monto_d" class="form-label">Abonado/Saldo (Dolares)</label>
                                                            @php
                                                                $saldoD = $movimiento->monto_d - $totalAbonadoD;
                                                            @endphp
                                                            <p class=" text-success">$.{{ number_format($totalAbonadoD,2, '.', ',') }} / <font class="text-danger">$.{{ number_format($saldoD,2, '.', ',') }}</font></p>
                                                        </div>
                                                    </div>



                                                    <h4>Documentos</h4>
                                                    <hr>

                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#addDocModal">
                                                        <i class="bi bi-plus-square"></i> Agregar Documento
                                                    </button>

                                                    @include('empresa.movimiento.adddocmodal')

                                                    <div class="table-responsive">
                                                        <table class="table align-middle table-striped flex-column">
                                                            <thead>
                                                                <tr>
                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                    <td align="center">fecha / <strong>Nombre</strong></td>
                                                                    <td align="center">Tipo</td>
                                                                    <td align="center">Descripcion</td>
                                                                    <td align="center">Usuario</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($documentos as $doc)
                                                                <tr>
                                                                    <td align="center">

                                                                        <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/documentos/'.$doc->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a>

                                                                        <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                            data-bs-target="#editarDocModal{{ $doc->id }}">
                                                                            <i class="bi bi-pencil"></i>
                                                                        </button>

                                                                        @if (Auth::user()->principal == 1)
                                                                            <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteDocModal-{{ $doc->id }}">
                                                                                <i class="bi bi-trash-fill text-white"></i>
                                                                            </button>
                                                                        @endif

                                                                        @include('empresa.movimiento.editdocmodal')
                                                                        @include('empresa.movimiento.deletedocmodal')

                                                                    </td>
                                                                    <td align="center">
                                                                        @php
                                                                            $fecha = date('d/m/Y', strtotime($doc->created_at));
                                                                        @endphp
                                                                        <p>{{ $fecha }} - <strong><a href="{{ asset('assets/uploads/documentos/'.$doc->archivo) }}" target="_blank" class="text-blue">{{ $doc->nombre }}</a></strong></p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{ $doc->tipo}}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{  $doc->descripcion}}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        @php
                                                                            $usuario = \App\Models\User::find( $movimiento->usuario_id );
                                                                        @endphp
                                                                        <p>{{ $doc->usuario->name }}</p>
                                                                    </td>


                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        @if ($documentos->count() == 0)
                                                            <div class="alert alert-warning text-white" role="alert">
                                                                <ul align="center">
                                                                    <p>No se han ingresado documentos.</p>
                                                                </ul>
                                                            </div>
                                                        @endif
                                                        {{-- {{ $Movimientos->links() }} --}}
                                                    </div>

                                                    <h4>Pagos</h4>
                                                    <hr>

                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                        data-bs-target="#addPagoModal">
                                                        <i class="bi bi-plus-square"></i> Agregar Pago
                                                    </button>

                                                    @include('empresa.movimiento.addpagomodal')

                                                    <div class="table-responsive">
                                                        <table class="table align-middle table-striped flex-column">
                                                            <thead>
                                                                <tr>
                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                    <td align="center">fecha</td>
                                                                    <td align="center">Monto Q/$</td>
                                                                    <td align="center">Descripcion</td>
                                                                    <td align="center">Forma Pago</td>
                                                                    <td align="center">Imagen</td>
                                                                    <td align="center">Usuario</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($pagos as $pago)
                                                                <tr>
                                                                    <td align="center">

                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pagos/'.$doc->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}

                                                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                                            data-bs-target="#editarPagoModal{{ $pago->id }}">
                                                                            <i class="bi bi-pencil"></i>
                                                                        </button>

                                                                        @if (Auth::user()->principal == 1)
                                                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletePagoModal-{{ $pago->id }}">
                                                                                <i class="bi bi-trash-fill text-white"></i>
                                                                            </button>
                                                                        @endif

                                                                        {{-- @include('empresa.movimiento.editpagomodal')
                                                                        @include('empresa.movimiento.deletepagomodal') --}}

                                                                    </td>
                                                                    <td align="center">
                                                                        @php
                                                                            $fecha = date('d/m/Y', strtotime($pago->created_at));
                                                                        @endphp
                                                                        <p>{{ $fecha }}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p><strong>Q.{{ number_format($pago->monto_q,2, '.', ',') }}</strong> / $.{{ number_format($pago->monto_d,2, '.', ',') }}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{  $pago->descripcion}}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{ $pago->forma_pago }}</p>
                                                                    </td>
                                                                    <td align="center">
                                                                        @if ($pago->imagen)
                                                                            <a href="{{ asset('assets/uploads/pagos/'.$pago->imagen) }}" target="_blank" rel="Imagen pago"><img src="{{ asset('assets/uploads/pagos/'.$pago->imagen) }}" class="img-thumbnail" style="height: 100px;" alt="Imagen pago" /></a>
                                                                        @endif
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{ $pago->usuario->name }}</p>
                                                                    </td>


                                                                </tr>
                                                                @include('empresa.movimiento.editpagomodal')
                                                                @include('empresa.movimiento.deletepagomodal')
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        @if ($documentos->count() == 0)
                                                            <div class="alert alert-warning text-white" role="alert">
                                                                <ul align="center">
                                                                    <p>No se han ingresado documentos.</p>
                                                                </ul>
                                                            </div>
                                                        @endif
                                                        {{-- {{ $Movimientos->links() }} --}}
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Row end -->
                                    </div>

                                </div>
                                {{-- <div class="d-flex gap-2 justify-content-end">
                                    <button type="button" class="btn btn-outline-secondary">
                                        Cancel
                                    </button>
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
