@extends('layout.admin')
@Section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header">Agregando nuevo Cliente</span>
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
                <div class="alert bg-danger text-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    {!! Form::open(['url' => 'reserva/clientes', 'method' => 'POST', 'autocomplete' => 'off', 'files' => 'true']) !!}
    {{ Form::token() }}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="TipDocumento">TIPO DOCUMENTO</label>
                <select name="TipDocumento" id="TipDocumento" class="form-control" required>
                    <option value="" selected hidden>Seleccionar</option>
                    @foreach ($tipo_documento as $t)
                        <option value="{{ $t->nomTipDoc }}_{{ $t->longitud }}"
                            {{ old('TipDocumento') == $t->nomTipDoc ? 'selected' : '' }}>{{ $t->nomTipDoc }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="NumDocumento">N° DOCUMENTO</label>
                <input type="text" name="NumDocumento" id="NumDocumento" value="{{ old('NumDocumento') }}"
                    class="form-control" placeholder="Ingrese el Nro de Documento según el Tipo de Documento seleccionado.">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="Nombre">NOMBRES</label>
                <input type="text" name="Nombre" value="{{ old('Nombre') }}" class="form-control"
                    placeholder="Ingrese los nombres del Cliente / Razón Social de la Empresa" required>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="Celular">CELULAR</label>
                <input type="text" name="Celular" value="{{ old('Celular') }}" class="form-control"
                    placeholder="Ingrese el Nro de Celular/Teléfono del Cliente">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="Correo">CORREO</label>
                <input type="text" name="Correo" value="{{ old('Correo') }}" class="form-control"
                    placeholder="Ingrese el correo electrónico del Cliente">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="Direccion">DIRECCIÓN ORIGEN</label>
                <input type="text" name="Direccion" value="{{ old('Direccion') }}" class="form-control"
                    placeholder="Ingrese la dirección del Cliente. Ejm {Andahuaylas - Jr. Las Americas 1XX}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="nroMatricula">N° MATRÍCULA</label>
                <input type="text" name="nroMatricula" value="{{ old('nroMatricula') }}" class="form-control"
                    placeholder="Ejemplo: AAA-123">
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="form-group">
                <label for="fecha">Camara</label>
                <div class="input-group mb-3">
                    <input id='fotocamara' name="fotocamara" type="hidden" class="form-control" />
                    <video id="video" width="198" autoplay=true class="img-responsive"></video>
                    <canvas id="canvas" width="198" class="img-responsive"></canvas>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="form-group">
        <button class="btn btn-primary" type="submit" id="enviar">Guardar</button>
        {{-- <button type="button" class="btn bg-gradient-primary grabar" id="grabar">
            Guardar</button> --}}
        <a href="{{ asset('reserva/clientes') }}" class="btn btn-danger">Cancelar</a>
    </div>

    {!! Form::close() !!}
    @push('scripts')
        <script>
            let data = document.getElementById('TipDocumento').value.split('_');
            verificar_long(data[1]);
            $("#TipDocumento").change(mostrarValores);

            function mostrarValores() {
                data = document.getElementById('TipDocumento').value.split('_');
                $('#NumDocumento').val("");
                verificar_long(data[1]);
            }

            function verificar_long(long) {
                document.getElementById("NumDocumento").maxLength = long;
            }
        </script>

        <script>
            function toast(message, type) {
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
                    icon: type,
                    title: message,
                    customClass: 'swal-pop',
                })
            }
        </script>
        @if (Session::has('error'))
            <script>
                toast('{{ Session::get('error') }}', 'error');
            </script>
        @endif
    @endpush
    {{-- <script>
        'use strict';
        navigator.mediaDevices.getUserMedia({
            audio: false,
            video: true
        }).then((stream) => {
            if (stream) {
                let video = document.getElementById('video');
                video.srcObject = stream;
                var canvas = document.getElementById('canvas');
                grabar.addEventListener("click", function() {
                    canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight,
                        0, 0, 198, 150);
                    var data = canvas.toDataURL('image/png');
                    document.getElementById('fotocamara').setAttribute('value', data);
                    var a = data;
                    // console.log(data);
                    $("#enviar").click();
                });
            }
        }).catch((err) => {
            console.log(err);
            grabar.addEventListener("click", function() {});
        })
    </script> --}}
@endsection
