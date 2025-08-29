<!-- Modal Agregar Constancia de Pago -->
<div class="modal fade" id="addConstanciaPagoModal" tabindex="-1" aria-labelledby="addConstanciaPagoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addConstanciaPagoModalLabel">
                    <i class="bi bi-receipt"></i> Agregar Constancia de Pago
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('insert-constancia-pago') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha_pago" class="form-label">Fecha de Pago <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_pago" class="form-control" value="{{ old('fecha_pago') }}" required>
                            @if ($errors->has('fecha_pago'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('fecha_pago') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="identificacion" class="form-label">Identificación <span class="text-danger">*</span></label>
                            <input type="text" name="identificacion" class="form-control" value="{{ old('identificacion') }}" required>
                            @if ($errors->has('identificacion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('identificacion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
                            @if ($errors->has('descripcion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('descripcion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="archivo" class="form-label">Archivo <span class="text-danger">*</span></label>
                            <input type="file" name="archivo" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                            <small class="form-text text-muted">Formatos permitidos: PDF, DOC, DOCX, JPG, JPEG, PNG. Tamaño máximo: 10MB</small>
                            @if ($errors->has('archivo'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('archivo') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <input type="hidden" name="pat_id" value="{{ $pat->id }}">
                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Guardar Constancia
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
