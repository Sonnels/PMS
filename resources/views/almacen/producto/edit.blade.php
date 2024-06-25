@extends ('layout.admin')
@section ('Contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <span class="title_header">Editar datos de: {{$Producto->NombProducto}}</span>
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
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		@if (count($errors)>0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{$error}}</li>
				@endforeach
			</ul>
		</div>
		@endif
	</div>
</div>
{!!Form::model($Producto,['method'=>'PATCH','route'=>['producto.update',$Producto->IdProducto],'files'=>'true'])!!}
{{Form::token()}}
<div class="row" id="formulario">
		<div class="form-group">
			<input type="hidden" name="IdProducto" required
			value="{{$Producto->IdProducto}}" class="form-control">
        </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="form-group">
            <span>CATEGORÍA</span>
            <select name="IdCategoria" class="form-control selectpicker" data-live-search="true">
                @foreach($Categoria as $cat)
                @if($cat->IdCategoria==$Producto->IdCategoria)
                <option value="{{$cat->IdCategoria}}" selected>{{$cat->Denominacion}}</option>
                @else
                <option value="{{$cat->IdCategoria}}">{{$cat->Denominacion}}</option>
                @endif
                @endforeach
            </select>
        </div>
    </div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="form-group fg " id="grupo__NombProducto">
			<span for="NombProducto">NOMBRE</span>
			<p class="formulario__input-error">/ El nombre del Producto tiene que ser de 3 a 30 digitos y solo puede ser letras.</p>
			<div class="formulario__grupo-input">
				<input type="text" name="NombProducto" id="NombProducto" required
				value="{{$Producto->NombProducto}}" class="form-control"
				placeholder="Ingrese el Nombre del Producto">
				<i class="formulario__validacion-estado fa fa-times-circle"></i>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="form-group fg" id="grupo__Precio">
			<span for="Precio">PRECIO</span>
			<p class="formulario__input-error">/ El precio debe ser un valor númerico. Ejm 12.34</p>
			<div class="formulario__grupo-input">
				<input type="text" name="Precio" id="Precio" required
				value="{{$Producto->Precio}}" class="form-control"
				placeholder="Ingrese el Precio del Producto">
				<i class="formulario__validacion-estado fa fa-times-circle"></i>
			</div>
		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="form-group">
			<span for="Descripcion">DESCRIPCIÓN</span>
			<input type="text" name="Descripcion" value="{{$Producto->Descripcion}}" class="form-control">
		</div>
	</div>

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="form-group">
            <span for="">IMAGEN</span>
			<input type="file" name="Imagen" id="Imagen" accept="image/png, .jpeg, .jpg, image/gif"
            class="form-control"  onchange="mostrar()">

            <img src="{{asset('Imagenes/Productos/'.$Producto->Imagen)}}" id="img"/ width="100" height="100">
            <input  type="hidden" name="nombre_imagen" id="nombre_imagen">

		</div>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="form-group">
			<span for="stock">STOCK</span>
			<input type="number" name="stock"  value="{{$Producto->stock}}" class="form-control" placeholder="Ingrese el stock del Producto" required>
		</div>
	</div>
</div>
<div class="form-group">
	<button class="btn btn-primary" type="submit">Guardar</button>
	<a href="{{asset('almacen/producto')}}" class="btn btn-danger">Cancelar</a>
</div>
{!!Form::close()!!}
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

@endsection
