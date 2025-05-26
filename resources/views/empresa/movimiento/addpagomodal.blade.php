<!-- Modal -->
<div class="modal fade" id="addPagoModal" tabindex="-1"
aria-labelledby="addPagoModal" aria-hidden="true">

<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addPagoModal">
                <i class="bi bi-plus text-success"></i> Agregar Pago
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        @if (count($errors)>0)
            <div class="alert alert-danger text-white" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>

        @endif
        <form action="{{ url('insert-pago') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row gx-3">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Monto (Quetzales)</label>
                        <div class="input-group">
                            <span class="input-group-text">Q.</span>
                            <input name="monto_q" type="number" step="0.01" class="form-control" id="monto_q" placeholder="0.00"  value="{{ number_format($saldo_q,2, '.', '') }}" required>
                        </div>
                        @if ($errors->has('monto_q'))
                            <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('monto_q') }}</font>
                                    </strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Monto (Dólares)</label>
                        <div class="input-group">
                            <span class="input-group-text">$.</span>
                            <input name="monto_d" type="number" step="0.01" class="form-control" id="monto_d" placeholder="0.00"  value="{{ number_format($saldo_d,2, '.', '') }}" required>
                        </div>
                        @if ($errors->has('monto_d'))
                            <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('monto_d') }}</font>
                                    </strong>
                            </span>
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="forma_pago" class="form-label">Forma Pago</label>
                            <select name="forma_pago" class="form-select" aria-label="Default select example" required>
                                <option value="">Seleccione forma de pago...</option>
                                    <option value="Efectivo" {{ old('forma_pago') == "Efectivo" ? ' selected' : '' }}>Efectivo</option>
                                    <option value="Cheque" {{ old('forma_pago') == "Cheque" ? ' selected' : '' }}>Cheque</option>
                                    <option value="Deposito" {{ old('forma_pago') == "Deposito" ? ' selected' : '' }}>Deposito</option>
                                    <option value="Transferencia" {{ old('forma_pago') == "Transferencia" ? ' selected' : '' }}>Transferencia</option>
                                    <option value="Tarjeta C/D" {{ old('forma_pago') == "Tarjeta C/D" ? ' selected' : '' }}>Tarjeta C/D</option>
                                    <option value="Moneda Digital" {{ old('forma_pago') == "Moneda Digital" ? ' selected' : '' }}>Moneda Digital</option>
                                    <option value="Especie" {{ old('forma_pago') == "Especie" ? ' selected' : '' }}>Especie</option>
                                    <option value="Exoneracion" {{ old('forma_pago') == "Exoneracion" ? ' selected' : '' }}>Exoneracion</option>
                                    <option value="Otros" {{ old('forma_pago') == "Otros" ? ' selected' : '' }}>Otros</option>
                            </select>
                            @if ($errors->has('forma_pago'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('forma_pago') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3" placeholder="Descripción..." required>{{ old('descripcion') }}</textarea>
                            @if ($errors->has('descripcion'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('descripcion') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="accordion" id="accordionSpecialTitle">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSpecialTitleOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSpecialTitleOne" aria-expanded="true"
                                    aria-controls="collapseSpecialTitleOne">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-filter text-info"></i>
                                        <div class="ms-3">
                                            <h5 class="text-yellow">Otros Datos:</h5>
                                            {{-- <p class="m-0 fw-normal">Leader</p> --}}

                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapseSpecialTitleOne" class="accordion-collapse collapse"
                                aria-labelledby="headingSpecialTitleOne" data-bs-parent="#accordionSpecialTitle">
                                <div class="accordion-body">
                                    <div class="row gx-3">

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">No. Documento</label>
                                            <input name="numero_documento" type="text" class="form-control" placeholder="Número de Documento">
                                            @if ($errors->has('numero_documento'))
                                                <span class="help-block opacity-7">
                                                        <strong>
                                                            <font color="red">{{ $errors->first('numero_documento') }}</font>
                                                        </strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Banco</label>
                                            <input name="banco" type="text" class="form-control" placeholder="Nombre del Banco">
                                            @if ($errors->has('banco'))
                                                <span class="help-block opacity-7">
                                                        <strong>
                                                            <font color="red">{{ $errors->first('banco') }}</font>
                                                        </strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">No. de Cuenta</label>
                                            <input name="numero_cuenta" type="text" class="form-control" placeholder="Número de cuenta">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-2">
                                                <label for="fecha_documento" class="form-label">Fecha</label>
                                                <div class="input-group">
                                                    <input type="text" name="fecha_documento" class="form-control datepicker text-center" id="fecha_documento" value=""/>
                                                    <span class="input-group-text">
                                                        <i class="bi bi-calendar4"></i>
                                                    </span>
                                                </div>
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
                                                    $( '#fecha_documento' ).datepicker( optSimple );
                                                    $( '#fecha_documento').datepicker( 'setDate', today );
                                                </script>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="movimiento_id" value="{{ $movimiento->id }}">

                    <div class="col-md-12 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label class="form-label">Imagen</label>
                            <input type="file" name="imagen" class="form-control border" value="{{ old('imagen') }}">
                            @if ($errors->has('imagen'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('imagen') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-warning" id="btnSubmitPago">
                    <i class="bi bi-check2-square"></i> Grabar
                </button>
            </div>
        </form>
        <!-- Script para prevenir múltiples envíos del formulario -->
        <script>
            document.getElementById('addPagoModal').addEventListener('shown.bs.modal', function() {
                document.querySelector('#addPagoModal form').addEventListener('submit', function() {
                    // Deshabilitar el botón de envío
                    var btnSubmit = document.getElementById('btnSubmitPago');
                    btnSubmit.disabled = true;
                    btnSubmit.innerHTML = '<i class="bi bi-hourglass-split"></i> Procesando...';
                });
            });
        </script>
    </div>
</div>
</div>


