<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Reporte</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td style="background: #5C5A5A; color: #ffffff; border: 1px solid #5C5A5A">N°</td>
                <td style="background: #5C5A5A; color: #ffffff; border: 1px solid #5C5A5A">HORA</td>
                <td style="background: #5C5A5A; color: #ffffff; border: 1px solid #5C5A5A">TIPO</td>
                <td style="background: #5C5A5A; color: #ffffff; border: 1px solid #5C5A5A">MOTIVO</td>
                <td style="background: #5C5A5A; color: #ffffff; border: 1px solid #5C5A5A">ENTIDAD</td>
                <td style="background: #5C5A5A; color: #ffffff; border: 1px solid #5C5A5A">MÉTODO PAGO</td>
                <td style="background: #5C5A5A; color: #ffffff; border: 1px solid #5C5A5A">MONTO</td>
            </tr>
        </thead>
        <tbody>
            @php($cont = 1)
            @php($total = 0)
            @foreach ($registro as $item)
                <tr>
                    <td style="border: 1px solid #5C5A5A">{{$cont++}}</td>
                    <td style="border: 1px solid #5C5A5A">{{$item['hora']}}</td>
                    <td style="border: 1px solid #5C5A5A">{{$item['tipo']}}</td>
                    <td style="border: 1px solid #5C5A5A">{{$item['motivo']}}</td>
                    <td style="border: 1px solid #5C5A5A">{{$item['entidad']}}</td>
                    <td style="border: 1px solid #5C5A5A">{{$item['metodoPago']}}</td>
                    <td style="border: 1px solid #5C5A5A" align="right">{{$item['monto']}}</td>
                </tr>
                @php($total += $item['monto'])
            @endforeach
                <tr>
                    <td colspan="5"></td>
                    <td align="right">TOTAL</td>
                    <td align="right">{{$total}}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>
