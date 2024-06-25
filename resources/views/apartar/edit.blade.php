<div class="modal fade" id="agenda_modal_edit" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" style="text-align: center; font-weight: bold">Datos de Reserva</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formulario_agenda_edit">
                    @csrf
                    <div class="row">
                        <input type="hidden" name="idApartar" id="idApartar">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Habitación</label>
                                <input type="text" class="form-control" id="Num_Hab_e" name="Num_Hab" readonly required>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="">Check In</label>
                                <input type="date" class="form-control" id="FechReserva_e"  name="FechReserva"  required>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="">Hora (In)</label>
                                <input type="time" class="form-control" id="HoraEntrada_e" name="HoraEntrada" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="">Check Out</label>
                                <input type="date" class="form-control" id="FechSalida_e" name="FechSalida" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="">Hora (Out)</label>
                                <input type="time" class="form-control" id="horaSalida_e" name="horaSalida"  required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Cliente</label>
                                {{-- <select name="IdCliente" id="IdCliente_e"  class="form-control " data-live-search="true" required>
                                    <option value="" selected>Seleccionar</option>
                                    @foreach ($cliente as $item)
                                        <option value="{{$item->IdCliente}}">{{$item->NumDocumento}} | {{$item->Nombre}}</option>
                                    @endforeach
                                </select> --}}
                                <div id="selectCliente_e">
                                </div>
                                <span id="IdCliente_message_e" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" onclick="alquilar()" id="b_alquilar" class="btn btn-default bg-teal">Alquilar</button>
                <button onclick="eliminar()" type="button" class="btn btn-danger">Eliminar</button>
                <button onclick="editar()" type="button" class="btn btn-success">Editar</button>
            </div>
        </div>
    </div>
</div>
