<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add-{{$item->IdReserva}}">
    {{-- {{ Form::Open(['action' => ['ClienteController@store'], 'method' => ' POST', 'files'=>'true']) }} --}}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title">Informes</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 text-center">
                        <a href="{{ route('comprobante.pdf', $item->IdReserva) }}" class="text-danger btn btn-default btn-block" target="_black">
                            Comprob. Inicial
                            <br>
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </div>
                    <div class="col-lg-4 text-center">
                        <a href="{{ URL::action('LReservaController@report', $item->IdReserva) }}" class="text-danger btn btn-default btn-block" target="_black">
                            Detalle General
                            <br>
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </div>
                    <div class="col-lg-4 text-center"  style="margin-bottom: 20px">
                        <a href="{{ asset('ventas/consumo/' . $item->IdReserva . '/edit') }}" class="text-olive btn btn-default btn-block" >
                            Consumo
                            <br>
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </div>
                    <div class="col-lg-4 text-center"  style="margin-bottom: 20px">
                        <a href="{{ asset('ventas/servicio/' . $item->IdReserva . '/edit') }}" class="text-olive btn btn-default btn-block" >
                            Servicio
                            <br>
                            <i class="fas fa-wifi"></i>
                        </a>
                    </div>
                    <div class="col-lg-4 text-center" style="margin-bottom: 20px">
                        <a href="{{ route('renovarAlquiler', $item->IdReserva) }}" class="text-info btn btn-default btn-block" >
                            Renovar Alquiler
                            <br>
                            <i class="fas fa-sync"></i>
                        </a>
                    </div>
                    <div class="col-lg-4 text-center"  style="margin-bottom: 20px">
                        <a href="{{ asset('salidas/verificacion/' . $item->IdReserva . '/edit') }}" class="text-secondary btn btn-default btn-block" >
                            Salida
                            <br>
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                    {{-- <div class="col-lg-4 text-center">
                        <a href="{{ route('add_service', $item->IdReserva) }}" class="btn btn-default"> Servicio Extra
                            <br>
                            <i class="fas fa-concierge-bell"></i>
                        </a>
                    </div> --}}
                </div>


                {{-- <input type="hidden" value="{{ $Habitacion->Num_Hab }}" name="n_hab"> --}}
                <input type="hidden" name="IdTipoCliente" value="1">

            </div>
            <div class="modal-footer">
            </div>
        </div>

    </div>
    {{-- {{ Form::Close() }} --}}

</div>
