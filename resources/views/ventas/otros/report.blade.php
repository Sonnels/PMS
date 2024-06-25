<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante #{{$venta->codVenta}}</title>
    @php($medidaTicket = 180)
    <style>
         * {
            font-size: 12px;
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
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
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
            margin: 0;
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
    <div class="ticket centrado">
        <h1>{{$empresa->nombre}}</h1>
        <h2>Comprobante #{{$venta->codVenta}}</h2>
        <h2>{{$fechaHora}}</h2>
    <table>
        <thead>
            <tr class="centrado">
                <th class="cantidad">CANT</th>
                <th class="producto">PROD</th>
                <th class="precio">PREC</th>
                <th>DESC</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalle_venta as $item)
                <tr>
                    <td>{{$item->cantidad}}</td>
                    <td>{{$item->NombProducto}}</td>
                    <td>{{$item->precioVenta}}</td>
                    <td>{{$item->descuento}}</td>
                </tr>
            @endforeach
        </tbody>
        <tr>
            <td class="cantidad"></td>
            <td class="producto">
                <strong>PAGO</strong>
            </td>
            <td class="precio">
                {{number_format($venta->totalVenta, 2)}}
            </td>
            <td></td>
        </tr>
    </table>
    <p class="centrado">¡GRACIAS POR SU PREFERENCIA!
        <br>CWILSOFT</p>
    </div>
</body>
</html>
