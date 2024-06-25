<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado Ventas</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.80em;
        }
        table {
            border-collapse: collapse; border-color: rgb(0, 0, 0);
            width: 100%;
        }
        td {
            padding: 3px; border: 1px solid rgb(37, 87, 134);
        }
        th {
            padding: 3px; border: 1px solid rgb(37, 87, 134);
            background: #eaf3fa;
            color: #12446b;
        }
        .data{
        float: right;
        margin: 2% 0% 0% 0%;
        }
    </style>
</head>
<body>
    {{-- @if (auth()->user()->tipo == 'PERSONAL')
        <div>
            <img src="../public/Logo/{{$localidad->logo}}" alt="" width="80" height="80">
            <p class="data">
                {{$localidad->nomLocalidad}} <br>
                Dirección: {{$localidad->direccion}} <br>
            <br>{{$fecha_hora}} <br>
            </p>
        </div>
    @endif --}}
    <div colspan="3">
        Criterio de Busqueda: {{$id}}
    </div>
    <div style="background: #165a92; color: #ffffff; text-align: center; padding: 3px; margin-bottom: 5px">
        <span>Listado de Ventas</span>
    </div>
    <table>
        <tr>
            <th>Nro.</th>
            <th>CodVenta</th>
            <th>Cliente</th>
            <th>Fecha de Venta</th>
            <th>Hora de Venta</th>
            {{-- <th>Estado</th> --}}
            <th>Total de Venta</th>
        @php($cont = 1)
        @php($total_venta = 0)
        @foreach ($venta as $p)
        <tr>
            <td align="center">{{ $cont++ }}</td>
            <td># {{ $p->codVenta}}</td>
            <td>{{ $p->Nombre  }}</td>
            <td align="center">{{ $p->fechaVenta}}</td>
            <td align="center">{{ $p->horaVenta}}</td>
            {{-- <td align="center">{{ $p->estado}}</td> --}}
            <td align="right">{{ $p->totalVenta}}</td>
            @php($total_venta += $p->totalVenta)

        </tr>
    @endforeach
        <tr>
            @if (auth()->user()->tipo == 'ADMINISTRADOR')
                <td colspan="4" style="border: 0px"></td>
            @else
                <td colspan="3" style="border: 0px"></td>
            @endif
            <th align="Center">TOTAL </th>
            <th align="right">{{number_format($total_venta, 2)}}</th>
        </tr>
    </table>
</body>
</html>
