@extends('layouts.admin')

@section('content')
    <div class="row">

        <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div
                        class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons opacity-10">people_alt</i>
                    </div>
                    <div class="text-center pt-1">
                        {{-- <p class="text-sm mb-0 text-capitalize">Today's Money</p> --}}
                        <h4 class="mb-0">{{ __('Usuarios') }}</h4>
                    </div>
                    <hr class="dark horizontal my-0">
                </div>
                <div class="card-body p-3 pt-2">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <a href="{{ url('add-user') }}" class="btn btn-success">
                                <i class="material-icons opacity-10">add</i> {{ __('Agregar') }} {{ __('Usuario') }}
                            </a>

                        </div>
                        @include('admin.user.search')
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-sm align-products-center mb-0 table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="align-left text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('Nombre') }}</th>
                                            {{-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('Phone') }}</th> --}}
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">{{ __('Rol') }}</th>
                                            <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"><i class="material-icons">format_list_bulleted</i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                  {{-- <div>
                                                    <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                                                  </div> --}}
                                                  <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-xs"><a href="{{ url('show-user/'.$user->id) }}">{{ $user->name }}</a></h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                  </div>
                                                </div>
                                            </td>
                                            {{-- <td class="align-middle text-center text-sm"><strong>{{ $user->phone }}</strong></td> --}}
                                            <td class="align-middle text-center text-sm"><strong>{{ $user->role_as == '0' ?'User' : 'Admin' }} @if ($user->principal == "1") (Principal) @endif</strong></td>
                                            <td class="align-middle  text-sm">
                                                <a href="{{ url('show-user/'.$user->id) }}" type="button" class="btn btn-info"><i class="material-icons">visibility</i></a>
                                                <a href="{{ url('edit-user/'.$user->id) }}" type="button" class="btn btn-warning"><i class="material-icons">edit</i></a>
                                                @if ($user->principal == "1")
                                                    <button disabled type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $user->id }}">
                                                        <i class="material-icons">delete</i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn bg-gradient-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $user->id }}">
                                                        <i class="material-icons">delete</i>
                                                    </button>
                                                @endif

                                            </td>
                                        </tr>
                                        @include('admin.user.deletemodal')
                                        @endforeach
                                    </tbody>
                                </table>
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
