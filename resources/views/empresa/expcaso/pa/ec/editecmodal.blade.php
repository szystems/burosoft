<!-- Modal -->
<div class="modal fade" id="editEcPaModal-{{ $ec->id }}" tabindex="-1" aria-labelledby="editEcPaModal-{{ $ec->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEcPaModal-{{ $ec->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar EC (Económico Activo) (PA)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('update-ec-pa/'.$ec->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">
                        <input type="hidden" name="audiencia_pa_id" value="{{ $audienciaPa->id }}">
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
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Arraigo" id="medida_arraigo_pa_{{ $ec->id }}"
                                               {{ in_array('Arraigo', $medidasSeleccionadas) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="medida_arraigo_pa_{{ $ec->id }}">Arraigo</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Bloqueo de cuentas" id="medida_cuentas_pa_{{ $ec->id }}"
                                               {{ in_array('Bloqueo de cuentas', $medidasSeleccionadas) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="medida_cuentas_pa_{{ $ec->id }}">Bloqueo de cuentas</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Bloqueo de Vehiculos" id="medida_vehiculos_pa_{{ $ec->id }}"
                                               {{ in_array('Bloqueo de Vehiculos', $medidasSeleccionadas) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="medida_vehiculos_pa_{{ $ec->id }}">Bloqueo de Vehículos</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Bloqueo de bienes inmuebles" id="medida_inmuebles_pa_{{ $ec->id }}"
                                               {{ in_array('Bloqueo de bienes inmuebles', $medidasSeleccionadas) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="medida_inmuebles_pa_{{ $ec->id }}">Bloqueo de bienes inmuebles</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Interventor" id="medida_interventor_pa_{{ $ec->id }}"
                                               {{ in_array('Interventor', $medidasSeleccionadas) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="medida_interventor_pa_{{ $ec->id }}">Interventor</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Otro" id="medida_otro_pa_{{ $ec->id }}" 
                                               onchange="toggleOtroFieldEditPa{{ $ec->id }}()"
                                               {{ in_array('Otro', $medidasSeleccionadas) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="medida_otro_pa_{{ $ec->id }}">Otro</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3" id="otro_field_pa_{{ $ec->id }}" style="display: {{ in_array('Otro', $medidasSeleccionadas) ? 'block' : 'none' }};">
                            <label for="medidas_decretadas_otro_{{ $ec->id }}" class="form-label">Especificar Otra Medida</label>
                            <input type="text" class="form-control @error('medidas_decretadas_otro') is-invalid @enderror" 
                                   id="medidas_decretadas_otro_{{ $ec->id }}" name="medidas_decretadas_otro" 
                                   value="{{ old('medidas_decretadas_otro', $ec->medidas_decretadas_otro) }}" maxlength="500">
                            @error('medidas_decretadas_otro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="3">{{ $ec->observaciones }}</textarea>
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
                            <input type="number" name="numero_folios" class="form-control" value="{{ $ec->numero_folios }}" min="1">
                            @if ($errors->has('numero_folios'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_folios') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="audiencia_pa_id" value="{{ $ec->audiencia_pa_id }}">
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

<script>
function toggleOtroFieldEditPa{{ $ec->id }}() {
    const checkbox = document.getElementById('medida_otro_pa_{{ $ec->id }}');
    const otroField = document.getElementById('otro_field_pa_{{ $ec->id }}');
    
    if (checkbox.checked) {
        otroField.style.display = 'block';
    } else {
        otroField.style.display = 'none';
        document.getElementById('medidas_decretadas_otro_{{ $ec->id }}').value = '';
    }
}
</script>
