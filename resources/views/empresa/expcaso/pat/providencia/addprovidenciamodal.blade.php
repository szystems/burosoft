<!-- Modal -->
<div class="modal fade" id="addProvidenciaModal" tabindex="-1"
aria-labelledby="addProvidenciaModal" aria-hidden="true">

<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addProvidenciaModal">
                <i class="bi bi-plus text-success"></i> Agregar Providencia
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="{{ url('insert-pat-providencia') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row gx-3">

                    <div class="col-md-6 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="no" class="form-label">No</label>
                            <input name="no" type="text" class="form-control" placeholder="No..." value="{{ old('no') }}" required/>
                            @if ($errors->has('no'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('no') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha de Providencia</label>
                            <input type="date" name="fecha" class="form-control text-center" value="{{ old('fecha') }}" required/>
                            @if ($errors->has('fecha'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('fecha') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="tipo_providencia" class="form-label">Tipo Providencia</label>
                            <select name="tipo_providencia" class="form-select" aria-label="Default select example"  required>
                                <option value="">Seleccione tipo de providencia...</option>
                                <option value="R. Admite" {{ old('tipo_providencia') == "R. Admite" ? ' selected' : '' }}>R. Admite</option>
                                <option value="R. Anula" {{ old('tipo_providencia') == "R. Anula" ? ' selected' : '' }}>R. Anula</option>
                                <option value="Otro" {{ old('tipo_providencia') == "Otro" ? ' selected' : '' }}>Otro</option>
                            </select>
                            @if ($errors->has('tipo_providencia'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('tipo_providencia') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="tipo_providencia_otro" class="form-label">Si es otro</label>
                            <input name="tipo_providencia_otro" type="text" class="form-control" placeholder="Otro tipo de providencia..." value="{{ old('tipo_providencia_otro') }}"/>
                            @if ($errors->has('tipo_providencia_otro'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('tipo_providencia_otro') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="admite" class="form-label">Se Admite</label>
                            <select name="admite" class="form-select" aria-label="Default select example"  required>
                                <option value="">Seleccione...</option>
                                <option value="Si" {{ old('admite') == "Si" ? ' selected' : '' }}>Si</option>
                                <option value="No" {{ old('admite') == "No" ? ' selected' : '' }}>No</option>
                                <option value="Otro" {{ old('admite') == "Otro" ? ' selected' : '' }}>Otro</option>
                            </select>
                            @if ($errors->has('admite'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('admite') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="admite_otro" class="form-label">Si es otro</label>
                            <input name="admite_otro" type="text" class="form-control" placeholder="Otro ..." value="{{ old('admite_otro') }}"/>
                            @if ($errors->has('admite_otro'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('admite_otro') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <input name="observaciones" type="text" class="form-control" placeholder="Observaciones..." value="{{ old('observaciones') }}" required/>
                            @if ($errors->has('observaciones'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('observaciones') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>


                    <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="pat_id" value="{{ $pat->id }}">

                    <div class="col-md-6 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label class="form-label">Archivo</label>
                            <input type="file" name="archivo" class="form-control border" value="{{ old('archivo') }}" required>
                            @if ($errors->has('archivo'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('archivo') }}</font>
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


