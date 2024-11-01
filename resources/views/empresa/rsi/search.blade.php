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
                                <form action="{{ url('rsi') }}" method="GET">
                                    @csrf
                                    <div class="row gx-3">

                                        <div class="col-md-4 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3">
                                                <label for="cuenta" class="form-label">Cuenta</label>
                                                <select name="cuenta_id" class="form-select" aria-label="Default select example">
                                                    <option value=""{{ request('cuenta_id') == '' ? ' selected' : '' }}>Todos</option>
                                                    @foreach($cuentas as $cuenta)
                                                        <option value="{{ $cuenta->id }}"{{ old('cuenta_id', request('cuenta_id')) == $cuenta->id ? ' selected' : '' }}>{{ $cuenta->codigo }} {{ $cuenta->razon_social }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3">
                                                <label for="saldo" class="form-label">Saldo</label>
                                                <select name="saldo" class="form-select" aria-label="Default select example">
                                                    <option value=""{{ request('saldo') == '' ? ' selected' : '' }}>Todos</option>
                                                    <option value="Pagado"{{ request('saldo') == 'Pagado' ? ' selected' : '' }}>Pagado</option>
                                                    <option value="Pendiente"{{ request('saldo') == 'Pendiente' ? ' selected' : '' }}>Pendiente</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3 ">
                                                <button type="submit" class="btn btn-info">
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

<!-- Row end -->
