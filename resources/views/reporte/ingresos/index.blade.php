@extends('layout.admin')
@Section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Reporte Diario</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Simple Tables</li> --}}
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    @include('reporte.ingresos.search')

    <div class="card">
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-md-12 col-12">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="bg-secondary">
                                <tr>
                                    <td>N°</td>
                                    <td>HORA</td>
                                    <td>TIPO</td>
                                    <td>MOTIVO</td>
                                    <td>ENTIDAD</td>
                                    <td>MÉTODO PAGO</td>
                                    <td>MONTO</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php($cont = 1)
                                @php($total = 0)
                                @foreach ($registro as $item)
                                    <tr>
                                        <td>{{$cont++}}</td>
                                        <td>{{$item['hora']}}</td>
                                        <td>{{$item['tipo']}}</td>
                                        <td>{{$item['motivo']}}</td>
                                        <td>{{$item['entidad']}}</td>
                                        <td>{{$item['metodoPago']}}</td>
                                        <td align="right">{{$item['monto']}}</td>
                                    </tr>
                                    @php($total += $item['monto'])
                                @endforeach
                                    <tr>
                                        <td colspan="5"></td>
                                        <td align="right">TOTAL</td>
                                        <td align="right">{{number_format($total, 2)}}</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
