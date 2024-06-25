<div class="modal fade modal-slide-in-center" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {!! Form::open(['url' => 'caja/egreso', 'method' => 'POST', 'autocomplete' => 'off']) !!}
    {!! Form::token() !!}

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title">Nuevo Egreso</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body" id="formulario">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="Importe">Tipo</label>
                        <div class="input-group">
                            <select name="tipo" id="" class="form-control" required>
                                <option value="" selected hidden>Seleccionar</option>
                                @foreach ($tipo as $item)
                                    <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Importe">Importe</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{$datos_empresa->simboloMoneda}}</span>
                           </div>
                            <input type="text" class="form-control importe" name="importe" id="importe" placeholder="Importe" value="{{ old('importe')}}" required>
                        </div>
                    </div>
                    <div class="form-group" >
                        <label for="entregadoA">Entregado a</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="entregadoA" id="entregadoA" placeholder="Entregado a ..." value="{{ old('entregadoA')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Motivo">Motivo</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="motivo" id="motivo" placeholder="Motivo" value="{{ old('motivo')}}">
                        </div>
                    </div>
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::Close() }}
