<!-- Delete Modal -->
<div class="modal fade" id="editSubscriptionModal{{ $subscription->id }}" tabindex="-1" role="dialog" aria-labelledby="editSubscriptionModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-normal" id="exampleModalLabel"><i class="material-icons opacity-10">workspace_premium</i> {{ __('Editar') }} {{ __('Subscripcion') }}</h5>
          <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ url('update-subscription/'.$subscription->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body" align="center">
                <br>
                @php
                    $active_until = date("d-m-Y", strtotime($subscription->active_until));
                    $planInfo = \App\Models\Plan::find($subscription->plan_id);
                    $userInfo = \App\Models\User::find($subscription->user_id);
                @endphp
                <div class="col-md-12 mb-3">
                    <label for="">{{ __('Usuario') }}</label>
                    <p>{{ $userInfo->email }} ({{ $userInfo->name }})</p>
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
                            <input type="text" class="form-control" id="untildateedit" aria-label="Amount (to the nearest dollar)" name="active_until" value="{{ $active_until }}" required>
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
    $( '#untildateedit' ).datepicker( optSimple );
</script>
