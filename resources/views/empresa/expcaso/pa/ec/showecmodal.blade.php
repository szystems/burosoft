<!-- Modal -->
<div class="modal fade" id="showEcModal-{{ $ec->id }}" tabindex="-1" aria-labelledby="showEcModal-{{ $ec->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showEcPaModal-{{ $ec->id }}">
                    <i class="bi bi-eye text-primary"></i> Detalles del EC (Económico Coactivo PA)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <strong>Número de Resolución:</strong>
                        <p class="mt-2">{{ $ec->numero_resolucion }}</p>
                    </div>

                    @if($ec->observaciones)
                    <div class="col-md-12 mb-3">
                        <strong>Observaciones:</strong>
                        <p class="mt-2">{{ $ec->observaciones }}</p>
                    </div>
                    @endif

                    <div class="col-md-6 mb-3">
                        <strong>Creado por:</strong>
                        <p class="mt-2">{{ $ec->usuario->name ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Fecha de creación:</strong>
                        <p class="mt-2">{{ $ec->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    @if($ec->updated_at != $ec->created_at)
                    <div class="col-md-12 mb-3">
                        <strong>Última actualización:</strong>
                        <p class="mt-2">{{ $ec->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
