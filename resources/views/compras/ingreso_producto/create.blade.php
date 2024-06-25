@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Nuevo Ingreso</span>
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

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('ingreso_producto.store') }}" method="POST" id="form">
        @csrf
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <label for="proveedor">Proveedor</label>
                    <select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true">
                        <option value="1">SIN ESPECIFICAR</option>
                        @foreach ($personas as $pro)
                            <option value="{{ $pro->idpro }}">{{ $pro->nomPro }}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            {{-- <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label>Comprobante</label>
                <select name="tipo_comprobante" class="form-control">
                    <option value="Boleta">Boleta</option>
                    <option value="Factura">Factura</option>
                    <option value="Ticket">Ticket</option>
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="serie_comprobante">Serie del Comprobante</label>
                <input type="text" name="serie_comprobante" value="{{ old('serie_comprobante') }}" class="form-control"
                    placeholder="Serie del Comprobante...">
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <label for="num_comprobante">Número del Comprobante</label>
                <input type="text" name="num_comprobante" required value="{{ old('num_comprobante') }}"
                    class="form-control" placeholder="Número del Comprobante...">
            </div>
        </div> --}}
        </div>
        <div class="row">
            <div class="cold-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                <div class="form-group">
                                    <label>Producto</label>
                                    <select name="pidarticulo" class="form-control selectpicker" id="pidarticulo"
                                        data-live-search="true">
                                        {{-- <option value="" selected hidden>Seleccionar Artículo</option> --}}
                                        @foreach ($articulos as $articulo)
                                            <option value="{{ $articulo->IdProducto }}"> {{ $articulo->articulo }} |
                                                {{ $articulo->stock }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Unidad Medida</label>
                                    <select name="punidadMedida" id="punidadMedida" class="form-control">
                                        @foreach ($unidadMedida as $item)
                                            <option
                                                value="{{ $item->idUnidadMedida }}_{{ $item->nombreUM }}_{{ $item->valorUM }}">
                                                {{ $item->nombreUM }} | {{ $item->valorUM }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad</label>
                                    <input type="number" name="pcantidad" id="pcantidad" class="form-control"
                                        placeholder="cantidad">
                                </div>
                            </div>
                            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                <div class="form-group">
                                    <label for="precio_compra">Precio x U.Medida</label>
                                    <input type="number" name="pprecio_compra" id="pprecio_compra" class="form-control"
                                        placeholder="P. Compra">
                                </div>
                            </div>
                            {{-- <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                            <div class="form-group">
                                <label for="precio_venta">Precio Venta</label>
                                <input type="number" name="pprecio_venta" id="pprecio_venta" class="form-control"
                                    placeholder="P. Venta">
                            </div>
                        </div> --}}
                            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                                <div class="form-group">
                                    <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <table id="detalles" class="table table-striped table-condensed table-hover">
                                    <thead class="bg-secondary">
                                        <td>OPCIONES</td>
                                        <td>ARTÍCULO</td>
                                        <td>U. MEDIDA</td>
                                        <td>CANTIDAD</td>
                                        <td>PRECIO x U.MEDIDA</td>
                                        {{-- <td>Precio Venta</td> --}}
                                        <td>SUBTOTAL</td>
                                    </thead>
                                    <tfoot>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        {{-- <th></th> --}}
                                        <th>
                                            <h4 id="total">{{ $datos_empresa->simboloMoneda }} 0.00</h4>
                                        </th>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 text-center" id="guardar">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" id="enviar"> Guardar </button>
                    <a href="{{route('ingreso_producto.store')}}" class="btn btn-danger" > Cancelar </a>
                </div>
            </div>
        </div>
    </form>



    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#bt_add').click(function() {
                    agregar();
                });
            });
            var cont = 0;
            total = 0;
            subtotal = [];
            $("#guardar").hide();

            function agregar() {
                idarticulo = $("#pidarticulo").val();
                articulo = $("#pidarticulo option:selected").text();
                unidadMedida = document.getElementById('punidadMedida').value.split('_');

                cantidad = $("#pcantidad").val();
                precio_compra = $("#pprecio_compra").val();
                // precio_venta = $("#pprecio_venta").val();

                if (idarticulo != "" && cantidad != "" && cantidad > 0 && precio_compra != "") {
                    subtotal[cont] = (cantidad * precio_compra);
                    total = total + subtotal[cont];

                    var fila = '<tr class="selected" id="fila' + cont +
                        '"><td><button type ="button" class="btn btn-default btn-sm" onclick="eliminar(' + cont +
                        ')"><i class="fas fa-trash-alt text-danger"></i></button></td> <td><input type="hidden" name="idarticulo[]" value="' +
                        idarticulo + '"> ' +
                        articulo + '</td><td>' + '<input type="hidden" readOnly name="unidadMedida[]" value="' + unidadMedida[
                            2] +
                        '">' + unidadMedida[1] + ' | ' + unidadMedida[2] + '</td>' +
                        '<td><input type="hidden" readOnly name="cantidad[]" value="' + cantidad +
                        '">' + cantidad + '</td><td><input type="hidden" readOnly name="precio_compra[]" value="' +
                        precio_compra +
                        '">' + precio_compra + '</td><td>' + @json($datos_empresa->simboloMoneda) + ' ' + subtotal[cont] + '</td></tr>';
                    cont++;
                    limpiar();
                    $("#total").html(@json($datos_empresa->simboloMoneda) + ' ' + total);
                    evaluar();
                    $('#detalles').append(fila);
                } else {
                    alert("Error al ingresar el detalle del ingreso, revise los datos del articulo");
                }
            }

            function limpiar() {
                $("#pcantidad").val("");
                $("#pprecio_compra").val("");
                // $("#pprecio_venta").val("");
            }

            function evaluar() {
                if (total > 0) {
                    $("#guardar").show();
                } else {
                    $("#guardar").hide();

                }

            }

            function eliminar(index) {
                total = total - subtotal[index];
                $("#total").html(@json($datos_empresa->simboloMoneda) + ' ' + total);
                $("#fila" + index).remove();
                evaluar();
            }

            // Para el formulario
            document.querySelector('#form').addEventListener('submit', function(e) {
                var form = this;

                e.preventDefault();

                // Utiliza SweetAlert2 para mostrar una ventana de confirmación
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres realizar el ingreso de productos?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, confirmar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let myButton = document.getElementById('enviar');
                        myButton.disabled = true;
                        myButton.style.opacity = 0.7;
                        myButton.textContent = 'Procesando ...';
                        form.submit();
                    }
                });
            });
        </script>
    @endpush

@endsection
