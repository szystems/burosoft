<!-- Modal -->
<div class="modal fade" id="editRtributaPaModal-{{ $rtributa->id }}" tabindex="-1" aria-labelledby="editRtributaPaModal-{{ $rtributa->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRtributaPaModal-{{ $rtributa->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Resolución Tributaria (PA)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('update-rtributa-pa/'.$rtributa->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">
                        <!-- Campo oculto 'is_pa' eliminado -->

                        <div class="col-md-6 mb-3">
                            <label for="fecha_hora_notificacion" class="form-label">Fecha y Hora de Notificación <span class="text-danger">*</span></label>
                            <input type="datetime-local" name="fecha_hora_notificacion" class="form-control" 
                                   value="{{ old('fecha_hora_notificacion', $rtributa->fecha_hora_notificacion ? \Carbon\Carbon::parse($rtributa->fecha_hora_notificacion)->format('Y-m-d\TH:i') : '') }}" required>
                            @if ($errors->has('fecha_hora_notificacion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('fecha_hora_notificacion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_resolucion" class="form-label">No. de Resolución <span class="text-danger">*</span></label>
                            <input type="text" name="numero_resolucion" class="form-control" value="{{ old('numero_resolucion', $rtributa->numero_resolucion) }}" required>
                            @if ($errors->has('numero_resolucion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_resolucion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo_resolucion" class="form-label">Tipo de Resolución <span class="text-danger">*</span></label>
                            <select name="tipo_resolucion" id="tipo_resolucion_edit_{{ $rtributa->id }}_pa" class="form-control" required onchange="toggleTipoResolucionOtroPa('edit_{{ $rtributa->id }}')">
                                <option value="">Seleccione...</option>
                                <option value="total a favor" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'total a favor' ? 'selected' : '' }}>Total a favor</option>
                                <option value="total en contra" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'total en contra' ? 'selected' : '' }}>Total en contra</option>
                                <option value="parcial" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'parcial' ? 'selected' : '' }}>Parcial</option>
                                <option value="nulidad" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'nulidad' ? 'selected' : '' }}>Nulidad</option>
                                <option value="penal" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'penal' ? 'selected' : '' }}>Penal</option>
                                <option value="otro" {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @if ($errors->has('tipo_resolucion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('tipo_resolucion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <!-- Campo Tipo de Resolución Otro -->
                        <div class="col-md-6 mb-3" id="tipo_resolucion_otro_edit_{{ $rtributa->id }}_pa" style="display: {{ old('tipo_resolucion', $rtributa->tipo_resolucion) == 'otro' || $rtributa->tipo_resolucion_otro ? 'block' : 'none' }};">
                            <label for="tipo_resolucion_otro" class="form-label">Especifique Tipo de Resolución <span class="text-danger">*</span></label>
                            <input type="text" 
                                   {{ (old('tipo_resolucion', $rtributa->tipo_resolucion) == 'otro' || $rtributa->tipo_resolucion_otro) ? 'name=tipo_resolucion_otro' : '' }}
                                   class="form-control" 
                                   value="{{ old('tipo_resolucion_otro', $rtributa->tipo_resolucion_otro) }}">
                            @if ($errors->has('tipo_resolucion_otro'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('tipo_resolucion_otro') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_resolucion" class="form-label">Fecha de Resolución</label>
                            <input type="date" name="fecha_resolucion" class="form-control" 
                                   value="{{ old('fecha_resolucion', $rtributa->fecha_resolucion ? \Carbon\Carbon::parse($rtributa->fecha_resolucion)->format('Y-m-d') : '') }}">
                            @if ($errors->has('fecha_resolucion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('fecha_resolucion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="plazo_cat" class="form-label">Plazo CAT</label>
                            <select name="plazo_cat" id="plazo_cat_edit_{{ $rtributa->id }}_pa" class="form-control" onchange="togglePlazoCatOtroPa('edit_{{ $rtributa->id }}')">
                                <option value="">Seleccione...</option>
                                <option value="5 días" {{ old('plazo_cat', $rtributa->plazo_cat) == '5 días' ? 'selected' : '' }}>5 días</option>
                                <option value="10 días" {{ old('plazo_cat', $rtributa->plazo_cat) == '10 días' ? 'selected' : '' }}>10 días</option>
                                <option value="15 días" {{ old('plazo_cat', $rtributa->plazo_cat) == '15 días' ? 'selected' : '' }}>15 días</option>
                                <option value="30 días" {{ old('plazo_cat', $rtributa->plazo_cat) == '30 días' ? 'selected' : '' }}>30 días</option>
                                <option value="45 días" {{ old('plazo_cat', $rtributa->plazo_cat) == '45 días' ? 'selected' : '' }}>45 días</option>
                                <option value="60 días" {{ old('plazo_cat', $rtributa->plazo_cat) == '60 días' ? 'selected' : '' }}>60 días</option>
                                <option value="3 meses" {{ old('plazo_cat', $rtributa->plazo_cat) == '3 meses' ? 'selected' : '' }}>3 meses</option>
                                <option value="otro" {{ old('plazo_cat', $rtributa->plazo_cat) == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @if ($errors->has('plazo_cat'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('plazo_cat') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <!-- Campo Plazo CAT Otro -->
                        <div class="col-md-6 mb-3" id="plazo_cat_otro_edit_{{ $rtributa->id }}_pa" style="display: {{ old('plazo_cat', $rtributa->plazo_cat) == 'otro' || $rtributa->plazo_cat_otro ? 'block' : 'none' }};">
                            <label for="plazo_cat_otro" class="form-label">Especifique Plazo CAT <span class="text-danger">*</span></label>
                            <input type="text" 
                                   {{ (old('plazo_cat', $rtributa->plazo_cat) == 'otro' || $rtributa->plazo_cat_otro) ? 'name=plazo_cat_otro' : '' }}
                                   class="form-control" 
                                   value="{{ old('plazo_cat_otro', $rtributa->plazo_cat_otro) }}">
                            @if ($errors->has('plazo_cat_otro'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('plazo_cat_otro') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="archivo" class="form-label">Archivo</label>
                            <input type="file" name="archivo" class="form-control">
                            @if ($errors->has('archivo'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('archivo') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="3">{{ $rtributa->observaciones }}</textarea>
                            @if ($errors->has('observaciones'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('observaciones') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_folios" class="form-label">Número de Folios</label>
                            <input type="number" name="numero_folios" class="form-control" value="{{ $rtributa->numero_folios }}" min="1">
                            @if ($errors->has('numero_folios'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_folios') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="audiencia_pa_id" value="{{ $rtributa->audiencia_pa_id }}">
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
function toggleTipoResolucionOtroPa(modalType) {
    const selectElement = document.getElementById('tipo_resolucion_' + modalType + '_pa');
    const otroElement = document.getElementById('tipo_resolucion_otro_' + modalType + '_pa');
    
    if (selectElement && otroElement) {
        const inputElement = otroElement.querySelector('input');
        if (selectElement.value === 'otro') {
            otroElement.style.display = 'block';
            inputElement.required = true;
            inputElement.setAttribute('name', 'tipo_resolucion_otro');
        } else {
            otroElement.style.display = 'none';
            inputElement.required = false;
            inputElement.value = '';
            inputElement.removeAttribute('name');
        }
    }
}

function togglePlazoCatOtroPa(modalType) {
    const selectElement = document.getElementById('plazo_cat_' + modalType + '_pa');
    const otroElement = document.getElementById('plazo_cat_otro_' + modalType + '_pa');
    
    if (selectElement && otroElement) {
        const inputElement = otroElement.querySelector('input');
        if (selectElement.value === 'otro') {
            otroElement.style.display = 'block';
            inputElement.required = true;
            inputElement.setAttribute('name', 'plazo_cat_otro');
        } else {
            otroElement.style.display = 'none';
            inputElement.required = false;
            inputElement.value = '';
            inputElement.removeAttribute('name');
        }
    }
}

// Inicializar cuando se abra el modal
$(document).on('shown.bs.modal', '[id*="editRtributaPaModal-"]', function () {
    const modalId = $(this).attr('id').match(/editRtributaPaModal-(\d+)/)[1];
    const tipoSelect = document.getElementById('tipo_resolucion_edit_' + modalId + '_pa');
    const plazoSelect = document.getElementById('plazo_cat_edit_' + modalId + '_pa');
    
    if (tipoSelect) {
        toggleTipoResolucionOtroPa('edit_' + modalId);
    }
    if (plazoSelect) {
        togglePlazoCatOtroPa('edit_' + modalId);
    }
});

// También inicializar al cargar la página por si ya hay contenido
document.addEventListener('DOMContentLoaded', function() {
    // Para todos los modales de edición que puedan estar presentes
    const editModals = document.querySelectorAll('[id*="editRtributaPaModal-"]');
    editModals.forEach(function(modal) {
        const modalId = modal.id.match(/editRtributaPaModal-(\d+)/)[1];
        const tipoSelect = document.getElementById('tipo_resolucion_edit_' + modalId + '_pa');
        const plazoSelect = document.getElementById('plazo_cat_edit_' + modalId + '_pa');
        
        if (tipoSelect) {
            toggleTipoResolucionOtroPa('edit_' + modalId);
        }
        if (plazoSelect) {
            togglePlazoCatOtroPa('edit_' + modalId);
        }
    });
});
</script>
