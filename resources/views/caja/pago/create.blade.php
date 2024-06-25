@extends('layout.admin')
@section('Contenido')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="card">
        <div class="card-header">
            <h4>
                <b>Añadir Pago</b>
            </h4>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 col-12">
                    <div class="form-group">
                        <label for="">Habitación</label>
                        <select name="IdReserva" id="IdReserva"
                            class="form-control {{ $errors->has('IdReserva') ? 'is-invalid' : '' }}">
                            <option value="">Seleccionar</option>
                            @foreach ($habitacion as $h)
                                <option value="{{ $h->IdReserva }}">{{ $h->Num_Hab }} | {{$h->Nombre}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('IdReserva'))
                            <span class="text-danger">{{ $errors->first('IdReserva') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-group">
                        <label for="">Deuda Total</label><br>
                        <span id="deuda_total" style="font-size: 1.5em; font-weight: bold"></span>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="card-header text-white bg-secondary">
                            <h3 class="card-title">Consumo / Servicio</h3>
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
                            <div class="form-group table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <th>#</th>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th>Cant.</th>
                                        <th>Precio</th>
                                        <th>Estado</th>
                                        <th>Sub Total</th>
                                    </thead>
                                    <tbody id="data_consumo">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card">
                        <div class="card-header text-white bg-secondary">
                            <h3 class="card-title">Alquiler</h3>
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
                            <form action="{{ route('pago.store') }}" method="post" id="form1">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="IdReserva" id="IdReservalbl">
                                    <div class="col-md-6 col-12">
                                        <label for="">Costo:</label><br>
                                        <span id="lblcosto"></span>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="">Descuento:</label><br>
                                        <span id="lbldescuento"></span>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="">Pagado:</label> <br>
                                        <span id="lblpagado"></span>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label for="">Deuda:</label><br>
                                        <span id="lbldeuda" style="font-size: 1.5em; color: #135a99"></span>
                                        <input type="hidden" id="txtdeuda">
                                    </div>
                                    <div style=" border-top: 2px solid #253441; width: 100%"></div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Método</label>
                                            <select name="metPag" id="metPag" class="form-control {{ $errors->has('metPag') ? 'is-invalid' : '' }}"
                                                required>
                                                <option value="" selected hidden>Seleccionar</option>
                                                @foreach ($metPago as $m)
                                                    <option value="{{ $m }}">{{ $m }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('metPag'))
                                                <span class="text-danger">{{ $errors->first('metPag') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Importe</label>
                                            <input type="text" name="monPag" id="monPag"
                                                class="form-control decimales {{ $errors->has('monPag') ? 'is-invalid' : '' }}"
                                                required>
                                            @if ($errors->has('monPag'))
                                                <span class="text-danger">{{ $errors->first('monPag') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- <div class="col-12">
                                        <div class="form-group">
                                            <label for="">Cambio/Vuelto</label>
                                            <input type="text" class="form-control">
                                        </div>
                                    </div> --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="sumit" class="btn btn-primary btn-sm">Registrar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            // VARIABLES
            let deuda_consumo = 0;
            let deuda_alquiler = 0;

            // FUNCIONES
            function cargar_consumo(id) {
                let consumo = @json($consumo);
                let cont_consumo = 0;
                $("#data_consumo").html("");
                deuda_consumo = 0;
                for (x of consumo) {
                    if (x.IdReserva == id) {
                        cont_consumo += 1;
                        let tr = `<tr>
                            <td>` + cont_consumo + `</td>
                            <td>` + x.Denominacion + `</td>
                            <td>` + x.NombProducto + `</td>
                            <td>` + x.Cantidad + `</td>
                            <td style="text-align:right">` + x.Precio + `</td>
                            <td class=" badge badge-` + (x.Estado == 'PAGADO' ? 'success' : 'danger') + `">` +
                            (x.Estado != 'PAGADO' ? '<a href="#" class="text-white" onclick="cambiarEstado(' + x.IdConsumo +
                                ')">' + x.Estado + '</a>' : '<span>' + x.Estado + '</span>') + `</td>
                            <td style="text-align:right">` + (x.Cantidad * x.Precio).toFixed(2) + `</td>
                        </tr>`;
                        $("#data_consumo").append(tr);
                        deuda_consumo += (x.Estado != 'PAGADO' ? (x.Cantidad * x.Precio) : 0);
                    }
                }
                let tr_deuda = `<tr>
                        <td colspan="5"></td>
                        <td>Deuda: </td>
                        <td style="text-align:right; font-size:1.5em; color: #135a99">` + deuda_consumo.toFixed(2) + `</td>
                    </tr>`;
                $("#data_consumo").append(tr_deuda);
                console.log(consumo)
            }

            function cargar_alquiler(id) {
                let alquiler = @json($alquiler);
                let renovacion = @json($renovacion);
                let pago = @json($pago);
                let pagado_pago = 0;
                for (x of pago) {
                    if (x.IdReserva == id) {
                        console.log(x)
                        pagado_pago = parseFloat(x.total);
                    }
                }

                let pagado_alquiler = 0;
                let costo_alquiler = 0;
                for (a of alquiler) {
                    if (a.IdReserva == id) {
                        console.log(a)
                        $("#lblcosto").html(a.CostoAlojamiento);
                        $("#lbldescuento").html(a.descuento);
                        pagado_alquiler = parseFloat(a.TotalPago);
                        costo_alquiler = parseFloat(a.CostoAlojamiento);
                    }
                }

                let costo_renovacion = 0;

                for (r of renovacion) {
                    if (r.IdReserva == id) {
                        costo_renovacion = r.total;
                    }
                }

                let pagado_total = pagado_pago + pagado_alquiler;
                deuda_alquiler = parseFloat(costo_alquiler) + parseFloat(costo_renovacion) - pagado_total;
                $("#lblpagado").html((pagado_total).toFixed(2));
                $("#lbldeuda").html((deuda_alquiler).toFixed(2));
                $("#txtdeuda").val(deuda_alquiler);
            }

            function cambiarEstado(id) {
                let metodoPago = "";
                Swal.fire({
                    title: 'Está seguro en pagar este producto?',
                    text: "¡No podrás revertir esto!",
                    input: 'select',
                    inputOptions: {
                        'EFECTIVO': 'EFECTIVO',
                        'TARJETA': 'TARJETA',
                        'B. DIGITAL': 'B. DIGITAL'
                    },
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí,continuar!',
                    cancelButtonText: 'Cancelar',
                    preConfirm: (value) => {
                        metodoPago = value;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = '{{ route('pagar_consumo', [':id', ':metodoPago']) }}';
                        console.log(url);
                        url = url.replace(':id', id);
                        url = url.replace(':metodoPago', metodoPago);
                        window.location.href = url;
                    }
                })
            }

            // ACCIONES

            $('.decimales').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });

            document.querySelector('#IdReserva').addEventListener('change', (event) => {
                if (event.target.value != '') {
                    cargar_consumo(event.target.value);
                    cargar_alquiler(event.target.value);
                    $('#deuda_total').html((deuda_consumo + deuda_alquiler).toFixed(2));
                } else {
                    $('#lblcosto').html('');
                    $('#lbldescuento').html('');
                    $('#lblpagado').html('');
                    $('#lbldeuda').html('');
                    $("#txtdeuda").val('');
                    $('#data_consumo').html('');
                    $('#deuda_total').html('');
                }
                $('#IdReservalbl').val(event.target.value);

            });

            document.querySelector('#form1').addEventListener('submit', function(e) {
                var form = this;
                e.preventDefault();
                let importe = parseFloat($('#monPag').val());
                let metodoPago = $('#metPag').val();
                let sel_habitacion = document.getElementById('IdReserva');
                let habitacion = (sel_habitacion.options[sel_habitacion.selectedIndex].text).split(' | ')[0];
                let cliente = (sel_habitacion.options[sel_habitacion.selectedIndex].text).split(' | ')[1];
                if (importe > deuda_alquiler) {
                    toastr.error('El importe no tiene que ser mayor a la deuda.', 'Obligatorio', {
                        "positionClass": "toast-bottom-right"
                    })
                    return 0;
                }else if(importe <= 0){
                    toastr.error('El importe tiene que ser mayor a 0.', 'Obligatorio', {
                        "positionClass": "toast-bottom-right"
                    })
                    return 0;
                }else if (isNaN(importe)){
                    toastr.error('El importe tiene que ser un número valido.', 'Obligatorio', {
                        "positionClass": "toast-bottom-right"
                    })
                    return 0;
                }
                console.log(importe + ' ' + NaN)
                Swal.fire({
                    // title: 'Necesitamos de tu Confirmación',
                    showDenyButton: true,
                    // customClass: 'swal-wide',
                    allowOutsideClick: false,
                    // confirmButtonColor: '#36BE80',
                    html: `<div class="table-responsive">
                        <table class="table text-nowrap">
                            <tr><td align="left" style="font-weight: bold">Habitación:</td><td align="left">${habitacion}</td></tr>
                            <tr><td align="left" style="font-weight: bold">Cliente:</td><td td align="left">${cliente}</td></tr>
                            <tr><td align="left" style="font-weight: bold">Importe:</td><td align="left">${importe.toFixed(2)}</td></tr>
                            <tr><td align="left" style="font-weight: bold">Método Pago:</td><td align="left">${metodoPago}</td></tr>
                        </table></div>
                        <span style="color: #36BE80; font-weight: bold">¿Está Usted de Acuerdo?</span>`,
                    confirmButtonText: `Sí, Adelante!`,
                    denyButtonText: `Cancelar`,
                    icon: 'info',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // <--- submit form programmatically
                    }
                })
            })
        </script>
        @if (!isset($caja))
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Advertencia!',
                        icon: 'warning',
                        confirmButtonColor: '#36BE80',
                        html: 'Para poder realizar esta operación es necesario Aperturar Caja <br><br> <span style="color: #36BE80; font-weight: bold">¿Está Usted de Acuerdo?</span>',
                        confirmButtonText: 'Sí, Adelante',
                        allowOutsideClick: false

                    }).then((result) => {
                        /* Read more about isConfirmed, isDenied below */
                        if (result.isConfirmed) {
                            location.href = "{{ asset('caja/apertura') }}";
                        }
                    })
                });
            </script>
        @else
            @if ($caja->codUsuario != auth()->user()->IdUsuario)
                <script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Advertencia!',
                            icon: 'warning',
                            confirmButtonColor: '#36BE80',
                            html: 'Caja aperturada por otro usuario. <br> Espere que el usuario responsable cierre la caja.<br><br> ',
                            confirmButtonText: 'Sí, Adelante',
                            allowOutsideClick: false

                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                location.href = "{{ asset('ventas/otros') }}";
                            }
                        })
                    });
                </script>
            @endif
        @endif
        @if (Session::has('success'))
            <script type="text/javascript">
                Swal.fire({
                    title: 'Pago realizado',
                    confirmButtonColor: '#36BE80',
                    text: '{{ Session::get('success') }}',
                    confirmButtonText: `Aceptar`,
                    icon: 'success',
                })
                $('#IdReserva').val('{{ Session::get('id') }}');
                cargar_consumo('{{ Session::get('id') }}');
                cargar_alquiler('{{ Session::get('id') }}');
                $('#deuda_total').html((deuda_consumo + deuda_alquiler).toFixed(2));
                $('#IdReservalbl').val('{{ Session::get('id') }}');
            </script>
        @elseif (Session::has('error'))
            <script>
                toastr.error('{{ Session::get('error') }}', 'Operación Fallida', {
                    "positionClass": "toast-top-right"
                })
            </script>
        @endif
    @endpush
@endsection
