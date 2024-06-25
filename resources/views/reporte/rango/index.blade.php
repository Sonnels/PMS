@extends('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Reporte por rango de Fecha de Alquiler/Reserva</span>
                </div>
                @php($searchText3 = empty($searchText3) ? 'TODO' : $searchText3)
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{ route('reportRango.excel', [$searchText, $searchText2, $searchText3]) }}"
                            class="btn btn-default text-green" style="float: right">
                            <i class="fas fa-file-excel"></i>
                        </a>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('reporte.rango.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead class="bg-secondary">
                            <tr>
                                <td>HAB.</td>
                                <td>CLIENTE</td>
                                <td>F. INGRESO</td>
                                <td>H. INGRESO</td>
                                <td title="FECHA PREVISTA DE SALIDA">F. P. SALIDA</td>
                                <td>SERVICIO</td>
                                <td align="right">TOTAL SERVICIO</td>
                                <td align="right">TOTAL ALQUILER</td>
                                <td align="right">SUB TOTAL</td>
                                {{-- <td>OPCIONES</td> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php($total = 0)
                            @foreach ($registro as $r)
                                @php($totalServicio = 0)
                                @foreach ($consumo as $c)
                                    @if ($c->IdReserva == $r->IdReserva)
                                        @php($totalServicio = $c->total)
                                    @endif
                                @endforeach
                                @php($totalAlquiler = $r->TotalPago + $r->Penalidad + $r->Pago2)
                                @php($nomCliente = count(explode(' ', $r->Nombre)) > 1 ? explode(' ', $r->Nombre)[0] . ' ' . explode(' ', $r->Nombre)[1] : $r->Nombre)
                                <tr>
                                    <td>{{ $r->Num_Hab }}</td>
                                    <td>{{ $nomCliente }}</td>
                                    <td>{{ date('d/m/Y', strtotime($r->FechReserva)) }}</td>
                                    <td>{{ $r->HoraEntrada }}</td>
                                    <td>{{ date('d/m/Y', strtotime($r->FechSalida)) }}</td>
                                    <td>{{ $r->servicio }}</td>
                                    <td align="right">{{ number_format($totalServicio, 2) }}</td>
                                    <td align="right">{{ number_format($totalAlquiler, 2) }}</td>
                                    <td align="right">{{ number_format($totalServicio + $totalAlquiler, 2) }}</td>
                                    @php($total += $totalServicio + $totalAlquiler)
                                </tr>
                            @endforeach
                                <tr>
                                    <td colspan="7"></td>
                                    <td align="right">TOTAL</td>
                                    <td align="right">{{number_format($total, 2)}}</td>
                                </tr>

                        </tbody>
                    </table>
                </div>
            </div>
           {{-- {{ $registro->appends(['searchText' => $searchText, 'searchText2' => $searchText2, 'searchText3' => $searchText3]) }} --}}
        </div>

    </div>


    @push('scripts')

    @endpush

@endsection
