<!-- Row start -->
<div class="row gx-3">
    <div class="col-xl-4">
        <div class="card card-background-mask-info">
            <div class="card-header">
                <div class="card-title"><u>Buscar Movimientos</u></div>
            </div>
            <div class="card-body">
                <form action="{{ url('movimientos') }}" method="GET">
                    @csrf
                    <div class="input-group mb-3">
                        <label for="fcodigo" class="form-label">Buscar solo por cuenta:</label>
                        <select name="fcodigo" id="fcodigo" class="form-select select2" aria-label="Default select example" style="width: 100%;">
                            <option value=""{{ request('fcodigo') == '' ? ' selected' : '' }}>Todos</option>
                            @foreach($cuentas as $cuenta)
                                <option value="{{ $cuenta->id }}"{{ old('fcodigo', request('fcodigo')) == $cuenta->id ? ' selected' : '' }}>
                                    {{ $cuenta->codigo }} {{ $cuenta->razon_social }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="tipobusqueda" value="2">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#fcodigo').select2({
            placeholder: 'Seleccione cuenta',
            allowClear: true,
            minimumInputLength: 1,
            language: {
                inputTooShort: function() {
                    return "Por favor, ingrese 1 o más caracteres"; // Cambia el texto aquí
                }
            }
        });
    });
</script>
<!-- Row end -->
