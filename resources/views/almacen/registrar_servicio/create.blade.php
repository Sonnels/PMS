@extends('layout.admin')
@Section ('Contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <span class="title_header">Nuevo Servicio</span>
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
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {!! Form::open(['url' => 'almacen/registrar_servicio', 'method' => 'POST', 'autocomplete' => 'off']) !!}
            {{ Form::token() }}
            <div class="form-group">
                <label for="NombProducto">Nombre</label>
                <input type="text" name="NombProducto" class="form-control" placeholder="Ingresar el nombre" value="{{ old('NombProducto')}}">
            </div>
            <div class="form-group">
                <label for="Precio">Precio</label>
                <input type="text" name="Precio" class="form-control precioS" placeholder="Ingresar el precio" value="{{ old('Precio')}}">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a href="{{asset('almacen/registrar_servicio')}}" class="btn btn-danger">Cancelar</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
    @push('scripts')
    <script>
        $('.precioS').on('input', function () {
            this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
        });
    </script>
    @endpush
@endsection
