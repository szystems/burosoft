<div class="modal fade" id="deleteRtributaPaModal-{{ $rtributa->id }}" tabindex="-1" aria-labelledby="deleteRtributaPaModal-{{ $rtributa->id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ url('delete-rtributa-pa/'.$rtributa->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title h4" id="deleteRtributaPaModal-{{ $rtributa->id }}">
                        Eliminar Resolución Tributaria (PA):
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar este registro de Resolución Tributaria (PA)?</p>
                    <div class="alert alert-warning">
                        <strong>Número de Resolución:</strong> {{ $rtributa->numero_resolucion }}<br>
                        <strong>Fecha de Creación:</strong> {{ $rtributa->created_at->format('d/m/Y H:i') }}
                    </div>
                    <p class="text-danger"><strong>Esta acción no se puede deshacer.</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
