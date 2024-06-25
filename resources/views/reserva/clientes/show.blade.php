@extends('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <b >
                        <span class="title_header">Historial de: </span>{{$cliente->Nombre}}
                    </b>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Simple Tables</li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-sm table-striped  table-condensed table-hover">
                    <thead class="bg-secondary">
                        <td title="HABITACIÓN">HAB.</td>
                        <td title="FECHA ENTRADA">F.ENTRADA</td>
                        <td title="FECHA PREVISTA SALIDA">F.PREV SALIDA</td>
                        <td title="FECHA SALIDA">F.SALIDA</td>
                        {{-- <td>OBSERVACIÓN</td> --}}
                        {{-- <td>TOALLA</td> --}}
                        <td>SERVICIO</td>
                        <td style="text-align: center">ESTADO</td>
                        <td style="text-align: center">ACCIONES</td>

                    </thead>
                    @foreach ($registro as $re)
                        <tr>
                            <td>{{ $re->Num_Hab }}</td>
                            @if ($re->FechEntrada == null)
                                <td>{{ date_format(new DateTime($re->FechReserva), 'd/m/Y') }}
                                    {{ $re->HoraEntrada }}
                                </td>
                            @else
                                <td>{{ date_format(new DateTime($re->FechEntrada), 'd/m/Y') }}
                                    {{ $re->HoraEntrada }}
                                </td>
                            @endif
                            <td>{{ date_format(new DateTime($re->FechSalida), 'd/m/Y') }} {{ $re->horaSalida }}</td>
                            <td>
                                @if (isset($re->FechaEmision))
                                    {{ $re->horaSalida_o }} {{ date('d/m/Y', strtotime($re->FechaEmision)) }}
                                @endif
                            </td>
                            {{-- <td>{{ $re->Observacion}}</td> --}}
                            {{-- <td align="center">{{ $re->toalla}}</td> --}}
                            <td>{{ $re->servicio }}</td>
                            <td align="center">
                                @if ($re->Estado == 'HOSPEDAR')
                                    <div class="badge badge-danger" title="HOSPEDADO">H</div>
                                @elseif($re->Estado == 'RESERVAR')
                                    <div class="badge badge-info" title="RESERVADO">R</div>
                                @else
                                    <div class="badge badge-secondary" title="REGISTRO CULMINADO">C</div>
                                @endif
                            </td>

                            <td>
                                <a href="{{ URL::action('LReservaController@report', $re->IdReserva) }}"
                                    target="_blank">
                                    <button class="btn btn-default btn-sm">
                                        <i class="far fa-file-pdf text-danger"></i>
                                    </button>
                                </a>
                            </td>


                        </tr>
                    @endforeach
                </table>
            </div>


        </div>
    </div>
@endsection
