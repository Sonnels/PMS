<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Corte de Turno {{ $caja->codCaja }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.80em;
        }

        table {
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

    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td style="border: none"> <img src="../public/logo/{{ $datos_hotel->logo }}" alt="" width="80"
                        height="80"></td>
                <td style="border: none; width: 30%"></td>
                <td style="border: none">{{ $datos_hotel->nombre }} <br>
                    Dirección: {{ $datos_hotel->direccion }}</td>
            </tr>
        </thead>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <td style="border: none"><span style="font-weight: bold"> Caja </span> <br> {{ $caja->codCaja }}</td>
                <td style="border: none"><span style="font-weight: bold"> Usuario Responsable </span> <br>
                    {{ $caja->Nombre }}</td>
                <td style="border: none"><span style="font-weight: bold"> Fecha </span> <br>
                    {{ date('d/m/Y H:i:s', strtotime($fechaHora)) }}</td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center; font-weight: bold; border: none">
                    CORTE DE TURNO - ARTICULOS VENDIDOS
                </td>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Articulo</th>
                <th>Categoría</th>
                <th>Medio</th>
                <th>Cortesía</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Importe</th>
            </tr>
        </thead>
        @php($total = 0)
        <tbody>
            @foreach ($consumo as $c)
                <tr>
                    <td align="center">{{ $c->IdProducto }}</td>
                    <td>{{ $c->NombProducto }}</td>
                    <td>{{ $c->Denominacion }}</td>
                    <td align="center">{{ 'H' }}</td>
                    <td></td>
                    <td align="center">{{ $c->Cantidad }}</td>
                    <td align="right">{{ $c->precioVenta }}</td>
                    <td align="right">{{ number_format($c->Cantidad * $c->precioVenta, 2) }}</td>
                </tr>
                @php($total += $c->Cantidad * $c->precioVenta)
            @endforeach
            @foreach ($cor_consumo as $cor_c)
            <tr>
                <td align="center">{{ $cor_c->IdProducto }}</td>
                <td>{{ $cor_c->NombProducto }}</td>
                <td>{{ $cor_c->Denominacion }}</td>
                <td align="center">{{ 'H' }}</td>
                <td align="center">{{ 'C' }}</td>
                <td align="center">{{ $cor_c->Cantidad }}</td>
                <td align="right">{{ $cor_c->precioVenta }}</td>
                <td align="right">{{ number_format($cor_c->Cantidad * $cor_c->precioVenta, 2) }}</td>
            </tr>
            @php($total += $cor_c->Cantidad * $cor_c->precioVenta)
        @endforeach
            @foreach ($producto as $p)
                <tr>
                    <td align="center">{{ $p->IdProducto }}</td>
                    <td>{{ $p->NombProducto }}</td>
                    <td>{{ $p->Denominacion }}</td>
                    <td align="center">{{ 'B' }}</td>
                    <td></td>
                    <td align="center">{{ $p->Cantidad }}</td>
                    <td align="right">{{ $p->precioVenta }}</td>
                    <td align="right">{{ number_format($p->Cantidad * $p->precioVenta, 2) }}</td>
                </tr>
                @php($total += $p->Cantidad * $p->precioVenta)
            @endforeach
            @foreach ($cor_producto as $cor_p)
                <tr>
                    <td align="center">{{ $cor_p->IdProducto }}</td>
                    <td>{{ $cor_p->NombProducto }}</td>
                    <td>{{ $cor_p->Denominacion }}</td>
                    <td align="center">{{ 'B' }}</td>
                    <td align="center">{{ 'C' }}</td>
                    <td align="center">{{ $cor_p->Cantidad }}</td>
                    <td align="right">{{ $cor_p->precioVenta }}</td>
                    <td align="right">{{ number_format($cor_p->Cantidad * $cor_p->precioVenta, 2) }}</td>
                </tr>
                @php($total += $cor_p->Cantidad * $cor_p->precioVenta)
            @endforeach
            <tr>
                <td style="border: none; font-size: 0.7em" colspan="6">MEDIO: HOSPEDAJE (H) / BODEGA (B)</td>
                <td align="right">TOTAL</td>
                <td align="right">{{ number_format($total, 2) }}</td>
            </tr>

        </tbody>
    </table>
</body>

</html>
