<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-hablHab-{{$pro->Num_Hab}}">
    {!!Form::model($pro, ['method'=>'POST','route'=>['hablHab', $pro->Num_Hab]])!!}
    {{Form::token()}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-purple">
                <h4 class="modal-title">Habilitar Habitación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div id="error_fecha" class=" bg-danger text-danger"></div>
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <span for="motivo">Habitación</span>
                            <input type="text" name="Num_Hab" value="{{$pro->Num_Hab}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <label for="">Datos de mantenimiento</label>
                    </div>
                    <div class="col-lg-12">
                        <span for="">Motivo</span>
                        <textarea cols="30" rows="3" class="form-control" readonly>{{$pro->motMan}}</textarea>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <span for="resMan">Responsable</span>
                            <input type="text" name="resMan" value="{{$pro->resMan}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <span for="fecMan">Fecha</span>
                            <input type="text" name="fecMan" value="{{ $pro->fecMan }}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-12 text-primary" style="font-size: 0.8em">
                        <p>La Habitación cambiará de estado a <span style="font-weight: bold" class="text-success">DISPONIBLE</span>.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div style="margin: 0px auto 0px auto">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                    {{-- <button class="btn btn-primary" type="submit" style="display: none" id="enviar">Guardar</button>
                    <button type="button" class="btn bg-gradient-primary grabar" id="grabar">
                        Guardar</button> --}}
                </div>
            </div>
        </div>

    </div>
    {{ Form::Close() }}

</div>
