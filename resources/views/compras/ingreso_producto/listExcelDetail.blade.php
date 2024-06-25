<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado de Compras</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td colspan="9" align="center" >Listado de Compras Detallado: {{ date('d/m/Y', strtotime($inicio)) }} hasta
                    {{ date('d/m/Y', strtotime($fin)) }}</td>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <td style="border: 1px solid #5C5A5A; background: #5C5A5A; color: #ffffff">ID</td>
                <td style="border: 1px solid #5C5A5A; background: #5C5A5A; color: #ffffff">FECHA</td>
                <td style="border: 1px solid #5C5A5A; background: #5C5A5A; color: #ffffff">HORA</td>
                <td style="border: 1px solid #5C5A5A; background: #5C5A5A; color: #ffffff">ARTICULO</td>
                <td style="border: 1px solid #5C5A5A; background: #5C5A5A; color: #ffffff">CANT</td>
                <td style="border: 1px solid #5C5A5A; background: #5C5A5A; color: #ffffff">CAT X U. MEDIDA</td>
                <td style="border: 1px solid #5C5A5A; background: #5C5A5A; color: #ffffff">ITEM INGRESADOS</td>
                <td style="border: 1px solid #5C5A5A; background: #5C5A5A; color: #ffffff">PRECIO COMPRA</td>
                <td style="border: 1px solid #5C5A5A; background: #5C5A5A; color: #ffffff" align="right">SUBTOTAL</td>
            </tr>
        </thead>
        <tbody>
            @php($total = 0)
            @foreach ($ingresos as $ing)
                @php($sub_total = 0)
                @foreach ($detalle_ingreso as $di)
                    @if ($ing->idingreso == $di->idingreso)
                        <tr>
                            <td style="border: 1px solid #5C5A5A">{{ $di->idingreso }}</td>
                            <td style="border: 1px solid #5C5A5A">{{ $di->fecha }}</td>
                            <td style="border: 1px solid #5C5A5A">{{ $di->hora }}</td>
                            <td style="border: 1px solid #5C5A5A">{{ $di->NombProducto }}</td>
                            <td style="border: 1px solid #5C5A5A">{{ $di->cantidad }}</td>
                            <td style="border: 1px solid #5C5A5A">{{ $di->valorUMedida }}</td>
                            <td style="border: 1px solid #5C5A5A">{{ $di->cantidad * $di->valorUMedida }}</td>
                            <td style="border: 1px solid #5C5A5A">{{ $di->precioCompra }}</td>
                            <td style="border: 1px solid #5C5A5A">{{ $di->cantidad * $di->precioCompra }}</td>
                        </tr>
                        @php($sub_total += $di->cantidad * $di->precioCompra)
                    @endif
                @endforeach
                <tr>
                    <td colspan="7"></td>
                    <td>Sub total</td>
                    <td>{{ $sub_total }}</td>
                </tr>
                @php($total += $sub_total)
            @endforeach
            <tr>
                <td colspan="7"></td>
                <td>TOTAL</td>
                <td>{{ $total }}</td>
            </tr>
        </tbody>

    </table>
</body>

</html>
