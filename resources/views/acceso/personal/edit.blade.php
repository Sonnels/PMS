@extends('layout.admin')
@section('Contenido')
    {!! Form::open(['url' => route('personal.update', $personal->idPer), 'method' => 'PUT', 'autocomplete' => 'off']) !!}
    <div class="row mt-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="modal-title title_header font-weight-bold" id="exampleModalLongTitle">
                        Editar | {{ $componentName }}
                    </h5>
                    <input type="hidden" name="idPer" value="{{ $personal->idPer }}">
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nombre<span class="text-danger" title="Campo obligatorio">*</span></label>
                                        <div class="input-group a mb-3">
                                            <input type="text" class="form-control" name="nomPer"
                                                placeholder="Ingrese el nombre" autocomplete="off"
                                                value="{{ $personal->nomPer }}" required>
                                        </div>
                                        @if ($errors->has('nomPer'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('nomPer') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <div class="input-group a mb-3">
                                            <input type="text" class="form-control" name="telPer"
                                                placeholder="Ingrese el Teléfono" autocomplete="off"
                                                value="{{ $personal->telPer }}">
                                        </div>
                                        @if ($errors->has('telPer'))
                                            <div>
                                                <span class="text-danger">{{ $errors->first('telPer') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <div style="margin: 0px auto 0px auto">
                            <div style="margin: 0px auto 0px auto">
                                <a href="{{ route('personal.index') }}" type="button" class="btn btn-danger ">Cancelar</a>
                                <button type="submit" class="btn btn-dark text-white">Modificar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
@endsection
