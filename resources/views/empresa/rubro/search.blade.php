<!-- Row start -->
<div class="row gx-3">
    <div class="col-xl-12">
        <div class="card card-background-mask-info">
            {{-- <div class="card-header">
                <div class="card-title"><u>Doctores</u></div>
            </div> --}}
            <div class="card-body">
                <form action="{{ url('rubros') }}" method="GET">
                    @csrf
                    <div class="input-group">
                        <input class="form-control" list="exampleDataList" id="exampleDataList" placeholder="Buscar Rubro ..." name="frubro" value="{{ $queryRubro }}"/>
                        <datalist id="exampleDataList">
                            @if ($queryRubro != null)
                                <option selected value="{{ $queryRubro }}" >{{ $queryRubro }}</option>
                            @endif
                            @foreach ($filterRubros as $item)
                                <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                            @endforeach
                        </datalist>
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
