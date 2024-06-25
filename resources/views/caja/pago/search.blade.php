{!! Form::open([
    'url' => 'caja/pago',
    'method' => 'GET',
    'autocomplete' => 'off',
    'role' => 'search',
]) !!}
<div class="col-md-6 col-12">
    <div class="card-tools">
        <div class="input-group input-group-sm">
            <input type="text" name="searchText" class="form-control" value="{{ $searchText }}" placeholder="Buscar ...">
            {{-- <input type="date" name="searchText2" class="form-control float-right" value="{{$searchText2}}"> --}}
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
