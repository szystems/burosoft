@extends('layouts.admin')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">workspace_premium</i>
                    </div>
                    <div class="text-center pt-1">
                        {{-- <p class="text-sm mb-0 text-capitalize">Today's Money</p> --}}
                        <h4 class="mb-0">{{ __('Suscripciones') }}</h4>
                    </div>
                    <hr class="dark horizontal my-0">
                </div>
                <div class="card-body p-3 pt-2">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            {{-- <a href="{{ url('add-course-category') }}" class="btn btn-success">
                                <i class="material-icons opacity-10">add</i> {{ __('Agregar') }} {{ __('Categoría de Cursos') }}
                            </a> --}}
                            <button type="button" class="btn bg-gradient-success" data-bs-toggle="modal" data-bs-target="#createSubscriptionModal">
                                <i class="material-icons">add</i> Crear Suscripción
                            </button>
                            @include('admin.subscription.createsubscriptionmodal')
                        </div>
                        @include('admin.subscription.search')

                        <div class="text-left pt-1">
                            {{-- <p class="text-sm mb-0 text-capitalize">Today's Money</p> --}}
                            <h6 class="mb-0">{{ $subscriptions->count() }} Resultado(s)</h6>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-sm align-categorys-center mb-0 table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0">{{ __('Usuario') }}</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0">{{ __('Activo Hasta') }}</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0">{{ __('Status') }}</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0">{{ __('Plan') }}</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0">{{ __('Precio') }}</th>
                                            {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-0"><i class="material-icons">format_list_bulleted</i></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscriptions as $subscription)
                                        @php
                                            $active_until = date("d-m-Y", strtotime($subscription->active_until));
                                            $planInfo = \App\Models\Plan::find($subscription->plan_id);
                                            $userInfo = \App\Models\User::find($subscription->user_id);
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-xs"><a href="{{ url('show-user/'.$userInfo->id) }}">{{ $userInfo->name }}</a></h6>
                                                        <p class="text-xs text-secondary mb-0">{{ $userInfo->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            {{-- <td class="align-middle text-center text-sm">{{ $category->description }}</td> --}}

                                            <td class="align-middle text-center text-sm"><strong>
                                                <span class="badge badge-sm bg-gradient-{{
                                                    $subscription->active_until < now() ? 'warning'
                                                    : ($subscription->active_until >= now() ? 'success'
                                                    : ""
                                                    ) }}">
                                                        {{ $active_until }}
                                                </span>
                                            </strong></td>
                                            <td class="align-middle text-center text-sm"><strong>
                                                @if ($subscription->plan_id != 1)
                                                    <span class="badge badge-sm bg-gradient-{{
                                                        $subscription->status == "ACTIVE" ? 'success'
                                                        : ($subscription->status == "SUSPENDED" ? 'warning'
                                                        : ""
                                                        ) }}">{{ $subscription->status }}
                                                    </span>
                                                @endif
                                                @if ($subscription->plan_id == 1)
                                                    <span class="badge badge-sm bg-gradient-{{
                                                        $subscription->active_until < now() ? 'danger'
                                                        : ($subscription->active_until >= now() ? 'success'
                                                        : ""
                                                        ) }}">
                                                        @if ($subscription->active_until < now())
                                                            Finalizada
                                                        @elseif ($subscription->active_until >= now())
                                                            Activa
                                                        @endif
                                                    </span>
                                                @endif

                                                </strong></td>
                                            <td class="align-middle text-center text-sm"><strong>{{ $planInfo->slug }}</strong></td>
                                            <td class="align-middle text-center text-sm"><strong>{{ $planInfo->visual_price }}</strong></td>
                                            <td class="align-middle text-center text-sm">
                                                {{-- <a href="{{ url('show-course-category/'.$category->id) }}" type="button" class="btn btn-info"><i class="material-icons">visibility</i></a>
                                                <a href="{{ url('edit-course-category/'.$category->id) }}" type="button" class="btn btn-warning"><i class="material-icons">edit</i></a> --}}
                                                @if($subscription->plan_id == 1)
                                                    <button type="button" class="btn bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#editSubscriptionModal{{ $subscription->id }}">
                                                        <i class="material-icons">edit</i>
                                                    </button>
                                                    @include('admin.subscription.editsubscriptionmodal')
                                                    <button type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteSubscriptionModal{{ $subscription->id }}">
                                                        <i class="material-icons">delete</i>
                                                    </button>
                                                    @include('admin.subscription.deletesubscriptionmodal')
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if ($subscriptions->count() == 0)
                                    <div class="alert alert-primary text-white" role="alert">
                                        <strong>{{ __('No se encontraron suscripciones.') }}</strong> <a href="{{ url('add-subscription') }}"> {{ __('Crear Subscripcion') }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                <div class="card-footer p-3">
                    {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p> --}}
                </div>
            </div>
        </div>

    </div>
@endsection
