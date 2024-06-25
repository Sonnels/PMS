<?php use App\Http\Controllers\HabitacionController as HC; ?>
@extends ('layout.admin')
@section('Contenido')
    <style>
        .simply-section {
            color: rgb(255, 255, 255);
            background: rgb(231, 80, 80);
            width: 28px;
            height: 50px;
            /* margin: 0 5px; */
            font-family: Arial, Helvetica, sans-serif;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .simply-amount {
            display: block;
            /* font-size: 40px; */
            /* font-weight: 700; */
        }

        .simply-word {
            /* font-weight: 300; */
            font-size: 0.5em;
            /* display: none */
        }
    </style>

    @include('reserva.registro.search')
    @if (Session::has('message'))
        <input type="hidden" id="errores" value="{{ Session::get('message') }}">
    @endif
    @if (!Session::has('message'))
        <input type="hidden" id="errores" value=".">
    @endif

    @if (Session::has('message_registro'))
        <input type="hidden" id="registro" value="{{ Session::get('message_registro') }}">
    @endif
    @php($HabOcupadas = [])
    <div class="row">
        @foreach ($habitacion as $h)
            @if ($h->Estado == 'RESERVADO')
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-info" style="background: #3c8dbc; color: #f8f4f4;">
                        <div class="inner">
                            <h3>N° {{ $h->Num_Hab }}</h3>
                            <p>{{ $h->tipoden }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion"><img src="{{ asset('img/icono3.png') }}" width="60" alt="imagen"></i>
                        </div>
                        {{-- <a href="#" class="small-box-footer">{{ $h->Estado }} <i
                                class="fa fa-arrow-circle-right"></i></a> --}}
                        @foreach ($reserva as $item)
                            @if ($item->Num_Hab == $h->Num_Hab && $item->EsReser == 'RESERVAR')
                                <a href="{{ asset('reserva/listar-registro/' . $item->IdReserva . '/edit') }}"
                                    class="small-box-footer">{{ $item->servicio }} | {{ $h->Estado }}
                                    <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @elseif ($h->Estado == 'OCUPADO')
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>N° {{ $h->Num_Hab }}</h3>
                            <p style="margin-bottom:0px;">{{ $h->tipoden }}</p>
                            @foreach ($reserva as $item)
                                @if ($item->Num_Hab == $h->Num_Hab && $item->EsReser == 'HOSPEDAR')
                                    @include('reserva.registro.modal2')
                                    <p style="margin-bottom:0px; font-size: 0.85em">{{ $item->nomcli }}</p>
                        </div>
                        <div class="icon">
                            <i class="ion">
                                {{-- <img src="{{ asset('img/icono2.png') }}" width="60"
                                    alt="imagen"> --}}
                                <span style="font-size: 0.3em" class="text-white">

                                    <div id="r{{ $item->Num_Hab }}" style="display: flex;">
                                    </div>

                                    @php($hSalida = explode(':', date('H:i:s', strtotime($item->departure_date))))
                                    @php($fSalida = explode('-', date('Y-m-d', strtotime($item->departure_date))))
                                    @php($HabOcupadas[] = ['id' => $item->Num_Hab, 'h' => $hSalida[0], 'm' => $hSalida[1], 's' => $hSalida[2], 'Y' => $fSalida[0], 'mm' => $fSalida[1], 'd' => $fSalida[2]])
                                </span>
                            </i>
                        </div>
                        {{-- <a href="{{ route('comprobante.pdf', $item->IdReserva) }}" target="_blank"
                            class="small-box-footer">{{ $item->servicio }} | {{ $h->Estado }} <i
                                class="fa fa-arrow-circle-right"></i></a> --}}
                        <a href="#" data-target="#modal-add-{{ $item->IdReserva }}" data-toggle="modal"
                            class="small-box-footer">{{ $item->servicio }} | {{ $h->Estado }}<i
                                class="fa fa-arrow-circle-right"></i></a>
            @endif
        @endforeach
        {{-- <a href="#" class="small-box-footer">{{ $h->Estado}} <i class="fa fa-arrow-circle-right"></i></a> --}}

    </div>
    </div>
@elseif ($h->Estado == 'DISPONIBLE')
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>N° {{ $h->Num_Hab }}</h3>
                <p>{{ $h->tipoden }}</p>
            </div>
            <div class="icon">
                <i class="ion"><img src="{{ asset('img/icono1.png') }}" width="60" alt="imagen"></i>
            </div>
            <a href="{{ URL::action('ReservaController@CrearReserva', $h->Num_Hab) }}"
                class="small-box-footer">{{ $h->Estado }} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
@elseif ($h->Estado == 'PARA LIMPIEZA')
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>N°:{{ $h->Num_Hab }}</h3>
                <p>{{ $h->tipoden }}</p>
            </div>
            <div class="icon">
                <i class="ion"><img src="{{ asset('img/icono4.png') }}" width="60" alt="imagen"></i>
            </div>
            {{-- <button type="button" class="small-box-footer" data-toggle="modal" data-target="#modal-default-{{$h->Num_Hab}}">
                        Launch Default Modal
                        </button> --}}
            <a href="#" class="small-box-footer" data-toggle="modal"
                data-target="#modal-default-{{ $h->Num_Hab }}">
                {{ $h->Estado }} <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    @include('reserva.registro.limpieza')
@elseif ($h->Estado == 'LIMPIEZA')
    <div class="col-lg-3 col-xs-6 estado_habitacion_l" data-nombre="{{ $h->Num_Hab }}">
        <!-- small box -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>N°:{{ $h->Num_Hab }}</h3>
                <p style="margin-bottom:0px;">{{ $h->tipoden }}</p>
                @php($data = HC::ged_d_limpieza($h->idDetLim))
                <p style="margin-bottom:0px; font-size: 0.85em">{{ $data->nomPer }}</p>
            </div>
            <div class="icon">
                <i class="ion">
                    <span style="font-size: 0.3em" class="text-white">
                        <div id="r{{ $h->Num_Hab }}" style="display: flex;">
                        </div>

                        @php($valor_fecha = explode(' ', HC::ged_limpieza($h->idDetLim)))

                        @php($hSalida2 = explode(':', $valor_fecha[1]))
                        @php($fSalida2 = explode('-', $valor_fecha[0]))
                        @php($HabOcupadas[] = ['id' => $h->Num_Hab, 'h' => $hSalida2[0], 'm' => $hSalida2[1], 's' => $hSalida2[2], 'Y' => $fSalida2[0], 'mm' => $fSalida2[1], 'd' => $fSalida2[2]])
                    </span>
                </i>
            </div>
            <a href="#" class="small-box-footer">L. {{ $data->nomLim }} <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    @endif
    @endforeach
    </div>
    <div id="cuenta104">
    </div>
    <div id="0000000002">
    </div>
    {{ $habitacion->appends(['searchText' => $searchText])->links() }}
    <script>
        const selectElement = document.querySelector('.searchText');
        selectElement.addEventListener('change', (event) => {
            $("#buscar").click();
        });
    </script>
    @push('scripts')
        <script>
            function crearTimer(val, h, m, s, y, mm, d) {
                simplyCountdown('#r' + val, {
                    year: y, // required
                    month: mm, // required
                    day: d, // required
                    hours: h, // Default is 0 [0-23] integer
                    minutes: m, // Default is 0 [0-59] integer
                    seconds: s, // Default is 0 [0-59] integer
                    words: {
                        days: {
                            singular: 'Día',
                            plural: 'Días'
                        },
                        hours: {
                            singular: 'Hora',
                            plural: 'Horas'
                        },
                        minutes: {
                            singular: 'Min',
                            plural: 'Minutos'
                        },
                        seconds: {
                            singular: 'Seg',
                            plural: 'Segundos'
                        }
                    },
                    plural: false, //use plurals
                    inline: false, //set to true to get an inline basic countdown like : 24 days, 4 hours, 2 minutes, 5 seconds
                    inlineClass: 'simply-countdown-inline', //inline css span class in case of inline = true
                    // in case of inline set to false
                    enableUtc: false, //Use UTC or not - default : false
                    onEnd: function() {
                        return;
                    }, //Callback on countdown end, put your own function here
                    refresh: 1000, // default refresh every 1s
                    sectionClass: 'simply-section', //section css class
                    amountClass: 'simply-amount', // amount css class
                    wordClass: 'simply-word', // word css class
                    zeroPad: false,
                    countUp: false
                });
            }
        </script>
        @foreach ($HabOcupadas as $item)
            <script>
                // console.log('{{ $item['id'] }}')
                crearTimer('{{ $item['id'] }}', '{{ $item['h'] }}', '{{ $item['m'] }}', '{{ $item['s'] }}',
                    '{{ $item['Y'] }}', '{{ $item['mm'] }}', '{{ $item['d'] }}')
            </script>
        @endforeach
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
            const mensaje = localStorage.getItem('mensaje');
            if (mensaje) {
                Toast.fire({
                    icon: 'success',
                    title: mensaje,
                    customClass: 'swal-pop',
                })
                localStorage.removeItem('mensaje');
            }
        </script>
        @if (Session::has('error'))
            <script>
                toastr.error('{{ Session::get('error') }}', 'Operación Fallida', {
                    "positionClass": "toast-top-right"
                })
            </script>
        @endif
        @if (Session::has('success'))
            <script type="text/javascript">
                Toast.fire({
                    icon: 'success',
                    title: '{{ Session::get('success') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif
    @endpush
@endsection
