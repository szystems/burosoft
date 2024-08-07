<div class="modal fade" id="deleteNombramientoModal-{{ $nombramiento->id }}" tabindex="-1" aria-labelledby="deleteNombramientoModal-{{ $nombramiento->id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ url('delete-pat-nombramiento/'.$nombramiento->id) }}" method="GET">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title h4" id="deleteNombramientoModal-{{ $nombramiento->id }}">
                        Eliminar Nombramiento:
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de eliminar este nombramiento?
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
