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

        <form action="{{ url('insert-audiencia-pa') }}" method="POST" enctype="multipart/form-data">
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
                        <select name="tipo_audiencia" id="tipo_audiencia" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="AEC" {{ old('tipo_audiencia') == 'AEC' ? 'selected' : '' }}>AEC</option>
                            <option value="AIR" {{ old('tipo_audiencia') == 'AIR' ? 'selected' : '' }}>AIR</option>
                            <option value="AS" {{ old('tipo_audiencia') == 'AS' ? 'selected' : '' }}>AS</option>
                            <option value="AA" {{ old('tipo_audiencia') == 'AA' ? 'selected' : '' }}>AA</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fecha" class="form-label">Fecha de la Audiencia</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="impuestos" class="form-label">Monto</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ $config->currency_simbol }}</span>
                            <input type="number" step="0.01" name="impuestos" id="impuestos" class="form-control" value="{{ old('impuestos') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fecha_notificacion" class="form-label">Fecha de Notificación</label>
                        <input type="date" name="fecha_notificacion" id="fecha_notificacion" class="form-control" value="{{ old('fecha_notificacion') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="plazo_evacuar" class="form-label">Plazo para Evacuar</label>
                        <select name="plazo_evacuar" id="plazo_evacuar" class="form-select" onchange="toggleOtroFieldPa()">
                            <option value="">Seleccione una opción</option>
                            <option value="15 dias" {{ old('plazo_evacuar') == '15 dias' ? 'selected' : '' }}>15 días</option>
                            <option value="30 dias" {{ old('plazo_evacuar') == '30 dias' ? 'selected' : '' }}>30 días</option>
                            <option value="60 dias" {{ old('plazo_evacuar') == '60 dias' ? 'selected' : '' }}>60 días</option>
                            <option value="90 dias" {{ old('plazo_evacuar') == '90 dias' ? 'selected' : '' }}>90 días</option>
                            <option value="Otro" {{ old('plazo_evacuar') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3" id="otro_plazo_div_pa" style="display: {{ old('plazo_evacuar') == 'Otro' ? 'block' : 'none' }};">
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
function toggleOtroFieldPa() {
    const plazoSelect = document.getElementById('plazo_evacuar');
    const otroDiv = document.getElementById('otro_plazo_div_pa');
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
</script>


