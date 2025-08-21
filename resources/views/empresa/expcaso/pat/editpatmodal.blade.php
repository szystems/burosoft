<!-- Modal -->
<div class="modal fade" id="editPatModal" tabindex="-1"
aria-labelledby="editPatModal" aria-hidden="true">

<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editPatModal">
                <i class="bi bi-pencil text-warning"></i> Editar Expediente
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        @if (count($errors)>0)
            <div class="alert alert-danger text-white" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>

        @endif
        <form action="{{ url('update-pat/'.$pat->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="row gx-3">

                    <input type="hidden" name="cuenta_id" value="{{ $cuenta->id }}">
                    <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">

                    <div class="col-md-4 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="no_expediente" class="form-label">No. Expediente</label>
                            <input name="no_expediente" type="text" class="form-control" placeholder="No. Expediente..." value="{{ $pat->no_expediente }}" required/>
                            @if ($errors->has('no_expediente'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('no_expediente') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="no_programa" class="form-label">No. Programa</label>
                            <input name="no_programa" type="text" class="form-control" placeholder="No. Programa..." value="{{ $pat->no_programa }}" required/>
                            @if ($errors->has('no_programa'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('no_programa') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="gerencia" class="form-label">Gerencia</label>
                            <select name="gerencia" class="form-select" aria-label="Default select example" required>
                                <option value="">Seleccione Gerencia...</option>
                                <option value="Central" {{ $pat->gerencia == "Central" ? ' selected' : '' }}>Central</option>
                                <option value="Occidente" {{ $pat->gerencia == "Occidente" ? ' selected' : '' }}>Occidente</option>
                                <option value="Norte" {{ $pat->gerencia == "Norte" ? ' selected' : '' }}>Norte</option>
                                <option value="Sur" {{ $pat->gerencia == "Sur" ? ' selected' : '' }}>Sur</option>
                            </select>
                            @if ($errors->has('gerencia'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('gerencia') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="tipo_contribuyente" class="form-label">Tipo Contribuyente</label>
                            <select name="tipo_contribuyente" class="form-select" aria-label="Default select example" required>
                                <option value="">Seleccione Tipo...</option>
                                <option value="Grande Especial" {{ $pat->tipo_contribuyente == "Grande Especial" ? ' selected' : '' }}>Grande Especial</option>
                                <option value="Mediano Especial" {{ $pat->tipo_contribuyente == "Mediano Especial" ? ' selected' : '' }}>Mediano Especial</option>
                                <option value="Normal General" {{ $pat->tipo_contribuyente == "Normal General" ? ' selected' : '' }}>Normal General</option>
                                <option value="Pequeño Contribuyente" {{ $pat->tipo_contribuyente == "Pequeño Contribuyente" ? ' selected' : '' }}>Pequeño Contribuyente</option>
                            </select>
                            @if ($errors->has('tipo_contribuyente'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('tipo_contribuyente') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select name="estado" class="form-select" aria-label="Default select example" required>
                                <option value="">Seleccione Tipo...</option>
                                <option value="Activo" {{ $pat->estado == "Activo" ? ' selected' : '' }}>Activo</option>
                                <option value="Archivo" {{ $pat->estado == "Archivo" ? ' selected' : '' }}>Archivo</option>
                                <option value="Cerrado" {{ $pat->estado == "Cerrado" ? ' selected' : '' }}>Cerrado</option>
                            </select>
                            @if ($errors->has('estado'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('estado') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="resultado" class="form-label">Resultado</label>
                            <select name="resultado" class="form-select" aria-label="Default select example" required>
                                <option value="Archivo" {{ $pat->resultado == "Archivo" ? ' selected' : '' }}>Archivo</option>
                                <option value="PRAF" {{ $pat->resultado == "PRAF" ? ' selected' : '' }}>PRAF</option>
                                <option value="VA" {{ $pat->resultado == "VA" ? ' selected' : '' }}>VA</option>
                                <option value="VP" {{ $pat->resultado == "VP" ? ' selected' : '' }}>VP</option>
                                <option value="En proceso" {{ $pat->resultado == "En proceso" ? ' selected' : '' }}>En proceso</option>
                            </select>
                            @if ($errors->has('resultado'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('resultado') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-check2-square"></i> Grabar
                </button>
            </div>
        </form>
    </div>
</div>
</div>


