<?php use App\Http\Controllers\LReservaController; ?>
@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">
                        Listado de Registros
                    </span>
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
    {{-- <div class="row"> --}}
    @include('reserva.listar-registro.search')
    {{-- </div> --}}
    <div class="row">
        {{-- <div class="col-lg-6 col-12">
            <div class="form-group">
                <a href="listar-registro/create"><button class="btn btn-success">Realizar Nuevo Registro</button></a>
            </div>
        </div> --}}
        <div class="col-lg-12 col-12" style="text-align: right">
            <div class="badge badge-danger">HOSPEDADO (H)</div>
            <div class="badge badge-secondary">CULMINADO (C)</div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-striped  table-condensed table-hover">
                        <thead class="bg-secondary">
                            <td title="HABITACIÓN">HAB.</td>
                            <td>CLIENTE</td>
                            <td title="FECHA ENTRADA">F.ENTRADA</td>
                            <td title="FECHA PREVISTA SALIDA">F.PREV SALIDA</td>
                            <td title="FECHA SALIDA">F.SALIDA</td>
                            {{-- <td>OBSERVACIÓN</td> --}}
                            {{-- <td>TOALLA</td> --}}
                            <td>SERVICIO</td>
                            <td style="text-align: center">ESTADO</td>
                            <td colspan="3" style="text-align: center">ACCIONES</td>

                        </thead>
                        @foreach ($reserva as $re)
                            <tr>
                                <td>{{ $re->Num_Hab }}</td>
                                <td><b>{{ $re->docli }}</b> <br> {{ $re->nomcli }} </td>
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
                                    @if ($re->EsReser == 'HOSPEDAR')
                                        <div class="badge badge-danger" title="HOSPEDADO">H</div>
                                    @elseif($re->EsReser == 'RESERVAR')
                                        <div class="badge badge-info" title="RESERVADO">R</div>
                                    @else
                                        <div class="badge badge-secondary" title="REGISTRO CULMINADO">C</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($re->EsReser == 'HOSPEDAR' && $re->regPago == 0)
                                        <a href="{{ URL::action('LReservaController@edit', $re->IdReserva) }}"><button
                                                class="btn btn-default btn-sm"
                                                title="Editar Registro Nro: {{ $re->IdReserva }}">
                                                <i class="fas fa-edit text-info"></i>
                                            </button></a>
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
                                <td>
                                    @if (isset($caja))
                                        @if (LReservaController::cont_consumo($re->IdReserva) && $caja->codCaja == $re->codCaja)
                                            <form class="edi"
                                                action="{{ URL::action('LReservaController@destroy', $re->IdReserva) }}"
                                                method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-default btn-sm borrar"
                                                    title="Eliminar {{ $re->IdReserva }}"
                                                    data-nombre="Registro N° {{ $re->IdReserva }}"><i
                                                        class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                            </form>
                                        @endif
                                    @endif


                                </td>

                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            {{ $reserva->appends(['searchText' => $searchText, 'searchText2' => $searchText2, 'searchText3' => $searchText3, 'searchText4' => $searchText4]) }}
            {{-- {{$reserva->render()}} --}}
        </div>
    </div>

    <script>
        const selectElement = document.querySelector('.searchText');
        selectElement.addEventListener('change', (event) => {
            $("#buscar").click();

        });
    </script>
    @push('scripts')
        @if (Session::has('success'))
            <script>
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    onOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif
    @endpush

@endsection
