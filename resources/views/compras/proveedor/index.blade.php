@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Proveedores</span>
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
            <a href="proveedor/create">
                <button class="btn btn-success btn-block">Nuevo
                </button></a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-12">
            @include('compras.proveedor.search')
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-striped table-condensed table-hover table-sm">
                    <thead class="bg-secondary">
                        <td>#</td>
                        <td>NOMBRE</td>
                        <td>N° TELÉFONO</td>
                        <td colspan="2">OPCIONES</td>
                    </thead>
                    @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                    @php($cont = ($page - 1) * $paginate + 1)
                    @foreach ($personas as $per)
                        <tr>
                            <td>{{ $cont++ }}</td>
                            <td>{{ $per->nomPro }}</td>
                            <td>{{ $per->phone }}</td>
                            <td>
                                <a href="{{ URL::action('ProveedorController@edit', $per->idpro) }}"> <button
                                        class="btn btn-info btn-sm"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                </a>

                            </td>
                            <td>
                                <form class="edi" action="{{ URL::action('ProveedorController@destroy', $per->idpro) }}"
                                    method="POST">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <button class="btn btn-danger  btn-sm borrar" title="Eliminar {{ $per->nomPro }}"
                                        data-nombre="{{ $per->nomPro }}"><i class="fa fa-trash"
                                            aria-hidden="true"></i></button>
                                </form>
                            </td>
                        </tr>
                        @include('compras.proveedor.modal')
                    @endforeach
                </table>
            </div>
            {{ $personas->appends(['searchText' => $searchText]) }}
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
