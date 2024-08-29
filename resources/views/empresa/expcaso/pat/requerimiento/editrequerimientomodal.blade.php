<!-- Modal -->
<div class="modal fade" id="editarRequerimientoModal{{ $requerimiento->id }}" tabindex="-1"
    aria-labelledby="editarRequerimientoModal{{ $requerimiento->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarRequerimientoModal{{ $requerimiento->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Requerimiento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form action="{{ url('update-pat-requerimiento/'.$requerimiento->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="no" class="form-label">No</label>
                                <input name="no" type="text" class="form-control" placeholder="No..." value="{{ $requerimiento->no }}" required/>
                                @if ($errors->has('no'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('no') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="tipo_requerimiento" class="form-label">Tipo Requerimiento</label>
                                <input name="tipo_requerimiento" type="text" class="form-control" placeholder="Tipo..." value="{{ $requerimiento->tipo_requerimiento }}" required/>
                                @if ($errors->has('tipo_requerimiento'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('tipo_requerimiento') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="lugar_atender" class="form-label">Lugar Para Atender</label>
                                <input name="lugar_atender" type="text" class="form-control" placeholder="Lugar..." value="{{ $requerimiento->lugar_atender }}" required/>
                                @if ($errors->has('lugar_atender'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('lugar_atender') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="plazo_atencion" class="form-label">Plazo de Atención</label>
                                <input name="plazo_atencion" type="text" class="form-control" placeholder="Plazo..." value="{{ $requerimiento->plazo_atencion }}" />
                                @if ($errors->has('plazo_atencion'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('plazo_atencion') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="tipo_revision" class="form-label">Tipo de Revision</label>
                                <input name="tipo_revision" type="text" class="form-control" placeholder="Tipo..." value="{{ $requerimiento->tipo_revision }}" />
                                @if ($errors->has('tipo_revision'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('tipo_revision') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="pat_id" value="{{ $requerimiento->pat_id }}">

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label class="form-label">Cambiar Archivo</label>
                                <p>{{ $requerimiento->nombre }}</p>
                                <input type="file" name="archivo" class="form-control border" value="{{ $requerimiento->archivo }}">
                                @if ($errors->has('archivo'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('archivo') }}</font>
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

