<?php date_default_timezone_set('America/Lima'); ?>
@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">
                        Editar datos del Registro
                    </span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div>
            </div>
        </div>
    </section>
    @php($r = 'reserva/listar-registro/' . $Reserva3->IdReserva . '/edit')
    {!! Form::open(['url' => $r, 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
    <div class="card">
        <div class="card-header bg-secondary">
            HABITACIÓN
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label>
                            <div class="titulo">N° HABITACIÓN </div>
                        </label>
                        <select class="form-control selectpicker searchText" name="searchText" id="Num_Hab" disabled>
                            <option value="">Seleccione una Habitación</option>
                            @foreach ($Habitacion as $hab)
                                @if ($searchText == $hab->Num_Hab)
                                    <option
                                        value="{{ $hab->Num_Hab }}_{{ $hab->tipoden }}_{{ $hab->precioHora }} | {{ $hab->precioHora6 }} | {{ $hab->precioHora8 }} | {{ $hab->precioNoche }} | {{ $hab->precioMes }}_{{ $hab->Estado }}_{{ $hab->deshab }}"
                                        selected>
                                        Habitación {{ $hab->Num_Hab }}</option>
                                @elseif($hab->Num_Hab == $Reserva3->Num_Hab)
                                    <option
                                        value="{{ $hab->Num_Hab }}_{{ $hab->tipoden }}_{{ $hab->precioHora }} | {{ $hab->precioHora6 }} | {{ $hab->precioHora8 }} | {{ $hab->precioNoche }} | {{ $hab->precioMes }}_{{ $hab->Estado }}_{{ $hab->deshab }}"
                                        selected>
                                        Habitación {{ $hab->Num_Hab }}</option>
                                @else
                                    <option
                                        value="{{ $hab->Num_Hab }}_{{ $hab->tipoden }}_{{ $hab->precioHora }} | {{ $hab->precioHora6 }} | {{ $hab->precioHora8 }} | {{ $hab->precioNoche }} | {{ $hab->precioMes }}_{{ $hab->Estado }}_{{ $hab->deshab }}">
                                        Habitación {{ $hab->Num_Hab }}</option>
                                @endif
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">

                    <label>
                        <div class="titulo">TIPO </div>
                    </label>
                    <input type="text" value="" id="Tipo_habitacion" class="form-control" disabled>

                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <label>
                        <div class="titulo">PRECIO (PH|PN|PM) </div>
                    </label>
                    {{-- <div id="precioSeleccionado"></div> --}}
                    <input type="text" id="preciosHab" class="form-control" disabled>
                    <input type="hidden" id="Precio" class="form-control">
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <label>
                        <div class="titulo">DESCRIPCIÓN </div>
                    </label>
                    <input type="text" value="" id="Descripcion" class="form-control" disabled>
                </div>
                <input type="hidden" value="" id="Estado_Hab" disabled>
                {{-- <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                    <button type="submit" class="btn btn-primary" id="btnbuscar">Buscar</button>
                </div> --}}
                @if (count($reserva) > 0)
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <p style="font-size:20px;"><b>Registros Activos</b></p>
                            @php($nro = 0)
                            <table class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                    <th>Nro </th>
                                    <th>Fecha Reserva</th>
                                    <th>Fecha Salida</th>
                                    <th>Estado</th>
                                </thead>
                                @foreach ($reserva as $re)
                                    <tr>
                                        <td>{{ $nro += 1 }}</td>
                                        <td>{{ date_format(new DateTime($re->FechReserva), 'd/m/Y') }}</td>
                                        <td>{{ date_format(new DateTime($re->FechSalida), 'd/m/Y') }}</td>
                                        @if ($re->Estado == 'HOSPEDAR')
                                            <td class="label label-danger">HOSPEDADO</td>
                                        @elseif($re->Estado == 'RESERVAR')
                                            <td class="label label-info">RESERVADO</td>
                                        @else
                                            <td>{{ $re->Estado }}</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{ Form::close() }}
    @include('reserva.registro.modal')
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
    {!! Form::model($Reserva3, ['method' => 'PATCH', 'route' => ['listar-registro.update', str_pad($Reserva3->IdReserva, 10, '0', STR_PAD_LEFT)]]) !!}
    {{ Form::token() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <span for="">CLIENTE</span>
                        <div class="input-group">
                            <table style="width: 100%">
                                <tr>
                                    <td colspan="2">
                                        <select name="IdCliente" class="form-control selectpicker" id="IdCliente"
                                            data-live-search="true">
                                            @foreach ($Cliente as $c)
                                                @if ($c->IdCliente == $Reserva3->IdCliente)
                                                    <option value="{{ $c->IdCliente }}_{{ $c->Nombre }}" selected="">
                                                        {{ $c->NumDocumento }} |
                                                        {{ $c->Nombre }} {{ $c->Apellido }}
                                                    </option>
                                                @else
                                                    <option value="{{ $c->IdCliente }}_{{ $c->Nombre }}">
                                                        {{ $c->NumDocumento }} | {{ $c->Nombre }}
                                                        {{ $c->Apellido }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <a href="" data-target="#modal-add" style="float: right;" data-toggle="modal"
                                            class="btn btn-success bg-teal">
                                            <i class="fa fa-user-plus" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- </div>
    <div class="row"> --}}
                <!-- Para el autoincrementable -->
                @if (isset($Reserva2))
                    <input type="hidden" name="codigo" value="{{ $Reserva2->IdReserva }}">
                @else
                    <input type="hidden" name="codigo" value="0">
                @endif
                <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <span for="">TIPO DE REGISTRO</span>
                        @if ($Reserva3->Estado == 'RESERVAR')
                            <select name="Estado" class="form-control selectpicker" id="Estado">
                                @if ($Reserva3->Estado == 'RESERVAR')
                                    <option value="HOSPEDAR">HOSPEDAR</option>
                                    <option value="RESERVAR" selected>RESERVAR</option>
                                @else
                                    <option value="HOSPEDAR" selected>HOSPEDAR</option>
                                    <option value="RESERVAR">RESERVAR</option>
                                @endif

                            </select>
                        @else
                            <select disabled="true" class="form-control" id="Estado">
                                @if ($Reserva3->Estado == 'RESERVAR')
                                    <option value="HOSPEDAR">HOSPEDAR</option>
                                    <option value="RESERVAR" selected>RESERVAR</option>
                                @else
                                    <option value="HOSPEDAR" selected>HOSPEDAR</option>
                                    <option value="RESERVAR">RESERVAR</option>
                                @endif
                            </select>
                            <input type="hidden" class="form-control" value="{{ $Reserva3->Estado }}" readonly
                                name="Estado">
                        @endif
                    </div>
                </div>
                @php($servicio = ['4 HORAS', '6 HORAS', '8 HORAS', 'TODA LA NOCHE', 'POR MES'])
                <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <span for="">SERVICIO</span>
                        <select name="servicio" id="servicio" class="form-control" required>
                            <option value="" hidden selected>Seleccionar</option>
                            @foreach ($servicio as $item)
                                @if ($Reserva3->servicio == $item)
                                    <option value="{{ $item }}" selected>{{ $item }}</option>
                                @else
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <span for="" id="Entrada">FECHA ENTRADA </span>
                        <span for="" id="Reserva" style="display:none;">FECHA RESERVA </span>
                        <input type="date" min="<?php echo date('Y-m-d', strtotime(date('Y-m-d') . ' -0 day')); ?>" id="freserva" name="FechReserva"
                            value="{{ $Reserva3->FechReserva }}" @if ($Reserva3->Estado == 'HOSPEDAR') readonly @endif
                            class="form-control">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12" id="seccion_cantidad"
                    style="display: {{ $Reserva3->servicio != 'POR MES' ? 'none' : 'block' }}">
                    <div class="form-group">
                        <span for="" id="Entrada">CANT.</span>
                        <div class="input-group">
                            <input type="text" class="form-control" id="cantida_m" name="cantida_m" min="1"
                                value="{{ $Reserva3->cantMes }}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <span for="">FECHA SALIDA</span>
                        <input type="date" name="FechSalida" id="fsalida" value="{{ $Reserva3->FechSalida }}"
                            class="form-control">
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <span for="">HORA SALIDA</span>
                        <input type="time" name="horaSalida" id="horaSalida" class="form-control"
                            value="{{ $Reserva3->horaSalida }}" required>
                    </div>
                </div>
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
        <div class="card-header bg-secondary">PAGO</div>
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
                <div class="col-lg-2 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <span for="">DESCUENTO</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white text-muted" style="display: grid;">
                                    <div class="text-left font-medium">$</div>
                                </span>
                            </div>
                            <input type="text" id="Descuento" name="Descuento" placeholder="Monto a Descontar"
                                value="{{ $Reserva3->descuento }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <span for="">PAGO RECIBIDO</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white text-muted" style="display: grid;">
                                    <div class="text-left font-medium">$</div>
                                </span>
                            </div>
                            <input type="text" id="Adelanto" name="Adelanto" placeholder="Dinero dejado"
                                value="{{ $Pago->TotalPago == 0 ? 0.0 : $Pago->TotalPago }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <span for="">VALOR TOTAL</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white text-muted" style="display: grid;">
                                    <div class="text-left font-medium">$</div>
                                </span>
                            </div>
                            <input type="text" id="costo" name="CostoAlojamiento" readonly class="form-control"
                                value="{{ $Reserva3->CostoAlojamiento }}">
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-2">
                    <div class="form-group">
                        <span for="" title="VALOR SERVICIO">VALOR SERVICIO</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white text-muted" style="display: grid;">
                                    <div class="text-left font-medium">$</div>
                                </span>
                            </div>
                            <input type="text" id="valorServicio" name="valorServicio" value="0.00" readonly
                                class="form-control">
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-2 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <span for="" class="text-danger">A DEUDA</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white text-muted" style="display: grid;">
                                    <div class="text-left font-medium">$</div>
                                </span>
                            </div>
                            <input type="text" id="pagar" name="pagar" readonly class="form-control text-danger"
                                value="{{ number_format($Reserva3->CostoAlojamiento - $Pago->TotalPago - $Reserva3->descuento, 2) }}">
                        </div>
                    </div>
                </div>
                <input type="hidden" value="" id="Num" name="Num_Hab">
                <input type="hidden" value="{{ $Pago->IdPago }}" name="IdPago">
                <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        <span for="">OBSERVACIONES</span>
                        <textarea name="Observacion" placeholder="Indique aqui alguna observación que tenga la reserva/hospedaje."
                            class="form-control">{{ $Reserva3->Observacion }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <a href="{{ asset('reserva/listar-registro') }}" class="btn btn-danger mr-2">Volver Atras</a>
        <div id="agregar_final" style="display: none">
            <a href="#" class="btn btn-primary agregar_o" style="float: right;">Actualizar</a>
            <button class="btn btn-primary agregar" style="float:right; display: none" type="submit">.</button>
        </div>
    </div>

    {!! Form::close() !!}
    @push('scripts')
        <script>
            dHabitacion = document.getElementById('Num_Hab').value.split('_');
            $("#Num").val(dHabitacion[0]);
            $("#Tipo_habitacion").val(dHabitacion[1]);
            $("#preciosHab").val(dHabitacion[2]);
            $("#Estado_Hab").val(dHabitacion[3]);
            $("#Descripcion").val(dHabitacion[4]);

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
            // window.onload = updateValue;

            // document.getElementById("btnbuscar").style.display = "none";
            const input = document.querySelector('#fsalida');
            const input2 = document.querySelector('#freserva');

            input.addEventListener('change', updateValue);
            input2.addEventListener('change', updateValue);

            function updateValue(e) {
                // Calculamos la diferencia en dias
                fecha1 = document.getElementById("freserva").value;
                fecha2 = document.getElementById("fsalida").value;
                if (document.getElementById("servicio").value == 'TODA LA NOCHE') {
                    var fechaInicio = new Date(fecha1).getTime();
                    var fechaFin = new Date(fecha2).getTime();
                    var dia = (fechaFin - fechaInicio) / (1000 * 60 * 60 * 24);
                    // Calculamos el total a pagar
                    precio = document.getElementById("Precio").value;
                    var n = dia * precio;
                    document.getElementById("costo").value = n.toFixed(2);
                } else {
                    document.getElementById("costo").value = document.getElementById("Precio").value;
                }
                sumarDias(fecha1, fecha2);
                calcular_descuento();
            }

            // Revervar/Hospedar
            const selectElement = document.querySelector('#Estado');
            var Reserva = document.getElementById("Reserva");
            var Entrada = document.getElementById("Entrada");



            selectElement.addEventListener('change', (event) => {


                if (event.target.value == 'RESERVAR') {
                    Entrada.style.display = "none";
                    Reserva.style.display = "block";
                    $("#freserva").removeAttr("readOnly");

                } else {
                    Reserva.style.display = "none";
                    Entrada.style.display = "block";
                    $("#freserva").attr("readonly", "readonly");
                    var f = new Date();
                    document.getElementById("freserva").value = f.getFullYear() + "-" +
                        ("0" + (f.getMonth() + 1)).slice(-2) + "-" + ("0" + (f.getDate())).slice(-2);
                }
                fecha1 = document.getElementById("freserva").value;
                fecha2 = document.getElementById("fsalida").value;
                sumarDias(fecha1, fecha2);

            });
            calcular_descuento();

            function calcular_descuento() {
                const descuento = document.querySelector('#Descuento');
                const val_adelanto = document.getElementById("Adelanto").value === '' ? 0 : document.getElementById("Adelanto")
                    .value;
                const val_descuento = document.getElementById("Descuento").value === '' ? 0 : document.getElementById(
                    "Descuento").value;
                document.getElementById("pagar").value = (parseFloat(document.getElementById("costo").value) - parseFloat(val_descuento) - parseFloat(
                    val_adelanto)).toFixed(2);
                evaluar_b();
                descuento.addEventListener("keyup", function(event) {
                    const val_descuento = event.target.value === '' ? 0 : event.target.value;
                    const val_adelanto = document.getElementById("Adelanto").value === '' ? 0 : document.getElementById(
                        "Adelanto").value;
                    document.getElementById("pagar").value = (parseFloat(document.getElementById("costo").value) +
                        parseFloat(document.getElementById("valorServicio").value) -
                        parseFloat(val_descuento) - parseFloat(val_adelanto)).toFixed(2);
                    evaluar_b();


                }, false);
            }

            function evaluar_b() {
                if (document.getElementById("Precio").value !== '') {
                    if (document.getElementById("pagar").value === '0' || document.getElementById("pagar").value === '0.00') {
                        document.getElementById("agregar_final").style.display = "block";
                    } else {
                        document.getElementById("agregar_final").style.display = "none";
                    }
                }
            }

            calcular_adelanto();

            function calcular_adelanto() {
                const adelanto = document.querySelector('#Adelanto');
                document.getElementById("pagar").value = (parseFloat(document.getElementById("costo").value) -
                    parseFloat(document.getElementById("Descuento").value) - parseFloat(document.getElementById("Adelanto")
                        .value)).toFixed(2);
                evaluar_b();
                adelanto.addEventListener("keyup", function(event) {
                    const val_adelanto = event.target.value === '' ? 0 : event.target.value;
                    const val_descuento = document.getElementById("Descuento").value === '' ? 0 : document
                        .getElementById("Descuento").value;
                    document.getElementById("pagar").value = (parseFloat(document.getElementById("costo").value) -
                        parseFloat(val_adelanto) - parseFloat(val_descuento)).toFixed(2);
                    evaluar_b();
                }, false);
            }
        </script>
        <script>
            const servicio = document.querySelector('#servicio');
            var preciosHab = document.getElementById('preciosHab').value.split(' | ');

            // let div = document.getElementById("precioSeleccionado");
            const f_actual = new Date(document.getElementById("freserva").value);
            fechaActual = f_actual.addDays(1);
            var seccion_cantidad = document.getElementById("seccion_cantidad");

            servicio.addEventListener('change', (event) => {
                document.getElementById("Descuento").readOnly = false;
                document.getElementById("Adelanto").readOnly = false;

                if (event.target.value === '4 HORAS') {
                    // div.innerHTML = preciosHab[0];
                    document.getElementById("Precio").value = preciosHab[0];
                    document.getElementById("fsalida").value = fechaActual;
                    document.getElementById("fsalida").readOnly = true;
                    seccion_cantidad.style.display = "none";
                    var fecha = new Date();
                    fecha.setHours(fecha.getHours() + 4)
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(fecha
                        .getMinutes(), 2);
                } else if (event.target.value === '6 HORAS') {
                    document.getElementById("Precio").value = preciosHab[1];
                    document.getElementById("fsalida").value = fechaActual;
                    document.getElementById("fsalida").readOnly = true;
                    seccion_cantidad.style.display = "none";
                    var fecha = new Date();
                    fecha.setHours(fecha.getHours() + 6)
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(fecha
                        .getMinutes(), 2);
                } else if (event.target.value === '8 HORAS') {
                    document.getElementById("Precio").value = preciosHab[2];
                    document.getElementById("fsalida").value = fechaActual;
                    document.getElementById("fsalida").readOnly = true;
                    seccion_cantidad.style.display = "none";
                    var fecha = new Date();
                    fecha.setHours(fecha.getHours() + 8)
                    document.getElementById('horaSalida').value = zeroFill(fecha.getHours(), 2) + ':' + zeroFill(fecha
                        .getMinutes(), 2);
                } else if (event.target.value === 'TODA LA NOCHE') {
                    // div.innerHTML = preciosHab[1];
                    document.getElementById("Precio").value = preciosHab[3];
                    document.getElementById("fsalida").readOnly = false;
                    // document.getElementById("fsalida").value = f_actual.addDays(2);
                    seccion_cantidad.style.display = "none";
                    document.getElementById('horaSalida').value = "12:00";
                } else if (event.target.value === 'POR MES') {
                    // div.innerHTML = preciosHab[2];
                    document.getElementById("Precio").value = preciosHab[4];
                    document.getElementById("fsalida").readOnly = false;
                    document.getElementById("fsalida").value = f_actual.addMonth(1);
                    seccion_cantidad.style.display = "block";
                    document.getElementById('horaSalida').value = "12:00";
                }
                document.getElementById("cantida_m").value = 1;
                updateValue();
            });
            const cantida_m = document.querySelector('#cantida_m');
            addEventListener("keyup", function(event) {
                if (document.getElementById("cantida_m").value > 0) {
                    // console.log(parseInt(document.getElementById("cantida_m").value));
                    if (document.getElementById("servicio").value == 'POR MES') {
                        document.getElementById("fsalida").value = f_actual.addMonth(parseInt(document.getElementById(
                            "cantida_m").value));
                        bloque();
                    }
                } else {
                    if (document.getElementById("servicio").value == 'POR MES') {
                        document.getElementById("fsalida").value = f_actual.addMonth(1);
                    }

                    document.getElementById("costo").value = document.getElementById("Precio").value * 1;

                }
                // calcular_adelanto();
            })

            function bloque() {
                document.getElementById("costo").value = document.getElementById("Precio").value * parseInt(document
                    .getElementById("cantida_m").value);

                var habitacion = parseFloat(document.getElementById("costo").value);
                var adelant = document.getElementById("Adelanto").value === '' ? 0 : parseFloat(document.getElementById(
                    "Adelanto").value);
                var desc = document.getElementById("Descuento").value === '' ? 0 : parseFloat(document.getElementById(
                    "Descuento").value);
                document.getElementById("pagar").value = parseFloat(habitacion - desc - adelant);


            }
        </script>



        <script>
            // Función para sumar fechas
            function sumarDias(fecha_Inicial, fecha_Final) {
                // var data = <?php echo json_encode($reserva); ?>;
                var data = @json($reserva);
                var fecha_Inicial = new Date(fecha_Inicial);
                var fecha_Final = new Date(fecha_Final);
                var h = fecha_Final - fecha_Inicial;
                var d = h / (1000 * 60 * 60 * 24);
                var finicial = new Date(fecha_Inicial);

                var agregar = document.getElementById("agregar_final");
                var error_fecha = document.getElementById("error_fecha");
                for (var i = 0; i <= d; i++) {
                    var add = finicial.getDate() + 1;
                    finicial.setDate();
                    var fecha = finicial.getFullYear() + "-" + (finicial.getMonth() + 1) + "-" + ("0" + (finicial.getDate()))
                        .slice(-2);
                    var aux = "";
                    for (x of data) {

                        if (fecha === x.FechReserva || fecha === x.FechSalida) {
                            aux = "1";
                            break;
                        }
                    }
                    if (aux === '1') {
                        error_fecha.innerHTML =
                            '<li>Verifique que el rango de las Fechas no interfiera con algún registro Activo.</li>';
                        error_fecha.style.padding = "15px";
                        agregar.style.display = "none";

                        break;
                    } else {
                        error_fecha.innerHTML = '';
                        agregar.style.display = "block";
                        error_fecha.style.padding = "0px";
                    }
                }
                var serv = document.getElementById("servicio").value;
                if (fecha_Inicial >= fecha_Final && serv != 'POR HORAS') {
                    error_fecha.innerHTML = '<li>La fecha inicial no debe ser mayor o igual que la fecha final.</li>';
                    error_fecha.style.padding = "15px";
                    agregar.style.display = "none";
                }

            }
        </script>


        @if (Session::has('success'))
            <script>
                toastr.success('{{ Session::get('success') }}', 'Operación Correcta', {
                    "positionClass": "toast-top-right"
                })
            </script>
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
                calcular_descuento();
                $("#fila" + index).remove();
                // evaluar();
            }
        </script>


        <script>
            $('#Descuento').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });
        </script>
        <script>
            $('#Adelanto').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });
        </script>
        <script>
            $('#costo').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });
        </script>
        <script>
            $('.agregar_o').unbind().click(function() {
                // var $button = $(this);
                // var importe = document.getElementById('montoCierre').value;
                if (document.getElementById('servicio').value === '') {
                    $(".agregar").click();
                } else if (document.getElementById('pagar').value < 0) {
                    toastr.error('Revise que el valor de la deuda no sea negativo.',
                        'Error con el registro de valores.', {
                            "positionClass": "toast-bottom-right",
                            "closeButton": true
                        })
                } else {
                    if (document.getElementById('Estado').value === 'HOSPEDAR') {
                        var h_Actual = new Date().toLocaleTimeString();
                    } else {
                        var h_Actual = '';
                    }
                    Swal.fire({
                        // title: 'Necesitamos de tu Confirmación',
                        showDenyButton: true,
                        customClass: 'swal-wide',
                        allowOutsideClick: false,
                        confirmButtonColor: '#36BE80',
                        html: '<table class="table text-nowrap"><tr><td align="left">Tipo Registro</td><td align="left">' +
                            document.getElementById('Estado').value + '</td></tr>' +
                            '<tr><td align="left">Huesped</td><td align="left">' + document.getElementById(
                                'IdCliente').value.split('_')[1] +
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
                            '<tr class="text-danger"><td align="left">Deuda</td><td align="right">$ ' +
                            document.getElementById('pagar').value +
                            '</td></tr></table>' +
                            '<span style="color: #36BE80; font-weight: bold">¿Está Usted de Acuerdo?</span>',
                        confirmButtonText: `Sí, Adelante!`,
                        denyButtonText: `Cancelar`,
                        icon: 'info',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(".agregar").click();
                        }
                    })
                    return false;
                }
            });
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
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'error',
                    title: '{{ Session::get('error') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif
    @endpush
@endsection
