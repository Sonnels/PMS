<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Información detallada de la reserva {{ $reserva->IdReserva }}</title>
</head>
<style>
    body {
        font-size: 0.90em;
    }

    table {
        border-collapse: collapse;
        border-color: darkblue;
        width: 100%;
        font-family: sans-serif;
    }

    /* table td {
        border: 1px solid black;
    } */

    .titulo {
        background: #345a8b;
        color: #ffffff;
    }
</style>

<body>
    <table>
        <tr>
            <td style="width: 33.3%">
                <img src="../public/logo/{{ $datos_empresa->logo }}" alt="" width="100" height="100">
            </td>
            <td style="text-align: center">
                @if (isset($datos_empresa->nombre))
                    <b>{{ $datos_empresa->nombre }}</b>
                @else
                    sin nombre de Hotel
                @endif
            </td>
            <td style="text-align: center">
                Nro: {{ $reserva->IdReserva }}
            </td>
        </tr>
    </table>
    <h3>1. Detalle Hospedaje</h3>
    <table>
        <tr>
            <td colspan="2">
                @if (isset($datos_empresa->direccion))
                    {{ $datos_empresa->direccion }}<br>
                    Teléfono: {{ $datos_empresa->telefono }}
                @else
                    Sin dirección
                @endif
            </td>
            <td></td>
            <td colspan="3">
                <b>Huesped:</b> {{ $reserva->nomcli }} {{ $reserva->apecli }}<br>
                <b>Cédula:</b> {{ $reserva->Ndcliente }}<br>
                {{ $fecha_actual }} {{ date('H:i:s') }}
            </td>
        </tr>
        <tr>
            <td colspan="6" style="border-top: rgb(33, 33, 34) solid 2px; margin-top: 10px"></td>
        </tr>
        <tr class="titulo">
            <td><b>Habitación </b></td>
            <td><b>Tipo </b></td>
            <td style="text-align: center"><b>F. Entrada</b></td>
            <td style="text-align: center"><b>F. Prev Salida</b></td>
            <td style="text-align: center"><b>F. Salida</b></td>
            <td><b>M. Pago</b></td>
            {{-- <td style="text-align: center"><b>Habitación </b></td>
            <td style="text-align: center"><b>S. Extra</b></td>
            <td style="text-align: center"><b>Descuento </b></td> --}}
        </tr>
        <tr>
            <td>{{ $reserva->Num_Hab }}</td>
            <td>{{ $reserva->Denominacion }}</td>
            <td style="text-align: center">{{ $reserva->HoraEntrada }} <br>
                {{ date('d/m/Y', strtotime($reserva->FechEntrada)) }}</td>
            <td style="text-align: center">{{ $reserva->horaSalida }} <br>
                {{ date('d/m/Y', strtotime($reserva->FechSalida)) }}</td>
            <td style="text-align: center">{{ $reserva->horaSalida_o }} <br>
                {{ empty($reserva->FechaEmision) ? '' : date('d/m/Y', strtotime($reserva->FechaEmision)) }}
            </td>
            <td>{{ $reserva->metodoPago }}</td>
            {{-- <td style="text-align: center">$ {{ $reserva->CostoAlojamiento }}</td>
            <td style="text-align: center">$ {{ $servicio->precioDS == null ? '0.00' : $servicio->precioDS }}</td>
            <td style="text-align: center">
                @if (isset($reserva->Descuento))
                    $ {{ $reserva->Descuento }}
                @endif
            </td> --}}
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td colspan="6" style="border-top: rgb(33, 33, 34) solid 2px"></td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td style="text-align: right">Valor Tarifa</td>
            <td style="text-align: right">{{$datos_empresa->simboloMoneda}} {{ number_format($reserva->CostoAlojamiento, 2) }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td style="text-align: right">Descuento</td>
            <td style="text-align: right">{{$datos_empresa->simboloMoneda}} {{ number_format($reserva->Descuento, 2) }}</td>
        </tr>
        <tr>
            <td colspan="4"></td>
            <td style="text-align: right"><b>Total</b></td>
            <td style="text-align: right"><b>{{$datos_empresa->simboloMoneda}} {{ number_format($reserva->CostoAlojamiento - $reserva->Descuento, 2) }}</b></td>
        </tr>

    </table>
    <h3>2. Renovaciones</h3>
    <table>
        <thead>
            <tr class="titulo">
                <th>N°</th>
                <th>F. Renovación</th>
                <th>F. Entrada</th>
                <th>F. Salida</th>
                <th>Descuento</th>
                <th>Valor</th>
                <th>Sub Total</th>
            </tr>
        </thead>
        @php($cont = 1)
        <tbody>
            @php($total_ren = 0)
            @foreach ($renovaciones as $r)
                @php($subtotal_ren = $r->cosRen - $r->descuentoRen)
                @php($total_ren += $subtotal_ren)
                <tr>
                    <td>{{ $cont++ }}</td>
                    <td style="text-align: center">
                        {{ date('H:i:s', strtotime($r->fRenovacion)) }}<br>{{ date('d/m/Y', strtotime($r->fRenovacion)) }}
                    </td>
                    <td style="text-align: center">
                        {{ date('H:i:s', strtotime($r->fIniRen)) }}<br>{{ date('d/m/Y', strtotime($r->fIniRen)) }}
                    </td>
                    <td style="text-align: center">
                        {{ date('H:i:s', strtotime($r->fFinRen)) }}<br>{{ date('d/m/Y', strtotime($r->fFinRen)) }}
                    </td>
                    <td style="text-align: right">{{ $r->descuentoRen }}</td>
                    <td style="text-align: right">{{ $r->cosRen }}</td>
                    <td style="text-align: right">{{ number_format($subtotal_ren, 2) }}</td>
                </tr>
            @endforeach
        </tbody>

        <tr>
            <td colspan="7" style="border-top: rgb(33, 33, 34) solid 2px"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td align="right"><b>Total</b></td>
            <td align="right"><b>{{$datos_empresa->simboloMoneda}} {{ number_format($total_ren, 2) }}</b></td>
        </tr>
    </table>
    <h3>3. Detalle de Consumo/Servicio</h3>
    <table>
        <thead>
            <tr class="titulo">
                <th>N°</th>
                <th>Tipo</th>
                <th><b>Nombre</b></th>
                <th>Estado</th>
                <th align="center"><b>Cant.</b></th>
                <th align="center"><b>Precio</b></th>
                <th align="center"><b>Sub total</b></th>
            </tr>
        </thead>
        @php($total = 0)
        @php($cont = 1)
        @php($aDeuda = 0)
        @php($pagConsumo = 0)
        @foreach ($consumo as $con)
            <tr>
                <td align="center">{{ $cont++ }}</td>
                <td>{{ $con->Denominacion == 'Servicio' ? 'Servicio' : 'Consumo' }}</td>
                <td>{{ $con->NombProducto }}</td>
                <td> <span style="padding: 10px; background: {{ $con->Estado == 'PAGADO' ? "#22a759" : "#fc2323"}}; color: #ffffff">{{ $con->Estado }}</span></td>
                <td align="center">{{ $con->Cantidad }}</td>
                <td align="right"> {{ $con->Precio }}</td>
                <td align="right"> {{ $con->Total }}</td>
            </tr>
            @php($total += $con->Total)
            @php($con->Estado == 'FALTA PAGAR' ? ($aDeuda += $con->Total) : ($pagConsumo += $con->Total))
        @endforeach
        <tr>
            <td colspan="7" style="border-top: rgb(33, 33, 34) solid 2px"></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td align="right"><b>Total</b></td>
            <td align="right"><b>{{$datos_empresa->simboloMoneda}} {{ number_format($total, 2) }}</b></td>
        </tr>
        <tr>
            <td colspan="5"></td>
            <td align="right"><b>Por Pagar</b></td>
            <td align="right"><b>{{$datos_empresa->simboloMoneda}} {{ number_format($aDeuda, 2) }}</b></td>
        </tr>
    </table>
    <h3>4. Huésped Adicional</h3>
    <table>
        <thead>
            <tr class="titulo">
                <th>N°</th>
                <th>Tipo</th>
                <th>N° Identificación</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($huespedes_adicional as $h)
                <tr>
                    <td style="text-align: center">{{ $cont++ }}</td>
                    <td style="text-align: center">{{ $h->TipDocumento }}</td>
                    <td style="text-align: center">{{ $h->NumDocumento }}</td>
                    <td>{{ $h->Nombre }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>5. Observación</h3>
    <table>
        <tr>
            <td>{{ $reserva->Observacion }}</td>
        </tr>
    </table>

    <h3>6. Resumen</h3>

    <div style="border:none;">

        <div style="width:50%; display:inline-block;">
            <table style="margin-top: 10px; border: none">
                <thead>
                    <tr class="titulo">
                        <th>N°</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @php($cont = 1)
                    @php($total_pagos = 0)
                    @foreach ($pagos as $p)
                        <tr>
                            <td style="text-align: center">{{ $cont++ }}</td>
                            <td style="text-align: center">{{ date('d/m/Y', strtotime($p->fecPag)) }}</td>
                            <td style="text-align: center">{{ date('H:i:s', strtotime($p->fecPag)) }}</td>
                            <td style="text-align: right">{{ $p->monPag }}</td>
                        </tr>
                        @php($total_pagos += $p->monPag)
                    @endforeach
                    <tr>
                        <td colspan="2"></td>
                        <td align="right"><b>Total</b></td>
                        <td align="right"><b>{{$datos_empresa->simboloMoneda}} {{ number_format($total_pagos, 2) }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="width:50%; display:inline-block; border:none;">
            <table style="width: 90%; background: #edf2fc; margin-left: 10px">

                @if ($reserva->EsReser != 'HOSPEDAR')
                    <tr>
                        {{-- <td colspan="4"></td> --}}
                        <td><b>Mora / Penalidad</b></td>
                        <td style="text-align: right">{{$datos_empresa->simboloMoneda}} {{ number_format($reserva->Penalidad, 2) }}</td>
                    </tr>
                @endif

                <tr>
                    {{-- <td colspan="4"></td> --}}
                    <td><b>Total a Pagar:</b></td>
                    @php($total_pagar = $reserva->CostoAlojamiento + $reserva->Penalidad + $total - $reserva->Descuento + $total_ren)
                    <td style="text-align: right">{{$datos_empresa->simboloMoneda}} {{ number_format($total_pagar, 2) }}</td>
                </tr>

                <tr>
                    {{-- <td colspan="4"></td> --}}
                    <td ><b>Pago Recibido:</b></td>
                    @php($pago_recibido = (isset($deuda_alquiler) ? $deuda_alquiler->importe : 0) + $reserva->TotalPago + $pagConsumo + $reserva->Penalidad + $total_pagos)
                    <td style="text-align: right">{{$datos_empresa->simboloMoneda}} {{ number_format($pago_recibido, 2) }}</td>
                </tr>
                <tr>
                    {{-- <td colspan="4"></td> --}}
                    <td ><b>Deuda:</b></td>
                    <td style="text-align: right">{{$datos_empresa->simboloMoneda}}
                        {{ number_format($total_pagar - $pago_recibido, 2) }}
                    </td>
                </tr>
            </table>

        </div>
    </div>


    <table>
        <tr>
            <td style="height: 20"></td>
        </tr>
        <tr style="text-align: center">
            <td colspan="3" style="width: 50%">----------------</td>
            <td colspan="3">----------------</td>
        </tr>
        <tr style="text-align: center">
            <td colspan="3"><b>Recepcionista</b></td>
            <td colspan="3"><b>Huesped</b></td>
        </tr>
    </table>

</body>

</html>
