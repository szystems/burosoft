<!-- Delete Modal -->
<div class="modal fade" id="deleteModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Eliminar Usuario</h5>
          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            ¿Está seguro de eliminar este usuario?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-gradient-info" data-bs-dismiss="modal"><i class="material-icons">close</i> Cancelar</button>
          <a href="{{ url('delete-user/'.$user->id) }}" type="button" class="btn bg-gradient-danger"><i class="material-icons">delete</i> Eliminar</a>
        </div>
      </div>
    </div>
  </div>
