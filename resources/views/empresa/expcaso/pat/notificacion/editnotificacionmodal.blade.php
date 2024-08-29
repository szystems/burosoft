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

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="tipo_notificacion" class="form-label">Tipo Notificación</label>
                                <input name="tipo_notificacion" type="text" class="form-control" placeholder="Tipo Notificación..." value="{{ $notificacion->tipo_notificacion }}" required/>
                                @if ($errors->has('tipo_notificacion'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('tipo_notificacion') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="recibio" class="form-label">Recibio</label>
                                <input name="recibio" type="text" class="form-control" placeholder="Nombre de quien recibió..." value="{{ $notificacion->recibio }}" required/>
                                @if ($errors->has('recibio'))
                                    <span class="help-block opacity-7">
                                            <strong>
                                                <font color="red">{{ $errors->first('recibio') }}</font>
                                            </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="domicilio_notificacion" class="form-label">Domicilio Notificación</label>
                                <input name="domicilio_notificacion" type="text" class="form-control" placeholder="Domicilio..." value="{{ $notificacion->domicilio_notificacion }}" required/>
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

                        <div class="col-md-3 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-2">
                                <label for="vencimiento_plazo" class="form-label">Vencimiento de Plazo</label>
                                <div class="input-group">
                                    <input type="text" name="vencimiento_plazo" class="form-control datepicker text-center" id="vencimiento_plazo_editar" value="{{ $vencimiento_plazo }}" required/>
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
                                    $( '#vencimiento_plazo_editar' ).datepicker( optSimple );
                                    // $( '#vencimiento_plazo').datepicker( 'setDate', today );
                                </script>
                            </div>
                        </div>



                        <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="pat_id" value="{{ $notificacion->pat_id }}">

                        <div class="col-md-6 mb-3">
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

