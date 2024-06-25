@extends('layout.admin')
@section ('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Agregando nueva Habitación</span>
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
    {!! Form::open(['url' => 'mantenimiento/habitacion', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true'])
    !!}
    {{ Form::token() }}
    <div class="row" id="formulario">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="form-group fg" id="grupo__Num_Hab">
                <span for="Num_Hab">N° DE HABITACIÓN</span>
                <p class="formulario__input-error">El valor del campo debe ser un número >= 1</p>
                <div class="formulario__grupo-input">
                    <input type="text" name="Num_Hab" id="whatsapp"
                    value="{{ old('Num_Hab') }}" class="form-control"
                    placeholder="Ingrese un número de Habitación" required>
                    <i class="formulario__validacion-estado fa fa-times-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
            <div class="form-group">
                <span for="Descripcion">DETALLES</span>
                <input type="text" name="Descripcion" value="{{ old('Descripcion') }}" class="form-control"
                    placeholder="Escriba una breve descripción de las caracteristicas de la Habitación.">
            </div>
        </div>
        {{-- Oculto Estado --}}
            <input type="hidden" name="Estado" value="DISPONIBLE" class="form-control" placeholder="Estado...">


        {{-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <span for="Precio">Precio</span> --}}
                @php($val_precio = empty(old('Precio')) ? 0 : old('Precio'))
                <input type="hidden" name="Precio" value="{{ $val_precio }}">
                {{-- class="form-control" placeholder="Ingrese el Precio por noche de la Habitacion">
            </div>
        </div> --}}
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
            <div class="form-group">
                <span>TIPO HABITACIÓN</span>
                <select name="IdTipoHabitacion" class="form-control" required>
                    <option value="" selected hidden>Seleccionar</option>
                    @foreach ($TipoHabitacion as $cata)
                        <option value="{{ $cata->IdTipoHabitacion }}" {{$cata->IdTipoHabitacion == old('IdTipoHabitacion') ? 'selected' : ''}}><b>{{ $cata->Denominacion }} </b> 4Hrs: {{$cata->precioHora}} | PN: {{$cata->precioNoche}} | PM: {{$cata->precioMes}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="form-group">
                <span>NIVEL/PISO</span>
                <select name="IdNivel" class="form-control" required>
                    <option value="" selected hidden>Seleccionar</option>
                    @foreach ($Nivel as $cat)
                        <option value="{{ $cat->IdNivel }}" {{$cat->IdNivel == old('IdNivel') ? 'selected' : ''}}>{{ $cat->Denominacion }}</option>
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
