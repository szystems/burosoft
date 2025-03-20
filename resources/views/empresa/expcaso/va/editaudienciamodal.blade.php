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
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $audiencia->fecha->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="impuestos" class="form-label">Impuestos</label>
                        <div class="input-group">
                            <span class="input-group-text">{{ $config->currency_simbol }}</span>
                            <input type="number" step="0.01" name="impuestos" id="impuestos" class="form-control" value="{{ $audiencia->impuestos }}" required>
                        </div>
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


