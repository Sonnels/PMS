@extends('layout.admin')
@Section ('Contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <span class="title_header">Alquileres Eliminados</span>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Simple Tables</li> --}}
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

{{-- <div class="row">
	<div class="col-lg-8 col-md-10 col-sm-8 col-xs-12">
		@include('respaldo.r_alquiler.search')
	</div>
</div> --}}
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-condensed table-hover">
				<thead class="bg-secondary">
                    <tr>
                        <td>Id</td>
                        <td>Id Reserva</td>
                        <td>Fecha Entrada</td>
                        <td>Fecha Salida</td>
                        <td>Costo Alojamiento</td>
                        <td>Hab.</td>
                        <td>Cliente</td>
                        <td>Usuario</td>
                        {{-- <td>Motivo</td> --}}
                        <td>F. Eliminación</td>
                        <td></td>
                    </tr>
				</thead>
               @foreach ($res_alquiler as $r)
                <tbody>
                    <tr>
                        <td>{{ $r->idResAlq }}</td>
                        <td>{{ $r->IdReserva }}</td>
                        <td>{{ date('d/m/Y', strtotime($r->fechEntrada)) }} {{ $r->horaEntrada }}</td>
                        <td>{{ date('d/m/Y', strtotime($r->fechSalida)) }} {{ $r->horaSalida }}</td>
                        <td>{{ $r->costoAlojamiento }}</td>
                        <td>{{ $r->numHab }}</td>
                        <td>{{ $r->nomCliente }}</td>
                        <td>{{ $r->nomUsuario }}</td>
                        {{-- <td>{{ $r->motElim }}</td> --}}
                        <td>{{ date('d/m/Y', strtotime($r->fechElim)) }} {{ $r->horaElim }}</td>
                        <td>
                            <form class="edi" action="{{ URL::action('RespAlquilerController@destroy', $r->idResAlq) }}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                                <button  class="btn btn-default  btn-sm borrar"
                                 title="Eliminar Registro n° {{ $r->idResAlq }}"
                                data-nombre="Registro n° {{ $r->idResAlq }}"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                            </form>
                        </td>
                    </tr>
                </tbody>
                @endforeach
			</table>
		</div>
		{{-- {{$res_alquiler->append()}} --}}
	</div>
</div>
@push('scripts')
    @if (Session::has('success'))
    <script>
        toastr.success('{{ Session::get('success') }}', 'Operación Correcta',  { "positionClass" : "toast-top-right"})
    </script>
    @endif
@endpush
@endsection
