@extends('layout.admin')
@Section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Habitaciones</span>
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
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <a href="habitacion/create"><button class="btn btn-success">
                    Agregar nueva Habitación
                </button></a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            @include('mantenimiento.habitacion.search')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped  table-condensed table-hover">
                    <thead class="bg-secondary">
                        <td>N° HAB.</td>
                        <td>DESCRIPCIÓN</td>
                        <td>TIPO</td>
                        <td>NIVEL/PISO</td>
                        <td>ESTADO</td>
                        <td colspan="4" align="center">OPCIONES</td>
                    </thead>
                    @foreach ($Habitacion as $pro)
                        <tr>
                            <td>{{ $pro->Num_Hab }}</td>
                            <td>{{ $pro->Descripcion }}</td>
                            <td>{{ $pro->TipoHabitacion }} <br>
                                4hrs: {{ $datos_hotel->simboloMoneda }} {{ $pro->precioHora }} | PN:
                                {{ $datos_hotel->simboloMoneda }} {{ $pro->precioNoche }} | PM:
                                {{ $datos_hotel->simboloMoneda }}
                                {{ $pro->precioMes }}</td>
                            <td>{{ $pro->Nivel }} </td>
                            <td>
                                @if ($pro->Estado == 'DISPONIBLE')
                                    <span class="badge badge-success">{{ $pro->Estado }}</span>
                                @elseif($pro->Estado == 'RESERVADO')
                                    <span class="badge badge-info">{{ $pro->Estado }}</span>
                                @elseif($pro->Estado == 'MANTENIMIENTO')
                                    <span class="badge badge-default bg-purple">{{ $pro->Estado }}</span>
                                @elseif($pro->Estado == 'LIMPIEZA')
                                    <span class="badge badge-primary">{{ $pro->Estado }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $pro->Estado }}</span>
                                @endif

                            </td>
                            <td>
                                @if ($pro->Estado == 'DISPONIBLE')
                                    <button data-target="#modal-conf-{{ $pro->Num_Hab }}" data-toggle="modal"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                @elseif ($pro->Estado == 'MANTENIMIENTO')
                                    <button data-target="#modal-hablHab-{{ $pro->Num_Hab }}" data-toggle="modal"
                                        class="btn btn-warning btn-sm">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                @endif
                            </td>
                            <td>
                                <button data-target="#modal-show-{{ $pro->Num_Hab }}" data-toggle="modal"
                                    class="btn btn-default btn-sm">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                            <td>
                                <a href="{{ URL::action('HabitacionController@edit', $pro->Num_Hab) }}">
                                    <button class="btn btn-info btn-sm" title="Editar Habitación Nro {{ $pro->Num_Hab }}">
                                        <i class="fas fa-edit"></i>
                                    </button></a>
                            </td>
                            <td>
                                <form class="edi"
                                    action="{{ URL::action('HabitacionController@destroy', $pro->Num_Hab) }}"
                                    method="POST">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <button class="btn btn-danger btn-sm  borrar"
                                        title="Eliminar {{ $pro->TipoHabitacion }}"
                                        data-nombre="{{ $pro->TipoHabitacion }}"><i class="fa fa-trash"
                                            aria-hidden="true"></i></button>
                                </form>
                            </td>
                        </tr>
                        @include('mantenimiento.habitacion.confHab')
                        @include('mantenimiento.habitacion.hablHab')
                        @include('mantenimiento.habitacion.show')
                    @endforeach
                </table>
            </div>
            {{ $Habitacion->render() }}
        </div>
    </div>

    @push('scripts')
        @if (Session::has('success'))
            <script>
                Snackbar.show({
                    text: '{{ session('success') }}',
                    actionText: 'CERRAR',
                    pos: 'bottom-right',
                    actionTextColor: '#27AE60',
                    duration: 6000
                });
            </script>
        @endif
        @if (Session::has('error'))
            <script>
                Snackbar.show({
                    text: '{{ session('error') }}',
                    actionText: 'CERRAR',
                    pos: 'bottom-right',
                    actionTextColor: '#FF5050',
                    duration: 6000
                });
            </script>
        @endif
    @endpush
@endsection
