<!-- Row start -->
<div class="row gx-3">
    <div class="col-xl-12">
        <div class="card card-background-mask-info">
            {{-- <div class="card-header">
                <div class="card-title"><u>Doctores</u></div>
            </div> --}}
            <div class="card-body">

                <div class="accordion" id="accordionSpecialTitle">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSpecialTitleTwo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSpecialTitleTwo" aria-expanded="true"
                                aria-controls="collapseSpecialTitleTwo">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-printer text-info"></i>
                                    <div class="ms-3">
                                        <h5 class="text-yellow">Imprimir Reporte</h5>
                                        {{-- <p class="m-0 fw-normal">Leader</p> --}}

                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseSpecialTitleTwo" class="accordion-collapse collapse"
                            aria-labelledby="headingSpecialTitleTwo" data-bs-parent="#accordionSpecialTitle">
                            <div class="accordion-body">
                                <form action="{{ url('pdf-movimientos') }}" method="GET" target="_blank">
                                    <div class="row gx-3">

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3">
                                                <label for="pdftamaño" class="form-label">Tamaño</label>
                                                <select name="pdftamaño" class="form-select" aria-label="Default select example">
                                                    <option value="Letter"{{ request('pdftamaño') == 'Letter' ? ' selected' : '' }}>Letter</option>
                                                    <option value="Legal"{{ request('pdftamaño') == 'Legal' ? ' selected' : '' }}>Legal</option>
                                                    <option value="A4"{{ request('pdftamaño') == 'A4' ? ' selected' : '' }}>A4</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3">
                                                <label for="pdfhorientacion" class="form-label">Orientación</label>
                                                <select name="pdfhorientacion" class="form-select" aria-label="Default select example">
                                                    <option value="portrait "{{ request('pdfhorientacion') == 'portrait' ? ' selected' : '' }}>portrait</option>
                                                    <option value="landscape"{{ request('pdfhorientacion') == 'landscape' ? ' selected' : '' }}>landscape</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3">
                                                <label for="pdfarchivo" class="form-label">Archivo</label>
                                                <select name="pdfarchivo" class="form-select" aria-label="Default select example">
                                                    <option value="download "{{ request('pdfarchivo') == 'download' ? ' selected' : '' }}>download</option>
                                                    <option value="stream"{{ request('pdfarchivo') == 'stream' ? ' selected' : '' }}>stream</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <h4>Columnas:</h4>
                                        </div>

                                        <div class="col-md-1 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="fid" type="checkbox" value="1" id="flexCheckChecked" {{ (old('fid', 1) == 1 ) ? 'checked' : '' }}/>
                                                <label class="form-check-label" for="flexCheckChecked">ID</label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="ffecha" type="checkbox" value="1" id="flexCheckChecked" {{ (old('ffecha', 1) == 1 ) ? 'checked' : '' }}/>
                                                <label class="form-check-label" for="flexCheckChecked">Fecha</label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="fcuenta" type="checkbox" value="1" id="flexCheckChecked" {{ (old('fcuenta', 1) == 1 ) ? 'checked' : '' }}/>
                                                <label class="form-check-label" for="flexCheckChecked">Cuenta</label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="frubro" type="checkbox" value="1" id="flexCheckChecked" {{ (old('frubro', 1) == 1 ) ? 'checked' : '' }}/>
                                                <label class="form-check-label" for="flexCheckChecked">Rubro</label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="fcargo" type="checkbox" value="1" id="flexCheckChecked" {{ (old('fcargo', 1) == 1 ) ? 'checked' : '' }}/>
                                                <label class="form-check-label" for="flexCheckChecked">Cargo</label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="festadosaldo" type="checkbox" value="1" id="flexCheckChecked" {{ (old('festadosaldo', 1) == 1 ) ? 'checked' : '' }}/>
                                                <label class="form-check-label" for="flexCheckChecked">Saldo</label>
                                            </div>
                                        </div>
                                        <div class="col-md-1 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="fpagadosaldo" type="checkbox" value="1" id="flexCheckChecked" {{ (old('fpagadosaldo', 1) == 1 ) ? 'checked' : '' }}/>
                                                <label class="form-check-label" for="flexCheckChecked">Pag/Sal</label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="fusuario" type="checkbox" value="1" id="flexCheckChecked" {{ (old('fusuario', 1) == 1 ) ? 'checked' : '' }}/>
                                                <label class="form-check-label" for="flexCheckChecked">Usuario</label>
                                            </div>
                                        </div>

                                        <div class="col-md-1 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" name="fpagos" type="checkbox" value="1" id="flexCheckChecked" {{ (old('fpagos', 1) == 1 ) ? 'checked' : '' }}/>
                                                <label class="form-check-label" for="flexCheckChecked">Pagos</label>
                                            </div>
                                        </div>

                                        <input type="hidden" name="ffechadesde" value="{{ $fecha_min }}">
                                        <input type="hidden" name="ffechahasta" value="{{ $fecha_max }}">
                                        <input type="hidden" name="ffcuenta" value="{{ $cuenta->id }}">

                                        <div class="col-md-2 mb-3">
                                            <!-- Form Field Start -->
                                            <div class="mb-3 ">
                                                <button type="submit" class="btn btn-info">
                                                    <i class="bi bi-printer"></i> Imprimir
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- Row end -->
