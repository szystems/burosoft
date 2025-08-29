<!-- Modal -->
<div class="modal fade" id="addEcPaModal" tabindex="-1" aria-labelledby="addEcPaModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEcPaModal">
                    <i class="bi bi-plus text-success"></i> Agregar EC (Económico Activo) (PA)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('insert-ec-pa') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row gx-3">

                        <input type="hidden" name="audiencia_pa_id" value="{{ $audienciaPa->id }}">
                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <!-- Campo oculto 'is_pa' eliminado -->


                        <div class="col-md-12 mb-3">
                            <label for="numero_resolucion" class="form-label">Número de Resolución <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('numero_resolucion') is-invalid @enderror" 
                                   id="numero_resolucion" name="numero_resolucion" 
                                   value="{{ old('numero_resolucion') }}" required maxlength="1000">
                            @error('numero_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_hora_notificacion" class="form-label">Fecha y Hora de Notificación</label>
                            <input type="datetime-local" class="form-control @error('fecha_hora_notificacion') is-invalid @enderror" 
                                   id="fecha_hora_notificacion" name="fecha_hora_notificacion" 
                                   value="{{ old('fecha_hora_notificacion') }}">
                            @error('fecha_hora_notificacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_resolucion" class="form-label">Fecha de Resolución</label>
                            <input type="date" class="form-control @error('fecha_resolucion') is-invalid @enderror" 
                                   id="fecha_resolucion" name="fecha_resolucion" 
                                   value="{{ old('fecha_resolucion') }}">
                            @error('fecha_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="juzgado_que_conoce" class="form-label">Juzgado que Conoce</label>
                            <input type="text" class="form-control @error('juzgado_que_conoce') is-invalid @enderror" 
                                   id="juzgado_que_conoce" name="juzgado_que_conoce" 
                                   value="{{ old('juzgado_que_conoce') }}" maxlength="500">
                            @error('juzgado_que_conoce')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Medidas Decretadas</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Arraigo" id="medida_arraigo_pa">
                                        <label class="form-check-label" for="medida_arraigo_pa">Arraigo</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Bloqueo de cuentas" id="medida_cuentas_pa">
                                        <label class="form-check-label" for="medida_cuentas_pa">Bloqueo de cuentas</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Bloqueo de Vehiculos" id="medida_vehiculos_pa">
                                        <label class="form-check-label" for="medida_vehiculos_pa">Bloqueo de Vehículos</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Bloqueo de bienes inmuebles" id="medida_inmuebles_pa">
                                        <label class="form-check-label" for="medida_inmuebles_pa">Bloqueo de bienes inmuebles</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Interventor" id="medida_interventor_pa">
                                        <label class="form-check-label" for="medida_interventor_pa">Interventor</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="medidas_decretadas[]" value="Otro" id="medida_otro_pa" onchange="toggleOtroFieldPa()">
                                        <label class="form-check-label" for="medida_otro_pa">Otro</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3" id="otro_field_pa" style="display: none;">
                            <label for="medidas_decretadas_otro" class="form-label">Especificar Otra Medida</label>
                            <input type="text" class="form-control @error('medidas_decretadas_otro') is-invalid @enderror" 
                                   id="medidas_decretadas_otro" name="medidas_decretadas_otro" 
                                   value="{{ old('medidas_decretadas_otro') }}" maxlength="500">
                            @error('medidas_decretadas_otro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones" name="observaciones" rows="4" 
                                      maxlength="5000">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Máximo 5000 caracteres</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_folios" class="form-label">Número de Folios</label>
                            <input type="number" class="form-control @error('numero_folios') is-invalid @enderror" 
                                   id="numero_folios" name="numero_folios" value="{{ old('numero_folios') }}" min="1">
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
                        <i class="bi bi-check2-square"></i> Grabar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleOtroFieldPa() {
    const checkbox = document.getElementById('medida_otro_pa');
    const otroField = document.getElementById('otro_field_pa');
    
    if (checkbox.checked) {
        otroField.style.display = 'block';
    } else {
        otroField.style.display = 'none';
        document.getElementById('medidas_decretadas_otro').value = '';
    }
}
</script>
