<!-- Modal -->
<div class="modal fade" id="editarNombramientoModal{{ $nombramiento->id }}" tabindex="-1"
    aria-labelledby="editarNombramientoModal{{ $nombramiento->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarNombramientoModal{{ $nombramiento->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Nombramiento
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form action="{{ url('update-pat-nombramiento/'.$nombramiento->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="no" class="form-label">No</label>
                                <input name="no" type="text" class="form-control" placeholder="No..." value="{{ $nombramiento->no }}" required/>
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
                                <label for="fecha_notificacion" class="form-label">Fecha de Nombramiento</label>
                                <input type="date" name="fecha" class="form-control" value="{{ $nombramiento->fecha }}" required/>
                                @if ($errors->has('fecha'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('fecha') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="periodo" class="form-label">Período</label>
                                <input name="periodo" type="text" class="form-control" placeholder="Período..." value="{{ $nombramiento->periodo }}" required/>
                                @if ($errors->has('periodo'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('periodo') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="nombrado_1" class="form-label">Nombrado 1</label>
                                <input name="nombrado_1" type="text" class="form-control" placeholder="Nombre..." value="{{ $nombramiento->nombrado_1 }}" required/>
                                @if ($errors->has('nombrado_1'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('nombrado_1') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="nombrado_2" class="form-label">Nombrado 2</label>
                                <input name="nombrado_2" type="text" class="form-control" placeholder="Nombre..." value="{{ $nombramiento->nombrado_2 }}" />
                                @if ($errors->has('nombrado_2'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('nombrado_2') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="nombrado_3" class="form-label">Nombrado 3</label>
                                <input name="nombrado_3" type="text" class="form-control" placeholder="Nombre..." value="{{ $nombramiento->nombrado_3 }}" />
                                @if ($errors->has('nombrado_3'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('nombrado_3') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="nombrado_4" class="form-label">Nombrado 4</label>
                                <input name="nombrado_4" type="text" class="form-control" placeholder="Nombre..." value="{{ $nombramiento->nombrado_4 }}" />
                                @if ($errors->has('nombrado_4'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('nombrado_4') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="nombrado_5" class="form-label">Nombrado 5</label>
                                <input name="nombrado_5" type="text" class="form-control" placeholder="Nombre..." value="{{ $nombramiento->nombrado_5 }}" />
                                @if ($errors->has('nombrado_5'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('nombrado_5') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="pat_id" value="{{ $nombramiento->pat_id }}">

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label class="form-label">Cambiar Archivo</label>
                                <p>{{ $nombramiento->nombre }}</p>
                                <input type="file" name="archivo" class="form-control border" value="{{ $nombramiento->archivo }}">
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

