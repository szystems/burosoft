

<!-- Modal -->
<div class="modal fade" id="cancelSubscriptionGratisModal" tabindex="-1" aria-labelledby="cancelSubscriptionGratisModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="cancelSubscriptionGratisModal">{{ __('Cancelar') }} {{ __('Suscripción') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h3><b>{{ __('¿Está seguro que desea cancelar su suscripción?') }}</b></h3>
            <p>Si cancela su suscripción actual se eliminara por completo y no tendrá acceso al contenido de www.burotributario.com, deberá crear una nueva suscripción para tener nuevamente acceso.</p>
        </div>
        <div class="modal-footer">
            <form action="{{ url('cancel-subscription-gratis') }}" method="POST">
                @csrf
                <div class="text-center mt-3">
                    <input type="hidden" name="subscription_id" value="{{ $subscription->subscription_id }}">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">cerrar</button>
                    <button type="submit" class="btn btn-danger">Cancelar Suscripción</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
