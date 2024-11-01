<div class="modal fade" id="deleteActaAdministrativaModal-{{ $acta->id }}" tabindex="-1" aria-labelledby="deleteActaAdministrativaModal-{{ $acta->id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ url('delete-pat-actaadministrativa/'.$acta->id) }}" method="GET">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title h4" id="deleteActaAdministrativaModal-{{ $acta->id }}">
                        Eliminar Acta Administrativa:
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de eliminar esta acta administrativa?
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
