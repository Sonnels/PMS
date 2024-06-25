@extends('layout.admin')
@Section ('Contenido')
<div class="row" style="margin-top: -15px;">
    <div class="cabecera">
        <i  aria-hidden="true" style="padding-right: 1em"></i>
        Listado de Consumos
    </div>
</div>
<div class="row">
	<!-- <div class="col-lg-3 col-md-4 col-sm-8 col-xs-12">
        <a href="nivel/create">
		<button class="btn btn-success btn-block">Agregar nuevo Nivel</button></a>
	</div> -->
</div>
<br>
<div class="row">
	<div class="col-lg-8 col-md-10 col-sm-8 col-xs-12">
		@include('ventas.listar-consumo.search')
	</div>
</div>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead class="htable">
					<th>N° HABITACIÓN</th>
                    <th>CLIENTE</th>
                    <th>TOTAL</th>
                    <th colspan="2" >Opciones</th>
				</thead>
               @foreach ($Consumo as $con)
				<tr>
                    <td>Nro Hab {{$con->Num_Hab}}</td>

                    <td>{{$con->Nombre}} {{$con->Apellido}}</td>
                    <td>S/ {{$con->Total2}}</td>

                    <td>
                        <a href="{{URL::action('LConsumoController@show',$con->IdReserva)}}">
                            <button class="btn btn-warning"
                            >
                            Detalles
                            </button></a>
                        </a>
                    </td>
                    <td>
                        {{-- <form  action="{{ URL::action('LConsumoController@destroy', $con->IdReserva) }}" method="POST">
                            {!! csrf_field() !!}
                            {!! method_field('DELETE') !!}
                            <button  class="btn btn-danger  borrar"
                            title="Eliminar {{ $con->IdReserva }}"
                            data-nombre="{{ $con->IdReserva }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        </form> --}}
                    </td>
				</tr>
                @endforeach
			</table>
		</div>
		{{$Consumo->render()}}
	</div>
</div>
@endsection
