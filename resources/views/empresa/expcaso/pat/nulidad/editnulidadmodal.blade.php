<!-- Modal -->
<div class="modal fade" id="editarNulidadModal{{ $nulidad->id }}" tabindex="-1"
    aria-labelledby="editarNulidadModal{{ $nulidad->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarNulidadModal{{ $nulidad->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Nulidad
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form action="{{ url('update-pat-nulidad/'.$nulidad->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="no" class="form-label">No</label>
                                <input name="no" type="text" class="form-control" placeholder="No..." value="{{ $nulidad->no }}" required/>
                                @if ($errors->has('no'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('no') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha de Nulidad</label>
                                <input type="date" name="fecha" class="form-control text-center" value="{{ $nulidad->fecha }}" required/>
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
                                <label for="tipo_nulidad" class="form-label">Tipo Nulidad</label>
                                <input name="tipo_nulidad" type="text" class="form-control" placeholder="Otro tipo de nulidad..." value="{{ $nulidad->tipo_nulidad }}"/>
                                @if ($errors->has('tipo_nulidad'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('tipo_nulidad') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="nueva_notificacion" class="form-label">Nueva Notificación</label>
                                <select name="nueva_notificacion" class="form-select" aria-label="Default select example"  required>
                                    <option value="">Seleccione lugar para atender...</option>
                                    <option value="Si" {{ $nulidad->nueva_notificacion == "Si" ? ' selected' : '' }}>Si</option>
                                <option value="No" {{ $nulidad->nueva_notificacion == "No" ? ' selected' : '' }}>No</option>
                                <option value="Otro" {{ $nulidad->nueva_notificacion == "Otro" ? ' selected' : '' }}>Otro</option>
                                </select>
                                @if ($errors->has('nueva_notificacion'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('nueva_notificacion') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="pat_id" value="{{ $pat->id }}">

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label class="form-label">Archivo</label>
                                <input type="file" name="archivo" class="form-control border" value="">
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

