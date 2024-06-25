<?php use App\Http\Controllers\IngresoCajaController as IC; ?>
@extends('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Listado de Egresos</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('caja.egreso.create')

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('caja.egreso.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead class="bg-secondary">
                            <tr>
                                <td>#</td>
                                <td>FECHA</td>
                                <td>HORA</td>
                                <td>ENCARGADO</td>
                                <td>TIPO</td>
                                <td>ENTREGADO A</td>
                                <td>MOTIVO</td>
                                <td>IMPORTE</td>
                                {{-- <th>Estado</th> --}}
                                <td style="text-align: center">OPCIONES</td>
                            </tr>
                        <tbody>
                            @php($cont = 1)
                            @foreach ($egreso as $e)
                                <tr>
                                    <td>{{ $cont++ }}</td>
                                    <td>{{ date('d/m/Y', strtotime($e->fechaEgreso)) }}</td>
                                    <td>{{ $e->horaEgreso }}</td>
                                    <td>{{ $e->Nombre }}</td>
                                    <td>{{ $e->tipo }}</td>
                                    <td>{{ $e->entregadoA }}</td>
                                    <td>{{ $e->motivo }}</td>
                                    <td align="right">{{ $e->importe }}</td>
                                    {{-- @php($estado_css = $e->estado == 'APROBADO' ? 'badge badge-success' : 'badge badge-danger')
                                    <td> <span class="{{ $estado_css }}">{{ $e->estado }}</span></td> --}}
                                    <td align="center">
                                        @if (IC::validate_destroy($e->codCaja))
                                            <form action="{{ route('egreso.destroy', $e->codEgreso) }}" method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-default btn-sm actualizar_ajax2 text-danger"
                                                    title="Anular Registro"
                                                    data-nombre="{{ $e->importe }}_{{ $e->entregadoA }}_{{ $e->motivo }}"><i
                                                        class="fa fa-trash" aria-hidden="true"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $egreso->appends(['searchText' => $searchText,'searchText2' => $searchText2]) }}
        </div>
    </div>
    @push('scripts')
        <script>
            $('.importe').on('input', function() {
                this.value = this.value.replace(/[^0-9,.]/g, '').replace(/,/g, '.');
            });
        </script>
        {{-- @if (!isset($caja))
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Advertencia!',
                        icon: 'warning',
                        confirmButtonColor: '#36BE80',
                        html: 'Para poder realizar esta operación es necesario Aperturar Caja <br><br> <span style="color: #36BE80; font-weight: bold">¿Está Usted de Acuerdo?</span>',
                        confirmButtonText: 'Aceptar',
                        allowOutsideClick: false

                    }).then((result) => {
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
                            if (result.isConfirmed) {
                                location.href = "{{ asset('reserva/registro') }}";
                            }
                        })
                    });
                </script>
            @endif
        @endif --}}
        @if (Session::has('success'))
            <script type="text/javascript">
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
        {{-- ----------------------------------------------- --}}
        @if (Session::has('error'))
            <script type="text/javascript">
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
                    icon: 'error',
                    title: '{{ Session::get('error') }}',
                    customClass: 'swal-pop',
                })
            </script>
        @endif
        @if (count($errors) > 0)
            <script type="text/javascript">
                $(document).ready(function() {
                    <?php if (old('codCategoria') == '') {?>
                    $('#modal-add').modal('show');
                    $("#modal-add").on('hidden.bs.modal', function() {
                        location.reload();
                    });
                    <?php } else { ?>
                    $('#modal-add-<?php echo old('codCategoria'); ?>').modal('show');
                    $("#modal-add-<?php echo old('codCategoria'); ?>").on('hidden.bs.modal', function() {
                        location.reload();
                    });
                    <?php }?>
                });
            </script>
        @endif
    @endpush



@endsection
