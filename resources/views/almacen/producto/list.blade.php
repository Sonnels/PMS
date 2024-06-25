<?php use App\Http\Controllers\ProductoController as PC; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Estado Inventario</title>
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
                <td style="border: none"><span style="font-weight: bold"> Usuario Responsable </span> <br>
                    {{ auth()->user()->Nombre }}</td>
                <td style="border: none"><span style="font-weight: bold"> Fecha </span> <br>
                    {{ date('d/m/Y H:i:s', strtotime($fechaHora)) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center; font-weight: bold; border: none">REPORTE DE INVENTARIO DE
                    ARTICULOS</td>
            </tr>
        </thead>
    </table>
    <table>
        <thead>
            <tr>
                <th>CÓD</th>
                <th>PRODUCTO</th>
                <th>CATEGORÍA</th>
                <th>IMAGEN</th>
                <th>ALMACÉN</th>
                <th>VENTA</th>
                <th>EXISTENCIA</th>
                <th>DESCRIPCIÓN</th>
                <th>PRECIO</th>
            </tr>

        </thead>
        @foreach ($producto as $pro)
            <tr>
                <td>{{ $pro->IdProducto }}</td>
                <td>{{ $pro->NombProducto }}</td>
                <td>{{ $pro->Denominacionc }}</td>
                <td>
                    @if ($pro->Imagen != '')
                        <img src="../public/Imagenes/Productos/{{ $pro->Imagen }}" alt="{{ $pro->NombProducto }}"
                            height="40" class="img-thumbnail">
                    @endif
                </td>
                <td align="center">
                    @if ($caja == false)
                        {{ $pro->stock }}
                    @else
                        {{ $pro->stock + PC::contar_productos($pro->IdProducto)}}
                    @endif

                </td>
                <td align="center">
                    @if ($caja != false)
                        {{ PC::contar_productos($pro->IdProducto) }}
                    @endif
                </td>
                <td align="center">{{ $pro->stock }}</td>
                <td>{{ $pro->Descripcion }}</td>
                <td align="right">{{ $datos_hotel->simboloMoneda}} {{ $pro->Precio }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
