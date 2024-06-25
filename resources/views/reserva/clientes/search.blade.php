{!! Form::open(['url' => 'reserva/clientes', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="form-group">
    <div class="input-group">
        <input type="text" class="form-control" name="searchText"
    placeholder="Puede buscar por {Nombres del Cliente}, {Nro Documento} o {Dirección}" value="{{ $searchText }}">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </span>
    </div>
</div>

{{ Form::close() }}
