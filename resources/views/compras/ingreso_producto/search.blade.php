{!! Form::open(['url' => 'compras/ingreso_producto', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <div class="input-group">
                <input type="date" class="form-control" name="searchText" value="{{ $searchText }}">
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <div class="input-group">
                <input type="date" class="form-control" name="searchText2" value="{{ $searchText2 }}">

            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </span>
        </div>
    </div>
</div>
{{ Form::close() }}
