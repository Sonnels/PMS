{!! Form::open(['url' => 'reporte/limpieza', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="card-header">
    <div class="row">
        @php($searchText3 = $searchText3 == 'TODO'? '': $searchText3)
        <div class="col-md-4">
            <input type="date" name="searchText" class="form-control" value="{{$searchText}}">
        </div>
        <div class="col-md-4">
            <input type="date" class="form-control" name="searchText2" value="{{$searchText2}}">
        </div>
        <div class="col-md-3">
            <input type="text" name="searchText3" class="form-control" value="{{$searchText3}}">
        </div>
        <div class="col-md-1">
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
