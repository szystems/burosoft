<!-- Modal -->
<div class="modal fade" id="addEcPaModal" tabindex="-1" aria-labelledby="addEcPaModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEcPaModal">
                    <i class="bi bi-plus text-success"></i> Agregar Escrito de Conclusiones (PA)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('insert-ec-pa') }}" method="POST" enctype="multipart/form-data">
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
