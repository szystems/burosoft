<!-- Modal -->
<div class="modal fade" id="deleteAudienciaModal-{{ $audiencia->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteAudienciaModal-{{ $audiencia->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('delete-audiencia/'.$audiencia->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteAudienciaModal-{{ $audiencia->id }}">
                        <i class="bi bi-trash-fill text-danger"></i> Eliminar Audiencia
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">¿Está seguro de eliminar esta audiencia? si confirma eliminara todos los registros que pertenezcan a esta audiencia.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-bs-dismiss="modal">
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
