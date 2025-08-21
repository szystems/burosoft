<div class="modal fade" id="deleteNtrrPaModal-{{ $ntrr->id }}" tabindex="-1" aria-labelledby="deleteNtrrPaModal-{{ $ntrr->id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ url('delete-ntrr-pa/'.$ntrr->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <!-- Removed hidden input for is_pa -->
                <div class="modal-header">
                    <h5 class="modal-title h4" id="deleteNtrrPaModal-{{ $ntrr->id }}">
                        Eliminar Notificación de Trámite de Recurso de Revocatoria (PA):
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de eliminar este registro de Notificación de Trámite de Recurso de Revocatoria?
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
