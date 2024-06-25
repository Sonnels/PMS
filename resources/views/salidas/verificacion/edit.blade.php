<?php use App\Http\Controllers\SalidaController; ?>
@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <span class="title_header">
                        Estado de Habitación N°: <font class="text-dark">{{ $reserva->Num_Hab }} - {{ $reserva->Denominacion }}</font>
                        | Cliente: <font class="text-dark">{{ $reserva->Ndcliente }} - {{ $reserva->nomcli }}</font>
                     </span><br>

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
    {{-- {!! Form::model($reserva, ['method' => 'PATCH', 'route' => ['verificacion.update', $reserva->IdReserva]]) !!}
    {{ Form::token() }} --}}
    <form action="{{ route('verificacion.update', $reserva->IdReserva) }}" method="post" id="form1">
        @csrf
        {{ method_field('PUT') }}
        <div class="row">
            <div class="form-group">
                <input type="hidden" name="IdCliente" class="form-control" value="{{ $reserva->IdCliente }}">
            </div>

            <div class="form-group">
                <input type="hidden" name="Estado" class="form-control" value="H. CULMINADO">
            </div>
            <div class="form-group">
                <input type="hidden" name="IdPago" class="form-control" value="{{ $reserva->IdPago }}">
            </div>
            <div class="form-group">
                <input type="hidden" name="Num_Hab" class="form-control" value="{{ $reserva->Num_Hab }}">
            </div>

            {{-- <div class="col-lg-3 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <span for="proveedor" class="text-success">CLIENTE</span>
                    <p>{{ $reserva->Ndcliente }} | {{ $reserva->nomcli }} </p>
                </div>
            </div> --}}

            {{-- <div class="col-lg-2 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <span for="Num_Hab" class="text-success">HABITACIÓN</span>
                    <p>{{ $reserva->Num_Hab }} - {{ $reserva->Denominacion }}</p>
                </div>
            </div> --}}
            <div class="col-lg-2 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    {{-- <span for="Precioxdia" class="text-success">PRECIO (P 4Hrs | P 6Hrs | P 8Hrs | PN | PM)</span>
                    <p>$ {{ $reserva->precioHora }} | $ {{ $reserva->precioHora6 }} | $ {{ $reserva->precioHora8 }}
                        |
                        $ {{ $reserva->precioNoche }} | $ {{ $reserva->precioMes }}
                    </p> --}}
                    <span class="text-success">TARIFA</span>
                    <p>{{ $reserva->servicio }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <span for="FechEntrada" class="text-success">F. ENTRADA</span>
                    <p>{{ SalidaController::fechaCastellano($reserva->FechEntrada) }}</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <span for="FechSalida" class="text-success">F. PREVISTA DE SALIDA</span>
                    <p>{{ SalidaController::fechaCastellano(date('Y-m-d', strtotime($reserva->departure_date))) }} {{ date('H:i:s', strtotime($reserva->departure_date)) }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            @php($pagos = !isset($pagos->total) ? 0 : $pagos->total)
            @php($deuda_alquiler = $reserva->CostoAlojamiento + (!isset($renovacion->total) ? 0 : $renovacion->total) - $pagos + $servicio->precioDS - $reserva->TotalPago - $reserva->Descuento)
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <table id="detalles" class="table table-sm table-striped table-bordered table-condensed table-hover">
                    <thead class="bg-secondary">
                        <td colspan="6">Detalles del Alquiler</td>
                    </thead>
                    <thead>
                        <tr>
                            <th>ALQUILER</th>
                            <th>RENOVACIÓN</th>
                            <th>TOTAL</th>
                            <th>PAGO RECIBIDO</th>
                            <th style="color: #135a99">DEUDA</th>
                            <th>MORA/ PENALIDAD</th>
                        </tr>
                    </thead>
                    <tr>
                        @php($alquiler = $reserva->CostoAlojamiento - $reserva->Descuento)
                        <td>{{ number_format($alquiler, 2) }}</td>
                        <td>{{ (!isset($renovacion->total) ? 0 : $renovacion->total) }}</td>
                        <td>{{ number_format($alquiler + (!isset($renovacion->total) ? 0 : $renovacion->total), 2) }}</td>
                        <td>{{ $reserva->TotalPago + $pagos }}</td>
                        <td style="font-size: 1.2em; color: #135a99">{{ number_format($deuda_alquiler, 2) }}</td>
                        <!-- Oculyo -->
                        <input type="hidden" name="totalpago" value="{{ $reserva->CostoAlojamiento }}">
                        <td class="text-olive">
                            <input type="text" id="penalidad" name="penalidad" class="input-number">
                        </td>
                    </tr>
                </table>
            </div>

            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <table id="detalles" class="table table-sm table-striped table-bordered table-condensed table-hover">
                    <thead class="bg-secondary">
                        <td colspan="6">Detalles de Consumo / Servicio</td>
                    </thead>
                    <thead>
                        <tr>
                            <th>TIPO</th>
                            <th>NOMBRE</th>
                            <th>CANTIDAD</th>
                            <th style="text-align: center">PRECIO U.</th>
                            <!-- <th>Detalles</th> -->
                            <th>ESTADO</th>
                            <th style="text-align: center">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <!-- <th></th> -->

                    </tfoot>
                    <tbody>
                        @php($total = 0)
                        @php($portotal = 0)
                        @foreach ($consumo as $con)
                            <tr>
                                <td>{{ $con->Denominacion == 'Servicio' ? 'Servicio' : 'Consumo' }}</td>
                                <td>{{ $con->NombProducto }}</td>
                                <td>{{ $con->Cantidad }}</td>
                                <td align="right">{{ $con->Precio }}</td>
                                @php($estilo_estado = $con->Estado == 'PAGADO' ? 'badge badge-success' : 'badge badge-danger')
                                <td> <span class="{{ $estilo_estado }}"> {{ $con->Estado }}</span> </td>
                                @php($portotal = $con->Estado != 'PAGADO' ? ($portotal += $con->Total) : $portotal)
                                <td align="right"> {{ $con->Total }}</td>
                                @php($total += $con->Total)
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5">Total:</th>
                            <td align="right"> {{ number_format($total, 2) }}</td>
                        </tr>

                        <tr class="text-olive">
                            <td colspan="5" style="font-size: 1.2em; color: #135a99">Deuda:</td>
                            <td align="right" style="font-size: 1.2em; color: #135a99"> {{ number_format($portotal, 2) }}</td>
                            <!-- Oculto -->
                            <input type="hidden" name="porpagarc" id="porpagarc" value="{{ $portotal }}">
                        </tr>
                        <tr>
                            <th colspan="4"></th>
                            <th>TOTAL A PAGAR:</th>
                            @php($por_pagar = $portotal + $deuda_alquiler)

                            <td width="200px">
                                <input type="hidden" value="{{ $por_pagar }}" id="porpagar1">
                                <input type="text" readOnly id="totalporpagar" name="totalporpagar" class="form-control" style="text-align: right; font-weight: bold; font-size: 1.5em"
                                    value="{{$por_pagar}}">
                            </td>
                        </tr>

                        <tr class="metodoPago" style="display: {{$por_pagar == 0 ? 'none' : ''}}" >
                            @php($mPago = ['EFECTIVO', 'TARJETA', 'B. DIGITAL'])
                            <th colspan="4"></th>
                            <th>MÉTODO PAGO</th>
                            <td>
                                <select name="metodoPago" class="form-control">
                                    @foreach ($mPago as $m)
                                        <option value="{{ $m }}">{{ $m }}</option>
                                    @endforeach
                                </select>

                            </td>
                        </tr>

                    </tfoot>
                    <tr>
                        <td>
                            <a href="{{ asset('salidas/verificacion') }}" class="btn btn-danger form-control">Volver</a>
                        </td>
                        <td colspan="4"></td>
                        <td>
                            <input type="submit" class="btn btn-info" value="Culminar">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>

    <script>

        const inputs4 = document.querySelectorAll('#penalidad');

        inputs4.forEach((input) => {
            input.addEventListener('keyup', sumar);
        })

        function sumar() {
            const penalidad = document.getElementById("penalidad").value === '' ? 0 : document.getElementById("penalidad")
                .value;
            var suma1 = parseFloat(penalidad) + parseFloat(document.getElementById("porpagar1").value);

            if (suma1 === 0) {
                $(".metodoPago").hide();
            }else{
                $(".metodoPago").show();

            }
            document.getElementById("totalporpagar").value = suma1.toFixed(2);
        }
    </script>

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
            $('.input-number').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '');
            });
        </script>
        <script>
            document.querySelector('#form1').addEventListener('submit', function(e) {
                var form = this;

                e.preventDefault(); // <--- prevent form from submitting

                Swal.fire({
                    title: 'Confirmar',
                    text: "Verifique haber recibido el monto total de pago, antes de confirmar!",
                    // html: '<h6>No podrás revertir esta acción.!</h6>' +
                    //     '<h5>Pago Recibido: ' + '<b>' + costo + '</b>' + '</h5>' +
                    //     '<h5>Nueva F. Salida: ' + '<b>' + fSalida + '</b>' + '</h5>',
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
