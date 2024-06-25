<div class="modal fade" id="agenda_modal_detail" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title" style="text-align: center; font-weight: bold">Datos de Alguiler</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="idApartar" id="idApartar">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Habitación</label>
                                <input type="text" class="form-control" id="Num_Hab_d"  readonly>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="">Check In</label>
                                <input type="date" class="form-control" id="FechReserva_d" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Hora (In)</label>
                                <input type="time" class="form-control" id="HoraEntrada_d" readonly>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="">Check Out</label>
                                <input type="date" class="form-control" id="FechSalida_d" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="">Hora (Out)</label>
                                <input type="time" class="form-control" id="horaSalida_d" readonly>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Cliente</label>
                                <select id="IdCliente_d"  class="form-control " data-live-search="true" disabled>
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($cliente as $item)
                                        <option value="{{$item->IdCliente}}">{{$item->NumDocumento}} | {{$item->Nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

            </div>

        </div>
    </div>
</div>
