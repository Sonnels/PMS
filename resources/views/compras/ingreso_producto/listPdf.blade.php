<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado de Compras</title>
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
    <table>
        <thead>
            <tr>
                <td style="border: none"> <img src="../public/logo/{{ $datos_hotel->logo }}" alt="" width="80" height="80"></td>
                <td style="border: none; width: 30%"></td>
                <td style="border: none">{{ $datos_hotel->nombre }} <br>
                    Dirección: {{ $datos_hotel->direccion }}</td>
            </tr>
            <tr>
                <td style="text-align: center" colspan="3">
                    Listado de Compras de: <strong>{{ date('d/m/Y', strtotime($inicio)) }}</strong> hasta <strong>{{ date('d/m/Y', strtotime($fin)) }}</strong>
                </td>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <th>FECHA</th>
                <th>HORA</th>
                <th>PROVEEDOR</th>
                <th align="right">TOTAL</th>
            </tr>

        </thead>
        @php($total = 0)
        @foreach ($ingresos as $ing)
            <tr>
                <td>{{ date('d/m/Y', strtotime($ing->fecha)) }} </td>
                <td>{{ $ing->hora }}</td>
                <td>{{ $ing->nomPro }}</td>
                <td align="right">{{ $ing->total }}</td>
            </tr>
            @php($total += $ing->total)
        @endforeach
        <tr>
            <td style="border: none" colspan="2"></td>
            <td align="right">TOTAL</td>
            <td align="right">{{ number_format($total, 2) }}</td>
        </tr>
    </table>
</body>

</html>
