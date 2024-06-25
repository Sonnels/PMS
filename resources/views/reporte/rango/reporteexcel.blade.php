<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte por rango de Fecha</title>
</head>

<body>
    @php($estilo_celda = 'border: 1px solid #3d9970')
    <table>
        <thead>
            <tr>
                <td style="background: #3d9970; color: #ffffff">HAB.</td>
                <td style="background: #3d9970; color: #ffffff">CLIENTE</td>
                <td style="background: #3d9970; color: #ffffff">F. INGRESO</td>
                <td style="background: #3d9970; color: #ffffff">H. INGRESO</td>
                <td style="background: #3d9970; color: #ffffff">F. P. SALIDA</td>
                <td style="background: #3d9970; color: #ffffff">SERVICIO</td>
                <td style="background: #3d9970; color: #ffffff" align="right">TOTAL SERVICIO</td>
                <td style="background: #3d9970; color: #ffffff" align="right">TOTAL ALQUILER</td>
                <td style="background: #3d9970; color: #ffffff" align="right">TOTAL</td>
                {{-- <td>OPCIONES</td> --}}
            </tr>
        </thead>
        <tbody>
            @php($total = 0)
            @foreach ($registro as $r)
                @php($totalServicio = number_format(0, 2))
                @foreach ($consumo as $c)
                    @if ($c->IdReserva == $r->IdReserva)
                        @php($totalServicio = $c->total)
                    @endif
                @endforeach
                @php($totalAlquiler = number_format($r->TotalPago + $r->Penalidad + $r->Pago2, 2))
                @php($nomCliente = count(explode(' ', $r->Nombre)) > 1 ? explode(' ', $r->Nombre)[0] . ' ' . explode(' ', $r->Nombre)[1] : $r->Nombre)
                <tr>
                    <td style="{{ $estilo_celda }}">{{ $r->Num_Hab }}</td>
                    <td style="{{ $estilo_celda }}">{{ $nomCliente }}</td>
                    <td style="{{ $estilo_celda }}">{{ date('d/m/Y', strtotime($r->FechReserva)) }}</td>
                    <td style="{{ $estilo_celda }}">{{ $r->HoraEntrada }}</td>
                    <td style="{{ $estilo_celda }}">{{ date('d/m/Y', strtotime($r->FechSalida)) }}</td>
                    <td style="{{ $estilo_celda }}">{{ $r->servicio }}</td>
                    <td style="{{ $estilo_celda }}" align="right">{{ $totalServicio }}</td>
                    <td style="{{ $estilo_celda }}" align="right">{{ $totalAlquiler }}</td>
                    <td style="{{ $estilo_celda }}" align="right">
                        {{ number_format($totalServicio + $totalAlquiler, 2) }}</td>
                    @php($total += $totalServicio + $totalAlquiler)
                </tr>
            @endforeach
            <tr>
                <td colspan="7"></td>
                <td style="{{ $estilo_celda }}" align="right">TOTAL</td>
                <td style="{{ $estilo_celda }}" align="right">{{ $total}}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
