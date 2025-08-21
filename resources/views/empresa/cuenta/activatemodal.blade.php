

  <!-- Modal -->
  <div class="modal fade" id="activateModal-{{ $cuenta->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="activateModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success" id="activateModal">
                  <i class="bi bi-trash-fill text-success"></i> Activar Cuenta
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">¿Está seguro de Activar esta cuenta? si acepta podrá agregar movimientos a esta cuenta.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                  <i class="bi bi-x-circle"></i> Regresar
                </button>
                <a href="{{ url('activate-cuenta/'.$cuenta->id) }}" type="button" class="btn btn-success">
                  <i class="bi bi-bookmark-check"></i> Activar Cuenta
                </a>
            </div>
        </div>
    </div>
  </div>
