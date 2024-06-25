@extends ('layout.admin')
@section ('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Agregar nuevo Usuario</span>
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
            {!!Form::open(array('url'=>'acceso/usuario', 'method'=>'POST', 'autocomplete'=>'off', 'files'=>'true'))!!}
            {{Form::token()}}
    <div class="row" id="formulario">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="NumDocumento">N° DOCUMENTO</label>
                <input type="text" name="NumDocumento"
                required value="{{old('NumDocumento')}}" class="form-control"
                placeholder="Ingrese el Nro de Documento de Identidad">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="Nombre">NOMBRES </label>
                <input type="text" name="Nombre" required
                class="form-control" value="{{old('Nombre')}}"
                 placeholder="Ingrese los Nombres del Usuario">
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="Celular">CELULAR</label>
                <input type="text" name="Celular"
                class="form-control" value="{{old('Celular')}}"
                placeholder="Ingrese el Nro de Celular (OPCIONAL).">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="email">CORREO ELECTRÓNICO</label>
                <input type="email" name="email" class="form-control" required
                value="{{old('email')}}" placeholder="Ingrese el correo electrónico del Usuario.">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group fg" id="grupo__password">
                <label for="password">CONTRASEÑA</label>
                    <input type="password" name="password" id="password"
                    class="form-control" required placeholder="Ingrese la Clave de Acceso."
                    value="{{old('password')}}">

            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group" >
                <label for="password2">REPETIR CONTRASEÑA</label>

                    <input type="password" name="password_confirmation" id="password2"
                    class="form-control" required placeholder="Vuelva a ingresar la Clave de Acceso."
                    value="{{old('password')}}">

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group fg" >
                <label for="password2">TIPO DE USUARIO</label>
                <div class="formulario__grupo-input">
                    <select name="tipo" id="" class="form-control">
                        @foreach ($tipo as $item)
                            <option value="{{$item}}" {{old('tipo')==$item ? 'selected' : ''}} >{{$item}}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a href="{{asset('acceso/usuario')}}" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
    </div>

    {!!Form::close()!!}

@endsection
