@extends('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Caja</span>
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('reporte.caja.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead class="bg-secondary">
                            <tr>
                                <td>N° CAJA</td>
                                <td>FECHA APERTURA</td>
                                <td title="Monto Apertura">MONTO A.</td>
                                <td>FECHA CIERRE</td>
                                <td title="Monto CIerre">MONTO C.</td>
                                <td>ESTADO</td>
                                <td>ENCARGADO</td>
                                <td colspan="2">DETALLE</td>
                            </tr>
                        <tbody>
                            @foreach ($caja as $c)
                                <tr>
                                    <td># {{ $c->codCaja }}</td>
                                    <td>{{ $c->horaApertura }} {{ date('d/m/Y', strtotime($c->fechaApertura)) }}</td>
                                    <td align="right">{{ $c->montoApertura }}</td>
                                    @php ($fecha_cierre = !isset($c->fechaCierre) ? '' : date('d/m/Y', strtotime($c->fechaCierre)))
                                    <td>{{ $c->horaCierre }} {{ $fecha_cierre}}</td>
                                    <td align="right">{{ $c->montoCierre }}</td>
                                    @php($estado = !isset($c->montoCierre) ? 'ABIERTO' : 'CERRADO')
                                    @php($estilo_estado = $estado == 'ABIERTO' ? 'badge badge-success' : 'badge badge-danger')
                                    <td> <span class="{{$estilo_estado}}">{{ $estado}}</span></td>
                                    @php($nombres = count(explode(' ', $c->Nombre)) > 1 ? explode(' ', $c->Nombre)[0] . ' ' . explode(' ', $c->Nombre)[1] : $c->Nombre)
                                    <td>{{$nombres}}</td>
                                    <td><a href="{{route('arqueo_caja.pdf', [$c->codCaja])}}" target="_blank">
                                        <i class="fas fa-clipboard-check text-success"></i></a>
                                    </td>
                                    <td>
                                        <a href="{{route('arqueo_caja2.pdf', [$c->codCaja])}}" target="_blank">
                                            <i class="fas fa-shopping-cart text-info"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{$caja->appends(['searchText' => $searchText])}}
        </div>
    </div>
    @push('scripts')

    @endpush


@endsection
