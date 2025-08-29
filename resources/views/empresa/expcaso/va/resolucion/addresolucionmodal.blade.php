<!-- Modal -->
<div class="modal fade" id="addResolucionVaModal" tabindex="-1" aria-labelledby="addResolucionVaModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addResolucionVaModalLabel">
                    <i class="bi bi-plus text-success"></i> Agregar R-SAT
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('insert-resolucion') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row gx-3">

                        <input type="hidden" name="audiencia_id" value="{{ $audiencia->id }}">
                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="fecha" value="2025-01-01">

                        <div class="col-md-6 mb-3">
                            <label for="fecha_notificacion" class="form-label">Fecha y Hora de Notificación</label>
                            <input type="datetime-local" name="fecha_notificacion" class="form-control" value="{{ old('fecha_notificacion') }}" required>
                            @if ($errors->has('fecha_notificacion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('fecha_notificacion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="fecha_resolucion" class="form-label">Fecha de Resolución</label>
                            <input type="date" name="fecha_resolucion" class="form-control" value="{{ old('fecha_resolucion') }}">
                            @if ($errors->has('fecha_resolucion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('fecha_resolucion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_resolucion" class="form-label">No. de Resolución</label>
                            <input type="text" name="numero_resolucion" class="form-control" value="{{ old('numero_resolucion') }}" required>
                            @if ($errors->has('numero_documento'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_resolucion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo_resolucion" class="form-label">Tipo de Resolución</label>
                            <select name="tipo_resolucion" id="tipo_resolucion_add" class="form-control" required onchange="toggleTipoResolucionOtroAdd(this.value)">
                                <option value="" selected disabled>Seleccione el tipo de resolución</option>
                                <option value="total a favor" {{ old('tipo_resolucion') == 'total a favor' ? 'selected' : '' }}>Total a favor</option>
                                <option value="total en contra" {{ old('tipo_resolucion') == 'total en contra' ? 'selected' : '' }}>Total en contra</option>
                                <option value="parcial" {{ old('tipo_resolucion') == 'parcial' ? 'selected' : '' }}>Parcial</option>
                                <option value="nulidad" {{ old('tipo_resolucion') == 'nulidad' ? 'selected' : '' }}>Nulidad</option>
                                <option value="penal" {{ old('tipo_resolucion') == 'penal' ? 'selected' : '' }}>Penal</option>
                                <option value="otro" {{ old('tipo_resolucion') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @if ($errors->has('tipo_resolucion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('tipo_resolucion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3" id="tipoResolucionOtroDivAdd" style="display: none;">
                            <label for="tipo_resolucion_otro" class="form-label">Especificar Otro Tipo de Resolución</label>
                            <input type="text" name="tipo_resolucion_otro" id="tipo_resolucion_otro_add" class="form-control" value="{{ old('tipo_resolucion_otro') }}">
                            @if ($errors->has('tipo_resolucion_otro'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('tipo_resolucion_otro') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="plazo_revocatoria" class="form-label">Plazo para recurso de revocatoria (PpRR)</label>
                            <select name="plazo_revocatoria" id="plazo_revocatoria_add" class="form-control" onchange="togglePlazoRevocatoriaOtroAdd(this.value)">
                                <option value="">Seleccione el plazo</option>
                                <option value="5 D.H." {{ old('plazo_revocatoria') == '5 D.H.' ? 'selected' : '' }}>5 D.H.</option>
                                <option value="10 D.H." {{ old('plazo_revocatoria') == '10 D.H.' ? 'selected' : '' }}>10 D.H.</option>
                                <option value="30 D.H." {{ old('plazo_revocatoria') == '30 D.H.' ? 'selected' : '' }}>30 D.H.</option>
                                <option value="otro" {{ old('plazo_revocatoria') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @if ($errors->has('plazo_revocatoria'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('plazo_revocatoria') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3" id="plazoRevocatoriaOtroDivAdd" style="display: none;">
                            <label for="plazo_revocatoria_otro" class="form-label">Especificar Otro Plazo</label>
                            <input type="text" name="plazo_revocatoria_otro" id="plazo_revocatoria_otro_add" class="form-control" value="{{ old('plazo_revocatoria_otro') }}">
                            @if ($errors->has('plazo_revocatoria_otro'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('plazo_revocatoria_otro') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="archivo" class="form-label">Archivo</label>
                            <input type="file" name="archivo" class="form-control" required>
                            @if ($errors->has('archivo'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('archivo') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
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
                            <input type="number" name="numero_folios" class="form-control" value="{{ old('numero_folios') }}" min="1">
                            @if ($errors->has('numero_folios'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_folios') }}</font>
                                    </strong>
                                </span>
                            @endif
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
function toggleTipoResolucionOtroAdd(value) {
    const otroDiv = document.getElementById('tipoResolucionOtroDivAdd');
    const otroInput = document.getElementById('tipo_resolucion_otro_add');
    
    if (value === 'otro') {
        otroDiv.style.display = 'block';
        otroInput.required = true;
    } else {
        otroDiv.style.display = 'none';
        otroInput.required = false;
        otroInput.value = '';
    }
}

function togglePlazoRevocatoriaOtroAdd(value) {
    const otroDiv = document.getElementById('plazoRevocatoriaOtroDivAdd');
    const otroInput = document.getElementById('plazo_revocatoria_otro_add');
    
    if (value === 'otro') {
        otroDiv.style.display = 'block';
        otroInput.required = true;
    } else {
        otroDiv.style.display = 'none';
        otroInput.required = false;
        otroInput.value = '';
    }
}

// Ejecutar al cargar para manejar valores de old()
document.addEventListener('DOMContentLoaded', function() {
    const tipoResolucionSelect = document.getElementById('tipo_resolucion_add');
    const plazoRevocatoriaSelect = document.getElementById('plazo_revocatoria_add');
    
    if (tipoResolucionSelect && tipoResolucionSelect.value === 'otro') {
        toggleTipoResolucionOtroAdd('otro');
    }
    
    if (plazoRevocatoriaSelect && plazoRevocatoriaSelect.value === 'otro') {
        togglePlazoRevocatoriaOtroAdd('otro');
    }
});
</script>


