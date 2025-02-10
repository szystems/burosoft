<!-- Modal -->
<div class="modal fade" id="editarProvidenciaModal{{ $providencia->id }}" tabindex="-1"
    aria-labelledby="editarProvidenciaModal{{ $providencia->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarProvidenciaModal{{ $providencia->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Providencia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form action="{{ url('update-pat-providencia/'.$providencia->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="no" class="form-label">No</label>
                                <input name="no" type="text" class="form-control" placeholder="No..." value="{{ $providencia->no }}" required/>
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
                                <input type="date" name="fecha" class="form-control text-center" value="{{ $providencia->fecha }}" required/>
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
                                    <option value="R. Admite" {{ $providencia->tipo_providencia == "R. Admite" ? ' selected' : '' }}>R. Admite</option>
                                    <option value="R. Anula" {{ $providencia->tipo_providencia == "R. Anula" ? ' selected' : '' }}>R. Anula</option>
                                    <option value="Otro" {{ $providencia->tipo_providencia == "Otro" ? ' selected' : '' }}>Otro</option>
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
                                <input name="tipo_providencia_otro" type="text" class="form-control" placeholder="Otro tipo de providencia..." value="{{ $providencia->tipo_providencia_otro }}"/>
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
                                    <option value="">Seleccione lugar para atender...</option>
                                    <option value="Si" {{ $providencia->admite == "Si" ? ' selected' : '' }}>Si</option>
                                <option value="No" {{ $providencia->admite == "No" ? ' selected' : '' }}>No</option>
                                <option value="Otro" {{ $providencia->admite == "Otro" ? ' selected' : '' }}>Otro</option>
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
                                <input name="admite_otro" type="text" class="form-control" placeholder="Otro lugar para atender..." value="{{ $providencia->admite_otro }}"/>
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
                                <input name="observaciones" type="text" class="form-control" placeholder="Observaciones..." value="{{ $providencia->observaciones }}" required/>
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
                                <input type="file" name="archivo" class="form-control border" value="">
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

