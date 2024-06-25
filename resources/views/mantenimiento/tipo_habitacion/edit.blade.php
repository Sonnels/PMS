@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Editar datos del tipo de habitación</span>
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
        @if (count($errors) > 0)
            <div class="col-lg-12 col-12">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
    {!! Form::model($TipoHabitacion, ['method' => 'PATCH', 'route' => ['tipo_habitacion.update', $TipoHabitacion->IdTipoHabitacion]]) !!}
    {{ Form::token() }}
    <div class="row">
        <div class="col-lg-4 col-12">
            <input type="hidden" name="IdTipoHabitacion" value="{{$TipoHabitacion->IdTipoHabitacion}}">
            <div class="form-group">
                <label for="Denominacion">Denominación</label>
                <input type="text" name="Denominacion" class="form-control" value="{{ $TipoHabitacion->Denominacion }}"
                    placeholder="Ingrese el nombre del Tipo de Habitación." required>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="form-group">
                <label for="precioHora">Precio Hora (3Hrs)</label>
                <input type="text" name="precioHora" class="form-control"
                placeholder="Ingrese el precio por Hora (4hrs)" value="{{$TipoHabitacion->precioHora}}" required>
            </div>
        </div>
        {{-- <div class="col-lg-4 col-12">
            <div class="form-group">
                <label for="precioHora">Precio Hora (6hrs)</label>
                <input type="text" name="precioHora6" class="form-control numero"
                placeholder="Ingrese el precio por Hora (6hrs)" value="{{$TipoHabitacion->precioHora6}}" required>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="form-group">
                <label for="precioHora">Precio Hora (8hrs)</label>
                <input type="text" name="precioHora8" class="form-control numero"
                placeholder="Ingrese el precio por Hora (8hrs)" value="{{$TipoHabitacion->precioHora8}}" required>
            </div>
        </div> --}}
        <div class="col-lg-4 col-12">
            <div class="form-group">
                <label for="precioNoche">Precio Noche</label>
                <input type="text" name="precioNoche" class="form-control"
                placeholder="Ingrese el precio por Noche" value="{{$TipoHabitacion->precioNoche}}" required>
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class="form-group">
                <label for="precioMes">Precio Mes</label>
                <input type="text" name="precioMes" class="form-control"
                placeholder="Ingrese el precio por Mes" value="{{$TipoHabitacion->precioMes}}" required>
            </div>
        </div>
        <div class="col-lg-8 col-12">

            <div class="form-group">
                <label for="Descripcion">Descripción</label>
                <input type="text" name="Descripcion" class="form-control" value="{{ $TipoHabitacion->Descripcion }}"
                    placeholder="Puede describir brevemente las caracteristicas de este tipo de habitación.">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a href="{{asset('mantenimiento/tipo_habitacion')}}" class="btn btn-danger">Cancelar</a>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection
