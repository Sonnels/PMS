@php
    use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ARQUEO CAJA #{{$caja->codCaja}}</title>
    @php($medidaTicket = 260)
    <style>
         * {
            font-size: 10px;
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
            /* border-top: 1px solid black; */
            border-collapse: collapse;
            margin: 0 auto;
            width: 100%;
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
            margin: 2;
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
    <br><br>
<h4>ARQUEO DE CAJA</h4>
<h4>CAJA #{{$caja->codCaja}}</h4>
@php($estado_caja = is_null($caja->montoCierre) ? 'ABIERTO' : 'CERRADO')
<p>ESTADO: {{$estado_caja}}</p>
<div class="ticket">
    <table>
        <tr>
            <td>ENCARGADO:</td>
            <td>{{$caja->Nombre}}</td>
        </tr>

        <tr>
            <td>FECHA APERTURA:</td>
            <td>{{$caja->fechaApertura}} {{$caja->horaApertura}}</td>
        </tr>
        <tr>
            <td>FECHA CIERRE:</td>
            <td>{{$caja->fechaCierre}} {{$caja->horaCierre}}</td>
        </tr>
    </table>
    <h4>== DINERO EN CAJA ==</h4>
    <table>
        <tr>
            <td>APERTURA DE CAJA:</td>
            <td align="right">+ {{$caja->montoApertura}}</td>
        </tr>
        <tr>
            <td>ALQUILER EFECTIVO:</td>
            @php($reserva_efe = !isset($registro->pago) ? 0 : $registro->pago)
            @php($post_al_efectivo = !isset($post_al_efectivo->importe) ? 0 : $post_al_efectivo->importe)
            @php($penalidad_efectivo = !isset($penalidad_efectivo->importe) ? 0 : $penalidad_efectivo->importe)
            @php($penalidad_efectivo = !isset($penalidad_efectivo->importe) ? 0 : $penalidad_efectivo->importe)
            @php($ren_ini_efectivo = !isset($ren_ini_efectivo->importe) ? 0 : $ren_ini_efectivo->importe)
            @php($pagos_efectivo = !isset($pagos_efectivo->total) ? 0 : $pagos_efectivo->total)
            @php($reserva_efe = $reserva_efe + $post_al_efectivo + $penalidad_efectivo + $ren_ini_efectivo + $pagos_efectivo)
            <td align="right"> {{number_format($reserva_efe, 2)}}</td>
        </tr>
        <tr>
            <td>ALQUILER B. DIGITAL:</td>
            @php($reserva_bdigital = !isset($registro_BDigital->pago) ? 0 : $registro_BDigital->pago)
            @php($post_al_BDigital = !isset($post_al_BDigital->importe) ? 0 : $post_al_BDigital->importe)
            @php($penalidad_BDigital = !isset($penalidad_BDigital->importe) ? 0 : $penalidad_BDigital->importe)
            @php($ren_ini_BDigital = !isset($ren_ini_BDigital->importe) ? 0 : $ren_ini_BDigital->importe)
            @php($pagos_bgdigital = !isset($pagos_bgdigital->total) ? 0 : $pagos_bgdigital->total)
            @php($reserva_bdigital = $reserva_bdigital + $post_al_BDigital + $penalidad_BDigital + $ren_ini_BDigital + $pagos_bgdigital)
            <td align="right"> {{number_format($reserva_bdigital, 2)}}</td>
        </tr>
        <tr>
            <td>ALQUILER TARJETA:</td>
            @php($reserva_tcredito = !isset($registro_TCredito->pago) ? 0 : $registro_TCredito->pago)
            @php($post_al_TCredito = !isset($post_al_TCredito->importe) ? 0 : $post_al_TCredito->importe)
            @php($penalidad_TCredito = !isset($penalidad_TCredito->importe) ? 0 : $penalidad_TCredito->importe)
            @php($ren_ini_TCredito = !isset($ren_ini_TCredito->importe) ? 0 : $ren_ini_TCredito->importe)
            @php($pagos_TCredito = !isset($pagos_TCredito->total) ? 0 : $pagos_TCredito->total)
            @php($reserva_tcredito = $reserva_tcredito + $post_al_TCredito + $penalidad_TCredito + $ren_ini_TCredito + $pagos_TCredito)
            <td align="right"> {{number_format($reserva_tcredito, 2)}}</td>
        </tr>
        @php($totalAlquiler = $reserva_efe + $reserva_bdigital + $reserva_tcredito)
        <tr>
            {{-- <td></td> --}}
            <td align="right" colspan="2" style="border-top: 1px solid #000000">TOTAL ALQUILER: + {{number_format($totalAlquiler, 2)}}</td>
        </tr>

        <tr>
            <td>CONSUMO EFECTIVO:</td>
            @php($venta_h_efectivo = !isset($consu_efectivo->totalVenta) ? 0 : $consu_efectivo->totalVenta)
            <td align="right"> {{number_format($venta_h_efectivo, 2)}}</td>
        </tr>
        <tr>
            <td>CONSUMO B. DIGITAL:</td>
            @php($venta_h_bdigital = !isset($consu_bdigital->totalVenta) ? 0 : $consu_bdigital->totalVenta)
            <td align="right"> {{number_format($venta_h_bdigital, 2)}}</td>
        </tr>
        <tr>
            <td>CONSUMO TARJETA:</td>
            @php($venta_h_tarjeta = !isset($consu_tarjeta->totalVenta) ? 0 : $consu_tarjeta->totalVenta)
            <td align="right"> {{number_format($venta_h_tarjeta, 2)}}</td>
        </tr>
        @php($totalVHospedados = $venta_h_efectivo + $venta_h_bdigital + $venta_h_tarjeta)
        <tr>
            <td align="right" colspan="2" style="border-top: 1px solid #000000">TOTAL CONSUMO: + {{number_format($totalVHospedados, 2)}}</td>
        </tr>

        <tr>
            <td>SERVICIO EFECTIVO:</td>
            @php($servicio_efectivo = !isset($servi_efectivo->totalVenta) ? 0 : $servi_efectivo->totalVenta)
            <td align="right">{{number_format($servicio_efectivo, 2)}}</td>
        </tr>
        <tr>
            <td>SERVICIO B. DIGITAL:</td>
            @php($servicio_bdigital = !isset($servi_bdigital->totalVenta) ? 0 : $servi_bdigital->totalVenta)
            <td align="right">{{number_format($servicio_bdigital, 2)}}</td>
        </tr>
        <tr>
            <td>SERVICIO TARJETA:</td>
            @php($servicio_tarjeta = !isset($servi_tarjeta->totalVenta) ? 0 : $servi_tarjeta->totalVenta)
            <td align="right">{{number_format($servicio_tarjeta, 2)}}</td>
        </tr>
        @php($totalServicio = $servicio_efectivo + $servicio_bdigital + $servicio_tarjeta)
        <tr>
            <td align="right" colspan="2" style="border-top: 1px solid #000000">TOTAL SERVICIO: + {{number_format($totalServicio, 2)}}</td>
        </tr>
        <tr>
            <td>VENTA EFECTIVO:</td>
            @php($venta_o_efectivo = !isset($v_otro_efectivo->totalVenta) ? 0 : $v_otro_efectivo->totalVenta)
            <td align="right"> {{number_format($venta_o_efectivo, 2)}}</td>
        </tr>
        <tr>
            <td>VENTA B. DIGITAL:</td>
            @php($venta_o_bdigital = !isset($v_otro_bdigital->totalVenta) ? 0 : $v_otro_bdigital->totalVenta)
            <td align="right"> {{number_format($venta_o_bdigital, 2)}}</td>
        </tr>
        <tr>
            <td>VENTA TARJETA:</td>
            @php($venta_o_tarjeta = !isset($v_otro_tarjeta->totalVenta) ? 0 : $v_otro_tarjeta->totalVenta)
            <td align="right"> {{number_format($venta_o_tarjeta, 2)}}</td>
        </tr>
        @php($totalVenta_o = $venta_o_efectivo + $venta_o_bdigital + $venta_o_tarjeta)
        <tr>
            <td align="right" colspan="2" style="border-top: 1px solid #000000">TOTAL VENTA: + {{number_format($totalVenta_o, 2)}}</td>
        </tr>
        <tr>
            <td>T. INGRESOS EXTRAS:</td>
            @php($importe = !isset($ingreso->importe) ? 0 : $ingreso->importe)
            <td align="right">+ {{number_format($importe, 2)}}</td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000000">T. EGRESOS EXTRAS:</td>
            @php($egreso_importe = !isset($egreso->importe) ? 0 : $egreso->importe)
            <td align="right" style="border-bottom: 1px solid #000000">- {{number_format($egreso_importe, 2)}} </td>
        </tr>
        <tr>
            @php($total_bdigital = $reserva_bdigital + $venta_h_bdigital + $servicio_bdigital + $venta_o_bdigital)
            @php($total_tarjeta = $reserva_tcredito + $venta_h_tarjeta + $servicio_tarjeta + $venta_o_tarjeta)
            <td>EFECTIVO EN CAJA:</td>
            @php($efectivo = $totalAlquiler + $caja->montoApertura + $totalVHospedados + $totalServicio + $totalVenta_o + $ingreso->importe - $egreso->importe - $total_bdigital - $total_tarjeta)
            <td align="right">{{number_format($efectivo, 2)}} </td>
        </tr>
        <tr>
            <td style="border-bottom: 1px solid #000000">EFECTIVO EN CIERRE:</td>
            @php($salida = !isset($caja->montoCierre) ? 0 : $caja->montoCierre)
            <td align="right" style="border-bottom: 1px solid #000000">{{number_format($salida, 2)}}</td>
        </tr>
        <tr>
            @php($faltante = $efectivo - $salida)
            <td></td>
            <td align="right" >T. Efectivo = {{number_format($faltante, 2)}}</td>
        </tr>
        <tr>
            <td></td>
            <td align="right" >T. B. Digital = {{number_format($total_bdigital, 2)}}</td>
        </tr>
        <tr>
            <td></td>
            <td align="right" >T. Tarjeta = {{number_format($total_tarjeta, 2)}}</td>
        </tr>
    </table>
    <br>
    <h4>== DETALLE INGRESOS ==</h4>
    <table>
        <tr>
            <th align="center">Recibido de</th>
            <th align="center">Motivo</th>
            <th align="center">Imp.</th>
        </tr>
        @foreach ($ingreso_detallado as $item)
            <tr>
                <td> {{$item->recibidoDe}}</td>
                <td> {{Str::limit($item->motivo, 13)}}</td>
                <td align="right"> {{$item->importe}}</td>
            </tr>
        @endforeach
        <tr>
            <td align="right" colspan="3" style="border-top: 1px solid #000000">
                {{number_format($importe, 2)}}
            </td>
        </tr>
    </table>
    <br>
    <h4>== DETALLE EGRESOS==</h4>
    <table>
        <tr>
            <th align="center">Entregado a</th>
            <th align="center">Motivo</th>
            <th align="center">Imp.</th>
        </tr>
        @foreach ($egreso_detallado as $item)
            <tr>
                <td> {{Str::limit($item->entregadoA, 14)}}</td>
                <td> {{Str::limit($item->motivo, 13)}}</td>
                <td align="right" > {{$item->importe}}</td>
            </tr>
        @endforeach
        <tr>
            <td align="right" colspan="3" style="border-top: 1px solid #000000">
                {{number_format($egreso_importe, 2)}}
            </td>
        </tr>
    </table>
    <br>

    {{-- <br>
    <h4>== PRODUCTOS VENDIDOS ==</h4>
    <table>
        <tr>
            <th>PRODUCTO</th>
            <th align="center">CANT.</th>
            <th align="center">P. U.</th>
            <th align="center">DESC.</th>
            <th align="center">IMP.</th>
        </tr>
        @foreach ($producto as $item)
            <tr>
                <td>{{$item->nomProducto}}</td>
                <td align="center">{{$item->cantidad}}</td>
                <td align="right">{{$item->precioVenta}}</td>
                <td align="right">{{$item->descuento}}</td>
                @php($imp = ($item->cantidad * $item->precioVenta) - $item->descuento)
                <td align="right">{{number_format($imp, 2)}}</td>
            </tr>
        @endforeach
    </table> --}}
    <br>
    <table>
        <tr><td><h4>DATOS DE IMPRESION</h4></td></tr>
        <tr><td><h4>USUARIO: {{auth()->user()->Nombre}}</h4></td></tr>
        <tr><td><h4>FECHA: {{$fechaHora}}</h4></td></tr>
    </table>
    <br> <br>
        <p><h4>---------------------------</h4></p>
        <h4>{{auth()->user()->Nombre}}</h4>

</div>

</body>
</html>
