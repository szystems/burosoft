<!-- Row start -->
<div class="row gx-3">
    <div class="col-xl-12">
        <div class="card card-background-mask-info">
            {{-- <div class="card-header">
                <div class="card-title"><u>Doctores</u></div>
            </div> --}}
            <div class="card-body">

                <div class="accordion" id="accordionSpecialTitle">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSpecialTitleOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSpecialTitleOne" aria-expanded="true"
                                aria-controls="collapseSpecialTitleOne">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-filter text-info"></i>
                                    <div class="ms-3">
                                        <h5 class="text-yellow">Filtros de Búsqueda</h5>
                                        {{-- <p class="m-0 fw-normal">Leader</p> --}}

                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseSpecialTitleOne" class="accordion-collapse collapse"
                            aria-labelledby="headingSpecialTitleOne" data-bs-parent="#accordionSpecialTitle">
                            <div class="accordion-body">
                                <form action="{{ url('movimientos') }}" method="GET">
                                    @csrf
                                    <div class="row gx-3">

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-2">
                                                <label for="fecha_desde" class="form-label">Fecha Desde</label>
                                                <div class="input-group">
                                                    <input type="text" name="fecha_desde" class="form-control datepicker" id="fecha_desde" value="{{ $fechaDesdeVista }}"/>
                                                    <span class="input-group-text">
                                                        <i class="bi bi-calendar4"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-2">
                                                <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                                                <div class="input-group">
                                                    <input type="text" name="fecha_hasta" class="form-control datepicker" id="fecha_hasta" value="{{ $fechaHastaVista }}"/>
                                                    <span class="input-group-text">
                                                        <i class="bi bi-calendar4"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="cuenta_id" value="{{ $cuenta->id }}">

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3">
                                                <label for="saldo" class="form-label">Saldo</label>
                                                <select name="saldo" class="form-select" aria-label="Default select example">
                                                    <option value="" selected>Todos</option>
                                                    <option value="Pagado">Pagado</option>
                                                    <option value="Pendiente">Pendiente</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3">
                                                <label for="rubro" class="form-label">Rubro</label>
                                                <select name="rubro_id" class="form-select" aria-label="Default select example">
                                                    <option value="" selected>Todos</option>
                                                    @foreach($rubros as $rubro)
                                                        <option value="{{ $rubro->id }}">{{ $rubro->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3">
                                                <label for="usuario" class="form-label">Usuario</label>
                                                <select name="usuario_id" class="form-select" aria-label="Default select example">
                                                    <option value="" {{ request('usuario_id') == '' ? ' selected' : '' }}>Todos</option>
                                                    @foreach($usuarios as $usuario)
                                                        <option value="{{ $usuario->id }}"{{ old('usuario_id', request('usuario_id')) == $usuario->id ? ' selected' : '' }}>{{ $usuario->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3 mb-4">
                                                <button type="submit" class="btn btn-info mt-4">
                                                    <i class="bi bi-filter"></i> Filtrar
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script>
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    var optSimple = {
        language: "es",
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        orientation: "bottom auto",
        startDate: "01-01-1900",

    };
    $( '#fecha_desde' ).datepicker( optSimple );
    $( '#fecha_hasta' ).datepicker( optSimple );
</script>

<!-- Row end -->
