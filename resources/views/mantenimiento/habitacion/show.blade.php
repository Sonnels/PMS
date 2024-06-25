<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-show-{{$pro->Num_Hab}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-teal">
                <h4 class="modal-title">Detalles de Habitación</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="motivo">Habitación</label>
                            <p>{{$pro->Num_Hab}}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="motivo">Descripción</label>
                            <p>{{$pro->Descripcion}}</p>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="motivo">Tipo</label>
                            <p>{{ $pro->TipoHabitacion }} <br> 4hrs: {{$datos_hotel->simboloMoneda}}{{ $pro->precioHora }} | PN: {{$datos_hotel->simboloMoneda}}{{ $pro->precioNoche }} | PM: {{$datos_hotel->simboloMoneda}}{{ $pro->precioMes }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="motivo">Nivel</label>
                            <p>{{$pro->Nivel}}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="motivo">Estado</label>
                            <p>{{$pro->Estado}}</p>
                        </div>
                    </div>
                    @if ($pro->Estado == 'MANTENIMIENTO')
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Responsable</label>
                                <p>{{$pro->resMan}}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Fecha Mantenimiento</label>
                                <p>{{$pro->fecMan}}</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="">Motivo</label>
                                <p>{{$pro->motMan}}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <div style="margin: 0px auto 0px auto">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>

    </div>

</div>
