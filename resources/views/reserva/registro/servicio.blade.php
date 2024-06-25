@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Añadir Servicio</span>
                </div>

                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <span class="text-gray-dark">N°: </span> <span>{{ $habitacion->Num_Hab }} |
                        {{ $habitacion->tipoden }}</span>
                </div>
                <div class="col-md-4">
                    <span class="text-gray-dark">PRECIO: </span><span> {{ $habitacion->precioHora }} |
                        {{ $habitacion->precioHora6 }} | {{ $habitacion->precioHora8 }} |
                        {{ $habitacion->precioNoche }} | {{ $habitacion->precioMes }}</span>
                    <div id="precioSeleccionado"></div>
                    <input type="hidden" id="Precio" value="">
                    <input type="hidden" id="preciosHab"
                        value="{{ $habitacion->precioHora }}_{{ $habitacion->precioHora6 }}_{{ $habitacion->precioHora8 }}_{{ $habitacion->precioNoche }}_{{ $habitacion->precioMes }}">
                </div>
                <div class="col-md-2" style="font-weight: bold">
                    @if ($habitacion->Estado == 'DISPONIBLE')
                        <span style=" color: #1cad69">
                            {{ $habitacion->Estado }}
                        </span>
                    @elseif ($habitacion->Estado == 'RESERVADO')
                        <span style=" color: #1c7fad">
                            {{ $habitacion->Estado }}
                        </span>
                    @elseif ($habitacion->Estado == 'OCUPADO')
                        <span style=" color: #e67469">
                            {{ $habitacion->Estado }}
                        </span>
                    @endif
                </div>
                <div class="col-md-4">
                    <span class="text-gray-dark">DESCRIPCIÓN: </span> {{ $habitacion->deshab }}
                </div>
            </div>
        </div>
    </div>
    {{-- -------------------------------------------- --}}

    <div class="card">
        <div class="card-header bg-secondary">
            INFORMACIÓN ALQUILER
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <span for="" style="font-weight: bold">FECHA ENTRADA </span>
                        <p>{{ date('d/m/Y', strtotime($reserva->FechEntrada)) }} {{ $reserva->HoraEntrada }}</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <span for="" style="font-weight: bold">FECHA SALIDA </span>
                        <p>{{ date('d/m/Y H:i:s', strtotime($reserva->departure_date)) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('add_service_post') }}" method="POST" id="form1">
        @csrf
        <input type="hidden" name="IdReserva" value="{{ $reserva->IdReserva }}">
        <div class="card">
            <div class="card-header bg-secondary">
                <span>AGREGAR SERVICIOS</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <span for="">SERVICIO</span>
                                    <select class="form-control selectpicker" name="codProducto" id="pidarticulo"
                                        data-live-search="true">
                                        <option value="" hidden selected>Selecione Servicio</option>
                                        @foreach ($servicioExtra as $s)
                                            <option value="{{ $s->idServicio }}_{{ $s->precioS }}">
                                                {{ $s->nombreS }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <span for="precio_venta">VALOR</span>
                                    <input type="number" disabled name="precioVenta" id="pPrecio" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <span for="">CANT</span>
                                    <input type="number" id="pCantidad" class="form-control" min="1" value="1">
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <table id="detalles" class="table table-striped table-condensed table-hover">
                                    <thead>
                                        <th>ELIMINAR</th>
                                        <th>SERVICIO</th>
                                        <th>VALOR</th>
                                        <th>CANT</th>
                                        <th>SUB TOTAL</th>
                                    </thead>
                                    <tfoot>
                                        <th>TOTAL</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>
                                            <h4 id="total">$ 0.00</h4> <input type="hidden" name="totalVenta"
                                                id="total_venta">
                                        </th>
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="form-group">
                            <span for="" title="VALOR SERVICIO">VALOR SERVICIO</span>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white text-muted" style="display: grid;">
                                        <div class="text-left font-medium">$</div>
                                    </span>
                                </div>
                                <input type="text" id="valorServicio" name="valorServicio" value="0" readonly
                                    class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6">
                        <span for="">PAGAR</span>
                        <div class="form-check">
                            <input type="radio" name="estServicio" value="PAGADO" required>
                            <label class="form-check-label">
                                AHORA
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="estServicio" value="FALTA PAGAR" required>
                            <label class="form-check-label">
                                LUEGO
                            </label>
                        </div>
                    </div>

                    <div class="col-md-3 col-6" id="metodoPago" style="display: none">
                        <div class="form-group">
                            <span for="" title="VALOR HABITACIÓN">MÉTODO PAGO</span>
                            @php($metodoPago = ['EFECTIVO', 'TARJETA', 'B. DIGITAL'])
                            <div class="input-group">
                                <select name="metodoPago" class="form-control">
                                    @foreach ($metodoPago as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-primary" type="submit">Registrar</button>
                <a href="{{ asset('reserva/registro') }}" class="btn btn-danger">Volver</a>
            </div>
        </div>
    </form>
    @push('scripts')
        <script>
            $('input[type=radio][name=estServicio]').change(function() {
            if (this.value === 'PAGADO') {
                document.getElementById('metodoPago').style.display = 'block';
            }else{
                document.getElementById('metodoPago').style.display = 'none';
            }
        });
    </script>
        @if (!isset($caja))
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Advertencia!',
                        icon: 'warning',
                        // showDenyButton: true,
                        confirmButtonColor: '#36BE80',
                        html: 'Para poder realizar esta operación es necesario Aperturar Caja <br><br> <span style="color: #36BE80; font-weight: bold">¿Está Usted de Acuerdo?</span>',
                        confirmButtonText: 'Sí, Adelante',
                        // footer: '¿Está Usted de Acuerdo?',
                        // denyButtonText: `Aún no`,
                        // closeOnClickOutside: false
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
                            // showDenyButton: true,
                            confirmButtonColor: '#36BE80',
                            html: 'Caja aperturada por otro usuario. <br> Espere que el usuario responsable cierre la caja.<br><br> ',
                            confirmButtonText: 'Sí, Adelante',
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
            $(document).ready(function() {
                $("#bt_add").click(function() {
                    agregar();
                });
            });
            var cont = 0;
            total = 0;
            subtotal = [];
            const elementos = [];
            $("#guardar").hide();
            $("#pidarticulo").change(mostrarValores);

            function mostrarValores() {
                datosArticulos = document.getElementById('pidarticulo').value.split('_');
                $("#pPrecio").val(datosArticulos[1]);

            }

            function agregar() {
                datosArticulos = document.getElementById('pidarticulo').value.split('_');
                idarticulo = datosArticulos[0];
                articulo = $("#pidarticulo option:selected").text();
                precio_venta = $("#pPrecio").val();
                cantidad = $("#pCantidad").val();

                if (idarticulo != "" && precio_venta != "" && cantidad > 0) {

                    if (evaluar_duplicidad(idarticulo)) {
                        subtotal[cont] = parseFloat(precio_venta) * parseFloat(cantidad);
                        total = total + subtotal[cont];

                        var fila = '<tr class="selected" id="fila' + cont +
                            '"><td align="center"><button type="button" class="btn btn-default btn-sm" onclick="eliminar(' +
                            cont + ',' + idarticulo +
                            ');"><i class="fas fa-trash-alt text-danger"></i></button></td><td><input type="hidden" name="codProducto[]" value="' +
                            idarticulo + '">' + articulo + '</td>' +
                            '<td><input type="hidden" name="precioVenta[]" readOnly value="' +
                            precio_venta + '">' + precio_venta + '</td>' +
                            '<td><input type="hidden" name="cantidad[]" readOnly value ="' + cantidad + '">' + cantidad +
                            '</td>' +
                            '<td>' + subtotal[cont] + '</td></tr>';
                        cont++;
                        limpiar();
                        $('#total').html("$ " + total);
                        $('#total_venta').val(total);
                        $('#valorServicio').val(total);
                        // calcular_descuento();
                        // evaluar();
                        $('#detalles').append(fila);
                    } else {
                        toastr.error('El servicio seleccionado ya se encuentra en la lista.', 'ADVERTENCIA', {
                            "positionClass": "toast-bottom-right"
                        })
                    }

                } else {
                    alert("Error al ingresar el servicio, revise los datos del servicio")
                }
            }

            function limpiar() {

                $("#pprecio_venta").val("");
                $("#pCantidad").val("1");
            }

            // function evaluar() {
            //     if (total > 0) {
            //         $("#guardar").show();
            //     } else {
            //         $("#guardar").hide();
            //     }
            // }
            function evaluar_duplicidad(value) {
                if (elementos.indexOf(value) === -1) {
                    elementos.push(value);
                    return true;
                }
                return false;
            }

            function eliminar(index, id) {
                total = total - subtotal[index];
                var myIndex = elementos.indexOf(String(id));
                if (myIndex !== -1) {
                    elementos.splice(myIndex, 1);
                }
                $("#total").html("$ " + total);
                $("#total_venta").val(total);
                $('#valorServicio').val(total);
                // calcular_descuento();
                $("#fila" + index).remove();
                // evaluar();
                cont--;
            }
        </script>


        {{-- Para boton del formulario --}}
        <script>
            document.querySelector('#form1').addEventListener('submit', function(e) {
                var form = this;

                e.preventDefault(); // <--- prevent form from submitting
                var valorServicio = document.getElementById('valorServicio').value;
                console.log(cont)
                if (cont > 0) {
                    Swal.fire({
                        title: 'Confirmar',
                        // text: "No podrás revertir esta acción.!",
                        html: '<h6>No podrás revertir esta acción.!</h6>' +
                            '<h5>Pago Recibido: ' + '<b>' + valorServicio + '</b>' + '</h5>',
                        // '<h5>Nueva F. Salida: ' + '<b>' + fSalida + '</b>' + '</h5>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Confirmar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // <--- submit form programmatically
                        }
                    })
                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error...',
                        text: 'Tiene que agregar al menos 1 servicio'
                        // footer: '<a href="">Why do I have this issue?</a>'
                    })
                }

            });
        </script>
        <script>
            // Solo números
            $('.numero').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
            });

            function zeroFill(number, width) {
                width -= number.toString().length;
                if (width > 0) {
                    return new Array(width + (/\./.test(number) ? 2 : 1)).join('0') + number;
                }
                return number + ""; // siempre devuelve tipo cadena
            }
        </script>
    @endpush
@endsection
