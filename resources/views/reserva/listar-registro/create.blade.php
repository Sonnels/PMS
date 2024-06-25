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
                            <span class="text-gray-dark">PRECIO: </span><span> {{ $Habitacion->precioHora }} |
                                {{-- {{ $Habitacion->precioHora6 }} | {{ $Habitacion->precioHora8 }} | --}}
                                {{ $Habitacion->precioNoche }} | {{ $Habitacion->precioMes }}</span>
                            {{-- S/ {{ $Habitacion->Precio }} --}}
                            <div id="precioSeleccionado"></div>
                            <input type="hidden" id="Precio" value="">
                            <input type="hidden" id="preciosHab"
                                value="{{ $Habitacion->precioHora }}_{{ $Habitacion->precioNoche }}_{{ $Habitacion->precioMes }}">
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
                            <span style="font-weight: bold">F. Entrada:</span>
                            {{ date('H:i:s d/m/Y', strtotime($apartar->fecIn)) }} <br>
                            <span style="font-weight: bold">F. Salida:</span>
                            {{ date('H:i:s d/m/Y', strtotime($apartar->fecOut)) }}
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
    @include('reserva.registro.cliente_modal')
    <form id="form1" method="POST" action="{{ route('listar-registro.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <span for="">CLIENTE</span>
                    <table style="width: 100%">
                        <tr>
                            <td colspan="2">
                                <div id="selectCliente">
                                </div>
                                <span id="IdCliente-error" class="text-danger"></span>
                            </td>
                            <td style=" width: 2%;">
                                <a href="" data-target="#modal-add" style="float: right;" data-toggle="modal"
                                    class="btn btn-success">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <input type="hidden" id="Estado" name="Estado" value="HOSPEDAR">
            <input type="hidden" name="idApartar" value="{{ $apartar->idApartar }}">
            @php($servicio = ['4 HORAS', 'TODA LA NOCHE', 'POR MES'])
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
                    <span id="FechSalida-error" class="text-danger"></span>
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
                                        <div class="text-left font-medium">{{ $datos_hotel->simboloMoneda }}</div>
                                    </span>
                                </div>
                                <input type="text" id="Descuento" name="Descuento"
                                    value="{{ old('Descuento', 0) }}"
                                    placeholder="Monto a Descontar" class="form-control" readonly>

                            </div>
                            <span id="Descuento-error" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <span for="">PAGO RECIBIDO</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted" style="display: grid;">
                                        <div class="text-left font-medium">{{ $datos_hotel->simboloMoneda }}</div>
                                    </span>
                                </div>
                                <input type="text" id="Adelanto" name="Adelanto"
                                    value="{{ old('Adelanto') }}"
                                    class="form-control" placeholder="Dinero dejado" readonly>
                            </div>
                            <span id="Adelanto-error" class="text-danger"></span>
                        </div>

                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="hidden" name="Num_Hab" value="{{ $Habitacion->Num_Hab }}">
                            <span for="" title="VALOR HABITACIÓN">TOTAL</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted" style="display: grid;">
                                        <div class="text-left font-medium">{{ $datos_hotel->simboloMoneda }}</div>
                                    </span>
                                </div>
                                <input type="text" id="costo" name="CostoAlojamiento" value="0.00" readonly
                                    class="form-control">
                            </div>
                            <span id="CostoAlojamiento-error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="col-md-2" style="display: none">
                        <div class="form-group">
                            <span for="" title="VALOR SERVICIO">VALOR SERVICIO</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted">
                                        <div class="text-left font-medium">{{ $datos_hotel->simboloMoneda }}</div>
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
                                        <div class="text-left font-medium">{{ $datos_hotel->simboloMoneda }}</div>
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
                            <span id="Observacion-error" class="text-danger"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" id="card-familiar">
            <div class="card-header bg-secondary pb-2 pt-2">
                <h3 class="card-title">REGISTRAR HUÉSPED ADICIONAL</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="">Huésped Adicional</label>
                            <div id="selectHuespedAdicional">
                            </div>
                        </div>
                        <span class="btn btn-info btn-sm" id="bt_add">Agregar</span>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="table-responsive">
                            <table class="table table-sm" id="familiar">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Nombre</th>
                                        <th>N° documento</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12 col-sm-6 col-md-6 col-xs-6 text-center">
                <div class="form-group">
                    <a href="{{ asset('reserva/registro') }}" class="btn btn-danger">Volver </a>
                    <button class="btn btn-primary agregar" type="submit" id="enviarRegistro">Registrar</button>
                </div>
            </div>
        </div>
    </form>
    {{-- {!! Form::close() !!} --}}

    @push('scripts')
        {{-- Para el N° de documento --}}
        <script>
            const selectCliente = document.getElementById('selectCliente');
            const selectHuespedAdicional = document.getElementById('selectHuespedAdicional');

            function obtenerClientes(idCliente = '') {
                let ruta = '{{ route('obtenerClientes') }}';
                ruta = ruta + `?IdCliente=${idCliente}`;
                fetch(ruta)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            selectCliente.innerHTML = data.select;
                            selectHuespedAdicional.innerHTML = data.select3;
                            $('#IdCliente').selectpicker('refresh');
                            $('#idHuespedAdicional').selectpicker('refresh');
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener los clientes:', error);
                    });
            }
            obtenerClientes(@json($apartar->IdCliente));

            function limpiaValidacionCliente() {
                document.getElementById('idTipDoc-error').innerHTML = "";
                document.getElementById('NumDocumento-error').innerHTML = "";
                document.getElementById('Nombre-error').innerHTML = "";
                document.getElementById('Correo-error').innerHTML = "";
                document.getElementById('Celular-error').innerHTML = "";
                document.getElementById('Direccion-error').innerHTML = "";
                document.getElementById('nroMatricula-error').innerHTML = "";
            }

            function limpiarValorCliente() {
                document.getElementById('idTipDoc').value = "";
                document.getElementById('NumDocumento').value = "";
                document.getElementById('Nombre').value = "";
                document.getElementById('Correo').value = "";
                document.getElementById('Celular').value = "";
                document.getElementById('Direccion').value = "";
                document.getElementById('nroMatricula').value = "";
            }

            let inputNombre = document.getElementById('Nombre');
            inputNombre.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });

            document.querySelector('#formCliente').addEventListener('submit', function(e) {
                let form = this;
                let fd = new FormData(form);
                e.preventDefault();
                let myButton = document.getElementById('enviarCliente');
                myButton.disabled = true;
                myButton.style.opacity = 0.7;
                myButton.textContent = 'Procesando ...';

                // Realizar la solicitud AJAX
                fetch("{{ route('guardarCliente') }}", {
                        method: 'POST',
                        body: fd,
                    })
                    .then(response => response.json())
                    .then(data => {
                        limpiaValidacionCliente();
                        if (data.success) {
                            limpiarValorCliente();
                            obtenerClientes(data.idCliente);
                            Snackbar.show({
                                text: 'Cliente guardado exitosamente',
                                actionText: 'CERRAR',
                                pos: 'bottom-right',
                                actionTextColor: '#27AE60',
                                duration: 6000
                            });
                            $('#modal-add').modal('hide');
                            myButton.disabled = false;
                            myButton.style.opacity = 1;
                            myButton.textContent = 'Guardar';
                        } else {
                            data.errors.forEach(error => {
                                document.getElementById(error.field + '-error').innerHTML = error.message;
                            });
                            myButton.disabled = false;
                            myButton.style.opacity = 1;
                            myButton.textContent = 'Guardar';
                        }

                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });


            let cont = 0;
            const elementos = [];
            document.getElementById("bt_add").onclick = function() {
                agregar()
            };

            function agregar() {
                let persona = document.getElementById('idHuespedAdicional').value.split('_');
                let idcliente = persona[0];
                let nombre = persona[1];
                let nro_documento = persona[2];
                // let nacionalidad = persona[3];
                // let profesion = persona[4];

                if (idcliente != "") {
                    if (evaluar_duplicidad(idcliente)) {
                        let fila = `<tr class="selected" id="fila${cont}">
                            <td><button type="button" class="btn btn-default btn-sm" onclick="eliminar('${cont},${idcliente}')"><i class="fas fa-trash-alt text-danger"></i></button></td>
                            <td><input type="hidden" name="persona[]" value="${idcliente}">${nombre}</td>
                            <td>${nro_documento}</td>
                            </tr>`;
                        cont++;
                        limpiar();
                        $('#familiar').append(fila);
                    } else {
                        alert('La persona seleccionada ya se encuentra en la lista.');
                    }
                } else {
                    alert('Es necesario seleccionar una persona.')
                }
            }

            function evaluar_duplicidad(value) {
                if (elementos.indexOf(value) === -1) {
                    elementos.push(value);
                    return true;
                }
                return false;
            }

            function limpiar() {
                document.getElementById('idHuespedAdicional').value = "";
                $('#idHuespedAdicional').selectpicker('refresh');
            }

            function eliminar(index, id) {
                var myIndex = elementos.indexOf(String(id));
                if (myIndex !== -1) {
                    elementos.splice(myIndex, 1);
                }
                cont--;
                $("#fila" + index).remove();
            }
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
           function limpiaValidacionRegistro() {
                document.getElementById('FechSalida-error').innerHTML = "";
                document.getElementById('CostoAlojamiento-error').innerHTML = "";
                document.getElementById('Observacion-error').innerHTML = "";
                document.getElementById('IdCliente-error').innerHTML = "";
                document.getElementById('Adelanto-error').innerHTML = "";
                document.getElementById('Descuento-error').innerHTML = "";
            }

            document.querySelector('#form1').addEventListener('submit', function(e) {
                var form = this;

                e.preventDefault(); // <--- prevent form from submitting

                var h_Actual = new Date().toLocaleTimeString();
                let simboloMoneda = @json($datos_hotel->simboloMoneda);
                let selectCliente = document.getElementById('IdCliente');
                let cliente = (selectCliente.options[selectCliente.selectedIndex].text).split('|');
                Swal.fire({
                    // title: 'Necesitamos de tu Confirmación',
                    showDenyButton: true,
                    // customClass: 'swal-wide',
                    allowOutsideClick: false,
                    // confirmButtonColor: '#36BE80',
                    html: '<div class="table-responsive">' +
                        '<table class="table table-sm text-nowrap">' +
                        '<tr><td align="left"><b>Cliente:</b></td><td align="left">' + cliente[1] +
                        '<tr><td align="left"><b>Tarifa:</b></td><td align="left">' + document.getElementById(
                            'servicio').value + '</td></tr>' +
                        '<tr><td align="left"><b>Fecha Entrada:</b></td><td align="left">' + h_Actual + ' ' +
                        document.getElementById('freserva').value + '</td></tr>' +
                        '<tr><td align="left"><b>Fecha Salida:</b></td><td align="left">' + document
                        .getElementById('horaSalida').value + ' ' + document.getElementById('fsalida')
                        .value + '</td></tr>' +
                        '<tr><td align="left"><b>Descuento:</b></td><td align="right">' + simboloMoneda + ' ' +
                        document
                        .getElementById('Descuento').value + '</td></tr>' +
                        '<tr class="text-success"><td align="left"><b>Pago Recibido:</b></td><td align="right">' +
                        simboloMoneda + ' ' +
                        document.getElementById('Adelanto').value + '</td></tr>' +
                        '<tr class="text-danger"><td align="left"><b>' + $('#text_f_value').val() +
                        ':</b></td><td align="right">' + simboloMoneda + ' ' +
                        document.getElementById('pagar').value +
                        '</td></tr></table></div>' +
                        '<span style="font-weight: bold">¿Está Usted de Acuerdo?</span>',
                    confirmButtonText: `Sí, Adelante!`,
                    denyButtonText: `Cancelar`,
                    icon: 'info',
                }).then((result) => {
                    if (result.isConfirmed) {
                        const myButton = document.getElementById('enviarRegistro');
                        myButton.disabled = true;
                        myButton.style.opacity = 0.7;
                        myButton.textContent = 'Procesando ...';
                        // ---------------------------------------
                        let fd = new FormData(form);
                        // Realizar la solicitud AJAX
                        fetch("{{ route('listar-registro.store') }}", {
                                method: 'POST',
                                body: fd,
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    localStorage.setItem('mensaje', data.message);
                                    window.location.href = data.redireccionar;
                                } else {
                                    limpiaValidacionRegistro();
                                    if (Array.isArray(data.errors)) {
                                        data.errors.forEach(error => {
                                            document.getElementById(error.field + '-error')
                                                .innerHTML = error
                                                .message;
                                        });
                                    } else {
                                        alert(data.message);
                                    }
                                    myButton.disabled = false;
                                    myButton.style.opacity = 1;
                                    myButton.textContent = 'Guardar';
                                }

                            })
                            .catch(error => {
                                console.error('Error:', error);
                                myButton.disabled = false;
                                myButton.style.opacity = 1;
                                myButton.textContent = 'Guardar';
                            });
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
                if (fecha_Inicial >= fecha_Final && (serv != '4 HORAS' && serv != '6 HORAS' && serv != '8 HORAS')) {
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

            if (event.target.value === '4 HORAS') {
                div.innerHTML = "Precio Seleccionado: " + preciosHab[0];
                document.getElementById("Precio").value = preciosHab[0];
                document.getElementById("fsalida").readOnly = true;
                seccion_cantidad.style.display = "block";
                var fecha = new Date();
                fecha.setHours(fecha.getHours() + 4)
                document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(fecha
                    .getMinutes(), 2);
            } else if (event.target.value === 'TODA LA NOCHE') {
                div.innerHTML = "Precio Seleccionado: " + preciosHab[1];
                document.getElementById("Precio").value = preciosHab[1];
                document.getElementById("fsalida").readOnly = false;
                document.getElementById("fsalida").value = f_actual.addDays(2);
                seccion_cantidad.style.display = "none";
                document.getElementById('horaSalida').value = "12:00";
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
                } else if (document.getElementById("servicio").value == '4 HORAS') {
                    var fecha = new Date();
                    const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                    fecha.setHours(fecha.getHours() + (4 * cantidad_m));
                    document.getElementById("fsalida").value = moment(fecha).format("YYYY-MM-DD");
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(
                        fecha.getMinutes(), 2);
                } else if (document.getElementById("servicio").value == '6 HORAS') {
                    var fecha = new Date();
                    const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                    fecha.setHours(fecha.getHours() + (6 * cantidad_m));
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
                } else if (document.getElementById("servicio").value == '6 HORAS') {
                    var fecha = new Date();
                    const cantidad_m = parseInt(document.getElementById("cantida_m").value);
                    fecha.setHours(fecha.getHours() + 6);
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
