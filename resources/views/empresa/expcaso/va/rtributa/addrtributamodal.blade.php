<!-- Modal -->
<div class="modal fade" id="addRtributaVaModal" tabindex="-1" aria-labelledby="addRtributaVaModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRtributaVaModalLabel">
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
                            <label for="fecha_hora_notificacion" class="form-label">Fecha y Hora de Notificación <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control @error('fecha_hora_notificacion') is-invalid @enderror" 
                                   name="fecha_hora_notificacion" value="{{ old('fecha_hora_notificacion') }}" required>
                            @error('fecha_hora_notificacion')
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
                            <select name="tipo_resolucion" id="tipo_resolucion_add" class="form-control @error('tipo_resolucion') is-invalid @enderror" required onchange="toggleRtributaTipoResolucionOtro('add')">
                                <option value="">Seleccione...</option>
                                <option value="total a favor" {{ old('tipo_resolucion') == 'total a favor' ? 'selected' : '' }}>Total a favor</option>
                                <option value="total en contra" {{ old('tipo_resolucion') == 'total en contra' ? 'selected' : '' }}>Total en contra</option>
                                <option value="parcial" {{ old('tipo_resolucion') == 'parcial' ? 'selected' : '' }}>Parcial</option>
                                <option value="nulidad" {{ old('tipo_resolucion') == 'nulidad' ? 'selected' : '' }}>Nulidad</option>
                                <option value="penal" {{ old('tipo_resolucion') == 'penal' ? 'selected' : '' }}>Penal</option>
                                <option value="otro" {{ old('tipo_resolucion') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('tipo_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo Tipo de Resolución Otro -->
                        <div class="col-md-6 mb-3" id="tipo_resolucion_otro_add" style="display: {{ old('tipo_resolucion') == 'otro' ? 'block' : 'none' }};">
                            <label for="tipo_resolucion_otro" class="form-label">Especifique Tipo de Resolución <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tipo_resolucion_otro') is-invalid @enderror" 
                                   name="tipo_resolucion_otro" value="{{ old('tipo_resolucion_otro') }}">
                            @error('tipo_resolucion_otro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_resolucion" class="form-label">Fecha de Resolución</label>
                            <input type="date" class="form-control @error('fecha_resolucion') is-invalid @enderror" 
                                   name="fecha_resolucion" value="{{ old('fecha_resolucion') }}">
                            @error('fecha_resolucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="plazo_cat" class="form-label">Plazo CAT</label>
                            <select name="plazo_cat" id="plazo_cat_add" class="form-control @error('plazo_cat') is-invalid @enderror" onchange="toggleRtributaPlazoCatOtro('add')">
                                <option value="">Seleccione...</option>
                                <option value="5 días" {{ old('plazo_cat') == '5 días' ? 'selected' : '' }}>5 días</option>
                                <option value="10 días" {{ old('plazo_cat') == '10 días' ? 'selected' : '' }}>10 días</option>
                                <option value="15 días" {{ old('plazo_cat') == '15 días' ? 'selected' : '' }}>15 días</option>
                                <option value="30 días" {{ old('plazo_cat') == '30 días' ? 'selected' : '' }}>30 días</option>
                                <option value="45 días" {{ old('plazo_cat') == '45 días' ? 'selected' : '' }}>45 días</option>
                                <option value="60 días" {{ old('plazo_cat') == '60 días' ? 'selected' : '' }}>60 días</option>
                                <option value="3 meses" {{ old('plazo_cat') == '3 meses' ? 'selected' : '' }}>3 meses</option>
                                <option value="otro" {{ old('plazo_cat') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('plazo_cat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Campo Plazo CAT Otro -->
                        <div class="col-md-6 mb-3" id="plazo_cat_otro_add" style="display: {{ old('plazo_cat') == 'otro' ? 'block' : 'none' }};">
                            <label for="plazo_cat_otro" class="form-label">Especifique Plazo CAT <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('plazo_cat_otro') is-invalid @enderror" 
                                   name="plazo_cat_otro" value="{{ old('plazo_cat_otro') }}">
                            @error('plazo_cat_otro')
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

                        <div class="col-md-6 mb-3">
                            <label for="numero_folios" class="form-label">Número de Folios</label>
                            <input type="number" class="form-control @error('numero_folios') is-invalid @enderror" 
                                   name="numero_folios" value="{{ old('numero_folios') }}" min="1">
                            @error('numero_folios')
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

<script>
// Funciones específicas para R-Tributa con manejo de errores mejorado
function toggleRtributaTipoResolucionOtro(modalType) {
    try {
        const selectElement = document.getElementById('tipo_resolucion_' + modalType);
        const otroElement = document.getElementById('tipo_resolucion_otro_' + modalType);
        
        if (selectElement && otroElement) {
            if (selectElement.value === 'otro') {
                otroElement.style.display = 'block';
                const input = otroElement.querySelector('input');
                if (input) input.required = true;
            } else {
                otroElement.style.display = 'none';
                const input = otroElement.querySelector('input');
                if (input) {
                    input.required = false;
                    input.value = '';
                }
            }
        }
    } catch (error) {
        console.log('Error en toggleRtributaTipoResolucionOtro:', error);
    }
}

function toggleRtributaPlazoCatOtro(modalType) {
    try {
        const selectElement = document.getElementById('plazo_cat_' + modalType);
        const otroElement = document.getElementById('plazo_cat_otro_' + modalType);
        
        if (selectElement && otroElement) {
            if (selectElement.value === 'otro') {
                otroElement.style.display = 'block';
                const input = otroElement.querySelector('input');
                if (input) input.required = true;
            } else {
                otroElement.style.display = 'none';
                const input = otroElement.querySelector('input');
                if (input) {
                    input.required = false;
                    input.value = '';
                }
            }
        }
    } catch (error) {
        console.log('Error en toggleRtributaPlazoCatOtro:', error);
    }
}

// Inicialización específica para R-Tributa
document.addEventListener('DOMContentLoaded', function() {
    try {
        // Solo ejecutar si el modal R-Tributa existe
        const rtributaModal = document.getElementById('addRtributaModal');
        if (rtributaModal) {
            const tipoSelect = document.getElementById('tipo_resolucion_add');
            const plazoSelect = document.getElementById('plazo_cat_add');
            
            if (tipoSelect && tipoSelect.value === 'otro') {
                toggleRtributaTipoResolucionOtro('add');
            }
            
            if (plazoSelect && plazoSelect.value === 'otro') {
                toggleRtributaPlazoCatOtro('add');
            }
        }
    } catch (error) {
        console.log('Error en inicialización R-Tributa:', error);
    }
});
</script>
