@extends('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Reporte Limpieza</span>
                </div>
                {{-- @php($searchText3 = empty($searchText3) ? 'TODO' : $searchText3) --}}
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{route('list_limpieza.pdf', [$searchText, $searchText2, $searchText3 == '' ? 'TODO' : $searchText3])}}"
                         target="_blank" >
                         <i class="fas fa-file-pdf text-danger"></i>
                        </a>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @include('reporte.limpieza.search')
                <div class="card-body table-responsive p-0">
                    <table class="table table-sm table-hover text-nowrap">
                        <thead class="bg-secondary">
                            <tr>
                                <td>N°</td>
                                <td>PERSONAL</td>
                                <td>LIMPIEZA</td>
                                <td>HABITACIÓN</td>
                                <td>F. ASIGNACIÓN</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php($cont = 1)
                            @foreach ($limpieza as $l)
                               <tr>
                                   <td>{{ $cont++ }}</td>
                                   <td>{{ $l->nomPer }}</td>
                                   <td>{{ $l->nomLim }}</td>
                                   <td>{{ $l->Num_Hab }}</td>
                                   <td>{{ date('d/m/Y', strtotime($l->fechaDetLim)) }} {{ $l->horaDetLim}}</td>
                               </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
           {{ $limpieza->appends(['searchText' => $searchText, 'searchText2' => $searchText2, 'searchText3' => $searchText3]) }}
        </div>

    </div>


    @push('scripts')

    @endpush

@endsection
