<!-- Row start -->
<div class="row gx-3">
    <div class="col-xl-12">
        <div class="card card-background-mask-info">
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
                                        <h5 class="text-yellow">Imprimir Reporte de Cuentas</h5>
                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="collapseSpecialTitleTwo" class="accordion-collapse collapse"
                            aria-labelledby="headingSpecialTitleTwo" data-bs-parent="#accordionSpecialTitle">
                            <div class="accordion-body">
                                <form action="{{ url('pdf-cuentas') }}" method="GET" target="_blank">
                                    <div class="row gx-3">
                                        <div class="col-md-2 mb-3">
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
                                            <div class="mb-3">
                                                <label for="pdfhorientacion" class="form-label">Orientación</label>
                                                <select name="pdfhorientacion" class="form-select" aria-label="Default select example">
                                                    <option value="portrait"{{ request('pdfhorientacion') == 'portrait' ? ' selected' : '' }}>Vertical</option>
                                                    <option value="landscape"{{ request('pdfhorientacion') == 'landscape' ? ' selected' : '' }}>Horizontal</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <div class="mb-3">
                                                <label for="pdfarchivo" class="form-label">Archivo</label>
                                                <select name="pdfarchivo" class="form-select" aria-label="Default select example">
                                                    <option value="download"{{ request('pdfarchivo') == 'download' ? ' selected' : '' }}>Descargar</option>
                                                    <option value="stream"{{ request('pdfarchivo') == 'stream' ? ' selected' : '' }}>Ver en navegador</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <div class="mb-3">
                                                <label for="limite" class="form-label">Límite de registros</label>
                                                <input type="number" name="limite" class="form-control" value="{{ old('limite', 500) }}">
                                            </div>
                                        </div>

                                        <div class="col-md-2 mb-3">
                                            <div class="mb-3" style="margin-top: 32px;">
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
