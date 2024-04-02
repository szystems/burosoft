<!-- Delete Modal -->
<div class="modal fade" id="createSubscriptionModal" tabindex="-1" role="dialog" aria-labelledby="createSubscriptionModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-normal" id="exampleModalLabel"><i class="material-icons opacity-10">workspace_premium</i> {{ __('Crear') }} {{ __('Suscripcion') }}</h5>
          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ url('insert-subscription') }}" method="POST">
            @csrf
            <div class="modal-body" align="center">
                <br>

                <div class="col-md-12 mb-3">
                    <label for="">{{ __('Usuario') }}</label>
                    <select class="form-select px-2" aria-label="Default select example" name="user_id" required>
                            <option selected value="">{{ __('Selecciona un usuario') }}</option>
                            @foreach ($usersFilter as $user)
                                <option value="{{ $user->id }}">{{ $user->email }} ({{ $user->name }})</option>
                            @endforeach
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">{{ __('Plan') }}</label>
                    <select class="form-select px-2" aria-label="Default select example" name="plan_id" required>
                            <option selected value="1">{{ __('gratis') }}</option>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="">{{ __('Activo Hasta') }} </label>
                    <div class="input-daterange input-group" >
                        <div class="input-group input-group-dynamic mb-4">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            <input type="text" class="form-control" id="untildate" aria-label="Amount (to the nearest dollar)" name="active_until" value="{{ old('active_until') }}" required>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-gradient-info" data-bs-dismiss="modal"><i class="material-icons">close</i> {{ __('Cancelar') }}</button>
                <button type="submit" class="btn btn-success"><i class="material-icons">save</i> {{ __('Grabar') }}</button>
            </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    var optSimple = {
        format: "dd-mm-yyyy",
        language: "es",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        orientation: "bottom auto",
        startDate: today,
        defaultViewDate: today,

    };
    $( '#untildate' ).datepicker( optSimple );
</script>
