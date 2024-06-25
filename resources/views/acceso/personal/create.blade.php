<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="formModalLabel">Crear {{ $componentName }}</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['url' => 'acceso/personal', 'method' => 'POST', 'autocomplete' => 'off']) !!}
            {!! Form::token() !!}
            <div class="modal-body">
                <div class="form-group">
                    <label>Nombre <span class="text-danger" title="Campo obligatorio">*</span> </label>
                    <div class="input-group a mb-3">
                        <input type="text" class="form-control" name="nomPer" placeholder="Ingrese el nombre"
                            autocomplete="off" value="{{ old('nomPer') }}" required>
                    </div>
                    {!! $errors->first('nomPer', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                </div>
                <div class="form-group">
                    <label>Teléfono</label>
                    <div class="input-group a mb-3">
                        <input type="text" class="form-control" name="telPer" placeholder="Ingrese el Teléfono"
                            autocomplete="off" value="{{ old('telPer') }}">
                    </div>
                    {!! $errors->first('telPer', '<span class="help-block text-danger"><b>:message </b></span>') !!}
                </div>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            {{ Form::Close() }}
        </div>
    </div>
</div>
