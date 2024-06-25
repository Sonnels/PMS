<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-add">
    {{-- {{ Form::Open(['action' => ['Cliente2Controller@store'], 'method' => ' POST']) }} --}}
    {!! Form::model($Datos, [
        'method' => 'PATCH',
        'route' => ['datos_hotel.update', $Datos->IdHotel],
        'files' => 'true',
    ]) !!}
    {{ Form::token() }}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title" style="text-align: center">
                    Datos de la Empresa</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="Nombre">NOMBRE DEL HOTEL</label>
                            <div class="input-group">

                                <input type="text" name="Nombre"
                                    @if (old('Nombre') != '') value="{{ old('Nombre') }}"
                                @else
                                    value="{{ $Datos->nombre }}" @endif
                                    class="form-control" placeholder="Ingrese el nombre del Hotel" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="Direccion">DIRECCIÓN</label>
                            <div class="input-group">
                                <input type="text" name="Direccion" id="Direccion"
                                    @if (old('Direccion') != '') value="{{ old('Direccion') }}"
                                @else
                                    value="{{ $Datos->direccion }}" @endif
                                    class="form-control" placeholder="Ejm: Lima - Jr. Las Americas 454" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="Telefono">TELÉFONO</label>
                            <div class="input-group">
                                <input type="text" name="Telefono" value="{{ old('Telefono') != '' ? old('Telefono') : $Datos->telefono }}"
                                    class="form-control" placeholder="Ingrese el N° de Teléfono Celular" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="ruc">N° RUC</label>
                            <div class="input-group">
                                <input type="text" name="ruc"
                                    value="{{ old('ruc') != '' ? old('ruc') : $Datos->ruc }}" class="form-control"
                                    placeholder="Ingrese el N° RUC">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="simboloMoneda">SÍMBOLO MONETARIO</label>
                            <div class="input-group">
                                <input type="text" name="simboloMoneda"
                                    value="{{ old('simboloMoneda') != '' ? old('simboloMoneda') : $Datos->simboloMoneda }}"
                                    class="form-control" placeholder="Ingrese el Símbolo Monetario" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="Imagen">LOGO</label>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                                </span>
                                <input type="file" name="Imagen" id="Imagen"
                                    accept="image/png, .jpeg, .jpg, image/gif" class="form-control"
                                    onchange="mostrar()">
                            </div>
                            <img src="{{ asset('logo/' . $Datos->logo) }}" id="img"/ width="100" height="100">
                        </div>
                    </div>
                    <div class=" col-sm-12 ">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div style="margin: 0px auto 0px auto">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>

    </div>
    {{ Form::Close() }}

</div>
