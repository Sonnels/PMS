@extends ('layout.admin')
@Section ('Contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <span class="title_header">Editar datos de la Habitación Nro {{ $Habitacion->Num_Hab }}</span>
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
                <div class="alert bg-danger text-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {!! Form::model($Habitacion, ['method' => 'PATCH', 'route' => ['habitacion.update', $Habitacion->Num_Hab], 'files' =>
    'true']) !!}
    {{ Form::token() }}
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <input type="hidden" name="Num_Hab_a" value="{{ $Habitacion->Num_Hab }}">
            <div class="form-group">
                <span for="Num_Hab">N° DE HABITACIÓN</span>
                <input type="text" name="Num_Hab" required value="{{ $Habitacion->Num_Hab }}" class="form-control" readonly>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
            <div class="form-group">
                <span for="Descripcion">DETALLES</span>
                <input type="text" name="Descripcion"  value="{{ $Habitacion->Descripcion }}"
                placeholder="Escriba una breve descripción de las caracteristicas de la Habitación." class="form-control">
            </div>
        </div>
            <input type="hidden" name="Estado" required value="{{ $Habitacion->Estado }}" class="form-control">
            <input type="hidden" name="Precio" required value="{{ $Habitacion->Precio }}" class="form-control">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
            <div class="form-group">
                <span>TIPO HABITACIÓN</span>
                <select name="IdTipoHabitacion" class="form-control">
                    @foreach ($TipoHabitacion as $cata)
                        @if ($cata->IdTipoHabitacion == $Habitacion->IdTipoHabitacion)
                            <option value="{{ $cata->IdTipoHabitacion }}" selected>{{ $cata->Denominacion }} 4hrs: {{$cata->precioHora}} | PN: {{$cata->precioNoche}} | PM: {{$cata->precioMes}}</option>
                        @else
                            <option value="{{ $cata->IdTipoHabitacion }}">{{ $cata->Denominacion }} 4hrs: {{$cata->precioHora}} | PN: {{$cata->precioNoche}} | PM: {{$cata->precioMes}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <span>NIVEL/PISO</span>
                <select name="IdNivel" class="form-control">
                    @foreach ($Nivel as $cat)
                        @if ($cat->IdNivel == $Habitacion->Num_Hab)
                            <option value="{{ $cat->IdNivel }}" selected>{{ $cat->Denominacion }}</option>
                        @else
                            <option value="{{ $cat->IdNivel }}">{{ $cat->Denominacion }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="form-group text-center">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a href="{{asset('mantenimiento/habitacion')}}" class="btn btn-danger">Cancelar</a>
    </div>
    {!! Form::close() !!}
@endsection
