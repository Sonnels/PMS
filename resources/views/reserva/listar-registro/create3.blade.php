<?php date_default_timezone_set('America/Lima'); ?>
@extends ('layout.admin')
@section('Contenido')
    <div class="row">
        <div class="col-md-8">
            <div class="card mt-2">
                <div class="card-header bg-secondary pb-2 pt-2">
                    <span>HABITACIÓN N° {{ $Habitacion->Num_Hab }} |
                        {{ $Habitacion->tipoden }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <span class="text-gray-dark">PRECIO: </span><span> {{ $Habitacion->precioMes }} | {{ $Habitacion->precioHora }} |
                                {{-- {{ $Habitacion->precioHora6 }} | {{ $Habitacion->precioHora8 }} | --}}
                                {{ $Habitacion->precioNoche }}</span>
                            {{-- S/ {{ $Habitacion->Precio }} --}}
                            <div id="precioSeleccionado"></div>
                            <input type="hidden" id="Precio" value="">
                            <input type="hidden" id="preciosHab"
                                value="{{ $Habitacion->precioMes }}_{{ $Habitacion->precioHora }}_{{ $Habitacion->precioNoche }}">
                        </div>
                        <div class="col-md-2">
                            <span class="text-gray-dark">ESTADO: </span>
                            <label>
                                @if ($Habitacion->Estado == 'DISPONIBLE')
                                    <span style=" color: #1cad69">
                                        {{ $Habitacion->Estado }}
                                    </span>
                                @elseif ($Habitacion->Estado == 'RESERVADO')
                                    <span style=" color: #1c7fad">
                                        {{ $Habitacion->Estado }}
                                    </span>
                                @elseif ($Habitacion->Estado == 'OCUPADO')
                                    <span style=" color: #e67469">
                                        {{ $Habitacion->Estado }}
                                    </span>
                                @endif
                            </label>
                        </div>
                        <div class="col-md-5">
                            <span class="text-gray-dark">DESCRIPCIÓN: </span> {{ $Habitacion->deshab }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mt-2">
                <div class="card-header bg-secondary pb-2 pt-2">
                    <span>DETALLES DE RESERVA</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <span style="font-weight: bold">F. Entrada:</span> {{ date('H:i:s d/m/Y', strtotime($apartar->fecIn))}} <br>
                            <span style="font-weight: bold">F. Salida:</span> {{ date('H:i:s d/m/Y', strtotime($apartar->fecOut))}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
            <div id="error_fecha" class=" bg-danger text-danger"></div>
            @if (count($errors) > 0)
                <div class="alert bg-danger text-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    @include('reserva.registro.modal')
    <form id="form1" method="POST" action="{{ route('listar-registro.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <span for="">CLIENTE</span>
                    <table style="width: 100%">
                        <tr>
                            <td colspan="2">
                                <select name="id_cliente2" class="form-control selectpicker" id="id_cliente2"
                                    data-live-search="true">
                                    @foreach ($Cliente as $c)
                                        @if ($apartar->IdCliente == $c->IdCliente)
                                            <option value="{{ $c->IdCliente }}_{{ $c->Nombre }}" selected>
                                                {{ $c->NumDocumento }} |
                                                {{ $c->Nombre }} {{ $c->Apellido }}
                                            </option>
                                        @else
                                            <option value="{{ $c->IdCliente }}_{{ $c->Nombre }}">
                                                {{ $c->NumDocumento }} |
                                                {{ $c->Nombre }} {{ $c->Apellido }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                            </td>
                            <td style=" width: 2%;">
                                <a href="" data-target="#modal-add" style="float: right;" data-toggle="modal"
                                    class="btn btn-success bg-teal">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <input type="hidden" id="IdCliente" name="IdCliente">
            <!-- Para el autoincrementable -->


            <input type="hidden" id="Estado" name="Estado" value="HOSPEDAR">
            <input type="hidden" name="idApartar" value="{{$apartar->idApartar}}">
            @php($servicio = ['2 HORAS', '4 HORAS', 'TODA LA NOCHE'])
            <div class="col-md-3 col-6">
                <div class="form-group">
                    <span for="">TARIFA / PRECIO</span>
                    <select name="servicio" id="servicio" class="form-control" required>
                        <option value="" hidden selected>Seleccionar</option>
                        @foreach ($servicio as $item)
                            @if (old('servicio') == $item)
                                <option value="{{ $item }}" selected>{{ $item }}</option>
                            @else
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="form-group">
                    <span for="" id="Entrada">FECHA DE ENTRADA</span>
                    <span for="" id="Reserva" style="display:none;">FECHA RESERVA</span>
                    <div class="input-group">
                        @php($min = date('Y-m-d', strtotime(date('Y-m-d') . ' -0 day')))
                        @php($val_fechaReserva = old('FechReserva') != '' ? old('FechReserva') : date('Y-m-d'))
                        <input type="date" id="freserva" name="FechReserva" value="{{ $val_fechaReserva }}"
                            class="form-control" readOnly>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6" id="seccion_cantidad">
                <div class="form-group">
                    <span for="" id="Entrada">CANT.</span>
                    <div class="input-group">
                        <input type="text" class="form-control numero" id="cantida_m" name="cantida_m" min="1"
                            value="1">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    <span for="">FECHA DE SALIDA</span>
                    <input type="date" name="FechSalida" id="fsalida"
                        value="{{ old('FechSalida') != '' ? old('FechSalida') : date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day')) }}"
                        min="<?php echo date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day')); ?>" class="form-control">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <span for="">HORA SALIDA</span>
                    <input type="time" name="horaSalida" id="horaSalida" class="form-control" value="12:00"
                        required>
                </div>
            </div>
        </div>

        {{-- <div class="card">
        <div class="card-header  bg-secondary">
            <span>AGREGAR SERVICIOS</span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <span for="">SERVICIO</span>
                                <select class="form-control selectpicker" name="codProducto" id="pidarticulo"
                                    data-live-search="true">
                                    <option value="" hidden selected>Selecione Servicio</option>
                                    @foreach ($servicioExtra as $s)
                                        <option value="{{ $s->idServicio }}_{{ $s->precioS }}">
                                            {{ $s->nombreS }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <span for="precio_venta">VALOR</span>
                                <input type="number" disabled name="precioVenta" id="pPrecio" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <span for="">CANT</span>
                                <input type="number" id="pCantidad" class="form-control" min="1" value="1">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body table-responsive p-0">
                            <table id="detalles" class="table table-striped table-condensed table-hover">
                                <thead>
                                    <th>ELIMINAR</th>
                                    <th>SERVICIO</th>
                                    <th>VALOR</th>
                                    <th>CANT</th>
                                    <th>SUB TOTAL</th>
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <h4 id="total">$ 0.00</h4> <input type="hidden" name="totalVenta" id="total_venta">
                                    </th>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
        <div class="card">
            <div class="card-header bg-secondary pb-2 pt-2">
                <span>REGISTRAR PAGO</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <span for="">MÉTODO PAGO</span>
                            <select name="metodoPago" class="form-control">
                                @foreach ($metPago as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <span for="">DESCUENTO</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted" style="display: grid;">
                                        <div class="text-left font-medium">$</div>
                                    </span>
                                </div>
                                <input type="text" id="Descuento" name="Descuento"
                                    @if (!old('Descuento')) value="0"
                        @else
                            value="{{ old('Descuento') }}" @endif
                                    placeholder="Monto a Descontar" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <span for="">PAGO RECIBIDO</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted" style="display: grid;">
                                        <div class="text-left font-medium">$</div>
                                    </span>
                                </div>
                                <input type="text" id="Adelanto" name="Adelanto"
                                    @if (!old('Adelanto')) value="0"
                        @else
                            value="{{ old('Adelanto') }}" @endif
                                    class="form-control" placeholder="Dinero dejado" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="hidden" name="Num_Hab" value="{{ $Habitacion->Num_Hab }}">
                            <span for="" title="VALOR HABITACIÓN">TOTAL</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted" style="display: grid;">
                                        <div class="text-left font-medium">$</div>
                                    </span>
                                </div>
                                <input type="text" id="costo" name="CostoAlojamiento" value="0.00" readonly
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2" style="display: none">
                        <div class="form-group">
                            <span for="" title="VALOR SERVICIO">VALOR SERVICIO</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted">
                                        <div class="text-left font-medium">$</div>
                                    </span>
                                </div>
                                <input type="text" id="valorServicio" name="valorServicio" value="0.00" readonly
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <span for="" title="" class="text-danger" id="text_f">A DEUDA</span>
                            <input type="hidden" id="text_f_value" name="text_f_value">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted" style="display: grid;">
                                        <div class="text-left font-medium">$</div>
                                    </span>
                                </div>
                                <input type="text" id="pagar" name="pagar" readonly class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                            <span for="">OBSERVACIONES</span>
                            <div class="input-group">
                                <textarea name="Observacion" placeholder="Escribir Aqui! algún detalle que tenga el registro." Class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-6 text-center">
                <div class="form-group">
                    <a href="{{ asset('reserva/registro') }}" class="btn btn-danger">Volver </a>
                    <button class="btn btn-primary agregar" type="submit">Registrar</button>
                </div>
            </div>
        </div>
    </form>
    {{-- {!! Form::close() !!} --}}

    @push('scripts')
        {{-- Para el N° de documento --}}
        <script>
            let data = document.getElementById('TipDocumento').value.split('_');
            verificar_long(data[1]);
            $("#TipDocumento").change(mostrarValores);

            function mostrarValores() {
                data = document.getElementById('TipDocumento').value.split('_');
                $('#NumDocumento').val("");
                verificar_long(data[1]);
            }

            function verificar_long(long) {
                document.getElementById("NumDocumento").maxLength = long;
            }
        </script>
        <script>
            $('#modal-add').on('hidden.bs.modal', function(e) {
                mediaStream.getVideoTracks()[0].stop();
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
        {{-- <script>
            $(document).ready(function() {
                $("#bt_add").click(function() {
                    agregar();
                });
            });
            var cont = 0;
            total = 0;
            subtotal = [];
            const elementos = [];
            $("#guardar").hide();
            $("#pidarticulo").change(mostrarValores);

            function mostrarValores() {
                datosArticulos = document.getElementById('pidarticulo').value.split('_');
                $("#pPrecio").val(datosArticulos[1]);

            }

            function agregar() {
                datosArticulos = document.getElementById('pidarticulo').value.split('_');
                idarticulo = datosArticulos[0];
                articulo = $("#pidarticulo option:selected").text();
                precio_venta = $("#pPrecio").val();
                cantidad = $("#pCantidad").val();

                if (idarticulo != "" && precio_venta != "" && cantidad > 0) {

                    if (evaluar_duplicidad(idarticulo)) {
                        subtotal[cont] = parseFloat(precio_venta) * parseFloat(cantidad);
                        total = total + subtotal[cont];

                        var fila = '<tr class="selected" id="fila' + cont +
                            '"><td align="center"><button type="button" class="btn btn-default btn-sm" onclick="eliminar(' +
                            cont + ',' + idarticulo +
                            ');"><i class="fas fa-trash-alt text-danger"></i></button></td><td><input type="hidden" name="codProducto[]" value="' +
                            idarticulo + '">' + articulo + '</td>' +
                            '<td><input type="hidden" name="precioVenta[]" readOnly value="' +
                            precio_venta + '">' + precio_venta + '</td>' +
                            '<td><input type="hidden" name="cantidad[]" readOnly value ="' + cantidad + '">' + cantidad +
                            '</td>' +
                            '<td>' + subtotal[cont] + '</td></tr>';
                        cont++;
                        limpiar();
                        $('#total').html("$ " + total);
                        $('#total_venta').val(total);
                        $('#valorServicio').val(total);
                        calcular_descuento();
                        // evaluar();
                        $('#detalles').append(fila);
                    } else {
                        toastr.error('El servicio seleccionado ya se encuentra en la lista.', 'ADVERTENCIA', {
                            "positionClass": "toast-bottom-right"
                        })
                    }

                } else {
                    alert("Error al ingresar el servicio, revise los datos del servicio")
                }
            }

            function limpiar() {

                $("#pprecio_venta").val("");
                $("#pCantidad").val("1");
            }


            function evaluar_duplicidad(value) {
                if (elementos.indexOf(value) === -1) {
                    elementos.push(value);
                    return true;
                }
                return false;
            }

            function eliminar(index, id) {
                total = total - subtotal[index];
                var myIndex = elementos.indexOf(String(id));
                if (myIndex !== -1) {
                    elementos.splice(myIndex, 1);
                }
                $("#total").html("$ " + total);
                $("#total_venta").val(total);
                $('#valorServicio').val(total);
                calcular_descuento();
                $("#fila" + index).remove();

            }
        </script> --}}

        {{-- --------------------------------------------------------------------------------------- --}}

        <script>
            $('.numero').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
            });

            $('#Descuento').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });

            $('#Adelanto').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });
        </script>
        <script>
            // $('.agregar_o').unbind().click(function() {
            document.querySelector('#form1').addEventListener('submit', function(e) {
                var form = this;

                e.preventDefault(); // <--- prevent form from submitting

                var h_Actual = new Date().toLocaleTimeString();
                Swal.fire({
                    // title: 'Necesitamos de tu Confirmación',
                    showDenyButton: true,
                    // customClass: 'swal-wide',
                    allowOutsideClick: false,
                    confirmButtonColor: '#36BE80',
                    html: '<div class="table-responsive">' +
                        '<table class="table text-nowrap">' +
                        '<tr><td align="left">Huesped</td><td align="left">' + document.getElementById(
                            'id_cliente2').value.split('_')[1] +
                        '<tr><td align="left">Servicio</td><td align="left">' + document.getElementById(
                            'servicio').value + '</td></tr>' +
                        '<tr><td align="left">Fecha de Entrada</td><td align="left">' + h_Actual + ' ' +
                        document.getElementById('freserva').value + '</td></tr>' +
                        '<tr><td align="left">Fecha de Salida</td><td align="left">' + document
                        .getElementById('horaSalida').value + ' ' + document.getElementById('fsalida')
                        .value + '</td></tr>' +
                        '<tr><td align="left">Descuento</td><td align="right">$ ' + document
                        .getElementById('Descuento').value + '</td></tr>' +
                        '<tr class="text-success"><td align="left">Pago Recibido</td><td align="right">$ ' +
                        document.getElementById('Adelanto').value + '</td></tr>' +
                        '<tr class="text-danger"><td align="left">' + $('#text_f_value').val() +
                        '</td><td align="right">$ ' +
                        document.getElementById('pagar').value +
                        '</td></tr></table></div>' +
                        '<span style="color: #36BE80; font-weight: bold">¿Está Usted de Acuerdo?</span>',
                    confirmButtonText: `Sí, Adelante!`,
                    denyButtonText: `Cancelar`,
                    icon: 'info',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // <--- submit form programmatically
                    }
                })
                //     return false;
                // }
            });
        </script>
        @if (Session::has('success'))
            <script>
                toastr.success('{{ Session::get('success') }}', 'Operación Correcta', {
                    "positionClass": "toast-top-right"
                })
            </script>
        @endif
        @if (Session::has('error'))
            <script>
                toastr.error('{{ Session::get('error') }}', 'Operación Fallida', {
                    "positionClass": "toast-top-right"
                })
            </script>
        @endif

        <script>
            window.onload = updateValue;
            const input = document.querySelector('#fsalida');
            const input2 = document.querySelector('#freserva');

            input.addEventListener('change', updateValue2);
            input2.addEventListener('change', updateValue);

            function updateValue(e) {
                // Calculamos la diferencia en dias

                fecha1 = document.getElementById("freserva").value;
                fecha2 = document.getElementById("fsalida");
                if (document.getElementById("servicio").value === 'TODA LA NOCHE') {
                    // Establecemos el min de la fecha final
                    var f = new Date(fecha1);
                    fecha2.setAttribute("min", ("0" + (f.getMonth() + 1)).slice(-2) + "-" + ("0" + (f.getDate() + 2)).slice(-
                        2));
                    console.log(fecha1);
                    //fecha2.value = f.getFullYear() + "-" + (f.getMonth() + 1) + "-" + ("0" + (f.getDate() + 2)).slice(-2);

                    var fechaInicio = new Date(fecha1).getTime();
                    var fechaFin = new Date(fecha2.value).getTime();

                    var dia = (fechaFin - fechaInicio) / (1000 * 60 * 60 * 24);
                    // Calculamos el total a pagar
                    precio = document.getElementById("Precio").value;
                    var n = dia * precio;
                    document.getElementById("costo").value = n.toFixed(2);
                } else {
                    document.getElementById("costo").value = document.getElementById("Precio").value === '' ? 0 : document
                        .getElementById("Precio").value;

                }


                FechaValida(fecha1, fecha2.value);
                calcular_descuento();
            }

            function updateValue2(e) {

                fecha1 = document.getElementById("freserva").value;
                fecha2 = document.getElementById("fsalida");
                if (document.getElementById("servicio").value === 'TODA LA NOCHE') {
                    var fechaInicio = new Date(fecha1).getTime();
                    var fechaFin = new Date(fecha2.value).getTime();
                    var dia = (fechaFin - fechaInicio) / (1000 * 60 * 60 * 24);
                    // Calculamos el total a pagar
                    precio = document.getElementById("Precio").value;
                    var n = dia * precio;
                    document.getElementById('cantida_m').value = dia;
                    document.getElementById("costo").value = n.toFixed(2);
                } else {
                    document.getElementById("costo").value = document.getElementById("Precio").value;

                }

                FechaValida(fecha1, fecha2.value);
                calcular_descuento();
            }


            function FechaValida(fecha_Inicial, fecha_Final) {
                var agregar = document.getElementById("agregar");
                var error_fecha = document.getElementById("error_fecha");
                var serv = document.getElementById("servicio").value;
                if (fecha_Inicial >= fecha_Final && (serv != '4 HORAS' && serv != '2 HORAS' && serv != '8 HORAS')) {
                    error_fecha.innerHTML = '<li>La fecha de salida debe ser mayor a la fecha de entrada.</li>';
                    error_fecha.style.padding = "15px";
                    // agregar.style.display = "none";
                } else {
                    error_fecha.innerHTML = '';
                    // agregar.style.display = "block";
                    error_fecha.style.padding = "0px";
                }
            }




            calcular_descuento();

            function calcular_descuento() {
                const descuento = document.querySelector('#Descuento');
                const val_adelanto = document.getElementById("Adelanto").value === '' ? 0 : document.getElementById("Adelanto")
                    .value;
                const val_descuento = document.getElementById("Descuento").value === '' ? 0 : document.getElementById(
                    "Descuento").value;
                document.getElementById("pagar").value = (parseFloat(document.getElementById("costo").value) + parseFloat(
                    document.getElementById("valorServicio").value) - parseFloat(val_descuento) - parseFloat(
                    val_adelanto)).toFixed(2);

                descuento.addEventListener("keyup", function(event) {
                    const val_descuento = event.target.value === '' ? 0 : event.target.value;
                    const val_adelanto = document.getElementById("Adelanto").value === '' ? 0 : document.getElementById(
                        "Adelanto").value;
                    document.getElementById("pagar").value = (parseFloat(document.getElementById("costo").value) +
                        parseFloat(document.getElementById("valorServicio").value) -
                        parseFloat(val_descuento) - parseFloat(val_adelanto)).toFixed(2);


                }, false);
            }


            calcular_adelanto();

            function calcular_adelanto() {
                const adelanto = document.querySelector('#Adelanto');
                const val_adelanto = document.getElementById("Adelanto").value === '' ? 0 : document.getElementById("Adelanto")
                    .value;
                const val_descuento = document.getElementById("Descuento").value === '' ? 0 : document.getElementById(
                    "Descuento").value;
                var asignado = parseFloat(document.getElementById("costo").value) + parseFloat(
                        document.getElementById("valorServicio").value) -
                    parseFloat(val_descuento) - parseFloat(val_adelanto);

                if (asignado >= 0) {
                    document.getElementById("pagar").value = (asignado).toFixed(2);
                    $('#text_f').html('A DEUDA');
                    $('#text_f_value').val('A DEUDA');
                } else {
                    // asignado = asignado * -1;
                    document.getElementById("pagar").value = (asignado * -1).toFixed(2);
                    $('#text_f').html('CAMBIO');
                    $('#text_f_value').val('CAMBIO');
                }


                adelanto.addEventListener("keyup", function(event) {
                    // const val_adelanto = event.target.value === '' ? 0 : event.target.value;
                    // const val_descuento = document.getElementById("Descuento").value === '' ? 0 : document
                    //     .getElementById("Descuento").value;
                    // var restante = parseFloat(document.getElementById("costo").value) +
                    //     parseFloat(document.getElementById("valorServicio").value) -
                    //     parseFloat(val_adelanto) - parseFloat(val_descuento);

                    // document.getElementById("pagar").value = (restante).toFixed(2);



                }, false);

            }

            // Jalamos el ID del cliente
            const cliente = document.querySelector('#id_cliente2');
            document.getElementById("IdCliente").value = document.getElementById("id_cliente2").value;
            cliente.addEventListener('change', (event) => {
                document.getElementById("IdCliente").value = event.target.value;

            });
        </script>
    @endpush
    <script>
        Date.prototype.addDays = function(noOfDays) {
            var tmpDate = new Date(this.valueOf());
            tmpDate.setDate(tmpDate.getDate() + noOfDays);
            return tmpDate.getFullYear() + "-" + ("0" + (tmpDate.getMonth() + 1)).slice(-2) + "-" + ("0" + tmpDate
                .getDate()).slice(-2);
        }
        Date.prototype.addMonth = function(n_meses) {
            var fecha = new Date(this.valueOf());
            fecha.setDate(fecha.getDate() + 1);
            fecha.setMonth(fecha.getMonth() + n_meses);
            return fecha.getFullYear() + "-" + ("0" + (fecha.getMonth() + 1)).slice(-2) + "-" + ("0" + fecha.getDate())
                .slice(-2);
        }
    </script>
    <script>
        const servicio = document.querySelector('#servicio');
        var preciosHab = document.getElementById('preciosHab').value.split('_');
        let div = document.getElementById("precioSeleccionado");
        const f_actual = new Date(document.getElementById("freserva").value);
        fechaActual = f_actual.addDays(1);
        var seccion_cantidad = document.getElementById("seccion_cantidad");

        servicio.addEventListener('change', (event) => {
            document.getElementById("Descuento").readOnly = false;
            document.getElementById("Adelanto").readOnly = false;

            if (event.target.value === '2 HORAS') {
                div.innerHTML = "Precio Seleccionado: " + preciosHab[0];
                document.getElementById("Precio").value = preciosHab[0];
                document.getElementById("fsalida").readOnly = true;
                seccion_cantidad.style.display = "block";
                var fecha = new Date();
                fecha.setHours(fecha.getHours() + 2)
                document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(fecha.getMinutes(), 2);
            }else if (event.target.value === '4 HORAS') {
                div.innerHTML = "Precio Seleccionado: " + preciosHab[1];
                document.getElementById("Precio").value = preciosHab[1];
                document.getElementById("fsalida").readOnly = true;
                seccion_cantidad.style.display = "block";
                var fecha = new Date();
                fecha.setHours(fecha.getHours() + 4)
                document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(fecha.getMinutes(), 2);
            } else if (event.target.value === 'TODA LA NOCHE') {
                div.innerHTML = "Precio Seleccionado: " + preciosHab[2];
                document.getElementById("Precio").value = preciosHab[2];
                document.getElementById("fsalida").readOnly = false;
                document.getElementById("fsalida").value = f_actual.addDays(2);
                seccion_cantidad.style.display = "none";
                document.getElementById('horaSalida').value = "12:00";
            }
            document.getElementById("cantida_m").value = 1;
            updateValue();
        });
    </script>
    <script>
        const cantida_m = document.querySelector('#cantida_m');
        addEventListener("keyup", function(event) {
            if (document.getElementById("cantida_m").value > 0) {
                // console.log(parseInt(document.getElementById("cantida_m").value));
                if (document.getElementById("servicio").value == 'POR MES') {
                    document.getElementById("fsalida").value = f_actual.addMonth(parseInt(document.getElementById(
                        "cantida_m").value));
                } else if (document.getElementById("servicio").value == '4 HORAS') {
                    var fecha = new Date();
                    const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                    fecha.setHours(fecha.getHours() + (4 * cantidad_m));
                    document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(
                        fecha.getMinutes(), 2);
                } else if (document.getElementById("servicio").value == '2 HORAS') {
                    var fecha = new Date();
                    const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                    fecha.setHours(fecha.getHours() + (2 * cantidad_m));
                    document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(
                        fecha.getMinutes(), 2);
                } else if (document.getElementById("servicio").value == '8 HORAS') {
                    var fecha = new Date();
                    const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                    fecha.setHours(fecha.getHours() + (8 * cantidad_m));
                    document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(
                        fecha.getMinutes(), 2);
                }

                bloque();

            } else {
                if (document.getElementById("servicio").value == 'POR MES') {
                    document.getElementById("fsalida").value = f_actual.addMonth(1);
                } else if (document.getElementById("servicio").value == '4 HORAS') {
                    var fecha = new Date();
                    const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                    fecha.setHours(fecha.getHours() + 4);
                    document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(
                        fecha.getMinutes(), 2);
                } else if (document.getElementById("servicio").value == '2 HORAS') {
                    var fecha = new Date();
                    const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                    fecha.setHours(fecha.getHours() + 2);
                    document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(
                        fecha.getMinutes(), 2);
                } else if (document.getElementById("servicio").value == '8 HORAS') {
                    var fecha = new Date();
                    const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                    fecha.setHours(fecha.getHours() + 8);
                    document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(
                        fecha.getMinutes(), 2);
                }

                document.getElementById("costo").value = document.getElementById("Precio").value * 1;
                bloque();
            }
            calcular_adelanto();
        })

        function bloque() {
            const cant2 = document.getElementById("cantida_m").value === '' ? 1 : parseInt(document.getElementById(
                "cantida_m").value);
            document.getElementById("costo").value = document.getElementById("Precio").value * cant2;

            var habitacion = parseFloat(document.getElementById("costo").value);
            var adelant = document.getElementById("Adelanto").value === '' ? 0 : parseFloat(document.getElementById(
                "Adelanto").value);
            var desc = document.getElementById("Descuento").value === '' ? 0 : parseFloat(document.getElementById(
                "Descuento").value);
            var vServicio = document.getElementById("valorServicio").value === '' ? 0 : parseFloat(document.getElementById(
                "valorServicio").value);
            // var deuda_final =  parseFloat(habitacion + vServicio - desc - adelant);
            // if (deuda_final > 0) {
            //     document.getElementById("pagar").value = deuda_final;
            // }

        }
    </script>
    <script>
        function zeroFill(number, width) {
            width -= number.toString().length;
            if (width > 0) {
                return new Array(width + (/\./.test(number) ? 2 : 1)).join('0') + number;
            }
            return number + ""; // siempre devuelve tipo cadena
        }
    </script>
@endsection
