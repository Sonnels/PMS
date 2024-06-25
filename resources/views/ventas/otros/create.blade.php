@extends('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">
                        Nueva Venta
                    </span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
                        {{-- <li class="breadcrumb-item active">Simple Tables</li> --}}
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-xs-6">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    @include('reserva.registro.cliente_modal')

    <form action="{{ route('otros.store') }}" method="POST" id="form">
        @csrf
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="proveedor">Cliente</label>
                    <table style="width: 100%">
                        <tr>
                            <td colspan="2">
                                <div id="selectCliente">
                                </div>
                            </td>
                            <td style=" width: 2%;">
                                <a href="" data-target="#modal-add" style="float: right;" data-toggle="modal"
                                    class="btn btn-success">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                <div class="form-group">
                    <label for="">Producto</label>
                    <select class="form-control form-control-sm selectpicker" name="codProducto" id="pidarticulo"
                        data-live-search="true">
                        <option value="" hidden selected>Selecione Producto</option>
                        @foreach ($producto as $p)
                            <option value="{{ $p->IdProducto }}_{{ $p->stock }}_{{ $p->Precio }}">
                                {{ $p->NombProducto }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" name="cantidad" id="pcantidad" class="form-control form-control-sm"
                        placeholder="Ejm: 2">
                </div>
            </div>
            <div class="col-md-1 col-6">
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" disabled name="pstock" id="pstock" class="form-control form-control-sm"
                        placeholder="Stock">
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="form-group">
                    <label for="precio_venta">Precio de Venta</label>
                    <input type="number" disabled name="precioVenta" id="pPrecio" class="form-control form-control-sm"
                        placeholder="Precio de venta">
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="form-group">
                    <label for="descuento">Descuento</label>
                    <input type="number" name="descuento" id="pdescuento" class="form-control form-control-sm"
                        placeholder="Descuento" value="0" min="0">
                </div>
            </div>
            <div class="col-12 text-center">
                <div class="form-group">
                    <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body table-responsive p-0">
                        <table id="detalles" class="table table-striped table-condensed table-hover">
                            <thead class="bg-secondary">
                                <td>OPCIONES</td>
                                <td>PRODUCTO</td>
                                <td>CANTIDAD</td>
                                <td>PRECIO VENTA</td>
                                <td>DESCUENTO</td>
                                <td>SUB TOTAL</td>
                            </thead>
                            <tfoot>
                                <th>TOTAL</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>
                                    <span for="">MÉTODO PAGO</span>
                                    <div class="input-group">
                                        @php($metPago = ['EFECTIVO', 'TARJETA', 'B. DIGITAL'])
                                        <select name="metodoPago" class="form-control metodoPago">
                                            @foreach ($metPago as $m)
                                                <option value="{{ $m }}"
                                                    {{ old('metodoPago') == $m ? 'selected' : '' }}>{{ $m }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </th>
                                <th>
                                    <h4 id="total">{{ $datos_empresa->simboloMoneda }} 0.00</h4> <input type="hidden"
                                        name="totalVenta" id="total_venta">
                                </th>
                            </tfoot>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center" id="guardar">
                <div class="form-group">
                    <button class="btn bg-primary" type="submit" id="enviar2">
                        Guardar
                    </button>
                    <a href="{{ asset('ventas/otros') }}" class="btn btn-danger">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </form>
    {{-- <script>
        if (document.getElementById('nroCuenta').value === 'TARJETA') {
            document.getElementById('nroCuentaB').style.display = 'block';
        } else {
            document.getElementById('nroCuentaB').style.display = 'none';
        }

        const mPago = document.querySelector('.metodoPago');
        mPago.addEventListener('change', (event) => {
            if (event.target.value.toString() === 'TARJETA') {
                document.getElementById('nroCuentaB').style.display = 'block';
            } else {
                document.getElementById('nroCuentaB').style.display = 'none';
                document.getElementById('nroCuenta').value = '';
            }
        });
    </script> --}}

    @push('scripts')
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
                                location.href = "{{ asset('ventas/otros') }}";
                            }
                        })
                    });
                </script>
            @endif
        @endif


        @if (Session::has('error'))
            <script type="text/javascript">
                // const Toast = Swal.mixin({
                //     toast: true,
                //     position: 'top-end',
                //     showConfirmButton: false,
                //     timer: 3000,
                //     timerProgressBar: true,
                //     onOpen: (toast) => {
                //         toast.addEventListener('mouseenter', Swal.stopTimer)
                //         toast.addEventListener('mouseleave', Swal.resumeTimer)
                //     }
                // });
                // Toast.fire({
                //     icon: 'error',
                //     title: '{{ Session::get('error') }}',
                //     customClass: 'swal-pop',
                // })
                alert('{{ Session::get('error') }}');
            </script>
        @endif
        <script>
            const selectCliente = document.getElementById('selectCliente');

            function obtenerClientes(idCliente = '') {
                let ruta = '{{ route('obtenerClientes') }}';
                ruta = ruta + `?IdCliente=${idCliente}`;
                console.log(ruta)
                fetch(ruta)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            selectCliente.innerHTML = data.select;
                            $('#IdCliente').selectpicker('refresh');
                        }
                    })
                    .catch(error => {
                        console.error('Error al obtener los clientes:', error);
                    });
            }
            obtenerClientes();

            function limpiaValidacionCliente() {
                document.getElementById('idTipDoc-error').innerHTML = "";
                document.getElementById('NumDocumento-error').innerHTML = "";
                document.getElementById('Nombre-error').innerHTML = "";
                document.getElementById('Correo-error').innerHTML = "";
                document.getElementById('Celular-error').innerHTML = "";
                document.getElementById('Direccion-error').innerHTML = "";
                document.getElementById('nroMatricula-error').innerHTML = "";
            }

            function limpiarValorCliente() {
                document.getElementById('idTipDoc').value = "";
                document.getElementById('NumDocumento').value = "";
                document.getElementById('Nombre').value = "";
                document.getElementById('Correo').value = "";
                document.getElementById('Celular').value = "";
                document.getElementById('Direccion').value = "";
                document.getElementById('nroMatricula').value = "";
            }

            let inputNombre = document.getElementById('Nombre');
            inputNombre.addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });

            document.querySelector('#formCliente').addEventListener('submit', function(e) {
                let form = this;
                let fd = new FormData(form);
                e.preventDefault();
                let myButton = document.getElementById('enviarCliente');
                myButton.disabled = true;
                myButton.style.opacity = 0.7;
                myButton.textContent = 'Procesando ...';

                // Realizar la solicitud AJAX
                fetch("{{ route('guardarCliente') }}", {
                        method: 'POST',
                        body: fd,
                    })
                    .then(response => response.json())
                    .then(data => {
                        limpiaValidacionCliente();
                        if (data.success) {
                            limpiarValorCliente();
                            obtenerClientes(data.idCliente);
                            Snackbar.show({
                                text: 'Cliente guardado exitosamente',
                                actionText: 'CERRAR',
                                pos: 'bottom-right',
                                actionTextColor: '#27AE60',
                                duration: 6000
                            });
                            $('#modal-add').modal('hide');
                            myButton.disabled = false;
                            myButton.style.opacity = 1;
                            myButton.textContent = 'Guardar';
                        } else {
                            data.errors.forEach(error => {
                                document.getElementById(error.field + '-error').innerHTML = error.message;
                            });
                            myButton.disabled = false;
                            myButton.style.opacity = 1;
                            myButton.textContent = 'Guardar';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });



            $('#nroCuenta').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
            });
            $(document).ready(function() {
                $("#bt_add").click(function()

                    {
                        agregar();
                    });
            });
            let simboloMoneda = @json($datos_empresa->simboloMoneda);
            var cont = 0;
            total = 0;
            subtotal = [];
            $("#guardar").hide();
            $("#pidarticulo").change(mostrarValores);


            function mostrarValores() {
                datosArticulos = document.getElementById('pidarticulo').value.split('_');
                $("#pPrecio").val(datosArticulos[2]);
                $("#pstock").val(datosArticulos[1]);
            }

            function agregar() {

                datosArticulos = document.getElementById('pidarticulo').value.split('_');


                idarticulo = datosArticulos[0];
                articulo = $("#pidarticulo option:selected").text();
                cantidad = $("#pcantidad").val();
                stock = $("#pstock").val();
                precio_venta = $("#pPrecio").val();
                descuento = $("#pdescuento").val();

                if (idarticulo != "" && cantidad != "" && cantidad > 0 && descuento != "" && precio_venta != "") {
                    if (parseInt(stock) >= parseInt(cantidad)) {
                        subtotal[cont] = (cantidad * precio_venta - descuento);
                        total = total + subtotal[cont];

                        var fila = '<tr class="selected" id="fila' + cont +
                            '"><td align="center"><button type="button" class="btn btn-default btn-sm" onclick="eliminar(' +
                            cont +
                            ');"><i class="fas fa-trash-alt text-danger"></i></button></td><td><input type="hidden" name="codProducto[]" value="' +
                            idarticulo + '">' +
                            articulo + '</td><td><input type="hidden" name="cantidad[]" readOnly value="' + cantidad +
                            '">' + cantidad + '</td><td><input type="hidden" name="precioVenta[]" readOnly value="' +
                            precio_venta +
                            '">' + precio_venta + '</td><td><input type="hidden" name="descuento[]" readOnly value="' +
                            descuento +
                            '">' + descuento + '</td><td>' +
                            simboloMoneda + ' ' + subtotal[cont] + '</td></tr>';
                        cont++;
                        limpiar();
                        $('#total').html(@json($datos_empresa->simboloMoneda) + ' ' + total);
                        $('#total_venta').val(total);
                        evaluar();
                        $('#detalles').append(fila);
                    } else {
                        alert('La cantidad a vender supera el stock.');
                    }


                } else {
                    alert("Error al ingresar el detalle de la venta, revise los datos del articulo")
                }
            }


            function limpiar() {
                $("#pcantidad").val("");
                $("#pdescuento").val("0");
                $("#pprecio_venta").val("");
            }

            function evaluar() {
                if (total > 0) {
                    $("#guardar").show();
                } else {
                    $("#guardar").hide();
                }
            }

            function eliminar(index) {
                total = total - subtotal[index];
                $("#total").html(@json($datos_empresa->simboloMoneda) + ' ' + total);
                $("#total_venta").val(total);
                $("#fila" + index).remove();
                evaluar();
            }

            // Para el formulario
            document.querySelector('#form').addEventListener('submit', function(e) {
                var form = this;
                e.preventDefault();

                // Utiliza SweetAlert2 para mostrar una ventana de confirmación
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: '¿Quieres continuar con la venta?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, confirmar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let myButton = document.getElementById('enviar2');
                        myButton.disabled = true;
                        myButton.style.opacity = 0.7;
                        myButton.textContent = 'Procesando ...';
                        form.submit();
                    }
                });
            });
        </script>


        @if (Session::has('success'))
            <script>
                toastr.success('{{ Session::get('success') }}', 'Operación Correcta', {
                    "positionClass": "toast-top-right"
                })
            </script>
        @endif
    @endpush
@endsection
