<!-- Modal -->
<div class="modal fade" id="editRoVaModal-{{ $ro->id }}" tabindex="-1" aria-labelledby="editRoVaModal-{{ $ro->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoVaModal-{{ $ro->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Resolución de Ocurso
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('update-ro/'.$ro->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">
                        <input type="hidden" name="fecha" value="{{ $ro->fecha ? \Carbon\Carbon::parse($ro->fecha)->format('Y-m-d') : '2025-01-01' }}">

                        <div class="col-md-6 mb-3">
                            <label for="fecha_notificacion" class="form-label">Fecha y Hora de Notificación</label>
                            <input type="datetime-local" name="fecha_notificacion" class="form-control" 
                                   value="{{ old('fecha_notificacion', $ro->fecha_notificacion ? \Carbon\Carbon::parse($ro->fecha_notificacion)->format('Y-m-d\TH:i') : ($ro->fecha ? \Carbon\Carbon::parse($ro->fecha)->format('Y-m-d\TH:i') : '')) }}" required>
                            @if ($errors->has('fecha_notificacion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('fecha_notificacion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_resolucion" class="form-label">Fecha de Resolución</label>
                            <input type="date" name="fecha_resolucion" class="form-control" 
                                   value="{{ old('fecha_resolucion', $ro->fecha_resolucion ? \Carbon\Carbon::parse($ro->fecha_resolucion)->format('Y-m-d') : '') }}">
                            @if ($errors->has('fecha_resolucion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('fecha_resolucion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_resolucion" class="form-label">No. de Resolución</label>
                            <input type="text" name="numero_resolucion" class="form-control" value="{{ $ro->numero_resolucion }}" required>
                            @if ($errors->has('numero_resolucion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_resolucion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo_resolucion" class="form-label">Tipo de Resolución</label>
                            <select name="tipo_resolucion" class="form-control" required>
                                <option value="">Seleccione el tipo de resolución</option>
                                <option value="Procede tramite" {{ $ro->tipo_resolucion == 'Procede tramite' ? 'selected' : '' }}>Procede trámite</option>
                                <option value="No procede tramite" {{ $ro->tipo_resolucion == 'No procede tramite' ? 'selected' : '' }}>No procede trámite</option>
                            </select>
                            @if ($errors->has('tipo_resolucion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('tipo_resolucion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="archivo" class="form-label">Archivo</label>
                            <input type="file" name="archivo" class="form-control">
                            @if ($errors->has('archivo'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('archivo') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="3">{{ $ro->observaciones }}</textarea>
                            @if ($errors->has('observaciones'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('observaciones') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_folios" class="form-label">Número de Folios</label>
                            <input type="number" name="numero_folios" class="form-control" value="{{ $ro->numero_folios }}" min="1">
                            @if ($errors->has('numero_folios'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_folios') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="audiencia_id" value="{{ $ro->audiencia_id }}">
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
