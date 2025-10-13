<!-- Modal -->
<div class="modal fade" id="addAudienciaModal" tabindex="-1"
aria-labelledby="addAudienciaModal" aria-hidden="true">

<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addAudienciaModal">
                <i class="bi bi-plus text-success"></i> Agregar Audiencia
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        @if (count($errors)>0)
            <div class="alert alert-danger text-white" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('insert-audiencia') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row gx-3">
                    <input type="hidden" name="pat_id" id="pat_id" class="form-control" value="{{ $pat->id }}" required>
                    <input type="hidden" name="usuario_id" id="usuario_id" class="form-control" value="{{ Auth::user()->id }}" required>
                    <div class="col-md-4 mb-3">
                        <label for="numero_audiencia" class="form-label">Número de Audiencia</label>
                        <input type="text" name="numero_audiencia" id="numero_audiencia" class="form-control" value="{{ old('numero_audiencia') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tipo_audiencia" class="form-label">Tipo de Audiencia</label>
                        <select name="tipo_audiencia" id="tipo_audiencia" class="form-select" onchange="toggleTipoOtroField()" required>
                            <option value="">Seleccione...</option>
                            <option value="AEC" {{ old('tipo_audiencia') == 'AEC' ? 'selected' : '' }}>AEC</option>
                            <option value="AIR" {{ old('tipo_audiencia') == 'AIR' ? 'selected' : '' }}>AIR</option>
                            <option value="AS" {{ old('tipo_audiencia') == 'AS' ? 'selected' : '' }}>AS</option>
                            <option value="AA" {{ old('tipo_audiencia') == 'AA' ? 'selected' : '' }}>AA</option>
                            <option value="Otro" {{ old('tipo_audiencia') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3" id="otro_tipo_div" style="display: {{ old('tipo_audiencia') == 'Otro' ? 'block' : 'none' }};">
                        <label for="tipo_audiencia_otro" class="form-label">Especificar Tipo</label>
                        <input type="text" name="tipo_audiencia_otro" id="tipo_audiencia_otro" class="form-control" 
                               value="{{ old('tipo_audiencia_otro') }}" placeholder="Especificar otro tipo">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fecha" class="form-label">Fecha de la Audiencia </label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="impuestos" class="form-label">Monto</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ $config->currency_simbol ?? 'Q' }}</span>
                            <input type="number" step="0.01" name="impuestos" id="impuestos" class="form-control" value="{{ old('impuestos') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fecha_notificacion" class="form-label">Fecha de Notificación</label>
                        <input type="date" name="fecha_notificacion" id="fecha_notificacion" class="form-control" value="{{ old('fecha_notificacion') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="plazo_evacuar" class="form-label">Plazo para Evacuar</label>
                        <select name="plazo_evacuar" id="plazo_evacuar" class="form-select" onchange="toggleOtroField()">
                            <option value="">Seleccione una opción</option>
                            <option value="5 Dias" {{ old('plazo_evacuar') == '5 Dias' ? 'selected' : '' }}>5 Días</option>
                            <option value="10 Dias" {{ old('plazo_evacuar') == '10 Dias' ? 'selected' : '' }}>10 Días</option>
                            <option value="30 Dias" {{ old('plazo_evacuar') == '30 Dias' ? 'selected' : '' }}>30 Días</option>
                            <option value="Otro" {{ old('plazo_evacuar') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3" id="otro_plazo_div" style="display: {{ old('plazo_evacuar') == 'Otro' ? 'block' : 'none' }};">
                        <label for="plazo_evacuar_otro" class="form-label">Especificar Plazo</label>
                        <input type="text" name="plazo_evacuar_otro" id="plazo_evacuar_otro" class="form-control" 
                               value="{{ old('plazo_evacuar_otro') }}" placeholder="Especificar otro plazo">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="archivo" class="form-label">Archivo</label>
                        <input type="file" name="archivo" id="archivo" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2-square"></i> Agregar
                </button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
function toggleOtroField() {
    const plazoSelect = document.getElementById('plazo_evacuar');
    const otroDiv = document.getElementById('otro_plazo_div');
    const otroInput = document.getElementById('plazo_evacuar_otro');
    
    if (plazoSelect.value === 'Otro') {
        otroDiv.style.display = 'block';
        otroInput.required = true;
    } else {
        otroDiv.style.display = 'none';
        otroInput.required = false;
        otroInput.value = '';
    }
}

function toggleTipoOtroField() {
    const tipoSelect = document.getElementById('tipo_audiencia');
    const otroDiv = document.getElementById('otro_tipo_div');
    const otroInput = document.getElementById('tipo_audiencia_otro');
    
    if (tipoSelect.value === 'Otro') {
        otroDiv.style.display = 'block';
        otroInput.required = true;
    } else {
        otroDiv.style.display = 'none';
        otroInput.required = false;
        otroInput.value = '';
    }
}
</script>


