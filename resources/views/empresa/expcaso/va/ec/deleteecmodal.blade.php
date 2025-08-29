<!-- Modal -->
<div class="modal fade" id="deleteEcVaModal-{{ $ec->id }}" tabindex="-1" aria-labelledby="deleteEcVaModal-{{ $ec->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteEcVaModalLabel-{{ $ec->id }}">
                    <i class="bi bi-exclamation-triangle text-danger"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar este registro de Escrito de Conclusiones (VA)?</p>
                <div class="alert alert-warning">
                    <strong>Número de Resolución:</strong> {{ $ec->numero_resolucion }}<br>
                    <strong>Fecha de Creación:</strong> {{ $ec->created_at->format('d/m/Y H:i') }}
                </div>
                <p class="text-danger"><strong>Esta acción no se puede deshacer.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <form action="{{ route('delete-ec', $ec->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
