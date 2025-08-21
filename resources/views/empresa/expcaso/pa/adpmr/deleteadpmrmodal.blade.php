<div class="modal fade" id="deleteAdpmrPaModal-{{ $adpmr->id }}" tabindex="-1" aria-labelledby="deleteAdpmrPaModal-{{ $adpmr->id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ url('delete-adpmr-pa/'.$adpmr->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <!-- Campo oculto 'is_pa' eliminado -->
                <div class="modal-header">
                    <h5 class="modal-title h4" id="deleteAdpmrPaModal-{{ $adpmr->id }}">
                        Eliminar Atención de Diligencia Para Mejor Resolver (PA):
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de eliminar esta atención de diligencia para mejor resolver?
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
