@extends('layouts.app')

@section('content')
    <div class="row" style="margin-top: 100px;">
        <div class="col-md-5 col-md-offset-5" style="margin-left:auto; margin-right:auto;">
            <div class="card">
                <div class="card-header p-3 mb-2 bg-dark text-white" style="text-align: center">
                    SISTEMA GESTIÓN HOTELERA 4
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login')}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="">Correo</label>
                            <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa fa-user" aria-hidden="true"></i></span>
                            </div>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                             placeholder="Ingrese su Correo Electrónico" value= "{{old ('email')}}" required>
                            </div>
                            {!! $errors->first('email', '<span class="help-block text-danger">:message </span>') !!}
                        </div>

                        <div class="form-group">
                            <label for="">Contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fa fa-key" aria-hidden="true"></i></span>
                                </div>
                            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password"
                             placeholder="Ingrese su Contraseña" required>
                            </div>
                            {!! $errors->first('password', '<span class="help-block text-danger">:message </span>') !!}
                        </div>
                        <button class="btn btn-success btn-block">Acceder</button>

                    </form>
                </div>
                <div class="card-footer p-3 mb-2 bg-gray text-dark" style="text-align: center">
                    <span style="font-weight: bold">
                        <a href="https://system.hotella49.com/" target="_blank" class="text-secondary">HOTELLA49</a>
                         - 2023</span>
                    {{-- <a href="" style="text-decoration: none; color:white">Olvidé mi contraseña</a> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
