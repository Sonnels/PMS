@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Estado de Hospedaje</span>
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
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">


            <div class="form-group">
                <input type="hidden" name="IdCliente" class="form-control" value="{{ $reserva->IdCliente }}">
            </div>

            <div class="form-group">
                <input type="hidden" name="Estado" class="form-control" value="H. CULMINADO">
            </div>
            <div class="form-group">
                <input type="hidden" name="IdPago" class="form-control" value="{{ $reserva->IdPago }}">
            </div>
            <div class="form-group">
                <input type="hidden" name="Num_Hab" class="form-control" value="{{ $reserva->Num_Hab }}">
            </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <span for="proveedor" class="text-success">CLIENTE</span>
                <p>{{ $reserva->Ndcliente }} | {{ $reserva->nomcli }} {{ $reserva->apecli }} |
                    {{ $reserva->Celular }}</p>
            </div>
        </div>

        <div class="col-lg-2 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <span for="Num_Hab" class="text-success">HABITACIÓN</span>
                <p>{{ $reserva->Num_Hab }} - {{ $reserva->Denominacion }}</p>
            </div>
        </div>
        <div class="col-lg-3 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <span for="Precioxdia" class="text-success">PRECIO (PH | PN | PM)</span>
                <p>S/ {{ $reserva->precioHora }} | S/ {{ $reserva->precioNoche }} | S/ {{ $reserva->precioMes }}
                </p>
            </div>
        </div>


        <div class="col-lg-2 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <span for="FechEntrada" class="text-success">F. ENTRADA</span>
                <p>{{ $reserva->FechEntrada }}</p>
            </div>
        </div>
        <div class="col-lg-2 col-sm-4 col-md-4 col-xs-12">
            <div class="form-group">
                <span for="FechSalida" class="text-success">F. PREVISTA DE SALIDA</span>
                <p>{{ $reserva->FechSalida }}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead class="bg-olive">
                            <td colspan="5">Detalles de Consumo</td>
                        </thead>
                        <thead>
                            <td>PRODUCTO</td>
                            <td>CANTIDAD</td>
                            <td align="right">PRECIO UNITARIO</td>
                            <!-- <td>Detalles</td> -->

                            <td align="right">SUBTOTAL</td>
                        </thead>
                        <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <!-- <th></th> -->

                        </tfoot>
                        <tbody>
                            @php($total = 0)
                            @php($portotal = 0)
                            @foreach ($consumo as $con)
                                <tr>
                                    <td>{{ $con->NombProducto }}</td>
                                    <td align="center">{{ $con->Cantidad }}</td>
                                    <td align="right">S/ {{ $con->Precio }}</td>
                                    @php($portotal += $con->Total)
                                    <td align="right">S/ {{ $con->Total }}</td>
                                    @php($total += $con->Total)
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">TOTAL CONSUMO</td>
                                <td align="right">S/ {{ number_format($total, 2) }}</td>
                            </tr>

                            <tr style="color: #f38365;">
                                <td colspan="3">MONTO HOSPEDAJE</td>
                                <td align="right">S/ {{ number_format($reserva->CostoAlojamiento, 2) }}</td>
                                <!-- Oculto -->
                                <input type="hidden" name="" id="porpagarc" value="{{ $portotal }}">
                            </tr>
                            <tr style="color: #0d8046;">
                                <td colspan="3">DESCUENTO</td>
                                <td align="right">S/ {{ number_format($reserva->Descuento, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="2"></th>
                                <th>TOTAL</th>
                                <td width="200px">
                                    <input type="text" readOnly id="totalporpagar" class="form-control"
                                        style="text-align:right;"
                                        value="S/ {{ number_format($reserva->CostoAlojamiento - $reserva->Descuento + $total, 2) }}">
                                </td>
                            </tr>
                        </tfoot>
                        <tr>
                            <td>
                                <a href="{{ asset('reserva/listar-registro') }}" class="btn btn-danger">Volver
                                    Atras</a>
                            </td>
                            <td colspan="2"></td>
                            <td>
                                <a href="{{ URL::action('LReservaController@report', $reserva->IdReserva) }}"
                                    target="_black">
                                    <button class="btn btn-info form-control">Imprimir
                                    </button>
                                </a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
