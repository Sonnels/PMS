<?php use App\Http\Controllers\LRenovacionController as LR; ?>
@extends('layout.admin')
@section('Contenido')
    <div class="card">
        <div class="card-header">
            <h4>
                <b>Renovaciones</b>
            </h4>
        </div>
        <div class="card-body">
            @include('reserva.listar-renovacion.search')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead class="bg-secondary">
                            <tr>
                                <td>#</td>
                                <td>HAB.</td>
                                <td>CLIENTE</td>
                                <td>F. RENOV</td>
                                <td>F.ENTRADA</td>
                                <td>F.PREV SALIDA</td>
                                <td>SERVICIO</td>
                                <td class="text-center">CANT.</td>
                                <td class="text-center">CAJA</td>
                                <td colspan="1" style="text-align: center">OPCIONES</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                            @php($cont = ($page - 1) * $paginate + 1)
                            @foreach ($renovacion as $r)
                                <tr>
                                    <td>{{ $cont++ }}</td>
                                    <td>{{$r->Num_Hab}}</td>
                                    <td>{{$r->Nombre}}</td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($r->fRenovacion))}}</td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($r->fIniRen))}}</td>
                                    <td>{{ date('d/m/Y H:i:s', strtotime($r->fFinRen))}}</td>
                                    <td>{{$r->tarRen}}</td>
                                    <td class="text-center">{{$r->canRen}}</td>
                                    <td class="text-center">{{$r->codCaja}}</td>
                                    {{-- <td align="center">
                                        <a class="btn btn-info btn-sm" href="{{ route('listar-renovacion.edit', $r->idRenovacion) }}">
                                            <i class="far fa-edit" title="Editar {{ $r->idRenovacion }} "></i>
                                        </a>
                                    </td> --}}
                                    <td align="center">
                                        @if (LR::get_last_ren($r->IdReserva, $r->idRenovacion))
                                            <form action="{{ route('listar-renovacion.destroy', $r->idRenovacion) }}" method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-default borrar btn-sm"
                                                    title="ELIMINAR {{ $r->idRenovacion }}" data-nombre="{{ $r->idRenovacion }}"><i
                                                        class="fa fa-trash text-danger" aria-hidden="true"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                    {{-- <td>
                                        <a href="{{ route('listar-renovacion.show', $r->idRenovacion)}}" class="btn btn-default btn-sm" target="_black">
                                            <i class="far fa-file-pdf text-danger"></i>
                                        </a>
                                    </td> --}}
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            {{ $renovacion->appends(['searchText' => $searchText, 'searchText2' => $searchText2, 'searchText3' => $searchText3]) }}
        </div>
    </div>


    @push('scripts')
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
        @elseif (Session::has('error'))
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
    @endpush

@endsection
