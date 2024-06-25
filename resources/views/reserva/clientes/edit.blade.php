@extends ('layout.admin')
@section('Contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <span class="title_header"> Editar datos del Cliente</span>
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
    </DIV>
    {!! Form::model($Cliente, ['method' => 'PATCH', 'route' => ['clientes.update', $Cliente->IdCliente]]) !!}
    {{ Form::token() }}
    <div class="row">
        <input type="hidden" name="IdCliente" value="{{$Cliente->IdCliente}}">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="TipDocumento">TIPO DE DOCUMENTO</label>
                <select name="TipDocumento" id="TipDocumento" class="form-control selectpicker">
                    @foreach ($tipo_documento as $t)
                        <option value="{{ $t->nomTipDoc }}"
                            {{ $Cliente->TipDocumento == $t->nomTipDoc ? 'selected' : '' }}>{{ $t->nomTipDoc }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="NumDocumento">N° DOCUMENTO</label>
                <input type="text" name="NumDocumento" value="{{ $Cliente->NumDocumento }}" class="form-control">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="Nombre">NOMBRES</label>
                <input type="text" name="Nombre" required value="{{ $Cliente->Nombre }}" class="form-control">
            </div>
        </div>
        {{-- <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="Apellido">APELLIDOS</label>
                <input type="text" name="Apellido" id="Apellido"
                value="{{ $Cliente->Apellido }}" class="form-control">
            </div>
        </div> --}}
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="Celular">CELULAR</label>
                <input type="text" name="Celular" value="{{ $Cliente->Celular }}" class="form-control">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="Correo">CORREO</label>
                <input type="text" name="Correo" value="{{ $Cliente->Correo }}" class="form-control">
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="Direccion">DIRECCIÓN</label>
                <input type="text" name="Direccion" value="{{ $Cliente->Direccion }}" class="form-control"
                    placeholder="Ingrese la dirección del Cliente. Ejm {Andahuaylas - Jr. Las Americas 1XX}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="nroMatricula">N° MATRÍCULA</label>
                <input type="text" name="nroMatricula" value="{{ $Cliente->nroMatricula }}" class="form-control"
                    placeholder="Ejemplo: AAA-123">
            </div>
        </div>
        {{-- <div class="col-md-6">
            <div class="form-group">
                <label for="fecha">Camara</label>
                <div class="input-group mb-3">
                    <img src="{{ asset('Imagenes/cliente/' . $Cliente->captura) }}" alt="" >
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
            // const selectElement = document.querySelector('#TipDocumento');
            // selectElement.addEventListener('change', (event) => {
            //     if (event.target.value === "RUC") {
            //         $("#Apellido").attr("readOnly", 1);
            //         document.getElementById("Apellido").value = ".";
            //     } else {
            //         $("#Apellido").removeAttr("readOnly");
            //         document.getElementById("Apellido").value = "";
            //     }
            // })
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
            grabar.addEventListener("click", function() {
            });
        })
    </script> --}}
@endsection
