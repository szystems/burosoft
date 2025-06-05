<!-- Modal -->
<div class="modal fade" id="editRtributaModal-{{ $rtributa->id }}" tabindex="-1" aria-labelledby="editRtributaModal-{{ $rtributa->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRtributaModal-{{ $rtributa->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Resolución R-Tributa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('update-rtributa/'.$rtributa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">                        <div class="col-md-6 mb-3">
                            <label for="fecha_{{ $rtributa->id }}" class="form-label">Fecha de Notificación <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha') is-invalid @enderror" 
                                   id="fecha_{{ $rtributa->id }}" name="fecha" 
                                   value="{{ old('fecha', $rtributa->fecha ? \Carbon\Carbon::parse($rtributa->fecha)->format('Y-m-d') : '') }}" required>
                            @error('fecha')
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
                            <select name="tipo_resolucion" id="tipo_resolucion_{{ $rtributa->id }}" class="form-control @error('tipo_resolucion') is-invalid @enderror" required>
                                <option value="">Seleccione...</option>
                                <option value="total a favor" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'total a favor' ? 'selected' : '' }}>Total a favor</option>
                                <option value="total en contra" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'total en contra' ? 'selected' : '' }}>Total en contra</option>
                                <option value="parcial" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'parcial' ? 'selected' : '' }}>Parcial</option>
                                <option value="nulidad" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'nulidad' ? 'selected' : '' }}>Nulidad</option>
                                <option value="penal" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'penal' ? 'selected' : '' }}>Penal</option>
                            </select>
                            @error('tipo_resolucion')
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
