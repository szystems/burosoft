<!-- Modal -->
<div class="modal fade" id="editDpmrModal-{{ $dpmr->id }}" tabindex="-1" aria-labelledby="editDpmrModal-{{ $dpmr->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDpmrModal-{{ $dpmr->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Diligencia Para Mejor Resolver
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('update-dpmr/'.$dpmr->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">
                        <div class="col-md-6 mb-3">
                            <label for="fecha_hora_{{ $dpmr->id }}" class="form-label">Fecha y Hora <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('fecha_hora') is-invalid @enderror" 
                                   id="fecha_hora_{{ $dpmr->id }}" name="fecha_hora" 
                                   value="{{ old('fecha_hora', date('Y-m-d\TH:i', strtotime($dpmr->fecha_hora))) }}" required>
                            @error('fecha_hora')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_resolucion_{{ $dpmr->id }}" class="form-label">Número de Resolución <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('numero_resolucion') is-invalid @enderror" 
                                   id="numero_resolucion_{{ $dpmr->id }}" name="numero_resolucion" 
                                   value="{{ old('numero_resolucion', $dpmr->numero_resolucion) }}" required>
                            @error('numero_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="archivo_{{ $dpmr->id }}" class="form-label">Archivo</label>
                            <input type="file" class="form-control @error('archivo') is-invalid @enderror" 
                                   id="archivo_{{ $dpmr->id }}" name="archivo" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            @if($dpmr->archivo)
                                <small class="text-muted">Archivo actual: {{ $dpmr->archivo }}</small>
                            @endif
                            @error('archivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observaciones_{{ $dpmr->id }}" class="form-label">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones_{{ $dpmr->id }}" name="observaciones" rows="3">{{ old('observaciones', $dpmr->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_folios_{{ $dpmr->id }}" class="form-label">Número de Folios</label>
                            <input type="number" class="form-control @error('numero_folios') is-invalid @enderror" 
                                   id="numero_folios_{{ $dpmr->id }}" name="numero_folios" 
                                   value="{{ old('numero_folios', $dpmr->numero_folios) }}" min="1">
                            @error('numero_folios')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="audiencia_id" value="{{ $dpmr->audiencia_id }}">
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

