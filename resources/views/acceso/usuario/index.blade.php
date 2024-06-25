@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Usuarios</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-log-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-group">
                <a href="usuario/create">
                    <button class="btn btn-success btn-block">
                        Nuevo Usuario </button></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-log-4 col-md-4 col-sm-8 col-xs-12">
            <div class="form-group">
                @include('acceso.usuario.search')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-condensed table-hover">
                    <thead class="bg-secondary">
                        <tr>
                            <td>N° DOCUMENTO</td>
                            <td>NOMBRES</td>
                            <td>CELULAR</td>
                            <td>CORREO</td>
                            <td>TIPO</td>
                            <td style="text-align: center">ESTADO</td>
                            <td colspan="2" align="center">OPCIONES</td>
                        </tr>
                    </thead>
                    @foreach ($usuario as $usu)
                        @php($habilitar_estado = $usu->IdUsuario == 1 ? '' : 'apertura')
                        <tr>
                            <td>{{ $usu->NumDocumento }}</td>
                            <td>{{ $usu->Nombre }} {{ $usu->Apellido }}</td>
                            <td>{{ $usu->Celular }}</td>
                            <td>{{ $usu->email }}</td>
                            <td>{{ $usu->tipo }}</td>
                            <td align="center">
                                @if ($usu->Estado == 'ACTIVO')
                                    <a class="btn-sm {{ $habilitar_estado }}" href="#"
                                        title="Cambiar estado a {{ $usu->Nombre }}" data-nombre="{{ $usu->IdUsuario }}">
                                        <span class="badge badge-success">{{ $usu->Estado }}</span>
                                    </a>
                                @else
                                    <a class="{{ $habilitar_estado }}" href="#"
                                        title="Cambiar estado a {{ $usu->Nombre }}" data-nombre="{{ $usu->IdUsuario }}">
                                        <span class="badge badge-danger">{{ $usu->Estado }}</span>
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a class="edi" title="Editar Usuario"
                                    href="{{ URL::action('UsuarioController@edit', $usu->IdUsuario) }}">
                                    <button class="btn btn-info btn-sm">
                                        <i class="fa fa-edit" aria-hidden="true"></i> </button></a>
                            </td>
                            <td>
                                @if ($usu->IdUsuario != 1)
                                    <form class="edi"
                                        action="{{ URL::action('UsuarioController@destroy', $usu->IdUsuario) }}"
                                        method="POST">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button class="btn btn-danger  btn-sm borrar" title="Eliminar {{ $usu->Nombre }}"
                                            data-nombre="{{ $usu->Nombre }}"><i class="fa fa-trash"
                                                aria-hidden="true"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $usuario->appends(['searchText' => $searchText])->links() }}
        </div>
    </div>

    @push('scripts')
        <script>
            $('.apertura').unbind().click(function() {
                var $button = $(this);
                var data_nombre = $button.attr('data-nombre');
                Swal.fire({
                    title: '¿Desea cambiar el estado del Usuario?',
                    showDenyButton: true,
                    confirmButtonText: `Cambiar`,
                    denyButtonText: `Cancelar`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        var d = '{{ URL::action('UsuarioController@show', 0) }}' + data_nombre
                        window.location.href = d;
                    } else if (result.isDenied) {
                        Swal.fire('No se realizó ningún cambio', '', 'info')
                    }
                })
                return false;
            });
        </script>
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
