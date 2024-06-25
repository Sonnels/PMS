<?php use App\Http\Controllers\Pago2Controller as PC; ?>
@extends('layout.admin')
@section('Contenido')
<div class="card">
    <div class="card-header">
        <h4>
            <b>Pagos</b>
        </h4>
        <a class="btn btn-success btn-sm" href="{{ route('pago.create') }}">
            <i class="fas fa-plus-circle" style="color: #cef5e1; margin-right: 10px"></i>Agregar
        </a>
    </div>
    {{-- <div class="card-body">
        @include('caja.pago.search')
    </div> --}}
</div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 style="font-weight: bold">Ultimos Pagos</h4>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-sm text-nowrap">
                        <thead class="bg-secondary">
                            <tr>
                                <td>#</td>
                                {{-- <td>N° Pago</td> --}}
                                <td>FECHA</td>
                                <td>CLIENTE</td>
                                <td>HABITACIÓN</td>
                                <td>MÉTODO DE PAGO</td>
                                <td>MONTO</td>
                                <td style="text-align: center">OPCIONES</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                            @php($cont = ( ($page-1) * $paginate) + 1)
                            @foreach ($registro as $r)
                                <tr>
                                    <td>{{ $cont++ }}</td>
                                    {{-- <td>{{ $r->idPagos }}</td> --}}
                                    <td>{{ date('d/m/Y H:i:s', strtotime($r->fecPag)) }}</td>
                                    <td>{{ $r->Nombre }}</td>
                                    <td>{{ $r->Num_Hab }}</td>
                                    <td>{{ $r->metPag }}</td>
                                    <td style="text-align: right">{{ $r->monPag }}</td>
                                    <td align="center">
                                        @if (PC::validate_destroy($r->codCaja, $r->IdReserva))
                                            <form action="{{ route('pago.destroy', $r->idPagos)  }}"
                                                method="POST">
                                                {!! csrf_field() !!}
                                                {!! method_field('DELETE') !!}
                                                <button class="btn btn-danger borrar btn-sm"
                                                    title="Eliminar {{ $r->idPagos }}" data-nombre="{{ $r->idPagos }}"><i
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
            {{ $registro->appends(['searchText' => $searchText]) }}
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
