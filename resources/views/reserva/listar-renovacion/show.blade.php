<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Renovación N°: {{$renovacion->idRenovacion}}</title>
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
            width: {{ $medidaTicket }}px;
            max-width: {{ $medidaTicket }}px;
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
</head>
<body>
    <table>
        <tr>
            <td colspan="2" style="text-align: right">
                Renovación N°: {{ $renovacion->idRenovacion }}
            </td>
        </tr>
        <tr>

            <td colspan="2">
                <div style=" width: 60px; margin: 0px auto 0px auto">
                    <img src="../public/logo/{{ $datos_empresa->logo }}" alt="">
                </div>
                {{-- <img src="../public/logo/{{$datos_empresa->logo}}" alt="" width="10" height="20"> --}}
            </td>


        </tr>
        <tr>
            <td colspan="2" align="center">
                @if (isset($datos_empresa->nombre))
                    <b>{{ $datos_empresa->nombre }}</b>
                @else
                    sin nombre de Hotel
                @endif
            </td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                RFC N°: {{ $datos_empresa->ruc }}
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                @if (isset($datos_empresa->direccion))
                    {{ $datos_empresa->direccion }}<br>
                    Teléfono: {{ $datos_empresa->telefono }}
                @else
                    Sin dirección
                @endif
            </td>


        </tr>
        <tr>
            <td colspan="2" align="center">
                {{ $fecha_actual }} {{ date('H:i:s') }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Huesped:</b> {{ $renovacion->nomcli }}
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <b>Cédula:</b> {{ $renovacion->Ndcliente }}
            </td>
        </tr>

        <tr>
            <td colspan="2" style="border-top: rgb(33, 33, 34) solid 2px; margin-top: 10px"></td>
        </tr>
        <tr class="titulo">
            <td colspan="2"><b>N° Habitación: </b>{{ $renovacion->Num_Hab }}<< /td>
        </tr>
        <tr>
            <td colspan="2"><b>Tipo: </b>{{ $renovacion->Denominacion }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>F. Entrada: </b>{{ date('H:i:s', strtotime($renovacion->fIniRen)) }}
                {{ date('d/m/Y', strtotime($renovacion->fIniRen)) }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>F. Salida: </b>{{ date('H:i:s', strtotime($renovacion->fFinRen)) }}
                {{ date('d/m/Y', strtotime($renovacion->fFinRen)) }}</td>
        </tr>
        <tr>
            <td colspan="2"><b>Método de Pago: </b>{{ $renovacion->metPagRen }}</td>
            {{-- <td align="right">{{ $renovacion->metodoPago }}</td> --}}
        </tr>
        <tr>
            <td><b>Servicio: </b>{{ $renovacion->tarRen }} </td>
            <td><b>Cant.: </b>{{ $renovacion->canRen }}</td>
        </tr>
    </table>
    <table style="border-top: rgb(33, 33, 34) solid 2px">
        <tr>
            <td><b>Pago Recibido:</b></td>
            <td align="right">$ {{ number_format($renovacion->cosRen, 2) }}</td>
        </tr>
        <tr>
            <td colspan="2" style="height: 20"></td>
        </tr>
        <tr style="text-align: center">
            <td colspan="2">----------------</td>
        </tr>
        <tr style="text-align: center">
            <td colspan="2"><b>Huesped</b></td>
        </tr>
        <tr>
            <td colspan="2" style="height: 20px">

            </td>
        </tr>
        <tr style="text-align: center">
            <td colspan="2">----------------</td>
        </tr>
        <tr style="text-align: center">
            <td colspan="2"><b>Recepcionista</b></td>
        </tr>
        <tr>
            <td align="center" colspan="2">
                {{ $renovacion->Nombre }}
            </td>
        </tr>
    </table>
</body>
</html>
