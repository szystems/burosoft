<!-- Modal Eliminar Constancia de Pago -->
<div class="modal fade" id="deleteConstanciaPagoModal-{{ $constancia->id }}" tabindex="-1" aria-labelledby="deleteConstanciaPagoModalLabel-{{ $constancia->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteConstanciaPagoModalLabel-{{ $constancia->id }}">
                    <i class="bi bi-exclamation-triangle"></i> Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro que desea eliminar la constancia de pago con los siguientes datos?</p>
                <ul>
                    <li><strong>Fecha de Pago:</strong> {{ \Carbon\Carbon::parse($constancia->fecha_pago)->format('d/m/Y') }}</li>
                    <li><strong>Identificación:</strong> {{ $constancia->identificacion }}</li>
                    <li><strong>Descripción:</strong> {{ $constancia->descripcion ?? 'N/A' }}</li>
                    <li><strong>Archivo:</strong> {{ $constancia->tipo_archivo }}</li>
                </ul>
                <div class="alert alert-warning" role="alert">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Advertencia:</strong> Esta acción no se puede deshacer.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('delete-constancia-pago', $constancia->id) }}" method="POST" style="display: inline;">
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
