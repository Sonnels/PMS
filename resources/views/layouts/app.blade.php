<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión Hotelero</title>
    {{-- <link rel="shortcut icon" type="image/ico" href="/img/yandrec-logo.ico"/> --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('dist/css/adicional.css')}}">
    <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <meta name="description" content="Sistema de Gestión Hotelero Versión 2.0 - Desarrollado por CWILSOFT 2021 - Andahuaylas">
    <meta name="author" content="CWILSOFT">
</head>
<body style="background: #e6e6e9">
    <div class="container" >
        @if (session()->has('flash'))
            <div class="alert alert-info">{{ session('flash')}}</div>
        @endif
        @yield('content')
    </div>

</body>
</html>
