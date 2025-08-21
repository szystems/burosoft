<div class="modal fade" id="deleteRoPaModal-{{ $ro->id }}" tabindex="-1" aria-labelledby="deleteRoPaModal-{{ $ro->id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ url('delete-ro-pa/'.$ro->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title h4" id="deleteRoPaModal-{{ $ro->id }}">
                        Eliminar Resolución de Ocurso (PA):
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar este registro de Resolución de Ocurso (PA)?</p>
                    <div class="alert alert-warning">
                        <strong>No. de Escrito:</strong> {{ $ro->numero_escrito }}<br>
                        <strong>Fecha de Creación:</strong> {{ $ro->created_at->format('d/m/Y H:i') }}
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
