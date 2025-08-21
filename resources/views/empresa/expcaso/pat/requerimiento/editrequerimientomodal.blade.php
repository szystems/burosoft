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

                        <div class="col-md-3 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha de Requerimiento</label>
                                <input type="date" name="fecha" class="form-control text-center" value="{{ $requerimiento->fecha }}" required/>
                                @if ($errors->has('fecha'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('fecha') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="fecha_maxima" class="form-label">Fecha Maxima</label>
                                <input type="date" name="fecha_maxima" class="form-control text-center" value="{{ $requerimiento->fecha_maxima }}" required/>
                                @if ($errors->has('fecha_maxima'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('fecha_maxima') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="tipo_requerimiento" class="form-label">Tipo Requerimiento</label>
                                <select name="tipo_requerimiento" class="form-select" aria-label="Default select example"  required>
                                    <option value="">Seleccione tipo de requerimiento...</option>
                                    <option value="Personal" {{ $requerimiento->tipo_requerimiento == "Personal" ? ' selected' : '' }}>Personal</option>
                                    <option value="Cruce de información respecto terceros" {{ $requerimiento->tipo_requerimiento == "Cruce de información respecto terceros" ? ' selected' : '' }}>Cruce de información respecto terceros</option>
                                    <option value="Otro" {{ $requerimiento->tipo_requerimiento == "Otro" ? ' selected' : '' }}>Otro</option>
                                </select>
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
                                <label for="tipo_requerimiento_otro" class="form-label">Si es otro</label>
                                <input name="tipo_requerimiento_otro" type="text" class="form-control" placeholder="Otro tipo de requerimiento..." value="{{ $requerimiento->tipo_requerimiento_otro }}"/>
                                @if ($errors->has('tipo_requerimiento_otro'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('tipo_requerimiento_otro') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="lugar_atender" class="form-label">Lugar Para Atender</label>
                                <select name="lugar_atender" class="form-select" aria-label="Default select example"  required>
                                    <option value="">Seleccione lugar para atender...</option>
                                    <option value="Domicilio Fiscal" {{ $requerimiento->lugar_atender == "Domicilio Fiscal" ? ' selected' : '' }}>Domicilio Fiscal</option>
                                    <option value="Domicilio Comercial" {{ $requerimiento->lugar_atender == "Domicilio Comercial" ? ' selected' : '' }}>Domicilio Comercial</option>
                                    <option value="Instalaciones de la SAT" {{ $requerimiento->lugar_atender == "Instalaciones de la SAT" ? ' selected' : '' }}>Instalaciones de la SAT</option>
                                    <option value="Otro" {{ $requerimiento->lugar_atender == "Otro" ? ' selected' : '' }}>Otro</option>
                                </select>
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
                                <label for="lugar_atender_otro" class="form-label">Si es otro</label>
                                <input name="lugar_atender_otro" type="text" class="form-control" placeholder="Otro lugar para atender..." value="{{ $requerimiento->lugar_atender_otro }}"/>
                                @if ($errors->has('lugar_atender_otro'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('lugar_atender_otro') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="domicilio" class="form-label">Domicilio</label>
                                <input name="domicilio" type="text" class="form-control" placeholder="Domicilio..." value="{{ $requerimiento->domicilio }}" required/>
                                @if ($errors->has('domicilio'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('domicilio') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="tipo_revision" class="form-label">Tipo de Revisión</label>
                                <select name="tipo_revision" class="form-select" aria-label="Default select example" required>
                                    <option value="">Seleccione tipo de revisión...</option>
                                    <option value="Integrada" {{ $requerimiento->tipo_revision }} == "Integrada" ? ' selected' : '' }}>Integrada</option>
                                    <option value="IVA" {{ $requerimiento->tipo_revision == "IVA" ? ' selected' : '' }}>IVA</option>
                                    <option value="ISR" {{ $requerimiento->tipo_revision == "ISR" ? ' selected' : '' }}>ISR</option>
                                    <option value="ISO" {{ $requerimiento->tipo_revision == "ISO" ? ' selected' : '' }}>ISO</option>
                                    <option value="Timbre" {{ $requerimiento->tipo_revision == "Timbre" ? ' selected' : '' }}>Timbre</option>
                                    <option value="Aspectos Formales" {{ $requerimiento->tipo_revision == "Integrada" ? ' selected' : '' }}>Aspectos Formales</option>
                                    <option value="Otro" {{ $requerimiento->tipo_revision == "Otro" ? ' selected' : '' }}>Otro</option>
                                </select>
                                @if ($errors->has('tipo_revision'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('tipo_revision') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="tipo_revision_otro" class="form-label">Si es otro</label>
                                <input name="tipo_revision_otro" type="text" class="form-control" placeholder="Otro tipo de revisión..." value="{{ $requerimiento->tipo_revision_otro }}"/>
                                @if ($errors->has('tipo_revision_otro'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('tipo_revision_otro') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="plazo_atencion" class="form-label">Plazo de Atención</label>
                                <input name="plazo_atencion" type="text" class="form-control" placeholder="Plazo..." value="{{ $requerimiento->plazo_atencion }}"  required/>
                                @if ($errors->has('plazo_atencion'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('plazo_atencion') }}</font>
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

