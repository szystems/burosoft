<!-- Modal -->
<div class="modal fade" id="editEcVaModal-{{ $ec->id }}" tabindex="-1" aria-labelledby="editEcVaModal-{{ $ec->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEcVaModal-{{ $ec->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar EC (Económico Coactivo)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('update-ec/'.$ec->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">

                        <input type="hidden" name="audiencia_id" value="{{ $audiencia->id }}">
                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">

                        <div class="col-md-12 mb-3">
                            <label for="numero_resolucion_{{ $ec->id }}" class="form-label">Número de Resolución <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('numero_resolucion') is-invalid @enderror" 
                                   id="numero_resolucion_{{ $ec->id }}" name="numero_resolucion" 
                                   value="{{ old('numero_resolucion', $ec->numero_resolucion) }}" required maxlength="1000">
                            @error('numero_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_hora_notificacion_{{ $ec->id }}" class="form-label">Fecha y Hora de Notificación</label>
                            <input type="datetime-local" class="form-control @error('fecha_hora_notificacion') is-invalid @enderror" 
                                   id="fecha_hora_notificacion_{{ $ec->id }}" name="fecha_hora_notificacion" 
                                   value="{{ old('fecha_hora_notificacion', $ec->fecha_hora_notificacion ? $ec->fecha_hora_notificacion->format('Y-m-d\TH:i') : '') }}">
                            @error('fecha_hora_notificacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_resolucion_{{ $ec->id }}" class="form-label">Fecha de Resolución</label>
                            <input type="date" class="form-control @error('fecha_resolucion') is-invalid @enderror" 
                                   id="fecha_resolucion_{{ $ec->id }}" name="fecha_resolucion" 
                                   value="{{ old('fecha_resolucion', $ec->fecha_resolucion ? $ec->fecha_resolucion->format('Y-m-d') : '') }}">
                            @error('fecha_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="juzgado_que_conoce_{{ $ec->id }}" class="form-label">Juzgado que Conoce</label>
                            <input type="text" class="form-control @error('juzgado_que_conoce') is-invalid @enderror" 
                                   id="juzgado_que_conoce_{{ $ec->id }}" name="juzgado_que_conoce" 
                                   value="{{ old('juzgado_que_conoce', $ec->juzgado_que_conoce) }}" maxlength="500">
                            @error('juzgado_que_conoce')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Medidas Decretadas</label>
                            @php
                                $medidasSeleccionadas = $ec->medidas_decretadas ?: [];
                            @endphp
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Arraigo" id="medida_arraigo_{{ $ec->id }}"
                                               {{ in_array('Arraigo', $medidasSeleccionadas) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="medida_arraigo_{{ $ec->id }}">Arraigo</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Bloqueo de cuentas" id="medida_cuentas_{{ $ec->id }}"
                                               {{ in_array('Bloqueo de cuentas', $medidasSeleccionadas) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="medida_cuentas_{{ $ec->id }}">Bloqueo de cuentas</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Bloqueo de Vehiculos" id="medida_vehiculos_{{ $ec->id }}"
                                               {{ in_array('Bloqueo de Vehiculos', $medidasSeleccionadas) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="medida_vehiculos_{{ $ec->id }}">Bloqueo de Vehículos</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Bloqueo de bienes inmuebles" id="medida_inmuebles_{{ $ec->id }}"
                                               {{ in_array('Bloqueo de bienes inmuebles', $medidasSeleccionadas) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="medida_inmuebles_{{ $ec->id }}">Bloqueo de bienes inmuebles</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Interventor" id="medida_interventor_{{ $ec->id }}"
                                               {{ in_array('Interventor', $medidasSeleccionadas) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="medida_interventor_{{ $ec->id }}">Interventor</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input medida-otro-checkbox" type="checkbox" name="medidas_decretadas[]" value="Otro" id="medida_otro_{{ $ec->id }}" 
                                               data-target="otro_field_{{ $ec->id }}" data-input="medidas_decretadas_otro_{{ $ec->id }}"
                                               {{ in_array('Otro', $medidasSeleccionadas) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="medida_otro_{{ $ec->id }}">Otro</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3" id="otro_field_{{ $ec->id }}" style="display: {{ in_array('Otro', $medidasSeleccionadas) ? 'block' : 'none' }};">
                            <label for="medidas_decretadas_otro_{{ $ec->id }}" class="form-label">Especificar Otra Medida</label>
                            <input type="text" class="form-control @error('medidas_decretadas_otro') is-invalid @enderror" 
                                   id="medidas_decretadas_otro_{{ $ec->id }}" name="medidas_decretadas_otro" 
                                   value="{{ old('medidas_decretadas_otro', $ec->medidas_decretadas_otro) }}" maxlength="500">
                            @error('medidas_decretadas_otro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observaciones_{{ $ec->id }}" class="form-label">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones_{{ $ec->id }}" name="observaciones" rows="4" 
                                      maxlength="5000">{{ old('observaciones', $ec->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Máximo 5000 caracteres</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_folios_{{ $ec->id }}" class="form-label">Número de Folios</label>
                            <input type="number" class="form-control @error('numero_folios') is-invalid @enderror" 
                                   id="numero_folios_{{ $ec->id }}" name="numero_folios" 
                                   value="{{ old('numero_folios', $ec->numero_folios) }}" min="1">
                            @error('numero_folios')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

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
