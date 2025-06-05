<!-- Modal -->
<div class="modal fade" id="editEcModal-{{ $ec->id }}" tabindex="-1" aria-labelledby="editEcModal-{{ $ec->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEcModal-{{ $ec->id }}">
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
