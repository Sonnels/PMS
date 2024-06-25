{!! Form::open(['url' => 'ventas/otros', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<div class="card-header">
    <h3 class="card-title" >
        <a class="btn btn-success btn-sm" href="otros/create" >
            Nueva Venta <i class="fas fa-plus-circle" style="color: #cef5e1; margin-left: 10px"></i>
        </a>
    </h3>
    <div class="card-tools">
        <div class="input-group input-group-sm" >
            @php($searchText=$searchText=='TODO'?'':$searchText)
            <input type="text" name="searchText" class="form-control float-right" value="{{$searchText}}">
            {{-- <input type="date" name="searchText2" class="form-control float-right" value="{{$searchText2}}"> --}}
            <div class="input-group-append">
                <button type="submit" class="btn btn-default">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
