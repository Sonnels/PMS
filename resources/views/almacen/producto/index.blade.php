@extends('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Productos</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('producto_pdf.pdf', $searchText == '' ? 'TODO' : $searchText) }}" target="_blank">
                            <i class="fas fa-file-pdf text-danger"></i>
                        </a>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-8 col-xs-12">
            <a href="producto/create">
                <button class="btn btn-success btn-block">Nuevo Producto</button></a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-8 col-md-10 col-sm-8 col-xs-12">
            @include('almacen.producto.search')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-sm table-striped  table-condensed table-hover">
                    <thead class="bg-secondary">
                        <td>CÓDIGO</td>
                        <td>PRODUCTO</td>
                        <td>CATEGORÍA</td>
                        <td>IMAGEN</td>
                        <td>STOCK</td>
                        <td>DESCRIPCIÓN</td>
                        <td>PRECIO</td>

                        <td align="center" colspan="2">OPCIONES</td>
                    </thead>
                    @foreach ($Producto as $pro)
                        <tr>
                            <td>{{ $pro->IdProducto }}</td>
                            <td>{{ $pro->NombProducto }}</td>
                            <td>{{ $pro->Denominacionc }}</td>
                            <td><img src="{{ asset('Imagenes/Productos/' . $pro->Imagen) }}" alt="{{ $pro->NombProducto }}"
                                    heigth="50px" width="50px" class="img-thumbnail"></td>
                            <td align="center">{{ $pro->stock }}</td>
                            <td>{{ $pro->Descripcion }}</td>
                            <td align="right">{{ $datos_hotel->simboloMoneda }} {{ $pro->Precio }}</td>
                            <td>
                                <a href="{{ URL::action('ProductoController@edit', $pro->IdProducto) }}">
                                    <button class="btn btn-info btn-sm" title="Editar {{ $pro->NombProducto }}">
                                        <i class="fas fa-edit"></i>
                                    </button></a>
                            </td>
                            <td>
                                <form action="{{ URL::action('ProductoController@destroy', $pro->IdProducto) }}"
                                    method="POST">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <button class="btn btn-danger btn-sm  borrar" title="Eliminar {{ $pro->NombProducto }}"
                                        data-nombre="{{ $pro->NombProducto }}"><i class="fa fa-trash"
                                            aria-hidden="true"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $Producto->render() }}
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
