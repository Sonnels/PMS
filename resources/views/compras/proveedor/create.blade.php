@extends('layout.admin')
@Section ('Contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <span class="title_header">Nuevo Proveedor </span>
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
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			@if (count($errors)>0)
			<div class="alert alert-danger" role="alert">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
			{!!Form::open(array('url'=>'compras/proveedor','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
            <div class="form-group">
            	<label for="nomPro">Nombre</label>
            	<input type="text" name="nomPro" class="form-control" value= "{{old('nomPro')}}" required>
            </div>
            <div class="form-group">
            	<label for="phone">N° Teléfono</label>
            	<input type="text" name="phone" class="form-control" value= "{{old('phone')}}">
            </div>
            <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<!-- <button class="btn btn-danger" type="reset">Cancelar</button> -->
				<a href="{{asset('compras/proveedor')}}" class="btn btn-danger">Cancelar</a>
            </div>

			{!!Form::close()!!}

		</div>
	</div>
@endsection
