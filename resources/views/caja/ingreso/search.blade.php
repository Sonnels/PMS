{!! Form::open(['url' => 'caja/ingreso', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="card-header">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-2">
            @if (isset($caja))
                @if ($caja->codUsuario == auth()->user()->IdUsuario)
                    <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
                        Nuevo Ingreso Extra
                    </a>
                @else
                    <p>Otro usuario aperturó la caja.</p>
                @endif
            @else
                <p>La caja no está aperturada.</p>
            @endif
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <label for="">Busqueda</label>
            <input type="text" name="searchText" class="form-control" value="{{$searchText}}">
        </div>
        <div class="col-12 col-sm-6 col-md-1">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary" style="margin: 30px auto auto auto">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>

</div>
{{ Form::close() }}
