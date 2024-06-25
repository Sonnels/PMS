@extends('layout.admin')
@Section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Unidad Medida</span>
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
        <div class="col-lg-3 col-md-4 col-sm-8 col-xs-12">
            <a href="unidad_medida/create">
                <button class="btn btn-success btn-block">Nuevo</button></a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-12">
            @include('configuracion.unidad_medida.search')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-condensed table-hover">
                    <thead class="bg-secondary">
                        {{-- <th>Id</th> --}}
                        <td>NOMBRE</td>
                        <td>VALOR UNIDAD</td>
                        <td colspan="2">OPCIONES</td>

                    </thead>
                    @foreach ($unidad_medida as $u)
                        <tr>
                            {{-- <td>{{$cat->IdNivel}}</td> --}}
                            <td>{{ $u->nombreUM }}</td>
                            <td>{{ $u->valorUM }}</td>
                            <td>
                                <a href="{{ URL::action('UMedidaController@edit', $u->idUnidadMedida) }}">
                                    <button class="btn btn-info btn-sm" title="Editar {{ $u->nombreUM }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>
                            </td>
                            <td>
                                <form class="edi"
                                    action="{{ URL::action('UMedidaController@destroy', $u->idUnidadMedida) }}"
                                    method="POST">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <button class="btn btn-danger  btn-sm borrar" title="Eliminar {{ $u->nombreUM }}"
                                        data-nombre="{{ $u->nombreUM }}"><i class="fa fa-trash"
                                            aria-hidden="true"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $unidad_medida->render() }}
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
