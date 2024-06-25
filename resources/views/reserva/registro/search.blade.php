{!! Form::open(['url' => 'reserva/registro', 'method' => 'GET', 'autocomplete' => 'off', 'role' => 'search']) !!}
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <span class="title_header">
                    @if ($searchText != '')
                    <i class="fa fa-h-square" aria-hidden="true" style="padding-right: 1em"></i> Habitaciones del {{ $searchText }}
                        @else
                    <i class="fa fa-h-square" aria-hidden="true" style="padding-right: 1em"></i> Se muestran todas las Habitaciones
                    @endif
                </span>
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
    <div class="col-log-4 col-md-4 col-sm-8 col-xs-12">
        <div class="form-group">
            <select name="searchText" class="form-control searchText">
                <option value="">Seleccione el Nivel/Piso</option>
                @foreach ($nivel as $n)
                    @if ($n->IdNivel == $searchText)
                        <option value="{{ $n->IdNivel }}" selected>{{ $n->Denominacion }}</option>
                    @else
                        <option value="{{ $n->IdNivel }}">{{ $n->Denominacion }}</option>
                    @endif
                @endforeach
            </select>

            <span class="input-group-btn">
                <button type="submit" id="buscar" class="btn btn-primary"> </button>
            </span>

            <!-- <input type="text" class="form-control" name="searchText" placeholder="Buscar.." value="{{ $searchText }}"> -->

        </div>
    </div>
</div>

{{ Form::close() }}
