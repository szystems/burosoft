<!-- Modal -->
<div class="modal fade" id="deleteAceptacionVaModal" tabindex="-1" aria-labelledby="deleteAceptacionVaModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAceptacionVaModalLabel">
                    <i class="bi bi-trash text-danger"></i>
                        Eliminar Aceptación:
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de eliminar esta aceptación?
                <br><br>
                <strong>No. de Documento:</strong> <span id="delete_numero_documento"></span><br>
                <strong>Fecha y Hora:</strong> <span id="delete_fecha_hora"></span><br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <form id="deleteAceptacionVaForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
