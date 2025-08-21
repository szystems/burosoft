<div class="modal fade" id="deleteAmpmrPaModal-{{ $ampmr->id }}" tabindex="-1" aria-labelledby="deleteAmpmrPaModal-{{ $ampmr->id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ url('delete-ampmr-pa/'.$ampmr->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <!-- Campo oculto 'is_pa' eliminado -->
                <div class="modal-header">
                    <h5 class="modal-title h4" id="deleteAmpmrPaModal-{{ $ampmr->id }}">
                        Eliminar Atención de Memorial Para Mejor Resolver (PA):
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de eliminar este registro de Atención de Memorial Para Mejor Resolver?
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
