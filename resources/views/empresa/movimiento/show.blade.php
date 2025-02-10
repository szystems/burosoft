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
                                                    @include('empresa.movimiento.printmovimiento')
                                                    <hr>

                                                    <div class="col-md-12 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">




                                                            @if ($movimiento->cuenta->estado == 1)
                                                                @if (Auth::user()->role_as == 0)
                                                                    <button type="button" class="btn btn-danger float-end m-1" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $movimiento->id }}">
                                                                        <i class="bi bi-trash"></i> Eliminar
                                                                    </button>
                                                                @endif
                                                                <a href="{{ url('edit-movimiento/'.$movimiento->id) }}" class="btn btn-warning float-end m-1" aria-current="page">
                                                                    <i class="bi bi-pencil"></i> Editar
                                                                </a>
                                                                @include('empresa.movimiento.deletemodal')
                                                            @endif
                                                            <a target="_blank" href="{{ url('pdf-movimiento-cabecera/'.$movimiento->id) }}" type="button" class="btn btn-info float-end m-1">
                                                                <i class="bi bi-printer"></i> Imprimir Cabecera
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="rubro" class="form-label">Código</label>
                                                            <p><strong class=" text-blue">{{ $movimiento->codigo }}</strong></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="fecha" class="form-label">Creado / Actualización</label>
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
                                                    <div class="col-md-8 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="proveedor" class="form-label">Descripción</label>
                                                            <p>{{ $movimiento->descripcion }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="proveedor" class="form-label">Estado</label>
                                                            <p>
                                                                @if($movimiento->estado == 0)
                                                                    <span class="badge shade-light-red">Eliminado</span>
                                                                @elseif ($movimiento->estado == 1)
                                                                    <span class="badge shade-light-green">Activo</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="monto_q" class="form-label">Monto (Quetzales)</label>
                                                            <p><strong>Q.{{ number_format($movimiento->monto_q,2, '.', ',') }}</strong></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="monto_q" class="form-label">Abonado/Saldo (Quetzales)</label>
                                                            @php
                                                                $saldoQ = $movimiento->monto_q - $totalAbonadoQ;
                                                            @endphp
                                                            <p class="text-success"><strong>Q.{{ number_format($totalAbonadoQ,2, '.', ',') }}</strong> / <font class="text-danger">Q.{{ number_format($saldoQ,2, '.', ',') }}</font></p>
                                                        </div>
                                                    </div>

                                                    @php
                                                        $monto_pagado_q = \App\Models\MovimientoPago::where('movimiento_id', $movimiento->id)
                                                        ->where('estado', 1)
                                                        ->sum('monto_q');
                                                        $saldo_q = $movimiento->monto_q - $monto_pagado_q;

                                                        $monto_pagado_d = \App\Models\MovimientoPago::where('movimiento_id', $movimiento->id)
                                                        ->where('estado', 1)
                                                        ->sum('monto_d');
                                                        $saldo_d = $movimiento->monto_d - $monto_pagado_d;
                                                    @endphp

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="saldo" class="form-label">Estado Saldo</label>
                                                            <p>
                                                                @if($movimiento->monto_q > $monto_pagado_q)
                                                                    <span class="badge shade-light-yellow">Pendiente</span>

                                                                @elseif ($movimiento->monto_q <= $monto_pagado_q)
                                                                    <span class="badge shade-light-green">Pagado</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="monto_d" class="form-label">Monto (Dólares)</label>
                                                            <p>$.{{ number_format($movimiento->monto_d,2, '.', ',') }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="monto_d" class="form-label">Abonado/Saldo (Dólares)</label>
                                                            @php
                                                                $saldoD = $movimiento->monto_d - $totalAbonadoD;
                                                            @endphp
                                                            <p class=" text-success">$.{{ number_format($totalAbonadoD,2, '.', ',') }} / <font class="text-danger">$.{{ number_format($saldoD,2, '.', ',') }}</font></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <!-- Form Field Start -->
                                                        <div class="mb-3">
                                                            <label for="saldo" class="form-label">Estado Saldo</label>
                                                            <p>
                                                                @if($movimiento->monto_d > $monto_pagado_d)
                                                                    <span class="badge shade-light-yellow">Pendiente</span>

                                                                @elseif ($movimiento->monto_d <= $monto_pagado_d)
                                                                    <span class="badge shade-light-green">Pagado</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>



                                                    <h4>Documentos</h4>
                                                    <hr>

                                                    @if ($movimiento->cuenta->estado == 1)
                                                        @if ($movimiento->estado == 1)
                                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                data-bs-target="#addDocModal">
                                                                <i class="bi bi-plus-square"></i> Agregar Documento
                                                            </button>
                                                        @endif

                                                    @endif

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
                                                                        @if ($movimiento->cuenta->estado == 1)
                                                                            @if ($movimiento->estado == 1)
                                                                                <button type="button" class="btn btn-warning  m-1" data-bs-toggle="modal"
                                                                                    data-bs-target="#editarDocModal{{ $doc->id }}">
                                                                                    <i class="bi bi-pencil"></i>
                                                                                </button>

                                                                                @if (Auth::user()->role_as == 0)
                                                                                    <button type="button" class="btn btn-danger  m-1" data-bs-toggle="modal" data-bs-target="#deleteDocModal-{{ $doc->id }}">
                                                                                        <i class="bi bi-trash-fill text-white"></i>
                                                                                    </button>
                                                                                @endif

                                                                                @include('empresa.movimiento.editdocmodal')
                                                                                @include('empresa.movimiento.deletedocmodal')
                                                                            @endif
                                                                        @endif

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

                                                    @if ($movimiento->cuenta->estado == 1)
                                                        @if ($movimiento->estado == 1)
                                                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                                                data-bs-target="#addPagoModal">
                                                                <i class="bi bi-plus-square"></i> Agregar Pago
                                                            </button>
                                                        @endif
                                                    @endif

                                                    @include('empresa.movimiento.addpagomodal')

                                                    <div class="table-responsive">
                                                        <table class="table align-middle table-striped flex-column">
                                                            <thead>
                                                                <tr>
                                                                    <td align="center"><i class="bi bi-list-task"></i></td>
                                                                    <td align="center">Código</td>
                                                                    <td align="center">fecha</td>
                                                                    <td align="center">Monto Q/$</td>
                                                                    <td align="center">Descripcion</td>
                                                                    <td align="center">Forma Pago</td>
                                                                    <td align="center">Imagen</td>
                                                                    <td align="center">Otros Datos</td>
                                                                    <td align="center">Usuario</td>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($pagos as $pago)
                                                                <tr>
                                                                    <td align="center">

                                                                        {{-- <a type="button" class="btn btn-info m-1" href="{{ asset('assets/uploads/pagos/'.$doc->archivo) }}" target="_blank"><i class="bi bi-eye-fill text-white"></i></a> --}}
                                                                        <a target="_blank" href="{{ url('pdf-pago/'.$pago->id) }}" type="button" class="btn btn-info">
                                                                            <i class="bi bi-printer"></i>
                                                                        </a>
                                                                        @if ($movimiento->cuenta->estado == 1)
                                                                            @if ($movimiento->estado == 1)
                                                                                @if ($pago->estado == 1)
                                                                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                                                        data-bs-target="#editarPagoModal{{ $pago->id }}">
                                                                                        <i class="bi bi-pencil"></i>
                                                                                    </button>

                                                                                    @if (Auth::user()->role_as == 0)
                                                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletePagoModal-{{ $pago->id }}">
                                                                                            <i class="bi bi-trash-fill text-white"></i>
                                                                                        </button>
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        @endif

                                                                        {{-- @include('empresa.movimiento.editpagomodal')
                                                                        @include('empresa.movimiento.deletepagomodal') --}}

                                                                    </td>
                                                                    <td align="center">
                                                                        <p class="text-blue"><small><strong>{{ $pago->codigo }}</strong></small></p>
                                                                        <p>
                                                                            @if($pago->estado == 0)
                                                                                <span class="badge shade-light-red">Eliminado</span>
                                                                            @endif
                                                                        </p>
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
                                                                            @if (Auth::user()->role_as == 0)
                                                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deletePagoImgModal-{{ $pago->id }}">
                                                                                    <i class="bi bi-trash-fill"></i>
                                                                                </button>
                                                                            @endif
                                                                        @endif
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>
                                                                            @if ($pago->numero_documento)
                                                                                <strong>No. Documento:</strong> {{ $pago->numero_documento }}
                                                                                <br>
                                                                            @endif
                                                                            @if ($pago->banco)
                                                                                <strong>Banco:</strong> {{ $pago->banco }}
                                                                                <br>
                                                                            @endif
                                                                            @if ($pago->numero_cuenta)
                                                                                <strong>Numero Cuenta:</strong> {{ $pago->numero_cuenta }}
                                                                                <br>
                                                                            @endif
                                                                            @if ($pago->fecha_documento)
                                                                                @php
                                                                                    $fecha_documento = date("d-m-Y", strtotime($pago->fecha_documento));
                                                                                @endphp
                                                                                <strong>Fecha:</strong> {{ $fecha_documento }}
                                                                                <br>
                                                                            @endif
                                                                        </p>
                                                                    </td>
                                                                    <td align="center">
                                                                        <p>{{ $pago->usuario->name }}</p>
                                                                    </td>


                                                                </tr>
                                                                @include('empresa.movimiento.editpagomodal')
                                                                @include('empresa.movimiento.deletepagomodal')
                                                                @include('empresa.movimiento.deletepagoimgmodal')
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        @if ($pagos->count() == 0)
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
