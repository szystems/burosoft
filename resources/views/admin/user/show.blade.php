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
                    <h4><u>{{ __('Ver') }} {{ __('Usuario') }}</u></h4>
                    <div>
                        {{-- <form action="{{ url('pdf-user') }}" method="GET" target="_blank">
                            <input type="hidden" name="ruser" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-danger float-end">
                                <i class="material-icons opacity-10">picture_as_pdf</i> PDF
                            </button>
                        </form> --}}
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
                        @include('admin.user.deletemodal')

                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for=""><strong>{{ __('Rol') }}</strong></label>
                            <p>{{ $user->role_as == '0' ?'User' : 'Admin' }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for=""><strong>{{ __('Nombre') }}</strong></label>
                            <p>{{ $user->name }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for=""><strong>Email</strong></label>
                            <p>{{ $user->email }}</p>
                        </div>
                        {{-- <div class="col-md-3 mb-3">
                            <label for=""><strong>{{ __('Phone') }}</strong></label>
                            <p>{{ $user->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for=""><strong>{{ __('Address') }} 1</strong></label>
                            <p>{{ $user->address1 }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for=""><strong>{{ __('Address') }} 2</strong></label>
                            <p>{{ $user->address2 }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for=""><strong>{{ __('Country') }}</strong></label>
                            <p>{{ $user->country }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for=""><strong>{{ (__('State')) }}</strong></label>
                            <p>{{ $user->state }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for=""><strong>{{ __('City') }}</strong></label>
                            <p>{{ $user->city }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for=""><strong>{{ __('Zipcode') }}</strong></label>
                            <p>{{ $user->zipcode }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for=""><strong>{{ __('Timezone') }}</strong></label>
                            <p>{{ $user->timezone }}</p>
                        </div> --}}
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3">
                        {{-- <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>than last week</p> --}}
                    </div>
                </div>
            </div>

        </div>
    @endsection
