<!-- Modal -->
<div class="modal fade" id="addPatModal" tabindex="-1"
aria-labelledby="addPatModal" aria-hidden="true">

<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addPatModal">
                <i class="bi bi-plus text-success"></i> Agregar Expediente
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
        <form action="{{ url('insert-pat') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row gx-3">

                    <input type="hidden" name="cuenta_id" value="{{ $cuenta->id }}">
                    <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">

                    <div class="col-md-4 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="no_expediente" class="form-label">No. Expediente</label>
                            <input name="no_expediente" type="text" class="form-control" placeholder="No. Expediente..." value="{{ old('no_expediente') }}" required/>
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
                            <input name="no_programa" type="text" class="form-control" placeholder="No. Programa..." value="{{ old('no_programa') }}" required/>
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
                                <option value="Central" {{ old('gerencia') == "Central" ? ' selected' : '' }}>Central</option>
                                <option value="Occidente" {{ old('gerencia') == "Occidente" ? ' selected' : '' }}>Occidente</option>
                                <option value="Norte" {{ old('gerencia') == "Norte" ? ' selected' : '' }}>Norte</option>
                                <option value="Sur" {{ old('gerencia') == "Sur" ? ' selected' : '' }}>Sur</option>
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
                                <option value="Grande Especial" {{ old('tipo_contribuyente') == "Grande Especial" ? ' selected' : '' }}>Grande Especial</option>
                                <option value="Mediano Especial" {{ old('tipo_contribuyente') == "Mediano Especial" ? ' selected' : '' }}>Mediano Especial</option>
                                <option value="Normal General" {{ old('tipo_contribuyente') == "Normal General" ? ' selected' : '' }}>Normal General</option>
                                <option value="Pequeño Contribuyente" {{ old('tipo_contribuyente') == "Pequeño Contribuyente" ? ' selected' : '' }}>Pequeño Contribuyente</option>
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
                                <option value="Activo" {{ old('estado') == "Activo" ? ' selected' : '' }}>Activo</option>
                                <option value="Archivo" {{ old('estado') == "Archivo" ? ' selected' : '' }}>Archivo</option>
                                <option value="Cerrado" {{ old('estado') == "Cerrado" ? ' selected' : '' }}>Cerrado</option>
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
                                <option value="Archivo" {{ old('resultado') == "Archivo" ? ' selected' : '' }}>Archivo</option>
                                <option value="RAF" {{ old('resultado') == "RAF" ? ' selected' : '' }}>RAF</option>
                                <option value="VA" {{ old('resultado') == "VA" ? ' selected' : '' }}>VA</option>
                                <option value="VP" {{ old('resultado') == "VP" ? ' selected' : '' }}>VP</option>
                                <option value="En proceso" {{ old('resultado') == "En proceso" ? ' selected' : '' }}>En proceso</option>
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


