<!-- Modal -->
<div class="modal fade" id="editAmpmrPaModal-{{ $ampmr->id }}" tabindex="-1" aria-labelledby="editAmpmrPaModal-{{ $ampmr->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAmpmrPaModal-{{ $ampmr->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Atención de Memorial Para Mejor Resolver (PA)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('update-ampmr-pa/'.$ampmr->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">
                        <!-- Campo oculto 'is_pa' eliminado -->

                        <div class="col-md-6 mb-3">
                            <label for="fecha_hora_presentacion" class="form-label">Fecha de Notificación</label>
                            <input type="datetime-local" name="fecha_hora_presentacion" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($ampmr->fecha_hora_presentacion)) }}" required>
                            @if ($errors->has('fecha_hora_presentacion'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('fecha_hora_presentacion') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_documento" class="form-label">No. de Documento</label>
                            <input type="text" name="numero_documento" class="form-control" value="{{ $ampmr->numero_documento }}" required>
                            @if ($errors->has('numero_documento'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_documento') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="oficina_ea" class="form-label">Oficina o agencia donde fue atendida la Medida Para Mejor Resolver</label>
                            <input type="text" name="oficina_ea" class="form-control" value="{{ $ampmr->oficina_ea }}">
                            @if ($errors->has('oficina_ea'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('oficina_ea') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="archivo" class="form-label">Archivo</label>
                            <input type="file" name="archivo" class="form-control">
                            @if ($errors->has('archivo'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('archivo') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea name="observaciones" class="form-control" rows="3">{{ $ampmr->observaciones }}</textarea>
                            @if ($errors->has('observaciones'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('observaciones') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="numero_folios" class="form-label">Número de Folios</label>
                            <input type="number" name="numero_folios" class="form-control" value="{{ $ampmr->numero_folios }}" min="1">
                            @if ($errors->has('numero_folios'))
                                <span class="help-block opacity-7">
                                    <strong>
                                        <font color="red">{{ $errors->first('numero_folios') }}</font>
                                    </strong>
                                </span>
                            @endif
                        </div>

                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="audiencia_pa_id" value="{{ $ampmr->audiencia_pa_id }}">
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
