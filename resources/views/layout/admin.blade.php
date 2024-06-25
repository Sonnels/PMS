<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestión Hotelera</title>
    @if (!empty($empresa_ini->logo))
        <link rel="shortcut icon" type="image/ico" href="{{ asset('logo/' . $empresa_ini->logo) }}" />
    @endif
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/validacion.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adicional.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/mis_estilos.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/snackbar.min.css') }}" type="text/css" />
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark bg-danger">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> --}}
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                {{-- <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li> --}}


                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-sort-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">{{ auth()->user()->Nombre }} {{ auth()->user()->Apellido }}<br>
                            <font style="font-weight: bold">{{ auth()->user()->TipoUsuario }}</font>
                        </span>

                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            {{ csrf_field() }}
                            <button class="dropdown-item dropdown-footer">
                                Cerrar Sesión <i class="fas fa-sign-out-alt" style="margin-left: 1em"></i>
                            </button>
                        </form>
                        {{-- <form method="POST" action="{{route('login')}}">
                            @method('put')
                            @csrf
                            <button class="dropdown-item dropdown-footer">
                                Cerrar Sesión <i class="fas fa-sign-out-alt" style="margin-left: 1em"></i></button>
                        </form> --}}
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-danger elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link bg-danger">

                @if (!empty($empresa_ini->logo))
                    <img src="{{ asset('logo/' . $empresa_ini->logo) }}" alt=""
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                @endif
                <span class="brand-text font-weight-light">
                    @if (isset($empresa_ini->nombre))
                        <font style="font-weight: bold; font-size: 0.8em;">{{ $empresa_ini->nombre }}
                        </font>
                    @endif
                </span>

            </a>

            <!-- Sidebar -->
            <div class="sidebar ">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (auth()->user()->foto != '')
                            <img src="{{ asset('Imagen/' . auth()->user()->foto) }}" class="img-circle elevation-2"
                                alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            {{ auth()->user()->Nombre }} {{ auth()->user()->Apellido }}
                        </a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->


                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ asset('apartar') }}"
                                class="nav-link {{ 'apartar' == request()->segment(1) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Reserva
                                    {{-- <span class="right badge badge-danger">New</span> --}}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{ 'reserva' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ 'reserva' == request()->segment(1) ? 'active' : '' }}">
                                {{-- <i class="far fa-futbol"></i> --}}
                                <i class="nav-icon fas fa-sign-in-alt"></i>
                                <p>
                                    Entradas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('reserva/dashboard') }}"
                                        class="nav-link {{ 'dashboard' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Panel de Control</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('reserva/registro') }}"
                                        class="nav-link {{ 'registro' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Recepción</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('reserva/listar-registro') }}"
                                        class="nav-link {{ 'listar-registro' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Listado de Registros</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('reserva/listar-renovacion') }}"
                                        class="nav-link {{ 'listar-renovacion' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Renovaciones</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('reserva/clientes') }}"
                                        class="nav-link {{ 'clientes' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Clientes</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item {{ 'ventas' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ 'ventas' == request()->segment(1) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>
                                    Consumo/Servicio
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('ventas/consumo') }}"
                                        class="nav-link {{ 'consumo' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Consumo</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('ventas/servicio') }}"
                                        class="nav-link {{ 'servicio' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Servicio</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('ventas/otros') }}"
                                        class="nav-link {{ 'otros' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Venta Externa</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ 'compras' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ 'compras' == request()->segment(1) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-box-open"></i>
                                <p>
                                    Compras
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('compras/ingreso_producto') }}"
                                        class="nav-link {{ 'ingreso_producto' == request()->segment(2) && 'compras' == request()->segment(1) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ingresos</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('compras/proveedor') }}"
                                        class="nav-link {{ 'proveedor' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Proveedores</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ 'salidas' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ 'salidas' == request()->segment(1) ? 'active' : '' }}">
                                {{-- <i class="nav-icon fas fa-clipboard-list"></i> --}}
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Salidas
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('salidas/verificacion') }}"
                                        class="nav-link {{ 'verificacion' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Verificación de Salidas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ 'caja' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#" class="nav-link {{ 'caja' == request()->segment(1) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cash-register"></i>
                                <p>
                                    Caja
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('caja/apertura') }}"
                                        class="nav-link {{ 'apertura' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Apertura y Cierre</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('caja/pago') }}"
                                        class="nav-link {{ 'pago' == request()->segment(2) && 'caja' == request()->segment(1) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pagos</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('caja/ingreso') }}"
                                        class="nav-link {{ 'ingreso' == request()->segment(2) && 'caja' == request()->segment(1) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ingresos Extras</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('caja/egreso') }}"
                                        class="nav-link {{ 'egreso' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Egresos</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item {{ 'reporte' == request()->segment(1) ? 'menu-open' : '' }}">
                            <a href="#"
                                class="nav-link {{ 'reporte' == request()->segment(1) ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>
                                    Reportes
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('reporte/caja') }}"
                                        class="nav-link {{ 'caja' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reporte Caja</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('reporte/ingresos') }}"
                                        class="nav-link {{ 'ingresos' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Reporte diario</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('reporte/mensual') }}"
                                        class="nav-link {{ 'mensual' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p> Mensual</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('reporte/rango') }}"
                                        class="nav-link {{ 'rango' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Rango de Fecha </p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('reporte/rango_venta') }}"
                                        class="nav-link {{ 'rango_venta' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Rango de Fecha Venta</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ asset('reporte/limpieza') }}"
                                        class="nav-link {{ 'limpieza' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Limpieza</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if (auth()->user()->tipo == 'ADMINISTRADOR')
                            <li class="nav-item {{ 'mantenimiento' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'mantenimiento' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-bed"></i>
                                    {{-- <i class="nav-icon fas fa-box-open"></i> --}}
                                    <p>
                                        Mantenimiento
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('mantenimiento/nivel') }}"
                                            class="nav-link {{ 'nivel' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nivel</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('mantenimiento/tipo_habitacion') }}"
                                            class="nav-link {{ 'tipo_habitacion' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Tipo Habitación</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('mantenimiento/habitacion') }}"
                                            class="nav-link {{ 'habitacion' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Habitación</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item {{ 'almacen' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'almacen' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-box-open"></i>
                                    <p>
                                        Almacén
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('almacen/registrar_servicio') }}"
                                            class="nav-link {{ 'registrar_servicio' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Servicio</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('almacen/producto') }}"
                                            class="nav-link {{ 'producto' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Productos</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('almacen/categoria') }}"
                                            class="nav-link {{ 'categoria' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Categorías</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'acceso' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'acceso' == request()->segment(1) ? 'active' : '' }}">
                                    {{-- <i class="nav-icon fas fa-clipboard-list"></i> --}}
                                    <i class=" nav-icon fas fa-shield-alt"></i>
                                    <p>
                                        Acceso
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('acceso/usuario') }}"
                                            class="nav-link {{ 'usuario' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Usuarios</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('acceso/personal') }}"
                                            class="nav-link {{ 'personal' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Personal</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'respaldo' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'respaldo' == request()->segment(1) ? 'active' : '' }}">
                                    {{-- <i class="nav-icon fas fa-clipboard-list"></i> --}}
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        Respaldo
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('respaldo/r_alquiler') }}"
                                            class="nav-link {{ 'r_alquiler' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Alquiler</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item {{ 'configuracion' == request()->segment(1) ? 'menu-open' : '' }}">
                                <a href="#"
                                    class="nav-link {{ 'configuracion' == request()->segment(1) ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tools"></i>
                                    <p>
                                        Configuración
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ asset('configuracion/datos_hotel') }}"
                                            class="nav-link {{ 'datos_hotel' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Ajustes</p>
                                        </a>
                                    </li>


                                    <li class="nav-item">
                                        <a href="{{ asset('configuracion/tipo_documento') }}"
                                            class="nav-link {{ 'tipo_documento' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Tipo Documento</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ asset('configuracion/unidad_medida') }}"
                                            class="nav-link {{ 'unidad_medida' == request()->segment(2) ? 'bg-secondary' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>U. Medida</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif





                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @yield('encabezado')
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('Contenido')
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            {{-- <strong>Copyright &copy; 2020-2021 <a href="https://adminlte.io">WIJGSOFT</a>.</strong> --}}
            <strong>Copyright &copy; 2023
                <a href="https://system.hotella49.com/" target="_blank">Hotella49</a>.
            </strong>
            Todos los derechos Reservados
            <div class="float-right d-none d-sm-inline-block">
                <b>Sistema Gestión Hotelera </b>Versión - 4
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/bootstrap-select.min.js') }}"></script>

    <!-- AdminLTE -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('dist/js/toastr.min.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/simplyCountdown.min.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/prueba.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/msg-registro.js') }}"></script>
    <script src="{{ asset('bower_components/chart.js/Chart.js') }}"></script>
    <script>
        $('.estado_habitacion_l').unbind().click(function() {
            var $button = $(this);
            var data_nombre = $button.attr('data-nombre');
            Swal.fire({
                title: '¿La habitación ' + data_nombre + ' ya esta disponible?',
                showDenyButton: true,
                confirmButtonText: `Ya está Limpio`,
                denyButtonText: `Aún no`,
                // customClass: 'swal-wide',
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var d = '{{ URL::action('ReservaController@show', 0) }}' + data_nombre
                    window.location.href = d;
                } else if (result.isDenied) {
                    Swal.fire('No se realizó ningún cambio', '', 'info')
                }
            })
        });
    </script>
     <script src="{{ asset('dist/js/snackbar.min.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('moment/moment.main.js') }}"></script>
    <script src="{{ asset('moment/moment-timezone.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/eliminar.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/actualizar.js') }}"></script>
    <script src="{{ asset('dist/sweetalert2/actualizar2.js') }}"></script>
    <script src="{{ asset('dist/js/pages/formulario.js') }}"></script>


</body>

</html>
