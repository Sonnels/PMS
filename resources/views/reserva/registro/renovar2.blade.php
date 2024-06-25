@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Renovar Alquiler</span>
                </div>

                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <span class="text-gray-dark">N°: </span> <span>{{ $habitacion->Num_Hab }} |
                        {{ $habitacion->tipoden }}</span>
                </div>
                <div class="col-md-4">
                    <span class="text-gray-dark">PRECIO: </span><span>{{ $habitacion->precioMes }} | {{ $habitacion->precioHora }} |
                        {{ $habitacion->precioNoche }}</span>
                    <div id="precioSeleccionado"></div>
                    <input type="hidden" id="Precio" value="">
                    <input type="hidden" id="preciosHab"
                        value="{{ $habitacion->precioMes }}_{{ $habitacion->precioHora }}_{{ $habitacion->precioNoche }}">
                </div>
                <div class="col-md-2" style="font-weight: bold">
                    @if ($habitacion->Estado == 'DISPONIBLE')
                        <span style=" color: #1cad69">
                            {{ $habitacion->Estado }}
                        </span>
                    @elseif ($habitacion->Estado == 'RESERVADO')
                        <span style=" color: #1c7fad">
                            {{ $habitacion->Estado }}
                        </span>
                    @elseif ($habitacion->Estado == 'OCUPADO')
                        <span style=" color: #e67469">
                            {{ $habitacion->Estado }}
                        </span>
                    @endif
                </div>
                <div class="col-md-4">
                    <span class="text-gray-dark">DESCRIPCIÓN: </span> {{ $habitacion->deshab }}
                </div>
            </div>
        </div>
    </div>
    {{-- -------------------------------------------- --}}

    <div class="card">
        <div class="card-header bg-secondary">
            INFORMACIÓN ALQUILER
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <span for="" style="font-weight: bold">FECHA ENTRADA </span>
                        <p>{{ date('d/m/Y', strtotime($reserva->FechEntrada)) }} {{ $reserva->HoraEntrada }}</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <span for="" style="font-weight: bold">FECHA SALIDA </span>
                        {{-- <p>{{ date('d/m/Y', strtotime($reserva->FechSalida)) }} {{ $reserva->horaSalida }}</p> --}}
                        <p>{{ date('d/m/Y H:i:s', strtotime($reserva->departure_date)) }}</p>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('renovar_post') }}" method="POST" id="form1">
        @csrf
        <input type="hidden" name="fIniRen" value="{{ $reserva->departure_date }}">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    {{-- Id Oculto --}}
                    <input type="hidden" name="IdReserva" value="{{ $reserva->IdReserva }}">
                    @php($servicio = ['2 HORAS', '4 HORAS', 'TODA LA NOCHE'])
                    <div class="col-lg-3 col-md-4 col-6">
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
                    {{-- <div class="col-lg-3 col-md-4 col-6">
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
                </div> --}}
                    <div class="col-lg-3 col-md-4 col-6" id="seccion_cantidad" style="display: none">
                        <div class="form-group">
                            <span for="" id="Entrada">CANT.</span>
                            <div class="input-group">
                                <input type="text" class="form-control numero" id="cantida_m" name="cantida_m"
                                    min="1" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="form-group">
                            <span for="">FECHA DE SALIDA</span>
                            <input type="date" name="FechSalida" id="fsalida"
                                value="{{ old('FechSalida') != '' ? old('FechSalida') : date('Y-m-d', strtotime(date('Y-m-d') . ' +1 day')) }}"
                                min="{{ $reserva->FechSalida }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="form-group">
                            <span for="">HORA SALIDA</span>
                            <input type="time" name="horaSalida" id="horaSalida" class="form-control" value="12:00"
                                required>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <span for="" title="VALOR HABITACIÓN">MÉTODO PAGO</span>
                            @php($metodoPago = ['EFECTIVO', 'TARJETA', 'B. DIGITAL'])
                            <div class="input-group">
                                <select name="metodoPago" class="form-control">
                                    @foreach ($metodoPago as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <span for="" title="VALOR HABITACIÓN">VALOR HABITACIÓN</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted" style="display: grid;">
                                        <div class="text-left font-medium">$</div>
                                    </span>
                                </div>
                                <input type="text" id="costo" name="CostoAlojamiento" value="0" readonly
                                    class="form-control">
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-md-3 col-6">
                        <div class="form-group">
                            <span for="" title="A DEUDA" class="text-danger">A DEUDA</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted" style="display: grid;">
                                        <div class="text-left font-medium">$</div>
                                    </span>
                                </div>
                                <input type="text" id="pagar" name="pagar" readonly class="form-control">
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-primary" type="submit">Registrar</button>
                <a href="{{ asset('reserva/registro') }}" class="btn btn-danger">Volver</a>
            </div>
        </div>
    </form>
    @push('scripts')
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
                        // calcular_descuento();
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

            // function evaluar() {
            //     if (total > 0) {
            //         $("#guardar").show();
            //     } else {
            //         $("#guardar").hide();
            //     }
            // }
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
                // calcular_descuento();
                $("#fila" + index).remove();
                // evaluar();
            }
        </script>


        {{-- Para boton del formulario --}}
        <script>
            document.querySelector('#form1').addEventListener('submit', function(e) {
                var form = this;

                e.preventDefault(); // <--- prevent form from submitting
                var costo = document.getElementById('costo').value;
                var fSalida = document.getElementById('fsalida').value + ' ' + document.getElementById('horaSalida')
                    .value;
                fSalida = moment(fSalida).format("DD/MM/YYYY h:mm A");

                Swal.fire({
                    title: 'Confirmar',
                    // text: "No podrás revertir esta acción.!",
                    html: '<h6>No podrás revertir esta acción.!</h6>' +
                        '<h5>Pago Recibido: ' + '<b>' + costo + '</b>' + '</h5>' +
                        '<h5>Nueva F. Salida: ' + '<b>' + fSalida + '</b>' + '</h5>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // <--- submit form programmatically
                    }
                })
            });
        </script>
        <script>
            // Solo números
            $('.numero').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
            });


            // const fSalidaR = @json($reserva->FechSalida) + ' ' + @json($reserva->horaSalida);
            const fSalidaR = @json($reserva->departure_date);

            function updateValue(e) {
                // Calculamos la diferencia en dias

                fecha1 = fSalidaR;
                fecha2 = document.getElementById("fsalida");
                if (document.getElementById("servicio").value === 'TODA LA NOCHE') {
                    // Establecemos el min de la fecha final
                    // var f = new Date(fecha1);
                    // fecha2.setAttribute("min", ("0" + (f.getMonth() + 1)).slice(-2) + "-" + ("0" + (f.getDate() + 2)).slice(-
                    //     2));
                    //fecha2.value = f.getFullYear() + "-" + (f.getMonth() + 1) + "-" + ("0" + (f.getDate() + 2)).slice(-2);
                    var fechaInicio = new Date(fecha1).getTime();
                    var fechaFin = new Date(fecha2.value + ' ' + @json(date('H:i:s', strtotime($reserva->departure_date)))).getTime();
                    var dia = (fechaFin - fechaInicio) / (1000 * 60 * 60 * 24);
                    // Calculamos el total a pagar
                    precio = document.getElementById("Precio").value;
                    var n = dia * precio;
                    // Colocamos el nro de día
                    document.getElementById("cantida_m").value = dia;
                    document.getElementById("costo").value = n.toFixed(2);
                } else {
                    document.getElementById("costo").value = document.getElementById("Precio").value === '' ? 0 : document
                        .getElementById("Precio").value;

                }


                // FechaValida(fecha1, fecha2.value);
                // calcular_descuento();
            }
        </script>
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
            window.onload = updateValue;
            const input = document.querySelector('#fsalida');
            input.addEventListener('change', updateValue);

            // ------------------------------------------------
            const servicio = document.querySelector('#servicio');
            var preciosHab = document.getElementById('preciosHab').value.split('_');
            let div = document.getElementById("precioSeleccionado");
            const f_actual = new Date(fSalidaR);
            fechaActual = f_actual.addDays(1);
            var seccion_cantidad = document.getElementById("seccion_cantidad");

            servicio.addEventListener('change', (event) => {
                // document.getElementById("Descuento").readOnly = false;
                // document.getElementById("Adelanto").readOnly = false;
                if (event.target.value === '2 HORAS') {
                    div.innerHTML = "Precio Seleccionado: " + preciosHab[0];
                    document.getElementById("Precio").value = preciosHab[0];
                    document.getElementById("fsalida").readOnly = true;
                    seccion_cantidad.style.display = "block";
                    var fecha = new Date(fSalidaR);
                    fecha.setHours(fecha.getHours() + 2)
                    document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(fecha
                        .getMinutes(), 2);
                } else if (event.target.value === '4 HORAS') {
                    div.innerHTML = "Precio Seleccionado: " + preciosHab[1];
                    document.getElementById("Precio").value = preciosHab[1];
                    document.getElementById("fsalida").readOnly = true;
                    seccion_cantidad.style.display = "block";
                    var fecha = new Date(fSalidaR);
                    fecha.setHours(fecha.getHours() + 4)
                    document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(fecha
                        .getMinutes(), 2);

                } else if (event.target.value === 'TODA LA NOCHE') {
                    div.innerHTML = "Precio Seleccionado: " + preciosHab[2];
                    document.getElementById("Precio").value = preciosHab[2];
                    document.getElementById("fsalida").readOnly = false;
                    var fecha = new Date(fSalidaR);
                    fecha.setHours(fecha.getHours() + 24);
                    document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(fecha
                        .getMinutes(), 2);
                    seccion_cantidad.style.display = "none";
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
                    } else if (document.getElementById("servicio").value == '2 HORAS') {
                        var fecha = new Date(fSalidaR);
                        const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                        fecha.setHours(fecha.getHours() + (2 * cantidad_m));
                        document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                        document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(
                            fecha.getMinutes(), 2);
                    } else if (document.getElementById("servicio").value == '4 HORAS') {
                        var fecha = new Date(fSalidaR);
                        const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                        fecha.setHours(fecha.getHours() + (4 * cantidad_m));
                        document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                        document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(
                            fecha.getMinutes(), 2);
                    }

                    bloque();

                } else {
                    if (document.getElementById("servicio").value == 'POR MES') {
                        document.getElementById("fsalida").value = f_actual.addMonth(1);
                    } else if (document.getElementById("servicio").value == '2 HORAS') {
                        var fecha = new Date(fSalidaR);
                        const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                        fecha.setHours(fecha.getHours() + 2);
                        document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                        document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(
                            fecha.getMinutes(), 2);
                    } else if (document.getElementById("servicio").value == '4 HORAS') {
                        var fecha = new Date(fSalidaR);
                        const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                        fecha.setHours(fecha.getHours() + 4);
                        document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                        document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(
                            fecha.getMinutes(), 2);
                    }

                    document.getElementById("costo").value = document.getElementById("Precio").value * 1;
                    bloque();
                }
                // calcular_adelanto();
                // calcular_descuento();
            })

            function bloque() {
                const cant2 = document.getElementById("cantida_m").value === '' ? 1 : parseInt(document.getElementById(
                    "cantida_m").value);
                document.getElementById("costo").value = document.getElementById("Precio").value * cant2;

                // var habitacion = parseFloat(document.getElementById("costo").value);
                // var adelant = document.getElementById("Adelanto").value === '' ? 0 : parseFloat(document.getElementById(
                //     "Adelanto").value);
                // var desc = document.getElementById("Descuento").value === '' ? 0 : parseFloat(document.getElementById(
                //     "Descuento").value);
                // var vServicio = document.getElementById("valorServicio").value === '' ? 0 : parseFloat(document.getElementById(
                //     "valorServicio").value);
                // calcular_descuento
                // document.getElementById("pagar").value = parseFloat(habitacion);

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
        @if (Session::has('error'))
            <script>
                toastr.error('{{ Session::get('error') }}', 'Operación Fallida', {
                    "positionClass": "toast-top-right"
                })
            </script>
        @endif
    @endpush
@endsection
