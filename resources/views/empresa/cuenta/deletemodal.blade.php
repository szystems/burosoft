

  <!-- Modal -->
  <div class="modal fade" id="deleteModal-{{ $cuenta->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title text-danger" id="deleteModal">
                <i class="bi bi-x-circle-fill text-danger"></i> Cancelar Cuenta
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">¿Está seguro de cancelar esta cuenta? si acepta no podra agregar movimientos a esta cuenta hasta que se vuelva a activar.</div>
          <div class="modal-footer">
              <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                <i class="bi bi-x-circle"></i> Regresar
              </button>
              <a href="{{ url('delete-cuenta/'.$cuenta->id) }}" type="button" class="btn btn-danger">
                <i class="bi bi-x-circle-fill"></i> Cancelar Cuenta
              </a>
          </div>
      </div>
  </div>
</div>
