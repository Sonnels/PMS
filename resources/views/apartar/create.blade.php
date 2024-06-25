<div class="modal fade" id="agenda_modal" data-backdrop="static" tabindex="-1" style="z-index: 1045">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" style="text-align: center; font-weight: bold">Reservar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="formulario_agenda">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Habitación</label>
                                <input type="text" class="form-control" id="Num_Hab" name="Num_Hab" readonly
                                    required>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="">Fecha (In)</label>
                                <input type="date" class="form-control" id="FechReserva" name="FechReserva" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="">Hora (In)</label>
                                <input type="time" class="form-control" id="HoraEntrada" name="HoraEntrada" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="">Fecha (Out)</label>
                                <input type="date" class="form-control" id="FechSalida" name="FechSalida" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="form-group">
                                <label for="">Hora (Out)</label>
                                <input type="time" class="form-control" id="horaSalida" name="horaSalida" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="">Cliente</label> <button class="btn btn-reset text-primary" data-target="#modal-add" style="float: right;" data-toggle="modal"  style="float: right;">
                                    <i class="fas fa-plus-circle" style=" margin-right: 5px"></i>Agregar</button>
                                <div id="selectCliente">
                                </div>
                                <span id="IdCliente" class="text-danger"></span>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button onclick="guardar()" type="button" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
