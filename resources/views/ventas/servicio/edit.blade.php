<?php use App\Http\Controllers\SalidaController; ?>
@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <span class="title_header">
                        Añadir Servicio a la Habitación N°:
                        <font class="text-dark">
                            {{ $reserva->Num_Hab }} - {{ $reserva->Denominacion }}
                        </font>|
                        Cliente:
                        <font class="text-dark">
                            {{ $reserva->Ndcliente }} | {{ $reserva->nomcli }}
                        </font>
                    </span>
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
        {{-- <div class="col-lg-2 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <span for="Num_Hab" class="text-success">HABITACIÓN</span>
                <p>{{ $reserva->Num_Hab }} - {{ $reserva->Denominacion }}</p>
            </div>
        </div> --}}
        <div class="col-lg-2 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <span for="Precioxdia" class="text-success">TARIFA</span>
                {{-- <p>$ {{ $reserva->precioHora }} | $ {{ $reserva->precioNoche }} | $ {{ $reserva->precioMes }}</p> --}}
                <p>{{ $reserva->servicio }}</p>
            </div>
        </div>


        <div class="col-lg-3 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <span for="FechEntrada" class="text-success">F. ENTRADA</span>
                <p>{{ SalidaController::fechaCastellano($reserva->FechEntrada) }}</p>
            </div>
        </div>
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <span for="FechSalida" class="text-success">F. PREVISTA DE SALIDA</span>
                <p>{{ SalidaController::fechaCastellano(date('Y-m-d', strtotime($reserva->departure_date))) }} {{ date('H:i:s', strtotime($reserva->departure_date)) }}</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    <ul>
                        <li>Ha sobrepasado el stock de uno o más productos. Verifique e intente nuevamente</li>
                    </ul>
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    {!! Form::model($reserva, ['method' => 'PATCH', 'route' => ['servicio.update', $reserva->IdReserva]]) !!}
    {{ Form::token() }}
    <div class="form-group">
        <input type="hidden" name="IdReserva" class="form-control" value="{{ $reserva->IdReserva }}">
    </div>

    <div class="row">
        <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <span>SERVICIO</span>
                <select name="IdProducto" class="form-control selectpicker" data-live-search="true" id="IdProducto">
                    <!-- <option>--Selecionar--</option> -->
                    @foreach ($producto as $pro)
                        <option value="{{ $pro->IdProducto }}_{{ $pro->Precio }}_{{ $pro->stock }}">
                            {{ $pro->NombProducto }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <span for="cantidad">CANTIDAD</span>
                <input type="number" name="Cantidad" id="Cantidad" class="form-control" placeholder="Cantidad">
            </div>
        </div>
        {{-- <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
                <span for="stock">STOCK</span>
                <input type="number" disabled name="pstock" id="pstock" class="form-control" placeholder="Stock">
            </div>
        </div> --}}
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <span for="precio">PRECIO VENTA</span>
                <input type="number" name="Precio" id="Precio" class="form-control" disabled placeholder="precio">
            </div>
        </div>

        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
            <div class="form-group">
                <br>
                <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <table id="detalles" class="table table-striped  table-condensed table-hover">
                <thead class="bg-secondary">
                    <td style="text-align:center;">OPCIONES</td>
                    <td>SERVICIO</td>
                    <td>CANTIDAD</td>
                    <td>PRECIO VENTA</td>
                    <td>SUBTOTAL</td>
                </thead>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align: right">
                            <h4>TOTAL</h4>
                        </td>
                        <td>
                            <h4 id="total">{{$datos_empresa->simboloMoneda}} 0.00</h4> <input type="hidden" id="Total" name="Total">
                            {{-- <input type="hidden" name="Estado" value="PAGADO" required> --}}

                        </td>
                    </tr>

                </tfoot>
            </table>

        </div>

        <div class="col-md-6 col-12">
            <span for="" style="font-weight: bold">PAGAR</span>
            <div class="form-check">
                <input type="radio" name="Estado" value="PAGADO" required>
                <label class="form-check-label">
                    AHORA
                </label>
            </div>
            <div class="form-check">
                <input type="radio" name="Estado" value="FALTA PAGAR" required>
                <label class="form-check-label">
                    LUEGO
                </label>
            </div>
        </div>
        <div class="col-md-6 col-12" id="metodoPago" style="display: none">
            <span for="" style="font-weight: bold">MÉTODO PAGO</span>
            <div class="input-group">
                @php($metPago = ['EFECTIVO', 'TARJETA', 'B. DIGITAL'])
                <select name="metodoPago" class="form-control metodoPago">
                    @foreach ($metPago as $m)
                        <option value="{{ $m }}" {{ old('metodoPago') == $m ? 'selected' : '' }}>
                            {{ $m }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12 text-center" style="margin-top: 20px">

            <a href="{{ asset('ventas/servicio') }}" class="btn btn-danger">Volver</a>
            <input name="_token" value="{{ csrf_token() }}" type="hidden"></input>
            <button class="btn btn-primary" type="submit" id="guardar" style="display: none">
                Registrar
            </button>


        </div>

    </div>

    {!! Form::close() !!}

    @push('scripts')
        <script>
             $('input[type=radio][name=Estado]').change(function() {
                console.log(this.value)
                // $("#buscar").click();
                if (this.value === 'PAGADO') {
                    document.getElementById('metodoPago').style.display = 'block';
                }else{
                    document.getElementById('metodoPago').style.display = 'none';
                }
            });
        </script>
        @if (!isset($caja))
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Advertencia!',
                        icon: 'warning',
                        // showDenyButton: true,
                        confirmButtonColor: '#36BE80',
                        html: 'Para poder realizar esta operación es necesario Aperturar Caja <br><br> <span style="color: #36BE80; font-weight: bold">¿Está Usted de Acuerdo?</span>',
                        confirmButtonText: 'Sí, Adelante',
                        // footer: '¿Está Usted de Acuerdo?',
                        // denyButtonText: `Aún no`,
                        // closeOnClickOutside: false
                        allowOutsideClick: false

                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            location.href = "{{ asset('caja/apertura') }}";
                        }
                    })
                });
            </script>
        @else
            @if ($caja->codUsuario != auth()->user()->IdUsuario)
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Advertencia!',
                            icon: 'warning',
                            // showDenyButton: true,
                            confirmButtonColor: '#36BE80',
                            html: 'Caja aperturada por otro usuario. <br> Espere que el usuario responsable cierre la caja.<br><br> ',
                            confirmButtonText: 'Sí, Adelante',
                            // footer: '¿Está Usted de Acuerdo?',
                            // denyButtonText: `Aún no`,
                            // closeOnClickOutside: false
                            allowOutsideClick: false

                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                location.href = "{{ asset('reserva/registro') }}";
                            }
                        })
                    });
                </script>
            @endif
        @endif
        <script>
            $('#nroCuenta').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
            });
            $(document).ready(function() {
                $('#bt_add').click(function() {
                    agregar();
                    mostrarValores();
                });
            });
            var cont = 0;
            total = 0;
            subtotal = [];
            // $("#guardar").hide();

            // Código para mostrar valores extra en un select "PLATO"
            mostrarValores();
            $("#IdProducto").change(mostrarValores);

            function mostrarValores() {
                datosProducto = document.getElementById('IdProducto').value.split('_');
                $("#Precio").val(datosProducto[1]);
                $("#pstock").val(datosProducto[2]);
            }

            // Seleccionar un valor idcliente
            // document.getElementById('IdCliente').options.selectedIndex = 1;
            // Código para cargar los datos direccion, latitud, longitud

            function agregar() {
                datosProducto = document.getElementById('IdProducto').value.split('_');
                idproducto = datosProducto[0];
                articulo = $("#IdProducto option:selected").text();
                cantidad = $("#Cantidad").val();
                // stock = $("#pstock").val();
                precio = $("#Precio").val();


                if (idproducto != "" && cantidad != "" && cantidad > 0 && precio != "") {
                    // if (parseInt(stock) >= parseInt(cantidad)) {
                        subtotal[cont] = (cantidad * precio);
                        cantidad
                        total = total + subtotal[cont];

                        var fila = '<tr class="selected" id="fila' + cont +
                            '"><td style="text-align:center;"><button type ="button" class="bn btn quitar" onclick="eliminar(' +
                            cont + ')">' +
                            '<i class="fa fa-minus-circle" aria-hidden="true"></i>' +
                            '</button></td>' +
                            '<td><input type="hidden" name="idproducto[]" value="' + idproducto + '"> ' + articulo +
                            '</td><td><input type="text" readonly name="cantidad[]" value="' + cantidad +
                            '"></td><td><input type="text" disabled name="precio[]" value="' + precio +
                            '"></td><td><input type="hidden" readonly name="precio_venta[]" value="' + subtotal[cont] +
                            '">' + @json($datos_empresa->simboloMoneda) + ' ' + subtotal[cont].toFixed(2) + '</td></tr>';
                        cont++;
                        limpiar();
                        $("#total").html(@json($datos_empresa->simboloMoneda) + ' ' + total.toFixed(2));
                        $("#Total").val(total);
                        evaluar();
                        $('#detalles').append(fila);
                    // } else {
                    //     alert('La cantidad a vender supera el stock.');
                    // }
                } else {
                    alert("Error al ingresar el detalle del Pedido, revise los datos del Producto");
                }
            }

            function limpiar() {
                $("#cantidad").val("");
                $("#Precio").val("");

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
        </script>
    @endpush

@endsection
