<!-- Modal -->
<div class="modal fade" id="editRtributaVaModal-{{ $rtributa->id }}" tabindex="-1" aria-labelledby="editRtributaVaModal-{{ $rtributa->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRtributaVaModal-{{ $rtributa->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Resolución R-Tributa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('update-rtributa/'.$rtributa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">                        <div class="col-md-6 mb-3">
                            <label for="fecha_hora_notificacion_{{ $rtributa->id }}" class="form-label">Fecha y Hora de Notificación <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('fecha_hora_notificacion') is-invalid @enderror" 
                                   id="fecha_hora_notificacion_{{ $rtributa->id }}" name="fecha_hora_notificacion" 
                                   value="{{ old('fecha_hora_notificacion', $rtributa->fecha_hora_notificacion ? \Carbon\Carbon::parse($rtributa->fecha_hora_notificacion)->format('Y-m-d\TH:i') : '') }}" required>
                            @error('fecha_hora_notificacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_resolucion_{{ $rtributa->id }}" class="form-label">No. de Resolución <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('numero_resolucion') is-invalid @enderror" 
                                   id="numero_resolucion_{{ $rtributa->id }}" name="numero_resolucion" 
                                   value="{{ old('numero_resolucion', $rtributa->numero_resolucion) }}" required>
                            @error('numero_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo_resolucion_{{ $rtributa->id }}" class="form-label">Tipo de Resolución <span class="text-danger">*</span></label>
                            <select name="tipo_resolucion" id="tipo_resolucion_edit_{{ $rtributa->id }}" class="form-control @error('tipo_resolucion') is-invalid @enderror" required onchange="toggleRtributaTipoResolucionOtro('edit_{{ $rtributa->id }}')">
                                <option value="">Seleccione...</option>
                                <option value="total a favor" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'total a favor' ? 'selected' : '' }}>Total a favor</option>
                                <option value="total en contra" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'total en contra' ? 'selected' : '' }}>Total en contra</option>
                                <option value="parcial" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'parcial' ? 'selected' : '' }}>Parcial</option>
                                <option value="nulidad" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'nulidad' ? 'selected' : '' }}>Nulidad</option>
                                <option value="penal" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'penal' ? 'selected' : '' }}>Penal</option>
                                <option value="otro" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('tipo_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo Tipo de Resolución Otro -->
                        <div class="col-md-6 mb-3" id="tipo_resolucion_otro_edit_{{ $rtributa->id }}" style="display: {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'otro' || $rtributa->tipo_resolucion_otro ? 'block' : 'none' }};">
                            <label for="tipo_resolucion_otro_{{ $rtributa->id }}" class="form-label">Especifique Tipo de Resolución <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tipo_resolucion_otro') is-invalid @enderror" 
                                   id="tipo_resolucion_otro_{{ $rtributa->id }}" name="tipo_resolucion_otro" 
                                   value="{{ old('tipo_resolucion_otro', $rtributa->tipo_resolucion_otro) }}">
                            @error('tipo_resolucion_otro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_resolucion_{{ $rtributa->id }}" class="form-label">Fecha de Resolución</label>
                            <input type="date" class="form-control @error('fecha_resolucion') is-invalid @enderror" 
                                   id="fecha_resolucion_{{ $rtributa->id }}" name="fecha_resolucion" 
                                   value="{{ old('fecha_resolucion', $rtributa->fecha_resolucion ? \Carbon\Carbon::parse($rtributa->fecha_resolucion)->format('Y-m-d') : '') }}">
                            @error('fecha_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="plazo_cat_{{ $rtributa->id }}" class="form-label">Plazo CAT</label>
                            <select name="plazo_cat" id="plazo_cat_edit_{{ $rtributa->id }}" class="form-control @error('plazo_cat') is-invalid @enderror" onchange="toggleRtributaPlazoCatOtro('edit_{{ $rtributa->id }}')">
                                <option value="">Seleccione...</option>
                                <option value="5 días" {{ old('plazo_cat', $rtributa->plazo_cat) == '5 días' ? 'selected' : '' }}>5 días</option>
                                <option value="10 días" {{ old('plazo_cat', $rtributa->plazo_cat) == '10 días' ? 'selected' : '' }}>10 días</option>
                                <option value="15 días" {{ old('plazo_cat', $rtributa->plazo_cat) == '15 días' ? 'selected' : '' }}>15 días</option>
                                <option value="30 días" {{ old('plazo_cat', $rtributa->plazo_cat) == '30 días' ? 'selected' : '' }}>30 días</option>
                                <option value="45 días" {{ old('plazo_cat', $rtributa->plazo_cat) == '45 días' ? 'selected' : '' }}>45 días</option>
                                <option value="60 días" {{ old('plazo_cat', $rtributa->plazo_cat) == '60 días' ? 'selected' : '' }}>60 días</option>
                                <option value="otro" {{ old('plazo_cat', $rtributa->plazo_cat) == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('plazo_cat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo Plazo CAT Otro -->
                        <div class="col-md-6 mb-3" id="plazo_cat_otro_edit_{{ $rtributa->id }}" style="display: {{ old('plazo_cat', $rtributa->plazo_cat) == 'otro' || $rtributa->plazo_cat_otro ? 'block' : 'none' }};">
                            <label for="plazo_cat_otro_{{ $rtributa->id }}" class="form-label">Especifique Plazo CAT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('plazo_cat_otro') is-invalid @enderror" 
                                   id="plazo_cat_otro_{{ $rtributa->id }}" name="plazo_cat_otro" 
                                   value="{{ old('plazo_cat_otro', $rtributa->plazo_cat_otro) }}">
                            @error('plazo_cat_otro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="archivo_{{ $rtributa->id }}" class="form-label">Archivo</label>
                            <input type="file" class="form-control @error('archivo') is-invalid @enderror" 
                                   id="archivo_{{ $rtributa->id }}" name="archivo" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            @if($rtributa->archivo)
                                <small class="text-muted">Archivo actual: {{ $rtributa->archivo }}</small>
                            @endif
                            @error('archivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observaciones_{{ $rtributa->id }}" class="form-label">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones_{{ $rtributa->id }}" name="observaciones" rows="3">{{ old('observaciones', $rtributa->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_folios_{{ $rtributa->id }}" class="form-label">Número de Folios</label>
                            <input type="number" class="form-control @error('numero_folios') is-invalid @enderror" 
                                   id="numero_folios_{{ $rtributa->id }}" name="numero_folios" 
                                   value="{{ old('numero_folios', $rtributa->numero_folios) }}" min="1">
                            @error('numero_folios')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="audiencia_id" value="{{ $rtributa->audiencia_id }}">
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
