<!-- Modal -->
<div class="modal fade" id="editAudienciaModal-{{ $audiencia->id }}" tabindex="-1"
aria-labelledby="editAudienciaModal-{{ $audiencia->id }}" aria-hidden="true">

<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editAudienciaModal-{{ $audiencia->id }}">
                <i class="bi bi-pencil text-warning"></i> Editar Audiencia
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

        <form action="{{ url('update-audiencia/'.$audiencia->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="row gx-3">
                    <input type="hidden" name="pat_id" id="pat_id" class="form-control" value="{{ $audiencia->pat_id }}" required>
                    <input type="hidden" name="usuario_id" id="usuario_id" class="form-control" value="{{ Auth::user()->id }}" required>
                    <div class="col-md-4 mb-3">
                        <label for="numero_audiencia" class="form-label">Número de Audiencia</label>
                        <input type="text" name="numero_audiencia" id="numero_audiencia" class="form-control" value="{{ $audiencia->numero_audiencia }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="tipo_audiencia" class="form-label">Tipo de Audiencia</label>
                        <select name="tipo_audiencia" id="tipo_audiencia" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="AEC" {{ $audiencia->tipo_audiencia == 'AEC' ? 'selected' : '' }}>AEC</option>
                            <option value="AIR" {{ $audiencia->tipo_audiencia == 'AIR' ? 'selected' : '' }}>AIR</option>
                            <option value="AS" {{ $audiencia->tipo_audiencia == 'AS' ? 'selected' : '' }}>AS</option>
                            <option value="AA" {{ $audiencia->tipo_audiencia == 'AA' ? 'selected' : '' }}>AA</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fecha" class="form-label">Fecha de la Audiencia </label>
                        <input type="date" name="fecha" id="fecha" class="form-control" 
                               value="{{ $audiencia->fecha instanceof \Carbon\Carbon ? $audiencia->fecha->format('Y-m-d') : $audiencia->fecha }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="impuestos" class="form-label">Monto</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ $config->currency_simbol }}</span>
                            <input type="number" step="0.01" name="impuestos" id="impuestos" class="form-control" value="{{ $audiencia->impuestos }}" required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fecha_notificacion" class="form-label">Fecha de Notificación</label>
                        <input type="date" name="fecha_notificacion" id="fecha_notificacion" class="form-control" 
                               value="{{ $audiencia->fecha_notificacion ? ($audiencia->fecha_notificacion instanceof \Carbon\Carbon ? $audiencia->fecha_notificacion->format('Y-m-d') : $audiencia->fecha_notificacion) : '' }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="plazo_evacuar" class="form-label">Plazo para Evacuar</label>
                        <select name="plazo_evacuar" id="plazo_evacuar_{{ $audiencia->id }}" class="form-select" onchange="toggleOtroFieldEdit({{ $audiencia->id }})">
                            <option value="">Seleccione una opción</option>
                            <option value="15 dias" {{ $audiencia->plazo_evacuar == '15 dias' ? 'selected' : '' }}>15 días</option>
                            <option value="30 dias" {{ $audiencia->plazo_evacuar == '30 dias' ? 'selected' : '' }}>30 días</option>
                            <option value="60 dias" {{ $audiencia->plazo_evacuar == '60 dias' ? 'selected' : '' }}>60 días</option>
                            <option value="90 dias" {{ $audiencia->plazo_evacuar == '90 dias' ? 'selected' : '' }}>90 días</option>
                            <option value="Otro" {{ $audiencia->plazo_evacuar == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3" id="otro_plazo_div_{{ $audiencia->id }}" style="display: {{ $audiencia->plazo_evacuar == 'Otro' ? 'block' : 'none' }};">
                        <label for="plazo_evacuar_otro" class="form-label">Especificar Plazo</label>
                        <input type="text" name="plazo_evacuar_otro" id="plazo_evacuar_otro_{{ $audiencia->id }}" class="form-control" 
                               value="{{ $audiencia->plazo_evacuar_otro }}" placeholder="Especificar otro plazo">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="archivo" class="form-label">Archivo</label>
                        <input type="file" name="archivo" id="archivo" class="form-control">
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

<script>
function toggleOtroFieldEdit(audienciaId) {
    const plazoSelect = document.getElementById('plazo_evacuar_' + audienciaId);
    const otroDiv = document.getElementById('otro_plazo_div_' + audienciaId);
    const otroInput = document.getElementById('plazo_evacuar_otro_' + audienciaId);
    
    if (plazoSelect.value === 'Otro') {
        otroDiv.style.display = 'block';
        otroInput.required = true;
    } else {
        otroDiv.style.display = 'none';
        otroInput.required = false;
        if (plazoSelect.value !== 'Otro') {
            otroInput.value = '';
        }
    }
}
</script>


