<!-- Modal -->
<div class="modal fade" id="editarNotificacionModal{{ $notificacion->id }}" tabindex="-1"
    aria-labelledby="editarNotificacionModal{{ $notificacion->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarNotificacionModal{{ $notificacion->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar Notificación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form action="{{ url('update-pat-notificacion/'.$notificacion->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">

                        <div class="col-md-3 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="fecha_notificacion" class="form-label">Fecha de Notificación</label>
                                <input type="date" name="fecha" class="form-control text-center" value="{{ $notificacion->fecha }}" required/>
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
                                <label for="hora" class="form-label">Hora de Notificación</label>
                                <input type="time" name="hora" class="form-control text-center" value="{{ $notificacion->hora }}" required/>
                                @if ($errors->has('hora'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('hora') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="tipo_notificacion" class="form-label">Tipo Notificación</label>
                                {{-- <input name="tipo_notificacion" type="text" class="form-control" placeholder="Tipo Notificación..." value="{{ $notificacion->tipo_notificacion }}" required/> --}}
                                <select name="tipo_notificacion" class="form-select" aria-label="Default select example" required>
                                    <option value="">Seleccione Tipo...</option>
                                    <option value="Personalmente" {{ $notificacion->tipo_notificacion == "Personalmente" ? ' selected' : '' }}>Personalmente</option>
                                    <option value="Por Otro Procedimiento Idóneo" {{ $notificacion->tipo_notificacion == "Por Otro Procedimiento Idóneo" ? ' selected' : '' }}>Por Otro Procedimiento Idóneo</option>
                                    <option value="Buzón Electrónico" {{ $notificacion->tipo_notificacion == "Buzón Electrónico" ? ' selected' : '' }}>Buzón Electrónico</option>
                                    <option value="Correo Electrónico" {{ $notificacion->tipo_notificacion == "Correo Electrónico" ? ' selected' : '' }}>Correo Electrónico</option>
                                    <option value="Teléfono" {{ $notificacion->tipo_notificacion == "Teléfono" ? ' selected' : '' }}>Teléfono</option>
                                    <option value="Hablado" {{ $notificacion->tipo_notificacion == "Hablado" ? ' selected' : '' }}>Hablado</option>
                                </select>
                                @if ($errors->has('tipo_notificacion'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('tipo_notificacion') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="recibio" class="form-label">Recibio</label>
                                <input name="recibio" type="text" class="form-control" placeholder="Nombre de quien recibió..." value="{{ $notificacion->recibio }}" />
                                @if ($errors->has('recibio'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('recibio') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="domicilio_notificacion_es" class="form-label">¿El domicilio de notificación es?</label>
                                {{-- <input name="tipo_notificacion" type="text" class="form-control" placeholder="Tipo Notificación..." value="{{ old('tipo_notificacion') }}" required/> --}}
                                <select name="domicilio_notificacion_es" class="form-select" aria-label="Default select example">
                                    <option value="">Seleccione tipo de domicilio...</option>
                                    <option value="Fiscal" {{ $notificacion->domicilio_notificacion_es == "Fiscal" ? ' selected' : '' }}>Fiscal</option>
                                    <option value="Comercial" {{ $notificacion->domicilio_notificacion_es == "Comercial" ? ' selected' : '' }}>Comercial</option>
                                    <option value="Especial" {{ $notificacion->domicilio_notificacion_es == "Especial" ? ' selected' : '' }}>Especial</option>
                                    <option value="Otro" {{ $notificacion->domicilio_notificacion_es == "Otro" ? ' selected' : '' }}>Otro</option>
                                </select>
                                @if ($errors->has('domicilio_notificacion_es'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('domicilio_notificacion_es') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-8 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="domicilio_notificacion_otro" class="form-label">Si el domicilio de notificacion es otro:</label>
                                <input name="domicilio_notificacion_otro" type="text" class="form-control" placeholder="Otro Domicilio..." value="{{ $notificacion->domicilio_notificacion_otro }}" />
                                @if ($errors->has('domicilio_notificacion_otro'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('domicilio_notificacion_otro') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="domicilio_notificacion" class="form-label">Domicilio Notificación</label>
                                <input name="domicilio_notificacion" type="text" class="form-control" placeholder="Domicilio..." value="{{ $notificacion->domicilio_notificacion }}" />
                                @if ($errors->has('domicilio_notificacion'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('domicilio_notificacion') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="persona_idonea" class="form-label">¿La persona que recibio es idonea?</label>
                                <select name="persona_idonea" class="form-select" aria-label="Default select example">
                                    <option value="">Seleccione...</option>
                                    <option value="Si" {{ $notificacion->persona_idonea == "Si" ? ' selected' : '' }}>Si</option>
                                    <option value="No" {{ $notificacion->persona_idonea == "No" ? ' selected' : '' }}>No</option>
                                </select>
                                @if ($errors->has('persona_idonea'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('persona_idonea') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="folios_notificados" class="form-label">Número de folios notificados</label>
                                <input name="folios_notificados" type="number" class="form-control" value="{{ $notificacion->folios_notificados }}"/>
                                @if ($errors->has('folios_notificados'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('folios_notificados') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="acto_notificado" class="form-label">Acto Notificado</label>
                                <input name="acto_notificado" type="text" class="form-control" placeholder="Acto..." value="{{ $notificacion->acto_notificado }}" required/>
                                @if ($errors->has('acto_notificado'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('acto_notificado') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="plazo_atencion" class="form-label">Plazo de Atención</label>
                                <input name="plazo_atencion" type="text" class="form-control" placeholder="Plazo..." value="{{ $notificacion->plazo_atencion }}" required/>
                                @if ($errors->has('plazo_atencion'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('plazo_atencion') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @php
                            $vencimiento_plazo = date("d-m-Y", strtotime($notificacion->vencimiento_plazo));
                        @endphp

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-2">
                                <label for="vencimiento_plazo" class="form-label">Vencimiento de Plazo</label>
                                <div class="input-group">
                                    <input type="text" name="vencimiento_plazo" class="form-control datepicker text-center" id="vencimiento_plazo_editar{{ $notificacion->id }}" value="{{ $vencimiento_plazo }}" required/>
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

                                    $( '#vencimiento_plazo_editar{{ $notificacion->id }}' ).datepicker( optSimple );
                                    // $( '#vencimiento_plazo').datepicker( 'setDate', today );
                                </script>
                            </div>
                        </div>



                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="pat_id" value="{{ $notificacion->pat_id }}">

                        <div class="col-md-4 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label class="form-label">Cambiar Archivo</label>
                                <p>{{ $notificacion->nombre }}</p>
                                <input type="file" name="archivo" class="form-control border" value="{{ $notificacion->archivo }}">
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

