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
                                <form action="{{ url('index-pat/'.$cuenta->id) }}" method="GET">
                                    @csrf
                                    <div class="row gx-3">

                                        <div class="col-md-4 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3">
                                                <label for="queryPat" class="form-label">Buscar</label>
                                                <input class="form-control" placeholder="No.Programa, No.Expediente..." name="queryPat" value="{{ $queryPat }}"/>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3">
                                                <label for="gerencia" class="form-label">Gerencia</label>
                                                <select name="gerencia" class="form-select" aria-label="Default select example">
                                                    <option value="" {{ request('gerencia') == '' ? ' selected' : '' }}>Todos</option>
                                                    <option value="Central" {{ request('gerencia') == 'Central' ? ' selected' : '' }}>Central</option>
                                                    <option value="Occidente" {{ request('gerencia') == 'Occidente' ? ' selected' : '' }}>Occidente</option>
                                                    <option value="Norte" {{ request('gerencia') == 'Norte' ? ' selected' : '' }}>Norte</option>
                                                    <option value="Sur" {{ request('gerencia') == 'Sur' ? ' selected' : '' }}>Sur</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3">
                                                <label for="tipo_contribuyente" class="form-label">T.Contribuyente</label>
                                                <select name="tipo_contribuyente" class="form-select" aria-label="Default select example">
                                                    <option value="" {{ request('tipo_contribuyente') == '' ? ' selected' : '' }}>Todos</option>
                                                    <option value="Especial" {{ request('tipo_contribuyente') == 'Especial' ? ' selected' : '' }}>Especial</option>
                                                    <option value="Mediano" {{ request('tipo_contribuyente') == 'Mediano' ? ' selected' : '' }}>Mediano</option>
                                                    <option value="Normal" {{ request('tipo_contribuyente') == 'Normal' ? ' selected' : '' }}>Normal</option>
                                                    <option value="Pie" {{ request('tipo_contribuyente') == 'Pie' ? ' selected' : '' }}>Pie</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3">
                                                <label for="estado" class="form-label">Estado</label>
                                                <select name="estado" class="form-select" aria-label="Default select example">
                                                    <option value="" {{ request('estado') == '' ? ' selected' : '' }}>Todos</option>
                                                    <option value="Activo" {{ request('estado') == 'Activo' ? ' selected' : '' }}>Activo</option>
                                                    <option value="Archivo" {{ request('estado') == 'Archivo' ? ' selected' : '' }}>Archivo</option>
                                                    <option value="Cerrado" {{ request('estado') == 'Cerrado' ? ' selected' : '' }}>Cerrado</option>
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

