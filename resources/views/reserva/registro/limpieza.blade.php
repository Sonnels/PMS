<div class="modal fade" id="modal-default-{{ $h->Num_Hab }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('enviar_limpieza') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="exampleModalLabel">Encargar Limpieza de la <strong>Hab
                            {{ $h->Num_Hab }}</strong></h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <input type="hidden" name="Num_Hab" value="{{ $h->Num_Hab }}">
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Personal</label>
                        <select name="idPer" class="form-control" required>
                            @foreach ($personal as $p)
                                <option value="{{ $p->idPer }}">{{ $p->nomPer }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tipo</label><br>
                        <div class="text-center">
                            @foreach ($tipo_limpieza as $t)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="idLim"
                                        value="{{ $t->idLim }}" required>
                                    <label class="form-check-label" for="">{{ $t->nomLim }} /
                                        {{ $t->tieLim }} (min)</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Limpiar</button>
                </div>
            </div>
        </form>
    </div>
</div>
