<!-- Modal -->
<div class="modal fade" id="deleteAceptacionPaModal" tabindex="-1" aria-labelledby="deleteAceptacionPaModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAceptacionPaModalLabel">
                    <i class="bi bi-trash text-danger"></i>
                        Eliminar Aceptación (PA):
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de eliminar esta aceptación?
                <br><br>
                <strong>No. de Documento:</strong> <span id="delete_numero_documento_pa"></span><br>
                <strong>Fecha y Hora:</strong> <span id="delete_fecha_hora_pa"></span><br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <form id="deleteAceptacionPaForm" method="POST" style="display: inline;">
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
