<!-- Modal -->
<div class="modal fade" id="addResolucionModal" tabindex="-1" aria-labelledby="addResolucionModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addResolucionModal">
                    <i class="bi bi-plus text-success"></i> Agregar R-SAT
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('insert-resolucion') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row gx-3">

                        <input type="hidden" name="audiencia_id" value="{{ $audiencia->id }}">
                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">

                        <div class="col-md-6 mb-3">
                            <label for="fecha" class="form-label">Fecha de Notificación</label>
                            <input type="date" name="fecha" class="form-control" value="{{ old('fecha') }}" required>
                            @if ($errors->has('fecha'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('fecha') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_resolucion" class="form-label">No. de Resolucion</label>
                            <input type="text" name="numero_resolucion" class="form-control" value="{{ old('numero_resolucion') }}" required>
                            @if ($errors->has('numero_documento'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_resolucion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="tipo_resolucion" class="form-label">Tipo de Resolución</label>
                            <select name="tipo_resolucion" class="form-control" required>
                                <option value="" selected disabled>Seleccione el tipo de resolución</option>
                                <option value="total a favor" {{ old('tipo_resolucion') == 'total a favor' ? 'selected' : '' }}>Total a favor</option>
                                <option value="total en contra" {{ old('tipo_resolucion') == 'total en contra' ? 'selected' : '' }}>Total en contra</option>
                                <option value="parcial" {{ old('tipo_resolucion') == 'parcial' ? 'selected' : '' }}>Parcial</option>
                                <option value="nulidad" {{ old('tipo_resolucion') == 'nulidad' ? 'selected' : '' }}>Nulidad</option>
                                <option value="penal" {{ old('tipo_resolucion') == 'penal' ? 'selected' : '' }}>Penal</option>
                            </select>
                            @if ($errors->has('tipo_resolucion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('tipo_resolucion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="archivo" class="form-label">Archivo</label>
                            <input type="file" name="archivo" class="form-control" required>
                            @if ($errors->has('archivo'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('archivo') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
                            @if ($errors->has('observaciones'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('observaciones') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="audiencia_id" value="{{ $audiencia->id }}">
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


