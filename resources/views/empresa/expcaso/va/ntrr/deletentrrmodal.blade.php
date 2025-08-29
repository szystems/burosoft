<!-- Modal -->
<div class="modal fade" id="deleteNtrrVaModal-{{ $ntrr->id }}" tabindex="-1" aria-labelledby="deleteNtrrVaModal-{{ $ntrr->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteNtrrVaModal-{{ $ntrr->id }}">
                    <i class="bi bi-trash text-danger"></i> Eliminar Negativa de Trámite Recurso de Revocatoria
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <strong>¿Está seguro que desea eliminar esta Negativa de Trámite Recurso de Revocatoria?</strong>
                </div>
                <div class="card">
                    <div class="card-body">
                        <p><strong>Fecha y Hora de Notificación:</strong> {{ $ntrr->fecha_hora_notificacion ? \Carbon\Carbon::parse($ntrr->fecha_hora_notificacion)->format('d/m/Y H:i') : 'N/A' }}</p>
                        <p><strong>Fecha de Resolución:</strong> {{ $ntrr->fecha_resolucion ? \Carbon\Carbon::parse($ntrr->fecha_resolucion)->format('d/m/Y') : 'N/A' }}</p>
                        <p><strong>No. de Resolución:</strong> {{ $ntrr->numero_resolucion }}</p>
                        <p><strong>Observaciones:</strong> {{ $ntrr->observaciones ?: 'N/A' }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <form action="{{ url('delete-ntrr/'.$ntrr->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash-fill"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
