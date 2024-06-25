<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add" style="z-index: 1050">
    <form action="{{ route('guardarCliente') }}" method="POST" id="formCliente">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title">Nuevo Cliente</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="TipDocumento">TIPO DOCUMENTO</label>
                                <select name="idTipDoc" id="idTipDoc" class="form-control form-control-sm" required>
                                    <option value="" selected hidden>Seleccionar</option>
                                    @foreach ($tipo_documento as $t)
                                        <option value="{{ $t->idTipDoc }}"
                                            {{ old('idTipDoc') == $t->idTipDoc ? 'selected' : '' }}>
                                            {{ $t->nomTipDoc }}</option>
                                    @endforeach
                                </select>
                                <span id="idTipDoc-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="NumDocumento">N° DOCUMENTO</label> <span title="Campo obligatorio"
                                    class="text-danger" style="font-weight: bold">*</span>
                                <div class="input-group">
                                    <input type="text" name="NumDocumento" id="NumDocumento"
                                        value="{{ old('NumDocumento') }}" class="form-control form-control-sm"
                                        placeholder="N° de Documento de Identificación." required autocomplete="off">
                                </div>
                                <span id="NumDocumento-error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="Nombre">NOMBRES </label><span title="Campo obligatorio"
                                    class="text-danger" style="font-weight: bold">*</span>
                                <div class="input-group">
                                    <input type="text" name="Nombre" id="Nombre" value="{{ old('Nombre') }}"
                                        class="form-control form-control-sm" placeholder="Ingrese los nombres del Cliente" required
                                        autocomplete="off">
                                </div>
                                <span id="Nombre-error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Correo">CORREO</label>
                                <div class="input-group">
                                    <input type="email" name="Correo" id="Correo" value="{{ old('Correo') }}"
                                        class="form-control form-control-sm" placeholder="Ingrese el correo electrónico del Cliente"
                                        autocomplete="off">
                                </div>
                                <span id="Correo-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Celular">CELULAR</label>
                                <div class="input-group">
                                    <input type="text" name="Celular" id="Celular" value="{{ old('Celular') }}"
                                        class="form-control form-control-sm" placeholder="Ingrese el N° de Celular" autocomplete="off">
                                </div>
                                <span id="Celular-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="Direccion">DIRECCIÓN ORIGEN</label>
                                <div class="input-group">
                                    <input type="text" name="Direccion" id="Direccion" value="{{ old('Direccion') }}"
                                        class="form-control form-control-sm" placeholder="Ejm: Lima - Jr. Las Americas 454">
                                </div>
                                <span id="Direccion-error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>N° MATRÍCULA</label>
                                <div class="input-group">
                                    <input type="text" name="nroMatricula" id="nroMatricula" value="{{ old('nroMatricula') }}"
                                        class="form-control form-control-sm" placeholder="Ejemplo: AAA-123">
                                </div>
                                <span id="nroMatricula-error" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" type="submit" id="enviarCliente">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
