<!-- Modal -->
<div class="modal fade" id="editarRctModal{{ $rct->id }}" tabindex="-1"
    aria-labelledby="editarRctModal{{ $rct->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarRctModal{{ $rct->id }}">
                    <i class="bi bi-pencil text-warning"></i> Editar RCT (Resolución del Conflicto Tributario)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('update-pat-rct/'.$rct->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row gx-3">

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="fecha_citacion" class="form-label">Fecha de Citación</label>
                                <input type="date" name="fecha_citacion" class="form-control text-center" value="{{ $rct->fecha_citacion }}" required/>
                                @if ($errors->has('fecha_citacion'))
                                    <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('fecha_citacion') }}</font>
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="medio_citacion" class="form-label">Medio de Citación</label>
                                <select name="medio_citacion" class="form-select" aria-label="Default select example" required>
                                    <option value="">Seleccione Medio...</option>
                                    <option value="Escrita" {{ $rct->medio_citacion == "Escrita" ? ' selected' : '' }}>Escrita</option>
                                    <option value="Hablada" {{ $rct->medio_citacion == "Hablada" ? ' selected' : '' }}>Hablada</option>
                                    <option value="Otro" {{ $rct->medio_citacion == "Otro" ? ' selected' : '' }}>Otro</option>
                                </select>
                                @if ($errors->has('medio_citacion'))
                                    <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('medio_citacion') }}</font>
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="medio_citacion_otro" class="form-label">Especifique otro medio (si seleccionó "Otro")</label>
                                <input name="medio_citacion_otro" type="text" class="form-control" placeholder="Especifique otro medio..." value="{{ $rct->medio_citacion_otro }}"/>
                                @if ($errors->has('medio_citacion_otro'))
                                    <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('medio_citacion_otro') }}</font>
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="fecha_atencion" class="form-label">Fecha de Atención</label>
                                <input type="date" name="fecha_atencion" class="form-control text-center" value="{{ $rct->fecha_atencion }}" required/>
                                @if ($errors->has('fecha_atencion'))
                                    <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('fecha_atencion') }}</font>
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="lugar_celebracion" class="form-label">Lugar de Celebración</label>
                                <input name="lugar_celebracion" type="text" class="form-control" placeholder="Lugar donde se celebró..." value="{{ $rct->lugar_celebracion }}" required/>
                                @if ($errors->has('lugar_celebracion'))
                                    <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('lugar_celebracion') }}</font>
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="participantes_reunion" class="form-label">Participantes en la Reunión</label>
                                <textarea name="participantes_reunion" class="form-control" rows="4" placeholder="Describa los participantes en la reunión..." required>{{ $rct->participantes_reunion }}</textarea>
                                @if ($errors->has('participantes_reunion'))
                                    <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('participantes_reunion') }}</font>
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="descripcion_resultado" class="form-label">Descripción del Resultado</label>
                                <textarea name="descripcion_resultado" class="form-control" rows="4" placeholder="Describa el resultado obtenido..." required>{{ $rct->descripcion_resultado }}</textarea>
                                @if ($errors->has('descripcion_resultado'))
                                    <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('descripcion_resultado') }}</font>
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="suscribe_acta" class="form-label">¿Se Suscribe Acta?</label>
                                <select name="suscribe_acta" class="form-select suscribe-acta-edit" aria-label="Default select example" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Si" {{ $rct->suscribe_acta == "Si" ? ' selected' : '' }}>Si</option>
                                    <option value="No" {{ $rct->suscribe_acta == "No" ? ' selected' : '' }}>No</option>
                                </select>
                                @if ($errors->has('suscribe_acta'))
                                    <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('suscribe_acta') }}</font>
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3 archivo-acta-edit-div" style="{{ $rct->suscribe_acta == 'Si' ? 'display: block;' : 'display: none;' }}">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="archivo_acta" class="form-label">Archivo del Acta</label>
                                <input name="archivo_acta" type="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"/>
                                @if($rct->archivo_acta)
                                    <small class="text-muted">Archivo actual: <a href="{{ asset('assets/uploads/pat/rcts/'.$rct->archivo_acta) }}" target="_blank">{{ $rct->tipo_archivo_acta }}</a></small>
                                @endif
                                @if ($errors->has('archivo_acta'))
                                    <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('archivo_acta') }}</font>
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- <div class="col-md-12 mb-3">
                            <!-- Form Field Start -->
                            <div class="mb-3">
                                <label for="archivo_recibo_pago" class="form-label">Recibo de Pago (Opcional)</label>
                                <input name="archivo_recibo_pago" type="file" class="form-control" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"/>
                                @if($rct->archivo_recibo_pago)
                                    <small class="text-muted">Archivo actual: <a href="{{ asset('assets/uploads/pat/rcts/'.$rct->archivo_recibo_pago) }}" target="_blank">{{ $rct->tipo_archivo_recibo }}</a></small>
                                @endif
                                @if ($errors->has('archivo_recibo_pago'))
                                    <span class="help-block opacity-7">
                                        <strong>
                                            <font color="red">{{ $errors->first('archivo_recibo_pago') }}</font>
                                        </strong>
                                    </span>
                                @endif
                            </div>
                        </div> --}}

                    </div>
                </div>
                
                <div class="modal-footer">
                    <input type="hidden" name="pat_id" value="{{ $rct->pat_id }}">
                    <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-warning">Actualizar RCT</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const suscribeActaEditSelect = document.querySelector('#editarRctModal{{ $rct->id }} .suscribe-acta-edit');
    const archivoActaEditDiv = document.querySelector('#editarRctModal{{ $rct->id }} .archivo-acta-edit-div');
    
    if (suscribeActaEditSelect) {
        suscribeActaEditSelect.addEventListener('change', function() {
            if (this.value === 'Si') {
                archivoActaEditDiv.style.display = 'block';
            } else {
                archivoActaEditDiv.style.display = 'none';
            }
        });
    }
});
</script>
