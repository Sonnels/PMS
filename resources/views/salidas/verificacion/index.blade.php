@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Verificación de Salidas</span>
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
        @foreach ($reserva as $r)
            <div class="col-lg-3 col-xs-6">
                @if ($fecha_hora >= $r->departure_date)
                    {{-- <span class="badge badge-warning navbar-badge">15</span> --}}
                    <div class="tooltip2">
                        <span data-toggle="tooltip" class="badge badge-default text-danger">
                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        </span>

                        <span class="tooltiptext2">Advertencia por Fecha de Salida </span>
                    </div>
                @else
                    <p style="padding: 5px"></p>
                @endif
                <!-- small box -->
                <div class="small-box bg-secondary">

                    <div class="inner">
                        <h3>Nro:{{ $r->Num_Hab }}</h3>
                        {{-- <p>Habitación {{$r->tipoden}}</p> --}}
                        <p style="margin-bottom:0px">Hab. {{ $r->Denominacion }}</p>
                        <p style="margin-bottom:0px; font-size: 0.85em">{{ $r->Nombre }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion"><img src="{{ asset('img/icono2.png') }}" width="60" alt="imagen"></i>
                    </div>
                    <a href="{{ URL::action('SalidaController@edit', $r->IdReserva) }}" class="small-box-footer">VER
                        DETALLES <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endforeach
        <h1 class="text-secondary">{{ count($reserva) == 0 ? 'NO SE ENCUENTRAN HABITACIONES OCUPADAS' : '' }}</h1>
        {{ $reserva->render() }}
    </div>
    @push('scripts')
        @if (Session::has('success'))
            <script>
                Snackbar.show({
                    text: '{{ session('success') }}',
                    actionText: 'CERRAR',
                    pos: 'bottom-right',
                    actionTextColor: '#27AE60',
                    duration: 6000
                });
            </script>
        @endif
    @endpush
@endsection
