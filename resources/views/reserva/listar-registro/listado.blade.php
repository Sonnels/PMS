<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado de Registros</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.80em;
        }

        table {
            /* margin-left: auto;
            margin-right: auto; */
            border-collapse: collapse;
            border-color: rgb(0, 0, 0);
            width: 100%;
        }

        td {
            padding: 3px;
            border: 1px solid rgb(37, 87, 134);
        }

        th {
            padding: 3px;
            border: 1px solid rgb(37, 87, 134);
            background: #eaf3fa;
            color: #12446b;
        }

        .data {
            /* background: rgb(146, 142, 142); */
            float: right;
            margin: 2% 0% 0% 0%;
        }

    </style>

</head>
<body>
    <div>
        <img src="../public/logo/{{ $datos_hotel->logo }}" alt="" width="80" height="80">
        <p class="data">
            {{ $datos_hotel->nombre }} <br>
            Dirección: {{ $datos_hotel->direccion }}
        </p>
    </div>
    <table>
        <tr>
            <th>HAB.</th>
            <th>CLIENTE</th>
            <th>F. ENTRA./RESER.</th>
            <th>F. PREV SALIDA</th>
            <th>F. SALIDA</th>
            <th>OBSERVACIONES</th>
            <th>ESTADO</th>
        </tr>
        @foreach ($reserva as $re)
            @php($explod_nombres = count(explode(' ', $re->nomcli)) > 1 ? $re->docli . ' | '. explode(' ', $re->nomcli)[0] . ' ' . explode(' ', $re->nomcli)[1] : $re->docli . ' | '. $re->nomcli)
            <tr>
                <td align="center">{{ $re->Num_Hab }}</td>

                <td>{{ $explod_nombres }}</td>
                @if ($re->FechEntrada == null)
                    <td>{{ date_format(new DateTime($re->FechReserva), 'd/m/Y') }} {{ $re->HoraEntrada }}</td>
                @else
                    <td>{{ date_format(new DateTime($re->FechEntrada), 'd/m/Y') }} {{ $re->HoraEntrada }}</td>
                @endif
                <td>{{ date_format(new DateTime($re->FechSalida), 'd/m/Y') }} {{ $re->horaSalida }}</td>
                <td>
                    @if (isset($re->FechaEmision))
                        {{ $re->horaSalida_o }} {{ date('d/m/Y', strtotime($re->FechaEmision)) }}
                    @endif
                </td>
                <td>{{ $re->Observacion }}</td>
                <td align="center">
                    @if ($re->EsReser == 'HOSPEDAR')
                        <div style="color: #db5050" >HOSPEDADO</div>
                    @elseif($re->EsReser == 'RESERVAR')
                        <div style="color: #50afdb">RESERVADO</div>
                    @else
                        <div style="color: #6b6a6a">CULMINADO</div>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>

</html>
