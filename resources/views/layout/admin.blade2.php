<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sistema de Gestión Hotelera</title>
  <link rel="shortcut icon" type="image/ico" href="/img/logo-sistemah.ico"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  {{-- <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}"> --}}
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/bootstrap-select.min.css')}}">
  <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
  <link rel="stylesheet" href="{{asset('dist/css/skins/skin-red.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/adicional.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/validacion.css')}}">
  <link rel="stylesheet" href="{{asset('dist/sweetalert2/sweetalert2.min.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="{{asset('reserva/registro')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>S</b>H</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Sistema Hotelero </b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{ auth()->user()->Nombre}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- Menu Footer-->
              <li class="user-footer" style="background: #cfcecd">
                <div class="pull-right" >
                    <form method="POST" action="{{ route('logout') }}">
                        {{ csrf_field() }}
                            <h5>{{ auth()->user()->Nombre}} {{ auth()->user()->Apellido}}</h5>
                            <label style="float: right">¿Quieres salir del Sistema?</label>
                            <button class="btn btn-default btn-flat"
                            style="float: right">Cerrar Sesión</button>
                    </form>

                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menú</li>
        {{-- Reservas --}}
        <li class="{{ 'reserva' == request()->segment(1)
            ? 'active treeview' : 'treeview' }}">
         <a href="#">
           <i class="fa fa-bell" aria-hidden="true"></i> <span>Reservas</span>
           <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
           </span>
         </a>

         <ul class="treeview-menu">
            <li class="{{ 'dashboard' == request()->segment(2)
                ? 'active' : '' }}"><a href="{{asset('reserva/dashboard')}}">
                <i class="fa fa-circle-o"></i> Panel de Control</a></li>
            <li class="{{ 'registro' == request()->segment(2)
            ? 'active' : '' }}"><a href="{{asset('reserva/registro')}}">
            <i class="fa fa-circle-o"></i> Recepción</a></li>
            <li class="{{ 'listar-registro' == request()->segment(2)
            ? 'active' : '' }}"><a href="{{asset('reserva/listar-registro')}}">
            <i class="fa fa-circle-o"></i> Listado de Registros</a></li>
            <li class="{{ 'clientes' == request()->segment(2)
                ? 'active' : '' }}"><a href="{{asset('reserva/clientes')}}">
                <i class="fa fa-circle-o"></i> Clientes</a></li>
         </ul>
       </li>

       {{-- Ventas --}}
       <li class="{{ 'ventas' == request()->segment(1)
        ? 'active treeview' : 'treeview' }}">
            <a href="#">
            <i class="fa fa-money" aria-hidden="true"></i> <span>Ventas</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
            <li class="{{ 'consumo' == request()->segment(2)
            ? 'active' : '' }}"><a href="{{asset('ventas/consumo')}}">
            <i class="fa fa-circle-o"></i> Vender a hospedados</a></li>
            <li class="{{ 'otros' == request()->segment(2)
                ? 'active' : '' }}"><a href="{{asset('ventas/otros')}}">
                <i class="fa fa-circle-o"></i> Vender a otros</a></li>
            <li class="{{ 'listar-consumo' == request()->segment(2)
            ? 'active' : '' }}"><a href="{{asset('ventas/listar-consumo')}}">
            <i class="fa fa-circle-o"></i> Listado Consumo</a></li>
            </ul>
        </li>

            {{-- Verificación de Salidas --}}
            <li class="{{ 'verificacion' == request()->segment(2)
                ? 'active' : '' }}"><a href="{{asset('salidas/verificacion')}}">
                <i class="fa fa-key" aria-hidden="true"></i>
                <span>Verificación de Salidas</span></a>
            </li>

        <li class="{{ 'reporte' == request()->segment(1)
            ? 'active treeview' : 'treeview' }}">
                <a href="#">
                <i class="fa fa-line-chart" aria-hidden="true"></i> <span>Reportes</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu">
                <li class="{{ 'ingresos' == request()->segment(2)
                    ? 'active' : '' }}"><a href="{{asset('reporte/ingresos')}}">
                    <i class="fa fa-circle-o"></i> Reporte diario </a></li>
                <li class="{{ 'mensual' == request()->segment(2)
                    ? 'active' : '' }}"><a href="{{asset('reporte/mensual')}}">
                    <i class="fa fa-circle-o"></i> Reporte Mensual</a></li>
                </ul>
        </li>

        {{-- Mantenimiento --}}
        <li class="{{ 'mantenimiento' == request()->segment(1)
            ? 'active treeview' : 'treeview' }}">
         <a href="#">
           <i class="fa fa-bed" aria-hidden="true"></i> <span>Mantenimiento</span>
           <span class="pull-right-container">
             <i class="fa fa-angle-left pull-right"></i>
           </span>
         </a>
         <ul class="treeview-menu">
           <li class="{{ 'nivel' == request()->segment(2)
            ? 'active' : '' }}"><a href="{{asset('mantenimiento/nivel')}}">
            <i class="fa fa-circle-o"></i> Nivel</a></li>
           <li class="{{ 'tipo_habitacion' == request()->segment(2)
            ? 'active' : '' }}"><a href="{{asset('mantenimiento/tipo_habitacion')}}"><i class="fa fa-circle-o"></i> Tipo Habitación</a></li>
           <li class="{{ 'habitacion' == request()->segment(2)
            ? 'active' : '' }}"><a href="{{asset('mantenimiento/habitacion')}}"><i class="fa fa-circle-o"></i> Habitación</a></li>
         </ul>
       </li>


        {{-- Almacén de Productos --}}
        <li class="{{ 'almacen' == request()->segment(1)
             ? 'active treeview' : 'treeview' }}">
          <a href="#">
            <i class="fa fa-archive" aria-hidden="true"></i> <span>Almacén Productos</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li class="{{ 'categoria' == request()->segment(2)
             ? 'active' : '' }}"><a href="{{asset('almacen/categoria')}}"><i class="fa fa-circle-o"></i> Categorías</a></li>
             <li class="{{ 'producto' == request()->segment(2)
             ? 'active' : '' }}"><a href="{{asset('almacen/producto')}}"><i class="fa fa-circle-o"></i> Productos</a></li>
          </ul>
        </li>


        <li class="{{ 'acceso' == request()->segment(1)
            ? 'active treeview' : 'treeview' }}">
          <a href="#"><i class="fa fa-shield" aria-hidden="true"></i> <span>Acceso</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ 'usuario' == request()->segment(2)
                ? 'active' : '' }}">
                <a href="{{asset('acceso/usuario')}}"><i class="fa fa-circle-o"></i> Usuarios
            </a>
            </li>

          </ul>
        </li>
        {{-- Configuración --}}
        <li class="{{ 'datos_hotel' == request()->segment(2)
            ? 'active' : '' }}"><a href="{{asset('configuracion/datos_hotel')}}">
            <i class="fa fa-cogs" aria-hidden="true"></i>
            <span>Configuración</span></a>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
        @yield('Contenido')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright  &copy; 2021 <a href="#">CWILSOFT</a>.</strong> Todos los derechos reservados.
  </footer>


</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="{{asset('bower_components/jquery/dist/jquery.min.js')}}"></script>
@stack('scripts')

<!-- Bootstrap 3.3.7 -->
<script src="{{asset('bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('dist/js/bootstrap-select.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
<!-- SweetAlert -->
<script src="{{asset('dist/sweetalert2/sweetalert2.all.min.js')}}"></script>
<!-- Eliminación de categoria -->
<script src="{{asset('dist/eliminacion/eliminar_categoria.js')}}"></script>
<script src="{{asset('dist/js/Formulario.js')}}"></script>
<script src="{{asset('bower_components/chart.js/Chart.js')}}"></script>
<script>
    $('.estado_habitacion_l').unbind().click(function () {
      var $button = $(this);
      var data_nombre = $button.attr('data-nombre');
      Swal.fire({
        title: '¿La habitación '+ data_nombre +' ya esta disponible?',
        showDenyButton: true,
        confirmButtonText: `Ya está Limpio`,
        denyButtonText: `Aún no`,
        customClass: 'swal-wide',
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          var d = '{{URL::action("ReservaController@show", 0)}}' + data_nombre
          window.location.href = d;
        } else if (result.isDenied) {
          Swal.fire('No se realizó ningún cambio', '', 'info')
        }
      })
    });
</script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
</body>
</html>
