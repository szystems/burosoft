<!-- Modal -->
<div class="modal fade" id="editarPagoModal{{ $pago->id }}" tabindex="-1"
    aria-labelledby="editarPagoModal{{ $pago->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarPagoModal{{ $pago->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Pago
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form action="{{ url('update-pago/'.$pago->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Monto (Quetzales)</label>
                            <div class="input-group">
                                <span class="input-group-text">Q.</span>
                                <input name="monto_q" type="number" class="form-control" id="monto_q" placeholder="0.00"  value="{{ $movimiento->monto_q }}" required>
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
                            <label class="form-label">Monto (Dolares)</label>
                            <div class="input-group">
                                <span class="input-group-text">$.</span>
                                <input name="monto_d" type="number" class="form-control" id="monto_d" placeholder="0.00"  value="{{ $movimiento->monto_d }}" required>
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
                                        <option value="Efectivo" {{ $pago->forma_pago == 'Efectivo' ? ' selected' : '' }}>Efectivo</option>
                                        <option value="Cheque" {{ $pago->forma_pago == 'Cheque' ? ' selected' : '' }}>Cheque</option>
                                        <option value="Deposito" {{ $pago->forma_pago == 'Deposito' ? ' selected' : '' }}>Deposito</option>
                                        <option value="Transferencia"{{ $pago->forma_pago == 'Transferencia' ? ' selected' : '' }}>Transferencia</option>
                                        <option value="Tarjeta C/D" {{ $pago->forma_pago == 'Tarjeta C/D' ? ' selected' : '' }}>Tarjeta C/D</option>
                                        <option value="Moneda Digital" {{ $pago->forma_pago == 'Moneda Digital' ? ' selected' : '' }}>Moneda Digital</option>
                                        <option value="Especie" {{ $pago->forma_pago == 'Especie' ? ' selected' : '' }}>Especie</option>
                                        <option value="Exoneracion" {{ $pago->forma_pago == 'Exoneracion' ? ' selected' : '' }}>Exoneracion</option>
                                        <option value="Otros" {{ $pago->forma_pago == 'Otros' ? ' selected' : '' }}>Otros</option>
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
                                <textarea name="descripcion" class="form-control" rows="3" placeholder="Descripción..." required>{{ $movimiento->descripcion }}</textarea>
                                @if ($errors->has('descripcion'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('descripcion') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="movimiento_id" value="{{ $movimiento->id }}">

                        @if ($pago->imagen)
                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label class="form-label">Imagen</label>
                                <a href="{{ asset('assets/uploads/pagos/'.$pago->imagen) }}" target="_blank" rel="Imagen pago"><img src="{{ asset('assets/uploads/pagos/'.$pago->imagen) }}" class="img-thumbnail" style="height: 100px;" alt="Imagen pago" /></a>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label class="form-label">Cambiar</label>
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
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check2-square"></i> Grabar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

