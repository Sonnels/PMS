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
                    <span class="text-gray-dark">N°: </span> <span>{{ $habitacion->Num_Hab }} <br>
                        {{ $habitacion->tipoden }}</span>
                </div>
                <div class="col-md-4">
                    <span class="text-gray-dark">PRECIO: </span><span>{{ $habitacion->precioHora }} | {{ $habitacion->precioNoche }} |
                        {{ $habitacion->precioMes }}</span>
                    <div id="precioSeleccionado"></div>
                    <input type="hidden" id="Precio" value="">
                    <input type="hidden" id="preciosHab"
                        value="{{ $habitacion->precioHora }}_{{ $habitacion->precioNoche }}_{{ $habitacion->precioMes }}">
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
        <div class="card-header bg-secondary pb-2 pt-2">
            INFORMACIÓN ALQUILER
        </div>
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-md-4 col-6">
                    <div class="form-group">
                        <span for="" style="font-weight: bold">CLIENTE </span>
                        <p>{{$reserva->Nombre}}</p>
                    </div>
                </div>
                <div class="col-md-4 col-6">
                    <div class="form-group">
                        <span for="" style="font-weight: bold">FECHA ENTRADA </span>
                        <p>{{ date('d/m/Y', strtotime($reserva->FechEntrada)) }} {{ $reserva->HoraEntrada }}</p>
                    </div>
                </div>
                <div class="col-md-4 col-6">
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
            <div class="card-body pb-0">
                <div class="row">
                    {{-- Id Oculto --}}
                    <input type="hidden" name="IdReserva" value="{{ $reserva->IdReserva }}">
                    @php($servicio = ['4 HORAS', 'TODA LA NOCHE', 'POR MES'])
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
            <div class="card-header bg-secondary pb-2 pt-2">
                <span>REGISTRAR PAGO</span>
            </div>
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
                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <span for="">DESCUENTO</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted" style="display: grid;">
                                        <div class="text-left font-medium">$</div>
                                    </span>
                                </div>
                                <input type="text" id="descuento" name="descuento" class="form-control decimal" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6" >
                        <div class="form-group">
                            <span for="">PAGO RECIBIDO</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted" style="display: grid;">
                                        <div class="text-left font-medium">$</div>
                                    </span>
                                </div>
                                <input type="text" id="montoRecibidoRen" name="montoRecibidoRen"  class="form-control decimal" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 col-6">
                        <div class="form-group">
                            <span for="">PAGO A RECIBIR</span>
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
                    <div class="col-md-2 col-6" >
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
                <a href="{{ asset('reserva/registro') }}" class="btn btn-danger">Volver</a>
                <button class="btn btn-primary" type="submit">Renovar</button>
            </div>
        </div>
    </form>
    @push('scripts')
        <script>
            $('.decimal').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
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


        {{-- Para boton del formulario --}}
        <script>
            document.querySelector('#form1').addEventListener('submit', function(e) {
                var form = this;

                e.preventDefault(); // <--- prevent form from submitting
                let tarifa = document.getElementById('servicio').value;
                let costo_info = document.getElementById('costo').value == '' ? 0 : document.getElementById('costo').value;
                let descuento_info = document.getElementById('descuento').value == '' ? 0 : document.getElementById('descuento').value;
                let montoRecibido_info = document.getElementById('montoRecibidoRen').value == '' ? 0 : document.getElementById('montoRecibidoRen').value;
                let pagar_info = document.getElementById('pagar').value == '' ? 0 : document.getElementById('pagar').value;
                let fSalida = document.getElementById('fsalida').value + ' ' + document.getElementById('horaSalida').value;
                fSalida = moment(fSalida).format("DD/MM/YYYY h:mm A");

                Swal.fire({
                    title: 'Confirmar',
                    // text: "No podrás revertir esta acción.!",
                    html: `<div class="table-responsive">
                            <table class="table table-sm text-nowrap">
                                <tr><td align="left"><b>Cliente:</b></td><td align="left">${@json($reserva->Nombre)}</td></tr>
                                <tr><td align="left"><b>Tarifa:</b></td><td align="left">${tarifa}</td></tr>
                                <tr><td style="text-align: left"><b>Fecha Salida:</b></td><td style="text-align: left; color:#135a99">${fSalida}</td></tr>
                                <tr><td style="text-align: left"><b>Descuento:</b></td><td style="text-align: right">${descuento_info} </td></tr>
                                <tr class="text-success"><td style="text-align: left"><b>Pago Recibido:</b></td><td style="text-align: right">${montoRecibido_info}</td></tr>
                                <tr class="text-danger"><td style="text-align: left"><b>${$('#text_f_value').val()}:</b></td><td style="text-align: right">${pagar_info}</td></tr>
                            </table></div>`,
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
                calcular_descuento();

            }


            calcular_descuento();
            function calcular_descuento() {

                const descuento = document.querySelector('#descuento');
                let val_adelanto = document.getElementById("montoRecibidoRen").value === '' ? 0 : document.getElementById("montoRecibidoRen").value;
                let val_descuento = document.getElementById("descuento").value === '' ? 0 : document.getElementById("descuento").value;
                document.getElementById("pagar").value = (parseFloat(document.getElementById("costo").value) - parseFloat(val_descuento) - parseFloat(val_adelanto)).toFixed(2);


                descuento.addEventListener("keyup", function(event) {
                    const val_descuento = event.target.value === '' ? 0 : event.target.value;
                    const val_adelanto = document.getElementById("montoRecibidoRen").value === '' ? 0 : document.getElementById(
                        "montoRecibidoRen").value;
                    document.getElementById("pagar").value = (parseFloat(document.getElementById("costo").value) -
                        parseFloat(val_descuento) - parseFloat(val_adelanto)).toFixed(2);


                }, false);
            }

            calcular_adelanto();
            function calcular_adelanto() {
                const adelanto = document.querySelector('#montoRecibidoRen');
                const val_adelanto = document.getElementById("montoRecibidoRen").value === '' ? 0 : document.getElementById("montoRecibidoRen").value;
                const val_descuento = document.getElementById("descuento").value === '' ? 0 : document.getElementById("descuento").value;
                var asignado = parseFloat(document.getElementById("costo").value) - parseFloat(val_descuento) - parseFloat(val_adelanto);
                if (asignado >= 0){
                    document.getElementById("pagar").value = (asignado).toFixed(2);
                    $('#text_f').html('A DEUDA');
                    $('#text_f_value').val('A DEUDA');
                }else{
                    // asignado = asignado * -1;
                    document.getElementById("pagar").value = (asignado * -1).toFixed(2);
                    $('#text_f').html('CAMBIO');
                    $('#text_f_value').val('CAMBIO');
                }


                adelanto.addEventListener("keyup", function(event) {
                    // const val_adelanto = event.target.value === '' ? 0 : event.target.value;
                    // const val_descuento = document.getElementById("descuento").value === '' ? 0 : document
                    //     .getElementById("descuento").value;
                    // var restante = parseFloat(document.getElementById("costo").value) -
                    //     parseFloat(val_adelanto) - parseFloat(val_descuento);
                    //     document.getElementById("pagar").value = (restante).toFixed(2);
                    calcular_descuento();
                }, false);

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
                document.getElementById("descuento").readOnly = false;
                document.getElementById("montoRecibidoRen").readOnly = false;

                 if (event.target.value === '4 HORAS') {
                    div.innerHTML = "Precio Seleccionado: " + preciosHab[0];
                    document.getElementById("Precio").value = preciosHab[0];
                    document.getElementById("fsalida").readOnly = true;
                    seccion_cantidad.style.display = "block";
                    var fecha = new Date(fSalidaR);
                    fecha.setHours(fecha.getHours() + 4)
                    document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(fecha
                        .getMinutes(), 2);

                } else if (event.target.value === 'TODA LA NOCHE') {
                    div.innerHTML = "Precio Seleccionado: " + preciosHab[1];
                    document.getElementById("Precio").value = preciosHab[1];
                    document.getElementById("fsalida").readOnly = false;
                    var fecha = new Date(fSalidaR);
                    fecha.setHours(fecha.getHours() + 24);
                    document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(fecha
                        .getMinutes(), 2);
                    seccion_cantidad.style.display = "none";
                } else if (event.target.value === 'POR MES') {
                    div.innerHTML = "Precio Seleccionado: " + preciosHab[2];
                    document.getElementById("Precio").value = preciosHab[2];
                    document.getElementById("fsalida").readOnly = false;
                    document.getElementById("fsalida").value = f_actual.addMonth(1);
                    seccion_cantidad.style.display = "block";
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
                calcular_adelanto();
                // calcular_descuento();
            })

            function bloque() {
                const cant2 = document.getElementById("cantida_m").value === '' ? 1 : parseInt(document.getElementById(
                    "cantida_m").value);
                document.getElementById("costo").value = document.getElementById("Precio").value * cant2;

                var habitacion = parseFloat(document.getElementById("costo").value);
                var adelant = document.getElementById("montoRecibidoRen").value === '' ? 0 : parseFloat(document.getElementById(
                    "montoRecibidoRen").value);
                var desc = document.getElementById("descuento").value === '' ? 0 : parseFloat(document.getElementById(
                    "descuento").value);
                document.getElementById("pagar").value = parseFloat(habitacion) - parseFloat(adelant) - parseFloat(desc);

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
