{!! Form::open(array('url'=>'reporte/mensual','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="row">
    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
        <select name="searchText2" id="" class="form-control">
            @if($searchText2 == '')
                @php($searchText2 = date('Y'))
            @endif
            @foreach ($anios_vista as $item)
                @if ($searchText2 == $item)
                    <option value="{{$item}}" selected>{{$item}}</option>
                @else
                    <option value="{{$item}}" >{{$item}}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" >
        <div class="form-group">
                <select name="searchText" id="" class="form-control">
                    @if($searchText == '')
                        @php($searchText = date('m'))
                    @endif
                    @php($cont = 1)
                    @foreach ($meses as $item)
                        @if ($searchText == $cont)
                            <option value="{{$cont}}" selected>{{$item}}</option>
                        @else
                            <option value="{{$cont}}" >{{$item}}</option>
                        @endif

                        @php($cont += 1)
                    @endforeach
                </select>
        </div>
    </div>
    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" >
        <div class="form-group">
            <div class="input-group">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </span>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12" >
        <div class="form-group" >
            <span class="input-group-btn" >
                <a href="{{route('ingreso_mensual.excel', [$searchText, $searchText2])}}" class="btn btn-default text-green" style="float: right">
                    <i class="fas fa-file-excel"></i>
                </a>
            </span>
        </div>
    </div>
</div>

{{Form::close()}}
