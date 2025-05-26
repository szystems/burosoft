<!-- Modal -->
<div class="modal fade" id="addRtributaModal" tabindex="-1" aria-labelledby="addRtributaModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRtributaModal">
                    <i class="bi bi-plus text-success"></i> Agregar Resolución R-Tributa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('insert-rtributa') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row gx-3">

                        <input type="hidden" name="audiencia_id" value="{{ $audiencia->id }}">
                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">

                        <div class="col-md-6 mb-3">
                            <label for="fecha" class="form-label">Fecha de Notificación <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha') is-invalid @enderror" 
                                   name="fecha" value="{{ old('fecha') }}" required>
                            @error('fecha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_resolucion" class="form-label">No. de Resolución <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('numero_resolucion') is-invalid @enderror" 
                                   name="numero_resolucion" value="{{ old('numero_resolucion') }}" required>
                            @error('numero_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo_resolucion" class="form-label">Tipo de Resolución <span class="text-danger">*</span></label>
                            <select name="tipo_resolucion" class="form-control @error('tipo_resolucion') is-invalid @enderror" required>
                                <option value="">Seleccione...</option>
                                <option value="total a favor" {{ old('tipo_resolucion') == 'total a favor' ? 'selected' : '' }}>Total a favor</option>
                                <option value="total en contra" {{ old('tipo_resolucion') == 'total en contra' ? 'selected' : '' }}>Total en contra</option>
                                <option value="parcial" {{ old('tipo_resolucion') == 'parcial' ? 'selected' : '' }}>Parcial</option>
                                <option value="nulidad" {{ old('tipo_resolucion') == 'nulidad' ? 'selected' : '' }}>Nulidad</option>
                                <option value="penal" {{ old('tipo_resolucion') == 'penal' ? 'selected' : '' }}>Penal</option>
                            </select>
                            @error('tipo_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="archivo" class="form-label">Archivo</label>
                            <input type="file" class="form-control @error('archivo') is-invalid @enderror" 
                                   name="archivo" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            @error('archivo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      name="observaciones" rows="3">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="audiencia_id" value="{{ $audiencia->id }}">
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
