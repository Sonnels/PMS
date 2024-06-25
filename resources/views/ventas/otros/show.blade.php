@extends ('layout.admin')
@section('Contenido')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-8">
                <span class="title_header">Detalle de Venta # {{$venta->codVenta}}  de <span style="color: #353b41">{{ $venta->Nombre }}</span></span>

            </div>
            <div class="col-sm-4">
                <ol class="breadcrumb float-sm-right">
                    {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Simple Tables</li> --}}
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
    {{-- <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
                <label for="cliente">Cliente</label>
                <p>{{ $venta->nombres }}</p>

            </div>


        </div>
    </div> --}}

    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead class="bg-teal" >
                            <th>Artículos</th>
                            <th>Cantidad</th>
                            <th>Precio Venta</th>
                            <th>Descuento</th>
                            <th>Subtotal</th>
                        </thead>
                        <tfoot>

                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>
                                <h4 id="total">{{ number_format($venta->totalVenta, 2) }}</h4>
                            </th>

                        </tfoot>
                        <tbody>
                            @foreach ($detalle_venta as $det)
                                <tr>
                                    <td>{{ $det->NombProducto }}</td>
                                    <td>{{ $det->cantidad }}</td>
                                    <td>{{ $det->precioVenta }}</td>
                                    <td>{{ $det->descuento }}</td>
                                    <td align="right">{{ number_format($det->cantidad * $det->precioVenta - $det->descuento, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <a href="{{ url()->previous() }}" class="btn btn-danger">VOLVER ATRAS</a>
        </div>
    </div>
@endsection
