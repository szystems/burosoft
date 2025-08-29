<!-- Modal Editar Constancia de Pago -->
<div class="modal fade" id="editConstanciaPagoModal" tabindex="-1" aria-labelledby="editConstanciaPagoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="editConstanciaPagoModalLabel">
                    <i class="bi bi-pencil-square"></i> Editar Constancia de Pago
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editConstanciaPagoForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_fecha_pago" class="form-label">Fecha de Pago <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_pago" id="edit_fecha_pago" class="form-control" required>
                            @if ($errors->has('fecha_pago'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('fecha_pago') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_identificacion" class="form-label">Identificación <span class="text-danger">*</span></label>
                            <input type="text" name="identificacion" id="edit_identificacion" class="form-control" required>
                            @if ($errors->has('identificacion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('identificacion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="edit_descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="3"></textarea>
                            @if ($errors->has('descripcion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('descripcion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="edit_archivo" class="form-label">Archivo</label>
                            <input type="file" name="archivo" id="edit_archivo" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <small class="form-text text-muted">Formatos permitidos: PDF, DOC, DOCX, JPG, JPEG, PNG. Tamaño máximo: 10MB. Dejar vacío si no desea cambiar el archivo.</small>
                            @if ($errors->has('archivo'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('archivo') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <input type="hidden" name="pat_id" value="{{ $pat->id }}">
                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle"></i> Actualizar Constancia
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('editConstanciaPagoModal');
    
    editModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const fechaPago = button.getAttribute('data-fecha_pago');
        const identificacion = button.getAttribute('data-identificacion');
        const descripcion = button.getAttribute('data-descripcion');
        
        console.log('Datos del modal:', { id, fechaPago, identificacion, descripcion }); // Para debug
        
        // Actualizar el action del formulario
        const form = document.getElementById('editConstanciaPagoForm');
        form.action = `/update-constancia-pago/${id}`;
        
        // Llenar los campos del formulario
        document.getElementById('edit_fecha_pago').value = fechaPago || '';
        document.getElementById('edit_identificacion').value = identificacion || '';
        document.getElementById('edit_descripcion').value = descripcion || '';
    });
});
</script>
