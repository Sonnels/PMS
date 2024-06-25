<?php use App\Http\Controllers\AperturaCierreController; ?>

@extends ('layout.admin')

@section('Contenido')

    <div class="row">
        <div class="col-lg-7 col-md-12">

            <div class="card bg-header">
                @if (isset($registro))
                    <div class="row" style="margin-left: 0px; margin-right: 0px;">
                        <!-- Column -->
                        <div class="col-lg-6 b-r">
                            <div class="card-body">
                                <div class="row text-center display-apertura m-t-40 m-b-40" style="display: block;">
                                    <div class="col-sm-8 offset-sm-2">
                                        <h2 style="color: #d3d3d3;"><i class="fas fa-unlock"></i>
                                        </h2>
                                        <span class="p-2 bg-success text-white">ABIERTO</span><br><br>
                                        <h6>Ingrese los datos,<br>para cerrar la caja</h6>
                                    </div>
                                </div>
                                <div class="row text-center m-t-30 m-b-40 display-cierre">
                                    <div class="col-sm-8 offset-sm-2">
                                        <h4 style="color: #d3d3d3;"><i
                                                class="mdi mdi-lock-open-outline display-3 m-t-40 m-b-10"></i>
                                        </h4>
                                        <span class="label label-success label-open m-b-20">ABIERTO</span><br>
                                        <h6 class="fecha-apertura">Abierto el día
                                            {{ AperturaCierreController::fechaCastellano($registro->fechaApertura) }} a
                                            las
                                            {{ $registro->horaApertura }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-lg-6 p-0">
                            <div class="p-0">
                                {!! Form::open(['url' => route('apertura.update', $registro->codCaja), 'method' => 'PUT', 'autocomplete' => 'off']) !!}
                                <form id="form-apertura" method="post" novalidate="novalidate">
                                    <div class="card-body bg-white" style="border-radius: .25rem;">
                                        <div class="row m-t-30">

                                            <div class="col-lg-12">
                                                <div class="form-group m-b-20 dec">
                                                    <label class="font-13 text-inverse">INGRESE MONTO DE CIERRE</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-white text-muted"
                                                                style="display: grid;">
                                                                <small class="text-left">EFE</small>
                                                                <div class="text-left font-medium">{{$datos_hotel->simboloMoneda}}</div>
                                                            </span>
                                                        </div>
                                                        <input type="text" name="montoCierre" id="montoCierre"
                                                            class="form-control form-control-lg montoCierre"
                                                            style="height: 58px;border-left: 0px; border-right: 0px;"
                                                            id="monto_aper" value="" autocomplete="off" required=""
                                                            data-fv-field="onlyNum">
                                                    </div>
                                                    <div class="help-block" data-fv-validator="notEmpty"
                                                        data-fv-for="onlyNum" data-fv-result="NOT_VALIDATED"
                                                        style="display: none;">Dato obligatorio</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-white">
                                        <a class="btn btn-danger btn-block cerrar_o ">CERRAR CAJA</a>
                                        <button type="submit" class="btn btn-danger btn-block cerrar"
                                            style="display: none">CERRAR CAJA</button>
                                    </div>
                                </form>
                                {!! Form::close() !!}

                            </div>
                        </div>
                    </div>
                @else
                    <div class="row" style="margin-left: 0px; margin-right: 0px;">
                        <!-- Column -->
                        <div class="col-lg-6 b-r">
                            <div class="card-body">
                                <div class="row text-center display-apertura m-t-40 m-b-40" style="display: block;">
                                    <div class="col-sm-8 offset-sm-2">
                                        <h2 style="color: #d3d3d3;"><i class="fas fa-lock"></i>
                                        </h2>
                                        <span class="p-2 bg-danger text-white">CERRADO</span><br><br>
                                        <h6>Ingrese los datos,<br>para abrir una caja</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <div class="col-lg-6 p-0">
                            <div class="p-0">
                                {!! Form::open(['url' => 'caja/apertura', 'method' => 'POST', 'autocomplete' => 'off']) !!}
                                {{ Form::token() }}
                                <form id="form-apertura" method="post" class="display-apertura fv-form fv-form-bootstrap">
                                    {{-- {{ csrf_field() }} --}}
                                    <div class="card-body bg-white" style="border-radius: .25rem;">
                                        <div class="row m-t-30">

                                            <div class="col-lg-12">
                                                <div class="form-group m-b-20 dec">
                                                    <label class="font-13 text-inverse">INGRESE MONTO DE APERTURA</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-white text-muted"
                                                                style="display: grid;">
                                                                <small class="text-left">EFE</small>
                                                                <div class="text-left font-medium">{{$datos_hotel->simboloMoneda}}</div>
                                                            </span>
                                                        </div>
                                                        <input type="text" name="montoApertura" id="montoApertura"
                                                            class="form-control form-control-lg montoApertura"
                                                            style="height: 58px;border-left: 0px; border-right: 0px;"
                                                            id="monto_aper" value="" autocomplete="off" required=""
                                                            data-fv-field="onlyNum">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="codLocalidad" id="" value="{{ $searchText }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-white">
                                        <a class="btn btn-success btn-block abrir_o ">ABRIR CAJA</a>
                                        <button type="submit" class="btn btn-success btn-block abrir"
                                            style="display: none">ABRIR CAJA</button>
                                    </div>
                                </form>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- style="margin-left:auto; margin-right:auto;" --}}
    {{-- <form action="#" method="POST" id="form" >
        {{ csrf_field() }}

    </form> --}}


    {{-- {!!  Form::close() !!} --}}



    @push('scripts')
        @if (isset($registro))
            @if ($registro->codUsuario != auth()->user()->IdUsuario)
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Advertencia!',
                            icon: 'warning',
                            // showDenyButton: true,
                            // confirmButtonColor: '#36BE80',
                            html: 'Caja aperturada por otro usuario. <br> Espere que el usuario responsable cierre la caja.<br><br> ',
                            confirmButtonText: 'Aceptar',
                            // footer: '¿Está Usted de Acuerdo?',
                            // denyButtonText: `Aún no`,
                            // closeOnClickOutside: false
                            allowOutsideClick: false

                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                location.href = "{{ asset('reserva/registro') }}";
                            }
                        })
                    });
                </script>
            @endif
        @endif
        <script>
            $('.montoApertura').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });
        </script>
        <script>
            $('.montoCierre').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });
        </script>
        <script>
            $('.registrar').hide();
            $('.apertura').unbind().click(function() {
                var $button = $(this);
                //   var data_nombre = $button.attr('data-nombre');
                Swal.fire({
                    title: '¿Está seguro de Agregar el  Ingreso?',
                    showDenyButton: true,
                    confirmButtonText: `Estoy seguro`,
                    denyButtonText: `Cancelar`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                        $(".registrar").click();

                        //   window.location.href = d;
                    } else if (result.isDenied) {
                        Swal.fire('No se realizó ningún cambio', '', 'info')
                    }
                })
                return false;
            });
        </script>
        <script>
            $('.cerrar_o').unbind().click(function() {
                // var $button = $(this);
                var importe = document.getElementById('montoCierre').value;
                if (importe === '') {
                    $(".cerrar").click();
                } else {
                    Swal.fire({
                        title: 'Necesitamos de tu Confirmación',
                        showDenyButton: true,
                        // confirmButtonColor: '#36BE80',
                        html: 'Se cerrará la caja con los siguientes datos:' +
                            '<table class="table text-nowrap"><tr><td>Importe</td><td>' + @json($datos_hotel->simboloMoneda) + ' ' + importe +
                            '</td></tr></table>' +
                            '<span style="font-weight: bold">¿Está Usted de Acuerdo?</span>',
                        confirmButtonText: `Sí, Adelante!`,
                        denyButtonText: `Cancelar`,
                        icon: 'info',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(".cerrar").click();
                        }
                    })
                    return false;
                }
            });
        </script>
        <script>
            $('.abrir_o').unbind().click(function() {
                // var $button = $(this);
                var importe = document.getElementById('montoApertura').value;
                if (importe === '') {
                    $(".abrir").click();
                } else {
                    Swal.fire({
                        title: 'Necesitamos de tu Confirmación',
                        showDenyButton: true,
                        // confirmButtonColor: '#36BE80',
                        html: 'Se Aperturara la caja con los siguientes datos:' +
                            '<table class="table text-nowrap"><tr><td>Importe</td><td>' + @json($datos_hotel->simboloMoneda) + ' ' + importe +
                            '</td></tr></table>' +
                            '<span style="font-weight: bold">¿Está Usted de Acuerdo?</span>',
                        confirmButtonText: `Sí, Adelante!`,
                        denyButtonText: `Cancelar`,
                        icon: 'info',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(".abrir").click();
                        }
                    })
                    return false;
                }
            });
        </script>
        @if (Session::has('success'))
            <script type="text/javascript">
                Swal.fire({
                    title: 'Proceso Terminado',
                    confirmButtonColor: '#36BE80',
                    html: 'La caja ha sido cerrada.<br>' +
                        'Puede imprimir el arqueo de caja, para obtener el detalle de sus procesos.<br>' +
                        '<span><a href="{{ route('arqueo_caja.pdf', [Session::get('success')]) }}" target="_blank"><i class="fas fa-print"></i><br>Arqueo de Caja</a> </span><br>',
                    confirmButtonText: `Aceptar`,
                    icon: 'success',
                })
            </script>
        @endif
        @if (Session::has('flash'))
            <script type="text/javascript">
                Swal.fire({
                    title: 'Aviso',
                    confirmButtonColor: '#36BE80',
                    html: '<span> {{ Session::get('flash') }} </span><br>',
                    confirmButtonText: `Aceptar`,
                    icon: 'success',
                })
            </script>
        @endif
        <script>
            // Sumar Monto Anterior + Monto Actual
            const agregarMonto = document.querySelectorAll('#addmonto');
            agregarMonto.forEach((input) => {
                input.addEventListener('keyup', sumar);
            })

            function sumar() {
                if (document.getElementById("addmonto").value === "") {
                    document.getElementById("addmonto").value = 0;
                } else {
                    if (document.getElementById("addmonto").value.length > 1 && document.getElementById("addmonto").value
                        .charAt(0) === "0") {
                        document.getElementById("addmonto").value = document.getElementById("addmonto").value.slice(1);
                    }
                }
                var suma1 = parseFloat(document.getElementById("addmonto").value) +
                    parseFloat(document.getElementById("montoAnterior").value);
                document.getElementById("MontoApertura").value = suma1.toFixed(2);
            }
        </script>
    @endpush
@endsection
