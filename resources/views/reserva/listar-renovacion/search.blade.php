{!! Form::open(['url' => 'reserva/listar-renovacion', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
    <div class="row">
        <div class="col-md-3 col-12">
            <input type="date" name="searchText" class="form-control form-control-sm" value="{{$searchText}}" placeholder="Buscar ...">
        </div>
        <div class="col-md-3 col-12">
            <input type="date" name="searchText2" class="form-control form-control-sm" value="{{$searchText2}}" placeholder="Buscar ...">
        </div>
        <div class="col-md-3 col-12">
            <input type="text" name="searchText3" class="form-control form-control-sm" value="{{$searchText3}}" placeholder="Buscar ...">
        </div>
        <div class="col-md-3 col-12">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
{{ Form::close() }}
