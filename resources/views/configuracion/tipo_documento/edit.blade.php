@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Editar Tipo de Documento</span>
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
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {!! Form::model($tipo_documento, ['method' => 'PATCH', 'route' => ['tipo_documento.update', $tipo_documento->idTipDoc]]) !!}
            {{ Form::token() }}
            <input type="hidden" name="idTipDoc" class="form-control" value="{{ $tipo_documento->idTipDoc }}">
            <div class="form-group">
                <label for="nomTipDoc">Nombre</label>
                <input type="text" name="nomTipDoc" class="form-control" value="{{ $tipo_documento->nomTipDoc }}" placeholder="Nombre...">
            </div>
            <div class="form-group">
                <label for="longitud">Longitud</label>
                <input type="text" name="longitud" class="form-control entero" value="{{ $tipo_documento->longitud }}" placeholder="">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a href="{{asset('configuracion/tipo_documento')}}" class="btn btn-danger">Cancelar</a>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
    @push('scripts')
    <script>
        $('.entero').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '').replace(/,/g, '.');
        });
    </script>
    @endpush
@endsection
