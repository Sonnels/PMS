@extends('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Panel de Control</span>
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
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $hab_por_salir->TotalHab }}</h3>
                    <p>Hab. que requieren atención</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bed"></i>
                </div>
                <a href="{{ asset('salidas/verificacion') }}" class="small-box-footer">Más info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $hab_disponible->TotalHab }}</h3>
                    <p>Habitaciones Disponibles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bed"></i>
                    {{-- <i class="ion ion-stats-bars"></i> --}}
                </div>
                <a href="{{ asset('reserva/registro') }}" class="small-box-footer">Más info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $hab_reservada->TotalHab }}</h3>

                    <p>Habitaciones Reservadas</p>
                </div>
                <div class="icon">
                    {{-- <i class="ion fas fa-bed-empty"></i> --}}
                    {{-- <i class="ion ion-bag"></i> --}}
                    {{-- <i class="fad fa-bed"></i> --}}
                    <i class="fas fa-bed"></i>
                </div>
                <a href="{{ asset('reserva/listar-registro') }}" class="small-box-footer">Más info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $hab_ocupada->TotalHab }}</h3>
                    <p>Habitaciones Ocupadas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bed"></i>
                </div>
                <a href="{{ asset('ventas/consumo') }}" class="small-box-footer">Más info <i
                        class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div>
    <div class="row">
        <!-- Left col -->
        @if (auth()->user()->tipo != 'RECEPCIONISTA')
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header bg-secondary">
                        <h3 class="card-title">Gráfico de Ingresos</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="gStacked" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-secondary">
                    <h3 class="card-title">Productos más Vendidos</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="gDona" width="400" height="200"></canvas>

                </div>
            </div>
        </div>

    </div>


    @push('scripts')
        <script src="{{ asset('dist/js/chart.min.js') }}"></script>
        {{-- <script src="{{ asset('dist/js/dashboard.js') }}"></script> --}}

        @if (auth()->user()->tipo != 'RECEPCIONISTA')
            <script>
                // Gráfica ingreso mensual

                var array_fecha = @json($array_fechas);
                var array_alq = @json($array_alquiler);
                var array_consumo = @json($array_consumo);
                let array_ingresoExtra = @json($array_ingresoExtra);
                let array_egreso = @json($array_egreso);


                var ctx = document.getElementById('gStacked');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: array_fecha,
                        datasets: [{
                            label: 'Alquiler',
                            data: array_alq,
                            backgroundColor: [
                                '#FF7187',
                            ],
                            borderColor: '#FF7187',
                            hoverOffset: 4
                        }, {
                            label: 'Consumo/Servicio',
                            data: array_consumo,
                            backgroundColor: [
                                '#7DC1F9',
                            ],
                            borderColor: '#7DC1F9',
                            hoverOffset: 4
                        },{
                            label: 'Ingreso Extra',
                            data: array_ingresoExtra,
                            backgroundColor: [
                                '#FFD56C',
                            ],
                            borderColor: '#FFD56C',
                            hoverOffset: 4
                        },{
                            label: 'Egreso',
                            data: array_egreso,
                            backgroundColor: [
                                '#84FFA2',
                            ],
                            borderColor: '#84FFA2',
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        // scales: {
                        //     y: {
                        //         ticks: {
                        //             stepSize: 1,
                        //             beginAtZero: true,
                        //         },
                        //     },
                        // },
                        plugins: {
                            title: {
                                display: true,
                                text: 'Gráfico Mensual'
                            }
                        },
                        responsive: true,
                        scales: {
                            x: {
                                stacked: true,
                            },
                            y: {
                                stacked: true
                            }
                        }
                    }

                });
            </script>
        @endif
        <script>
            $(function() {
                var registro = @json($data);
                let producto_ven = [];
                let cantidad_ven = [];
                var cont_r = 0;
                for (x of registro) {
                    if (cont_r < 9) {
                        producto_ven.push(x[0]);
                        cantidad_ven.push(x[1]);
                        cont_r++;
                    }

                }
                var ctx = document.getElementById('gDona');
                var myChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: producto_ven,
                        datasets: [{
                            label: 'My First Dataset',
                            data: cantidad_ven,
                            backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)',
                                '#1DB76E',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                '#27F2DD',
                                '#FFF817',
                                '#1B63B4'

                            ],
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                ticks: {
                                    stepSize: 1,
                                    beginAtZero: true,
                                },
                            }
                        }
                    }
                });



            });
        </script>
    @endpush
@endsection
