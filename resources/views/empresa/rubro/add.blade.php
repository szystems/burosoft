@extends('layouts.empresa')
@section('content')

    <!-- Content wrapper scroll start -->
    <div class="content-wrapper-scroll">

        <!-- Main header starts -->
        <div class="main-header d-flex align-items-center justify-content-between position-relative">
            <div class="d-flex align-items-center justify-content-center">
                <div class="page-icon">
                    <i class="bi bi-coin"></i>
                </div>
                <div class="page-title">
                    <h5>Rubros</h5>
                </div>
            </div>
            <!-- Date range start -->
            <div class="d-flex align-items-end">
                <h6 class="float-end text-light d-none d-sm-block" id="reloj"></h6>
            </div>
        </div>
        <!-- Main header ends -->

        <!-- Content wrapper start -->
        <div class="content-wrapper">


            <!-- Row start -->
            <div class="row gx-3">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="custom-tabs-container">
                                <ul class="nav nav-tabs" id="customTab2" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="tab-oneA" data-bs-toggle="tab" href="#oneA" role="tab"
                                            aria-controls="oneA" aria-selected="true">Crear Rubro</a>
                                    </li>
                                </ul>
                                <div class="tab-content h-350">
                                    <div class="tab-pane fade show active" id="oneA" role="tabpanel">
                                        <!-- Row start -->
                                        <div class="row gx-3">
                                            <div class="col-sm-12 col-12">
                                                @if (count($errors)>0)
                                                    <div class="alert alert-danger text-white" role="alert">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{$error}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>

                                                @endif
                                                <form action="{{ url('insert-rubro') }}" method="POST">
                                                    @csrf
                                                    <div class="row gx-3">

                                                        <h3><u>Rubro</u></h3>

                                                        <div class="col-md-3 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label for="nombre" class="form-label">Nombre</label>
                                                                <input name="nombre" type="text" class="form-control" placeholder="Nombre..." value="{{ old('nombre') }}" />
                                                                @if ($errors->has('nombre'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('nombre') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12 mb-3">
                                                            <!-- Form Field Start -->
                                                            <div class="mb-3">
                                                                <label class="form-label">Descripción</label>
                                                                <textarea name="descripcion" class="form-control" rows="3" placeholder="Descripción...">{{ old('descripcion') }}</textarea>
                                                                @if ($errors->has('descripcion'))
                                                                    <span class="help-block opacity-7">
                                                                            <strong>
                                                                                <font color="red">{{ $errors->first('descripcion') }}</font>
                                                                            </strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <a href="{{ url('rubros') }}" type="button" class="btn btn-danger">
                                                            <i class="bi bi-x-circle"></i> Cancelar
                                                        </a>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="bi bi-check2-square"></i> Grabar
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- Row end -->
                                    </div>

                                </div>
                                {{-- <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ url('edit-user/'.$user->id) }}" type="button" class="btn btn-outline-secondary">
                                        Cancelar
                                    </a>
                                    <button type="button" class="btn btn-success">
                                        Update
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row end -->
        </div>
        <!-- Content wrapper end -->
    </div>
    <!-- Content wrapper scroll end -->

    <script>
        var date = new Date();
        var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

        var optSimple = {
            language: "es",
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            orientation: "bottom auto",
            startDate: "01-01-1900",


        };
        $( '#fecha_vencimiento' ).datepicker( optSimple );
        $( '#fecha_vencimiento').datepicker( 'setDate', today );
    </script>

<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

@endsection
