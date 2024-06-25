{!! Form::open(array('url'=>'reserva/listar-registro', 'method'=>'GET', 'autocomplete'=>'off', 'role'=>'search')) !!}
<div class="row">
    <div class="col-lg-2 col-sm-6">
        <div class="form-group">
            <span for=""> HABITACIÓN</span>
            <select class="form-control selectpicker searchText" name="searchText" >
                <option value="" >Mostrar Todo</option>
                @foreach ($habitacion as $hab)
                @if ($searchText == $hab->Num_Hab)
                    <option value="{{$hab->Num_Hab}}" selected>Habitación: {{$hab->Num_Hab}}</option>
                @else
                    <option value="{{$hab->Num_Hab}}" >{{$hab->Num_Hab}} | {{$hab->Estado}}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-lg-2 col-sm-6">
        <div class="form-group">
        <span for="">ESTADO </span>
        <select class="form-control selectpicker searchText2" name="searchText2" >
        @if ($searchText2 == "HOSPEDAR")
            <option value="" >Mostrar Todo</option>
            <option value="HOSPEDAR" selected>HOSPEDADO</option>
            <option value="RESERVAR" >RESERVADA</option>
            <option value="H. CULMINADO" >H. CULMINADO</option>
        @elseif($searchText2 == "RESERVAR")
            <option value="" >Mostrar Todo</option>
            <option value="HOSPEDAR" >HOSPEDADO</option>
            <option value="RESERVAR" selected>RESERVADA</option>
            <option value="H. CULMINADO" >H. CULMINADO</option>
        @elseif($searchText2 == "H. CULMINADO")
            <option value="" >Mostrar Todo</option>
            <option value="HOSPEDAR" >HOSPEDADO</option>
            <option value="RESERVAR" >RESERVADA</option>
            <option value="H. CULMINADO" selected>H. CULMINADO</option>
        @else
            <option value="" >Mostrar Todo</option>
            <option value="HOSPEDAR" >HOSPEDADO</option>
            <option value="RESERVAR" >RESERVADA</option>
            <option value="H. CULMINADO" >H. CULMINADO</option>
        @endif
        </select>
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="form-group">
        <span for="">F. INICIO </span>
        <input type="date" class="form-control" name="searchText3" placeholder="Buscar.." value="{{$searchText3}}">
        </div>
    </div>
    <div class="col-lg-3 col-sm-6">
        <div class="form-group">
        <span for="">F. FIN</span>
        <input type="date" class="form-control" name="searchText4" value="{{$searchText4}}">
        </div>
    </div>
        @if ($searchText == '')
            @php($searchText = 'TODO')
        @endif
        @if ($searchText2 == '')
            @php($searchText2 = 'TODO')
        @endif
        @if ($searchText3 == '')
            @php($searchText3 = 'TODO')
        @endif
        @if ($searchText4 == '')
            @php($searchText4 = 'TODO')
        @endif
    <div class="col-lg-2 col-sm-6 col-md-6 col-xs-12" style="margin-top: 1.7em">
        <button type="submit" class="btn btn-primary" >Buscar</button>
        <a href="{{route('listado.pdf',[$searchText, $searchText2, $searchText3, $searchText4])}}" target="_black" title="Reporte en PDF"
            class="btn btn-default btn-sm"><i class="fas fa-file-pdf text-danger"></i></a>
    </div>
</div>
{{Form::close()}}
