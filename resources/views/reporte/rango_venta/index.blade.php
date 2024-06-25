@extends('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Salidas de Productos</span>
                </div>
                @php($searchText3 = empty($searchText3) ? 'TODO' : $searchText3)
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <a href="{{route('reportRango.excel', [$searchText, $searchText2, $searchText3])}}" class="btn btn-default text-green" style="float: right">
                            <i class="fas fa-file-excel"></i>
                        </a> --}}
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('reporte.rango_venta.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead class="bg-secondary">
                            <tr>
                                <td>F. VENTA</td>
                                <td>PRODUCTO</td>
                                <td>CANTIDAD</td>
                                <td align="right">PRECIO UNI.</td>
                                <td align="right">SUB TOTAL</td>
                                {{-- <td>OPCIONES</td> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @php($total = 0)
                            @foreach ($registro as $r)
                                <tr>
                                    <td>{{date('d/m/Y', strtotime($r[1]))}}</td>
                                    <td>{{$r[0]}}</td>
                                    <td>{{$r[2]}}</td>
                                    <td align="right">{{$r[3]}}</td>
                                    <td align="right">{{number_format($r[3] * $r[2], 2)}}</td>
                                    @php($total += $r[3] * $r[2])
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3"></td>
                                <td align="right">TOTAL</td>
                                <td align="right">{{number_format($total, 2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- {{$registro->appends(['searchText' => $searchText, 'searchText2' => $searchText2, 'searchText3' => $searchText3])}} --}}
        </div>

    </div>


    @push('scripts')

    @endpush

@endsection
