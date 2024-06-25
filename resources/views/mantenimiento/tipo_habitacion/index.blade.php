@extends('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Tipo de Habitación</span>
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
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
            <a href="tipo_habitacion/create">
                <button class="btn btn-success btn-block">
                    Nuevo
                </button></a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            @include('mantenimiento.tipo_habitacion.search')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-condensed table-hover">
                    <thead class="bg-secondary">
                        {{-- <th>Id</th> --}}
                        <td>NOMBRE </td>
                        <td>DESCRIPCIÓN</td>
                        <td style="text-align: right">P. HORA (3Hrs)</td>
                        {{-- <td style="text-align: right">P. HORA (6Hrs)</td>
                        <td style="text-align: right">P. HORA (8Hrs)</td> --}}
                        <td style="text-align: right">P. NOCHE</td>
                        <td style="text-align: right">P. MES</td>
                        <td colspan="2" align="center">OPCIONES</td>
                    </thead>
                    @foreach ($TipoHabitacion as $cat)
                        <tr>
                            {{-- <td>{{ $cat->IdTipoHabitacion }}</td>
                            --}}
                            <td>{{ $cat->Denominacion }}</td>
                            <td>{{ $cat->Descripcion }}</td>
                            <td align="right">{{ $cat->precioHora }}</td>
                            {{-- <td align="right">{{ $cat->precioHora6 }}</td>
                            <td align="right">{{ $cat->precioHora8 }}</td> --}}
                            <td align="right">{{ $cat->precioNoche }}</td>
                            <td align="right">{{ $cat->precioMes }}</td>
                            <td>
                                <a href="{{ URL::action('TipoHabitacionController@edit', $cat->IdTipoHabitacion) }}">
                                    <button class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </button></a>
                            </td>
                            <td>
                                <form action="{{ URL::action('TipoHabitacionController@destroy', $cat->IdTipoHabitacion) }}"
                                    method="POST">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <button class="btn btn-danger  btn-sm borrar" title="Eliminar {{ $cat->Denominacion }}"
                                        data-nombre="{{ $cat->Denominacion }}"><i class="fa fa-trash"
                                            aria-hidden="true"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $TipoHabitacion->render() }}
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
    @endpush
@endsection
