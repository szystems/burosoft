<!-- Modal -->
<div class="modal fade" id="addDpmrModal" tabindex="-1" aria-labelledby="addDpmrModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDpmrModal">
                    <i class="bi bi-plus text-success"></i> Agregar Diligencia Para Mejor Resolver
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('insert-dpmr') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row gx-3">

                        <input type="hidden" name="audiencia_id" value="{{ $audiencia->id }}">
                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">

                        <div class="col-md-6 mb-3">
                            <label for="fecha_hora" class="form-label">Fecha y Hora <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('fecha_hora') is-invalid @enderror" 
                                   id="fecha_hora" name="fecha_hora" value="{{ old('fecha_hora') }}" required>
                            @error('fecha_hora')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_resolucion" class="form-label">Número de Resolución <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('numero_resolucion') is-invalid @enderror" 
                                   id="numero_resolucion" name="numero_resolucion" value="{{ old('numero_resolucion') }}" required>
                            @error('numero_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="archivo" class="form-label">Archivo</label>
                            <input type="file" class="form-control @error('archivo') is-invalid @enderror" 
                                   id="archivo" name="archivo" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            @error('archivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones" name="observaciones" rows="3">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
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


