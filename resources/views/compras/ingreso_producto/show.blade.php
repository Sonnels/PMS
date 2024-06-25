@extends ('layout.admin')
@section ('Contenido')

<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="form-group">
            <label for="proveedor">Proveedor</label>
            <p>{{$ingreso->nomPro}}</p>

        </div>
    </div>

</div>
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">

            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                    <thead style="background-color: #ffe9e9;">

                        <th>Artículo</th>
                        <th>Cantidad</th>
                        <th>Cant x U. Medida</th>
                        <th>Item Ingresados</th>
                        <th>Precio Compra</th>
                        <th>Subtotal</th>
                    </thead>
                    <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th> <h4 id="total">{{$ingreso->total}}</h4></th>
                    </tfoot>
                    <tbody>
                        @foreach($detalles as $det)
                        <tr>
                            <td>{{$det->NombProducto}}</td>
                            <td>{{$det->cantidad}}</td>
                            <td>{{$det->valorUMedida}}</td>
                            <td>{{$det->cantidad * $det->valorUMedida}}</td>
                            <td>{{$det->precioCompra}}</td>
                            <td>{{number_format($det->cantidad*$det->precioCompra, 2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <a href="{{asset('compras/ingreso_producto')}}" class="btn btn-sm btn-danger">Volver atras</a>
    </div>
</div>
@endsection
