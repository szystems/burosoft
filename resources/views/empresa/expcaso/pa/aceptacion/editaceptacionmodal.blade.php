<!-- Modal -->
<div class="modal fade" id="editAceptacionPaModal" tabindex="-1" aria-labelledby="editAceptacionPaModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAceptacionPaModalLabel">
                    <i class="bi bi-pencil text-warning"></i> Editar Aceptación (PA)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editAceptacionPaForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">

                        <input type="hidden" name="audiencia_pa_id" id="edit_audiencia_pa_id">
                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">

                        <div class="col-md-6 mb-3">
                            <label for="edit_fecha_hora_presentacion_pa" class="form-label">Fecha y Hora de Presentación</label>
                            <input type="datetime-local" name="fecha_hora_presentacion" id="edit_fecha_hora_presentacion_pa" class="form-control" required>
                            @if ($errors->has('fecha_hora_presentacion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('fecha_hora_presentacion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_numero_documento_pa" class="form-label">No. de Documento</label>
                            <input type="text" name="numero_documento" id="edit_numero_documento_pa" class="form-control" required>
                            @if ($errors->has('numero_documento'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_documento') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_archivo_pa" class="form-label">Archivo</label>
                            <input type="file" name="archivo" id="edit_archivo_pa" class="form-control">
                            <small class="form-text text-muted">Deje vacío si no desea cambiar el archivo actual</small>
                            <div id="current_archivo_pa" class="mt-2"></div>
                            @if ($errors->has('archivo'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('archivo') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_observaciones_pa" class="form-label">Observaciones</label>
                            <textarea name="observaciones" id="edit_observaciones_pa" class="form-control" rows="3"></textarea>
                            @if ($errors->has('observaciones'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('observaciones') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_oficina_presentacion_pa" class="form-label">Oficina o Agencia de Presentación</label>
                            <input type="text" name="oficina_presentacion" id="edit_oficina_presentacion_pa" class="form-control" placeholder="Ej: Oficina Central, Agencia Zona 1, etc.">
                            @if ($errors->has('oficina_presentacion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('oficina_presentacion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_numero_folios_pa" class="form-label">Número de Folios</label>
                            <input type="number" name="numero_folios" id="edit_numero_folios_pa" class="form-control" min="1">
                            @if ($errors->has('numero_folios'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_folios') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check2-square"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
