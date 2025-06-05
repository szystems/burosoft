<!-- Modal -->
<div class="modal fade" id="editNulidadModal-{{ $nulidad->id }}" tabindex="-1" aria-labelledby="editNulidadModal-{{ $nulidad->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editNulidadModal-{{ $nulidad->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Nulidad
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('update-nulidad/'.$nulidad->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">

                        <input type="hidden" name="audiencia_id" value="{{ $audiencia->id }}">
                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">                        <div class="col-md-6 mb-3">
                            <label for="fecha" class="form-label">Fecha de Notificación</label>
                            <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $nulidad->fecha ? \Carbon\Carbon::parse($nulidad->fecha)->format('Y-m-d') : '') }}" required>
                            @if ($errors->has('fecha'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('fecha') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_resolucion" class="form-label">No. de Resolución</label>
                            <input type="text" name="numero_resolucion" class="form-control" value="{{ old('numero_resolucion', $nulidad->numero_resolucion) }}" required>
                            @if ($errors->has('numero_resolucion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_resolucion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo_nulidad" class="form-label">Tipo de Nulidad</label>
                            <select name="tipo_nulidad" class="form-control" required>
                                <option value="" disabled>Seleccione el tipo de nulidad</option>
                                <option value="Absoluta" {{ old('tipo_nulidad', $nulidad->tipo_nulidad) == 'Absoluta' ? 'selected' : '' }}>Absoluta</option>
                                <option value="Relativa" {{ old('tipo_nulidad', $nulidad->tipo_nulidad) == 'Relativa' ? 'selected' : '' }}>Relativa</option>
                            </select>
                            @if ($errors->has('tipo_nulidad'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('tipo_nulidad') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="archivo" class="form-label">Archivo</label>
                            <input type="file" name="archivo" class="form-control">
                            @if ($nulidad->archivo)
                                <small class="text-muted">Archivo actual: 
                                    <a href="{{ asset('uploads/nulidades/'.$nulidad->archivo) }}" target="_blank" class="text-primary">
                                        {{ $nulidad->tipo_archivo }}
                                    </a>
                                </small>
                            @endif
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
                            <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones', $nulidad->observaciones) }}</textarea>
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
                            <input type="number" name="numero_folios" class="form-control" value="{{ old('numero_folios', $nulidad->numero_folios) }}" min="1">
                            @if ($errors->has('numero_folios'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_folios') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="audiencia_id" value="{{ $audiencia->id }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check2-square"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
