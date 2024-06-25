{!! Form::open(['url' => 'reporte/rango', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="card-header">
    <h3 class="card-title" >
        {{-- <a class="btn btn-success btn-sm" href="" data-target="#modal-add" data-toggle="modal">
            Nuevo  <i class="fas fa-user-plus" style="color: #cef5e1; margin-left: 10px" ></i>
        </a> --}}
    </h3>
    <div class="card-tools">
        <div class="input-group input-group-sm" >

            @php($searchText3 = $searchText3 == 'TODO'? '': $searchText3)
            <input type="date" name="searchText" class="form-control float-right" value="{{$searchText}}">
            <input type="date" class="form-control" name="searchText2" value="{{$searchText2}}">
            <input type="text" name="searchText3" class="form-control" value="{{$searchText3}}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
