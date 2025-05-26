<!-- Modal -->
<div class="modal fade" id="editMpmrModal-{{ $mpmr->id }}" tabindex="-1" aria-labelledby="editMpmrModal-{{ $mpmr->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMpmrModal-{{ $mpmr->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Medida Para Mejor Resolver
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('update-mpmr/'.$mpmr->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">
                        <div class="col-md-6 mb-3">
                            <label for="fecha_hora_{{ $mpmr->id }}" class="form-label">Fecha y Hora <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('fecha_hora') is-invalid @enderror" 
                                   id="fecha_hora_{{ $mpmr->id }}" name="fecha_hora" 
                                   value="{{ old('fecha_hora', date('Y-m-d\TH:i', strtotime($mpmr->fecha_hora))) }}" required>
                            @error('fecha_hora')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_resolucion_{{ $mpmr->id }}" class="form-label">Número de Resolución <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('numero_resolucion') is-invalid @enderror" 
                                   id="numero_resolucion_{{ $mpmr->id }}" name="numero_resolucion" 
                                   value="{{ old('numero_resolucion', $mpmr->numero_resolucion) }}" required>
                            @error('numero_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="archivo_{{ $mpmr->id }}" class="form-label">Archivo</label>
                            <input type="file" class="form-control @error('archivo') is-invalid @enderror" 
                                   id="archivo_{{ $mpmr->id }}" name="archivo" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            @if($mpmr->archivo)
                                <small class="text-muted">Archivo actual: {{ $mpmr->archivo }}</small>
                            @endif
                            @error('archivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observaciones_{{ $mpmr->id }}" class="form-label">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones_{{ $mpmr->id }}" name="observaciones" rows="3">{{ old('observaciones', $mpmr->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="audiencia_id" value="{{ $mpmr->audiencia_id }}">
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
