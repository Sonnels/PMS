@extends('layout.admin')
@Section ('Contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <span class="title_header">Ajustes</span>
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
<div class="row">
	<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive" style="background: white">
			<table class="table  ">
                <tr>
                    <td colspan="2" style="color: #b41717">
                        *Esta información es importante para la emisión de reportes y representación de valores.
                    </td>
                </tr>
				<tr>
					<td><b>Nombre:</b></td>
                    <td>{{$Datos->nombre}}</td>
				</tr>
                <tr>
					<td><b>Dirección:</b></td>
                    <td>{{$Datos->direccion}}</td>
				</tr>
                <tr>
					<td><b>Teléfono:</b></td>
                    <td>{{$Datos->telefono}}</td>
				</tr>
                <tr>
					<td><b>RUC:</b></td>
                    <td>{{$Datos->ruc}}</td>
				</tr>
                <tr>
					<td><b>Símbolo Monetario:</b></td>
                    <td>{{$Datos->simboloMoneda}}</td>
				</tr>
                <tr>
                    <td><b>Logo</b></td>
                    <td> <img src="{{asset('logo/'.$Datos->logo)}}" alt="" width="150" height="150"></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <a href="" data-target="#modal-add" style="width: 20em"
                             data-toggle="modal" class="btn btn-primary">
                            Editar</a>
                    </td>
                </tr>

			</table>
		</div>

	</div>
</div>
@include('configuracion.datos_hotel.modal')
<script>
    // const nombre_imagen = document.getElementById('Imagen').files[0].name;

    function mostrar(){
    var archivo = document.getElementById("Imagen").files[0];
    var reader = new FileReader();
    if (archivo) {
        reader.readAsDataURL(archivo );
        reader.onloadend = function () {
        document.getElementById("img").src = reader.result;
        document.getElementById("nombre_imagen").value = archivo.name;
        }
    }else{
        document.getElementById("img").src = "";
        document.getElementById("nombre_imagen").value = "";
    }
}
</script>
@push('scripts')
@if (Session::has('success'))
<script>
    Snackbar.show({text: '{{session('success')}}', actionText: 'CERRAR', pos: 'bottom-right', actionTextColor: '#27AE60', duration: 6000});
</script>
@endif


@if (count($errors) > 0)
    <script type="text/javascript">
        $(document).ready(function(){
        <?php if (old('IdHotel') == '') {?>
            $('#modal-add').modal('show');
            $("#modal-add").on('hidden.bs.modal', function () {
                location.reload();
            });
        <?php } else { ?>
            $('#modal-add-<?php echo old("IdHotel") ?>').modal('show');
            $("#modal-add-<?php echo old("IdHotel") ?>").on('hidden.bs.modal', function () {
                location.reload();
            });
        <?php }?>
        });
    </script>

@endif
@endpush
@endsection
