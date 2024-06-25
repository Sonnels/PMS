{!! Form::open(array('url'=>'reporte/ingresos','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="row">

    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
        <span>FECHA</span>
        <div class="form-group">
            <input type="date" value="{{$searchText}}" name="searchText" class="form-control">
        </div>
    </div>
    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
        @php($tipo = ['VENTA', 'SERVICIO', 'CONSUMO', 'ALQUILER'])
        <span>TIPO</span>
        <select name="searchText2" id="" class="form-control">
            <option value="">TODO</option>
                @foreach ($tipo as $t)
                    <option value="{{$t}}" {{$searchText2 == $t ? 'selected' : ''}}>{{$t}}</option>
                @endforeach
        </select>
    </div>
    <div class="col-md-2" >
        @php($metPago = ['EFECTIVO', 'TARJETA', 'B. DIGITAL'])
        <span>MÉTODO PAGO</span>
        <div class="form-group">
            <select name="metodoPago" class="form-control">
                <option value="">TODO</option>
                @foreach ($metPago as $m)
                    <option value="{{$m}}" {{$metodoPago == $m ? 'selected' : ''}}>{{$m}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
        <div class="form-group">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-primary" style="margin-top: 1.4em">Buscar</button>
            </span>
        </div>
    </div>

    <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
        <p>
            <a class="btn btn-default text-success" style="float: right"
            href="{{ route('ingreso_diario.excel', [$searchText, empty($searchText2) ? 'TODO' : $searchText2, empty($metodoPago) ? 'TODO' : $metodoPago])}}">
                <i class="fas fa-file-excel"></i>
            </a>
        </p>
    </div>
</div>
{{Form::close()}}
