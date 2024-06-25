@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Ingresos</span>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{route('list_compra.pdf', [$searchText, $searchText2])}}" class="btn btn-default"  target="_blank">
                            <i class="fas fa-file-pdf text-danger" title="Reporte de Compras - PDF"></i>
                        </a>
                        <a href="{{route('list_compra.excel', [$searchText, $searchText2])}}" class="btn btn-default"  target="_blank">
                            <i class="fas fa-file-excel text-success" title="Reporte de Compras - EXCEL"></i>
                        </a>
                        <a href="{{route('list_compraDetalladoE.excel', [$searchText, $searchText2])}}" class="btn btn-default"  target="_blank">
                            {{-- <i class="fas fa-file-excel text-success"></i> --}}
                            <i class="far fa-file-excel text-success" title="Reporte de Compras Detallado"></i>
                        </a>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <a href="ingreso_producto/create" class="btn btn-success"> Nuevo </a>
            </div>
        </div>
    </div>
        @include('compras.ingreso_producto.search')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm table-striped table-condensed table-hover">
                    <thead class="bg-secondary">
                        <td>N°</td>
                        <td>FECHA</td>
                        <td>HORA</td>
                        <td>PROVEEDOR</td>
                        <td align="right">TOTAL</td>
                        <td align="center" colspan="2">OPCIONES</td>
                    </thead>
                    @php($page = isset($_GET['page']) ? $_GET['page'] : 1)
                    @php($cont = ( ($page-1) * $paginate) + 1)
                    @foreach ($ingresos as $ing)
                        <tr>
                            <td>{{$cont++}}</td>
                            <td>{{ date('d/m/Y', strtotime($ing->fecha)) }} </td>
                            <td>{{ $ing->hora }}</td>
                            <td>{{ $ing->nomPro }}</td>
                            {{-- <td>{{ $ing ->tipo_comprobante. ': '. $ing ->serie_comprobante. '-'. $ing ->num_comprobante}}</td> --}}
                            <td align="right">{{$empresa_ini->simboloMoneda}}{{ $ing->total }}</td>
                            {{-- <td>{{ $ing ->estado}}</td> --}}
                            <td align="center">
                                <a href="{{ URL::action('IngresoController@show', $ing->idingreso) }}"> <button
                                        class="btn btn-primary btn-sm">Detalles</button> </a>
                                {{-- <a href="#" data-target="#modal-delete-{{$ing->idingreso}}" data-toggle="modal"> <button class="btn btn-danger">Anular</button> </a> --}}
                            </td>
                            <td>
                                <form action="{{ URL::action('IngresoController@destroy', $ing->idingreso) }}"
                                    method="POST">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <button class="btn btn-danger btn-sm  borrar" title="Eliminar Ingreso N° {{ $ing->idingreso }}"
                                        data-nombre="Ingreso N° {{ $ing->idingreso }}"><i class="fa fa-trash"
                                            aria-hidden="true"></i></button>
                                </form>
                            </td>
                        </tr>
                        @include('compras.ingreso_producto.modal')
                    @endforeach
                </table>
            </div>
            {{ $ingresos->appends(['searchText' => $searchText]) }}
        </div>
    </div>
    @push('scripts')
        @if (Session::has('success'))
            <script>
                Snackbar.show({text: '{{session('success')}}', actionText: 'CERRAR', pos: 'bottom-right', actionTextColor: '#27AE60', duration: 6000});
            </script>
        @endif
        @if (Session::has('error'))
            <script>
                Snackbar.show({text: '{{session('error')}}', actionText: 'CERRAR', pos: 'bottom-right', actionTextColor: '#FF5050', duration: 6000});
            </script>
        @endif
    @endpush
@endsection
