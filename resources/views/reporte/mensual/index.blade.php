@extends('layout.admin')
@section ('Contenido')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <span class="title_header">Reporte Mensual</span>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">

                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

@include('reporte.mensual.search')

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-sm text-nowrap">
                    <thead class="bg-secondary">
                        {{-- <th>Id</th> --}}
                        <td>N°</td>
                        <td>FECHA</td>
                        <td style="text-align: right">+ VENTA</td>
                        <td style="text-align: right">+ SERVICIO</td>
                        <td style="text-align: right">+ CONSUMO</td>
                        <td style="text-align: right">+ ALQUILER</td>
                        <td style="text-align: right">+ INGRESO EXTRA</td>
                        <td style="text-align: right">- EGRESO</td>
                        <td style="text-align: right">TOTAL</td>

                    </thead>
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
                        <td>{{$contador}}</td>
                        <td>{{date('d/m/Y', strtotime($valor_item[0]))}}</td>
                        @if (strtotime($valor_item[0]) <= strtotime($fecha))
                            <td style="text-align: right">{{ $valor_item[1] == 0 ? '' : $datos_hotel->simboloMoneda . ' ' . number_format($valor_item[1], 2)}}</td>
                            <td style="text-align: right">{{ $valor_item[2] == 0 ? '' : $datos_hotel->simboloMoneda . ' ' . number_format($valor_item[2], 2)}}</td>
                            <td style="text-align: right">{{ $valor_item[3] == 0 ? '' : $datos_hotel->simboloMoneda . ' ' . number_format($valor_item[3], 2)}}</td>
                            <td style="text-align: right">{{ $valor_item[4] == 0 ? '' : $datos_hotel->simboloMoneda . ' ' . number_format($valor_item[4], 2)}}</td>
                            <td style="text-align: right">{{ $valor_item[5] == 0 ? '' : $datos_hotel->simboloMoneda . ' ' . number_format($valor_item[5], 2)}}</td>
                            <td style="text-align: right">{{ $valor_item[6] == 0 ? '' : $datos_hotel->simboloMoneda . ' ' . number_format($valor_item[6], 2)}}</td>
                            @php($total = $valor_item[1] + $valor_item[2] + $valor_item[3] + $valor_item[4] + $valor_item[5] - $valor_item[6])
                            <td style="text-align: right">{{ $datos_hotel->simboloMoneda }} {{number_format($total, 2)}}</td>
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
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
                        <td colspan="2">TOTAL: </td>
                        <td style="text-align: right">{{ $datos_hotel->simboloMoneda }} {{number_format($total_venta,2)}}</td>
                        <td style="text-align: right">{{ $datos_hotel->simboloMoneda }} {{number_format($total_servicio,2)}}</td>
                        <td style="text-align: right">{{ $datos_hotel->simboloMoneda }} {{number_format($total_consumo,2)}}</td>
                        <td style="text-align: right">{{ $datos_hotel->simboloMoneda }} {{number_format($total_alquiler,2)}}</td>
                        <td style="text-align: right">{{ $datos_hotel->simboloMoneda }} {{number_format($total_ingresoExtra,2)}}</td>
                        <td style="text-align: right">{{ $datos_hotel->simboloMoneda }} {{number_format($total_egreso,2)}}</td>
                        <td style="text-align: right">{{ $datos_hotel->simboloMoneda }} {{number_format($total_venta + $total_servicio + $total_consumo + $total_alquiler + $total_ingresoExtra - $total_egreso,2)}}</td>
                    </tr>
                </table>
            </div>
            </div>
        </div>
    </div>


@endsection
