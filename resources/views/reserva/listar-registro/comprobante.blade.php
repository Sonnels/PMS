<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Información detallada de la reserva {{ $reserva->IdReserva }}</title>
</head>
{{-- <style>
    table {
        border-collapse: collapse;
        border-color: darkblue;
        width: 100%;
        /* font-family: monospace; */
        font-family: sans-serif;
    }

    /* table td {
        background: red
    } */

    .titulo {
        background: #eee7e7;
    }

</style> --}}
@php($medidaTicket = 260)
    <style>
         * {

            font-size: 10px;
            font-family: 'DejaVu Sans', serif;
        }

        h1 {
            font-size: 18px;
        }

        .ticket {
            margin: 2px;
        }

        td,
        th,
        tr,
        table {
            /* border-top: 1px solid black; */
            border-collapse: collapse;
            margin: 0 auto;
            width: 100%;
        }

        td.precio {
            text-align: right;
            font-size: 11px;
        }

        td.cantidad {
            font-size: 11px;
        }

        td.producto {
            text-align: center;
        }

        th {
            text-align: center;
        }

        .centrado {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: {{$medidaTicket}}px;
            max-width: {{$medidaTicket}}px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        * {
            margin: 2;
            padding: 0;
        }

        .ticket {
            margin: 0;
            padding: 0;
        }

        body {
            text-align: center;
        }
    </style>

<body>

    <table >
        <tr>
            <td colspan="2" style="text-align: right">
                COD_REGISTRO: {{$reserva->IdReserva}}
            </td>
        </tr>
        <tr>

            <td colspan="2">
                <div style=" width: 60px; margin: 0px auto 0px auto">
                     <img src="../public/logo/{{$datos_empresa->logo}}" alt="" >
                </div>
                {{-- <img src="../public/logo/{{$datos_empresa->logo}}" alt="" width="10" height="20"> --}}
            </td>


        </tr>
        <tr>
            <td colspan="2"  align="center">
                @if (isset($datos_empresa->nombre))
                    <b>{{$datos_empresa->nombre}}</b>
                @else
                    sin nombre de Hotel
                @endif
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                RUC N°: {{$datos_empresa->ruc}}
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                @if (isset($datos_empresa->direccion))
                    {{$datos_empresa->direccion}}<br>
                    Teléfono: {{$datos_empresa->telefono}}
                @else
                    Sin dirección
                @endif
            </td>


        </tr>
        <tr>
            <td colspan="2" align="center">
                {{$fecha_actual}} {{date('H:i:s')}}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Huesped:</b> {{ $reserva->nomcli }} {{ $reserva->apecli }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Cédula:</b> {{ $reserva->Ndcliente }}
            </td>
        </tr>

        <tr>
            <td  colspan="2" style="border-top: rgb(33, 33, 34) solid 2px; margin-top: 10px" ></td>
        </tr>
        <tr class="titulo">
            <td colspan="2"><b>N° Habitación </b> {{ $reserva->Num_Hab }}<</td>
        </tr>
        <tr>
            <td colspan="2"><b>Tipo </b> {{ $reserva->Denominacion }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>F. Entrada</b>{{$reserva->HoraEntrada}} {{ date('d/m/Y', strtotime($reserva->FechEntrada)) }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>F. Salida</b>{{$reserva->horaSalida}} {{ date('d/m/Y', strtotime($reserva->FechSalida)) }}</td>
        </tr>
        <tr>
            <td style="width: 120"><b>Método de Pago </b> </td>
            <td style="width: 40;" align="right">{{ $reserva->metodoPago }}</td>
        </tr>
        <tr>
            <td><b>Habitación </b> </td>
            <td align="right">+ {{$datos_empresa->simboloMoneda}} {{ $reserva->CostoAlojamiento }}</td>
        </tr>
        {{-- <tr>
            <td><b>Servicio Extra</b></td>
            <td align="right">
                + $ {{$servicio->precioDS == null ? '0.00': $servicio->precioDS}}
            </td>
        </tr> --}}
        <tr>
            <td><b>Descuento </b> </td>
            <td align="right">- {{$datos_empresa->simboloMoneda}} {{ $reserva->Descuento }}</td>
        </tr>
        <tr>
            <td colspan="2"  style="border-top: rgb(33, 33, 34) solid 2px"></td>
        </tr >
        <tr>
            <td><b>Total a Pagar:</b>
            </td>
            <td align="right">
                {{$datos_empresa->simboloMoneda}} {{ number_format($reserva->CostoAlojamiento + $servicio->precioDS - $reserva->Descuento, 2) }}
            </td>
        </tr>
        <tr>
            <td><b>Pago Recibido:</b></td>
            <td align="right">{{$datos_empresa->simboloMoneda}} {{ number_format($reserva->TotalPago, 2) }}</td>
        </tr>
        <tr>
            <td><b>Deuda:</b></td>
            <td align="right">
                {{$datos_empresa->simboloMoneda}} {{ number_format($reserva->CostoAlojamiento + $servicio->precioDS - $reserva->Descuento - $reserva->TotalPago, 2) }}
            </td>
        </tr>
        <tr>
            <td colspan="2" style="height: 20"></td>
        </tr>
        <tr style="text-align: center">
            <td colspan="2">----------------</td>
        </tr>
        <tr style="text-align: center">
            <td colspan="2" ><b>Huesped</b></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 20px">

            </td>
        </tr>
        <tr style="text-align: center">
            <td colspan="2">----------------</td>
        </tr>
        <tr style="text-align: center">
            <td colspan="2" ><b>Recepcionista</b></td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                {{$reserva->Nombre}}
            </td>
        </tr>
    </table>
    <hr>
</body>
</html>
