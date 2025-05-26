<div class="modal fade" id="deleteRtributaModal-{{ $rtributa->id }}" tabindex="-1" aria-labelledby="deleteRtributaModal-{{ $rtributa->id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ url('delete-rtributa/'.$rtributa->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title h4" id="deleteRtributaModal-{{ $rtributa->id }}">
                        Eliminar Resolución R-Tributa:
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de eliminar esta resolución R-Tributa?
                    <br><strong>No. {{ $rtributa->numero_resolucion }}</strong>
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
