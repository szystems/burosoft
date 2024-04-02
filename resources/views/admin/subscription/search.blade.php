
                <form action="{{ url('index-subscriptions') }}" method="GET">
                    @csrf
                    <div class="row">

                        <div class="col-md-12 mb-0">
                            <label for=""><strong>{{ __('Buscar') }} {{ __('Suscripciones') }}:</strong></label>

                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="">{{ __('Usuario') }} {{ $queryuser }}</label>
                            <select class="form-select px-2" aria-label="Default select example" name="fuser">
                                    @if ($queryuser)
                                        @php
                                            $usersearch = \App\Models\User::where('email',$queryuser)->first();
                                        @endphp
                                        <option selected value="{{ $usersearch->email }}">{{ $usersearch->email }} ({{ $usersearch->name }})</option>
                                    @else
                                        <option selected value="">{{ __('Todos') }}</option>
                                    @endif
                                    <option value="">{{ __('Todos') }}</option>
                                    @foreach ($usersFilter as $user)
                                        <option value="{{ $user->email }}">{{ $user->email }} ({{ $user->name }})</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">

                            <label for="">{{ __('Plan') }}</label>
                            <select class="form-select px-2" aria-label="Default select example" name="fplan">
                                    @if ($queryplan != null)
                                        @php
                                            $planflitro = \App\Models\Plan::find($queryplan);
                                        @endphp
                                        <option selected value="{{ $planflitro->id }}">{{ $planflitro->slug }}</option>
                                    @else
                                        <option selected value="">{{ __('Todos') }}</option>
                                    @endif
                                    <option value="">{{ __('Todos') }}</option>
                                    @foreach ($plansFilter as $plan)
                                        <option value="{{ $plan->id }}">{{ $plan->slug }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">

                            <label for="">{{ __('Estado') }}</label>
                            <select class="form-select px-2" aria-label="Default select example" name="fisactive">
                                @if( $queryisactive != null)
                                <option value="{{ $queryisactive }}">
                                    {{
                                        $queryisactive == '>=' ? __('Activa')
                                        : ($queryisactive == '<' ? __('Inactiva')
                                        : "")
                                    }}</option>
                                @endif
                                <option value="">{{ __('Todos') }}</option>
                                <option value=">=">{{ __('Activa') }}</option>
                                <option value="<">{{ __('Inactiva') }}</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3" >
                            <label for="">{{ __('Buscar') }}</label><br>
                            <button type="submit" class="btn btn-info"><i class="material-icons">search</i></button>
                        </div>
                    </div>
                </form>
