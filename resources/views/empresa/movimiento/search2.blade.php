<!-- Row start -->
<div class="row gx-3">
    <div class="col-xl-4">
        <div class="card card-background-mask-info">
            {{-- <div class="card-header">
                <div class="card-title"><u>Doctores</u></div>
            </div> --}}
            <div class="card-body">
                <form action="{{ url('movimientos') }}" method="GET">
                    @csrf
                    <div class="input-group">
                        <input class="form-control"  placeholder="Buscar Código ..." name="fcodigo" value="{{ $fcodigo }}"/>
                        <input type="hidden" name="tipobusqueda" value="2">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->
