<!-- Modal -->
<div class="modal fade" id="addNotificacionModal" tabindex="-1"
aria-labelledby="addNotificacionModal" aria-hidden="true">

<div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addNotificacionModal">
                <i class="bi bi-plus text-success"></i> Agregar Notificación
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>


        <form action="{{ url('insert-pat-notificacion') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row gx-3">

                    <div class="col-md-3 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha de Notificación</label>
                            <input type="date" name="fecha" class="form-control text-center" value="{{ old('fecha') }}" required/>
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
                            <input type="time" name="hora" class="form-control text-center" value="{{ old('hora') }}" required/>
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
                            {{-- <input name="tipo_notificacion" type="text" class="form-control" placeholder="Tipo Notificación..." value="{{ old('tipo_notificacion') }}" required/> --}}
                            <select name="tipo_notificacion" class="form-select" aria-label="Default select example" required>
                                <option value="">Seleccione Tipo...</option>
                                <option value="Personalmente" {{ old('tipo_notificacion') == "Personalmente" ? ' selected' : '' }}>Personalmente</option>
                                <option value="Por Otro Procedimiento Idóneo" {{ old('tipo_notificacion') == "Por Otro Procedimiento Idóneo" ? ' selected' : '' }}>Por Otro Procedimiento Idóneo</option>
                                <option value="Buzón Electrónico" {{ old('tipo_notificacion') == "Buzón Electrónico" ? ' selected' : '' }}>Buzón Electrónico</option>
                                <option value="Correo Electrónico" {{ old('tipo_notificacion') == "Correo Electrónico" ? ' selected' : '' }}>Correo Electrónico</option>
                                <option value="Teléfono" {{ old('tipo_notificacion') == "Teléfono" ? ' selected' : '' }}>Teléfono</option>
                                <option value="Hablado" {{ old('tipo_notificacion') == "Hablado" ? ' selected' : '' }}>Hablado</option>
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
                            <input name="recibio" type="text" class="form-control" placeholder="Nombre de quien recibió..." value="{{ old('recibio') }}"/>
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
                                <option value="Fiscal" {{ old('domicilio_notificacion_es') == "Fiscal" ? ' selected' : '' }}>Fiscal</option>
                                <option value="Comercial" {{ old('domicilio_notificacion_es') == "Comercial" ? ' selected' : '' }}>Comercial</option>
                                <option value="Especial" {{ old('domicilio_notificacion_es') == "Especial" ? ' selected' : '' }}>Especial</option>
                                <option value="Otro" {{ old('domicilio_notificacion_es') == "Otro" ? ' selected' : '' }}>Otro</option>
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
                            <input name="domicilio_notificacion_otro" type="text" class="form-control" placeholder="Otro Domicilio..." value="{{ old('domicilio_notificacion_otro') }}" />
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
                            <input name="domicilio_notificacion" type="text" class="form-control" placeholder="Domicilio..." value="{{ old('domicilio_notificacion') }}"/>
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
                                <option value="Si" {{ old('persona_idonea') == "Si" ? ' selected' : '' }}>Si</option>
                                <option value="No" {{ old('persona_idonea') == "No" ? ' selected' : '' }}>No</option>
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
                            <input name="folios_notificados" type="number" class="form-control" value="{{ old('folios_notificados', 0) }}"/>
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
                            <input name="acto_notificado" type="text" class="form-control" placeholder="Acto..." value="{{ old('acto_notificado') }}" required/>
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
                            <input name="plazo_atencion" type="text" class="form-control" placeholder="Plazo..." value="{{ old('plazo_atencion') }}" required/>
                            @if ($errors->has('plazo_atencion'))
                                <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('plazo_atencion') }}</font>
                                        </strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- @php
                        $vencimiento_plazo = date("d-m-Y", strtotime($notificacion->vencimiento_plazo));
                    @endphp --}}

                    <div class="col-md-3 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-2">
                            <label for="vencimiento_plazo" class="form-label">Vencimiento de Plazo</label>
                            <div class="input-group">
                                <input type="text" name="vencimiento_plazo" class="form-control datepicker text-center" id="vencimiento_plazo" value="{{ old('vencimiento_plazo') }}" required/>
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
                                $( '#vencimiento_plazo' ).datepicker( optSimple );
                                $( '#vencimiento_plazo').datepicker( 'setDate', today );
                            </script>
                        </div>
                    </div>



                    <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="pat_id" value="{{ $pat->id }}">

                    <div class="col-md-6 mb-3">
                        <!-- Form Field Start -->
                        <div class="mb-3">
                            <label class="form-label">Archivo</label>
                            <input type="file" name="archivo" class="form-control border" value="{{ old('archivo') }}" required>
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


