<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Mensual</title>
</head>
<body>
    @php($estilo_header = 'background-color: #5C5A5A; color: #f1ebeb; border: 1px solid #5C5A5A;')
    <table>
        <tr>
            <td style="{{$estilo_header}}">N°</td>
            <td style="{{$estilo_header}}">FECHA</td>
            <td style="{{$estilo_header}}">VENTA</td>
            <td style="{{$estilo_header}}">SERVICIOS</td>
            <td style="{{$estilo_header}}">CONSUMO</td>
            <td style="{{$estilo_header}}">ALQUILER</td>
            <td style="{{$estilo_header}}">INGRESO EXTRA</td>
            <td style="{{$estilo_header}}">EGRESO</td>
            <td style="{{$estilo_header}}">TOTAL</td>
        </tr>
    @php($total_venta = 0)
    @php($total_servicio = 0)
    @php($total_consumo = 0)
    @php($total_alquiler = 0)
    @php($total_ingresoExtra = 0)
    @php($total_egreso = 0)
    @php($contador = 0)
    @foreach ($array_fechas as $item)
    @php($contador += 1)
    @php($valor_item = explode('_', $item))
    @php($valor_item[1] = $valor_item[1] == '' ? 0 : $valor_item[1])
    @php($valor_item[2] = $valor_item[2] == '' ? 0 : $valor_item[2])
    @php($valor_item[3] = $valor_item[3] == '' ? 0 : $valor_item[3])
    @php($valor_item[4] = $valor_item[4] == '' ? 0 : $valor_item[4])
    @php($valor_item[5] = $valor_item[5] == '' ? 0 : $valor_item[5])
    @php($valor_item[6] = $valor_item[6] == '' ? 0 : $valor_item[6])
        <tr>
            <td style="border: 1px solid #5C5A5A;">{{$contador}}</td>
            <td style="border: 1px solid #5C5A5A;">{{date('d/m/Y', strtotime($valor_item[0]))}}</td>
            @if (strtotime($valor_item[0]) <= strtotime($fecha))
            <td style="text-align: right; border: 1px solid #5C5A5A;">{{ $valor_item[1] == 0 ? '' : $valor_item[1]}}</td>
            <td style="text-align: right; border: 1px solid #5C5A5A;">{{ $valor_item[2] == 0 ? '' : $valor_item[2]}}</td>
            <td style="text-align: right; border: 1px solid #5C5A5A;">{{ $valor_item[3] == 0 ? '' : $valor_item[3]}}</td>
            <td style="text-align: right; border: 1px solid #5C5A5A;">{{ $valor_item[4] == 0 ? '' : $valor_item[4]}}</td>
            <td style="text-align: right; border: 1px solid #5C5A5A;">{{ $valor_item[5] == 0 ? '' : $valor_item[5]}}</td>
            <td style="text-align: right; border: 1px solid #5C5A5A;">{{ $valor_item[6] == 0 ? '' : $valor_item[6]}}</td>
                <td style="text-align: right; border: 1px solid #5C5A5A;"> {{floatval($valor_item[1]) + floatval($valor_item[2]) + floatval($valor_item[3]) + floatval($valor_item[4]) + floatval($valor_item[5]) - floatval($valor_item[6])}}</td>
            @else
                <td style="text-align: right; border: 1px solid #5C5A5A;"></td>
                <td style="text-align: right; border: 1px solid #5C5A5A;"></td>
                <td style="text-align: right; border: 1px solid #5C5A5A;"></td>
                <td style="text-align: right; border: 1px solid #5C5A5A;"></td>
                <td style="text-align: right; border: 1px solid #5C5A5A;"></td>
                <td style="text-align: right; border: 1px solid #5C5A5A;"></td>
                <td style="text-align: right; border: 1px solid #5C5A5A;"></td>
            @endif
        </tr>
        @php($total_venta += floatval($valor_item[1]))
        @php($total_servicio += floatval($valor_item[2]))
        @php($total_consumo += floatval($valor_item[3]))
        @php($total_alquiler += floatval($valor_item[4]))
        @php($total_ingresoExtra += floatval($valor_item[5]))
        @php($total_egreso += floatval($valor_item[6]))
    @endforeach
        <tr style="font-weight: bold">
            <td style="border: 1px solid #5C5A5A;" colspan="2">TOTAL: </td>
            <td style="text-align: right; border: 1px solid #5C5A5A;"> {{$total_venta}}</td>
            <td style="text-align: right; border: 1px solid #5C5A5A;"> {{$total_servicio}}</td>
            <td style="text-align: right; border: 1px solid #5C5A5A;"> {{$total_consumo}}</td>
            <td style="text-align: right; border: 1px solid #5C5A5A;"> {{$total_alquiler}}</td>
            <td style="text-align: right; border: 1px solid #5C5A5A;"> {{$total_ingresoExtra }}</td>
            <td style="text-align: right; border: 1px solid #5C5A5A;"> {{$total_egreso }}</td>
            <td style="text-align: right; border: 1px solid #5C5A5A;"> {{$total_venta + $total_servicio + $total_consumo + $total_alquiler + $total_ingresoExtra - $total_egreso}}</td>
        </tr>
    </table>

</body>
</html>

