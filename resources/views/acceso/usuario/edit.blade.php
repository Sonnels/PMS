@extends ('layout.admin')
@section ('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Editar datos del Usuario</span>
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
    {!!Form::model($usuario,['method'=>'PATCH', 'route'=>['usuario.update', $usuario->IdUsuario]])!!}
    {{Form::token()}}
    <div class="row" id="formulario">
        <input type="hidden" value="{{$usuario->IdUsuario}}" name="IdUsuario">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="NumDocumento">N° DOCUMENTO</label>
                <input type="text" name="NumDocumento"
                required value="{{$usuario->NumDocumento}}" class="form-control"
                placeholder="Ingrese el N° de Documento de Identidad">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="Nombre">NOMBRES </label>
                <input type="text" name="Nombre" required class="form-control" value="{{$usuario->Nombre}}" placeholder="Ingrese los Nombres del Usuario">
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="Celular">CELULAR</label>
                <input type="text" name="Celular"
                class="form-control" value="{{$usuario->Celular}}"
                placeholder="Ingrese el Nro de Celular (Opcional)">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="email">CORREO ELECTRÓNICO</label>
                <input type="email" name="email" class="form-control"
                value="{{$usuario->email}}" placeholder="Ingrese el correo electrónico del Usuario.">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group " id="grupo__password">
                <label for="password">CONTRASEÑA</label>
                <input type="password" name="password" id="password"
                class="form-control" placeholder="Ingrese la Clave de Acceso.">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group" >
                <label for="password2">REPETIR CONTRASEÑA</label>
                <input type="password" name="password_confirmation" id="password2"
                class="form-control" placeholder="Vuelva a ingresar la Clave de Acceso.">
            </div>
        </div>
        @if ($usuario->IdUsuario != 1)
            <div class="col-md-6">
                <div class="form-group" >
                    <label for="">TIPO DE USUARIO</label>
                    <div class="formulario__grupo-input">
                        <select name="tipo" id="" class="form-control">
                            @foreach ($tipo as $item)
                                <option value="{{$item}}" {{$usuario->tipo==$item ? 'selected' : ''}} >{{$item}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        @else
            <input type="hidden" name="tipo" value="ADMINISTRADOR">
        @endif
    </div>
    <div class="row">
        <div class="col-lg-3 col-sm-4 col-md-6 col-xs-12">
            <div class="form-group">
                <a href="{{asset('acceso/usuario')}}" class="btn btn-danger btn-block">Cancelar</a>
            </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-md-6 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary btn-block"
                type="submit" id="btnguardar">Modificar Datos</button>
            </div>
        </div>
    </div>

    {!!Form::close()!!}

{{-- Código para validar que las contraseñas sean iguales --}}
{{-- <script>

const inputs2 = document.querySelectorAll('#password');
const inputs3 = document.querySelectorAll('#password2');
inputs2.forEach((input) => {
        input.addEventListener('keyup', validarClave);
    })
inputs3.forEach((input) => {
        input.addEventListener('keyup', validarClave);
    })
function validarClave (){
    caja = document.getElementById("password").value;
    caja2 = document.getElementById("password2").value;
    if ((caja.length > 0 && caja.length <= 3) || caja !== caja2){
        document.getElementById('btnguardar').style.display = 'none';

    }else{
        document.getElementById('btnguardar').style.display = 'block';
    }
}
</script> --}}
@endsection
