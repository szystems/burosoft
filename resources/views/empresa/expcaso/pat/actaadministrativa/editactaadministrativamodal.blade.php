<!-- Modal -->
<div class="modal fade" id="editarActaAdministrativaModal{{ $acta->id }}" tabindex="-1"
    aria-labelledby="editarActaAdministrativaModal{{ $acta->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarActaAdministrativaModal{{ $acta->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Atencion de Requerimiento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form action="{{ url('update-pat-actaadministrativa/'.$acta->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">

                        <div class="col-md-4 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha de Acta Administrativa</label>
                                <input type="date" name="fecha" class="form-control text-center" value="{{ date('Y-m-d', strtotime($acta->fecha)) }}" required/>
                                @if ($errors->has('fecha'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('fecha') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="col-md-12 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="quienes_intervinieron" class="form-label">¿Quiénes intervinieron?</label>
                                <textarea name="quienes_intervinieron" class="form-control" rows="3" placeholder="">{{ $acta->quienes_intervinieron }}</textarea>
                                @if ($errors->has('quienes_intervinieron'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('quienes_intervinieron') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="tipo_acta" class="form-label">Tipo de Acta</label>
                                <select name="tipo_acta" class="form-select" aria-label="Default select example"  required>
                                    <option value="">Seleccione forma de atención...</option>
                                    <option value="Limpia" {{ $acta->tipo_acta == "Limpia" ? ' selected' : '' }}>Limpia</option>
                                    <option value="Con Acuerdo" {{ $acta->tipo_acta == "Con Acuerdo" ? ' selected' : '' }}>Con Acuerdo</option>
                                    <option value="De Inconformidad" {{ $acta->tipo_acta == "De Inconformidad" ? ' selected' : '' }}>De Inconformidad</option>
                                    <option value="Otro" {{ $acta->tipo_acta == "Otro" ? ' selected' : '' }}>Otro</option>
                                </select>
                                @if ($errors->has('tipo_acta'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('tipo_acta') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="tipo_acta_otro" class="form-label">Si es otro</label>
                                <input name="tipo_acta_otro" type="text" class="form-control" placeholder="Otro tipo de acta..." value="{{ $acta->tipo_acta_otro }}"/>
                                @if ($errors->has('tipo_acta_otro'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('tipo_acta_otro') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="observaciones" class="form-label">Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="3" placeholder="Observaciones...">{{ $acta->observaciones }}</textarea>
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
                                <input type="file" name="archivo" class="form-control border" value="{{ $acta->archivo }}">
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

