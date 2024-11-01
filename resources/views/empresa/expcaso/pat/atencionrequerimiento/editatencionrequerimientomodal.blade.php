<!-- Modal -->
<div class="modal fade" id="editarAtencionRequerimientoModal{{ $atencion->id }}" tabindex="-1"
    aria-labelledby="editarAtencionRequerimientoModal{{ $atencion->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarAtencionRequerimientoModal{{ $atencion->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Atencion de Requerimiento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form action="{{ url('update-pat-atencionrequerimiento/'.$atencion->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="no" class="form-label">No</label>
                                <input name="no" type="text" class="form-control" placeholder="No..." value="{{ $atencion->no }}" required/>
                                @if ($errors->has('no'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('no') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha de Requerimiento</label>
                                <input type="date" name="fecha" class="form-control text-center" value="{{ date('Y-m-d', strtotime($atencion->fecha)) }}" required/>
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
                                <label for="forma_atencion" class="form-label">Forma de Atención</label>
                                <select name="forma_atencion" class="form-select" aria-label="Default select example"  required>
                                    <option value="">Seleccione forma de atención...</option>
                                    <option value="Escrito" {{ $atencion->forma_atencion == "Escrito" ? ' selected' : '' }}>Escrito</option>
                                    <option value="Verbal" {{ $atencion->forma_atencion == "Verbal" ? ' selected' : '' }}>Verbal</option>
                                    <option value="Otro" {{ $atencion->forma_atencion == "Otro" ? ' selected' : '' }}>Otro</option>
                                </select>
                                @if ($errors->has('forma_atencion'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('forma_atencion') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="forma_atencion_otro" class="form-label">Si es otro</label>
                                <input name="forma_atencion_otro" type="text" class="form-control" placeholder="Otro forma de atención..." value="{{ $atencion->forma_atencion_otro }}"/>
                                @if ($errors->has('forma_atencion_otro'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('forma_atencion_otro') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="acta_administrativa" class="form-label">¿Se suscribió acta administrativa?</label>
                                <select name="acta_administrativa" class="form-select" aria-label="Default select example"  required>
                                    <option value="">Seleccione...</option>
                                    <option value="Si" {{ $atencion->acta_administrativa == "Si" ? ' selected' : '' }}>Si</option>
                                    <option value="No" {{ $atencion->acta_administrativa == "No" ? ' selected' : '' }}>No</option>
                                </select>
                                @if ($errors->has('acta_administrativa'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('acta_administrativa') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="quien_atendio" class="form-label">¿Quién atendió?</label>
                                <input name="quien_atendio" type="text" class="form-control" placeholder="Otro lugar para atender..." value="{{ $atencion->quien_atendio }}" required/>
                                @if ($errors->has('quien_atendio'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('quien_atendio') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="observaciones" class="form-label">Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="3" placeholder="Observaciones...">{{ $atencion->observaciones }}</textarea>
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
                                <input type="file" name="archivo" class="form-control border" value="{{ $atencion->archivo }}">
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

