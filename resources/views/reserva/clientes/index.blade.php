<?php use App\Http\Controllers\ClienteController as CC; ?>
@extends('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Clientes</span>
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
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <a href="clientes/create"><button class="btn btn-success">
                    Nuevo Cliente
                </button></a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            @include('reserva.clientes.search')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-sm table-condensed table-hover">
                    <thead class="bg-secondary">
                        <td>CLIENTE</td>
                        <td>N° CELULAR</td>
                        <td>CORREO</td>
                        <td>TIPO DOC.</td>
                        <td>N° DOC.</td>
                        <td>ORIGEN</td>
                        <td>N° MAT.</td>
                        <td colspan="3">OPCIONES</td>
                    </thead>
                    @foreach ($Cliente as $pro)
                        <tr>
                            {{-- <td>{{ $pro->IdCliente }}</td> --}}
                            @if ($pro->TipDocumento == 'RUC')
                                <td>{{ $pro->Nombre }}</td>
                            @else
                                <td>{{ $pro->Nombre }} {{ $pro->Apellido }}</td>
                            @endif
                            <td>{{ $pro->Celular }}</td>
                            <td>{{ $pro->Correo }}</td>
                            <td>
                                @if (!empty($pro->NumDocumento))
                                    {{ $pro->TipDocumento }}
                                @endif
                            </td>
                            <td>{{ $pro->NumDocumento }}</td>
                            <td>{{ $pro->Direccion }}</td>
                            <td>{{ $pro->nroMatricula }}</td>
                            <td>
                                <a href="{{ URL::action('ClienteController@show', $pro->IdCliente) }}">
                                    <button class="btn btn-primary btn-sm"
                                        title="Historial datos de {{ $pro->Nombre }}">
                                        <i class="fas fa-clipboard-list"></i>
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href="{{ URL::action('ClienteController@edit', $pro->IdCliente) }}">
                                    <button class="btn btn-info btn-sm"
                                        title="Editar datos de {{ $pro->Nombre }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </a>
                            </td>
                            <td>
                                @if(CC::validate_destroy($pro->IdCliente))
                                    <form class="edi" action="{{ URL::action('ClienteController@destroy', $pro->IdCliente) }}"
                                        method="POST">
                                        {!! csrf_field() !!}
                                        {!! method_field('DELETE') !!}
                                        <button class="btn btn-danger btn-sm  borrar" title="Eliminar {{ $pro->Nombre }}"
                                            data-nombre="{{ $pro->Nombre }}"><i class="fa fa-trash"
                                                aria-hidden="true"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $Cliente->render() }}
        </div>
    </div>
    @push('scripts')
        @if (Session::has('success'))
            <script>
                Snackbar.show({text: '{{session('success')}}', actionText: 'CERRAR',
                pos: 'bottom-right', actionTextColor: '#27AE60', duration: 6000});
            </script>
        @endif
    @endpush
@endsection
