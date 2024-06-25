<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {!! Form::open(['url' => 'caja/ingreso', 'method' => 'POST', 'autocomplete' => 'off']) !!}
    {!! Form::token() !!}

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title">Nuevo Ingreso Extra</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body" id="formulario">
                <div class="modal-body">
                    <div class="form-group row" >
                        <div class="input-group  a mb-3">
                            <label for="Importe">Importe</label>
                            <div class="formulario__grupo-input input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{$datos_empresa->simboloMoneda}}</span>
                                </div>
                                <input type="text" class="form-control importe" name="importe" id="importe" placeholder="Importe" value="{{ old('importe')}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="input-group  a mb-3">
                            <label for="Recibido de">Recibido de</label>
                            <div class="formulario__grupo-input input-group">
                                <input type="text" class="form-control" name="recibidoDe" id="recibidoDe" placeholder="Recibido de" value="{{ old('recibidoDe')}}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" >
                        <div class="input-group  a mb-3">
                            <label for="Motivo">Motivo</label>
                            <div class="formulario__grupo-input input-group">
                                <input type="text" class="form-control" name="motivo" id="motivo" placeholder="Motivo" value="{{ old('motivo')}}" required>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="form-group row" >
                        <div class="input-group  a mb-3">
                            <label for="Motivo">Método Pago</label>
                            <div class="formulario__grupo-input input-group">
                                <select name="metodoPago" class="form-control">
                                    @foreach ($mPago as $item)
                                        <option value="{{$item}}">{{$item}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    @if (count($errors) > 0)
                        <div style="margin: 0px auto 0px auto">
                            <div class="alert alert-danger">
                                <ul>
                                    @php($error_create = 0)
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                    @endif
                    <div style="margin: 0px auto 0px auto">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::Close() }}
