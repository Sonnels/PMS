<?php use App\Http\Controllers\PersonalController; ?>
@extends('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">{{ $componentName }}</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-log-3 col-md-3 col-sm-12 col-xs-12">
            <div class="form-group">
                <a class="btn btn-success" href="" data-target="#modal-add" data-toggle="modal">
                    Nuevo Personal
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-log-4 col-md-4 col-sm-8 col-xs-12">
            <div class="form-group">
                @include('acceso.personal.search')
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table id="datatable" class="table table striped mt-1">
                    <thead class="text-white bg-secondary">
                        <tr>
                            <td class="table-th text-white">ID</td>
                            <td class="table-th text-white">NOMBRE</td>
                            <td class="table-th text-white">TELÉFONO</td>
                            <td class="table-th text-white" style="text-align: center">ACCIONES</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personal as $p)
                            <tr>
                                <td>{{ $p->idPer }}</td>
                                <td>
                                    <h6>{{ $p->nomPer }}</h6>
                                </td>
                                <td>
                                    <h6>{{ $p->telPer }}</h6>
                                </td>
                                <td align="center">
                                    <a class="btn btn-sm btn-info text-white"
                                        href="{{ route('personal.edit', $p->idPer) }}">
                                        <i class="far fa-edit" title="EDITAR CATEGORIA {{ $p->nomPer }}"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    @if (PersonalController::validate_destroy($p->idPer))
                                        <form action="{{ route('personal.destroy', $p->idPer) }}" style="margin-bottom: 0px"
                                            method="POST">
                                            {!! csrf_field() !!}
                                            {!! method_field('DELETE') !!}
                                            <button class="btn btn-danger borrar btn-sm"
                                                title="Eliminar Personal {{ $p->nomPer }}"
                                                data-nombre="{{ $p->nomPer }}"><i class="fas fa-trash"
                                                    aria-hidden="true"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $personal->appends(['searchText' => $searchText])->links() }}
    </div>

    @include('acceso.personal.create')


    @push('scripts')
        <script>
            var table = $('#datatable').DataTable({
                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
            });
            $('#datatable_filter label input').keyup(function(event) {
                // Para los filtros del reporte (si no hay reporte, comentar esta parte)
                console.log(event.target.value)
            });
        </script>
        @if (count($errors) > 0)
            <script>
                $(document).ready(function() {
                    Snackbar.show({
                        text: 'Registre de forma correcta los campos.',
                        actionText: 'CERRAR',
                        pos: 'bottom-right',
                        duration: 5000
                    });
                    $('#modal-add').modal('show');
                });
            </script>
        @endif

        @if (Session::has('success'))
            <script type="text/javascript">
                Snackbar.show({
                    text: '{{ session('success') }}',
                    actionText: 'CERRAR',
                    pos: 'bottom-right',
                    actionTextColor: '#27AE60',
                    duration: 6000
                });
            </script>
        @elseif(Session::has('error'))
            <script type="text/javascript">
                Snackbar.show({
                    text: '{{ session('error') }}',
                    actionText: 'CERRAR',
                    pos: 'bottom-right',
                    actionTextColor: '#FF5050',
                    duration: 6000
                });
            </script>
        @endif
    @endpush
@endsection
