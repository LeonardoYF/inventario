<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <title>INVENTARIO</title>
  <!-- Css -->
  <link rel="stylesheet" href="/example-app/resources/css/app.css">
  <!-- Font Awesome -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
  <link rel="stylesheet" href="/example-app/public/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/example-app/public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/example-app/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/example-app/public/dist/css/adminlte.min.css">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/example-app/public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/example-app/public/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/example-app/public/plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->


    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" id="nav-principal">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Contact</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">

        <!-- Messages Dropdown Menu 
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
      </li>-->
        <!-- Notifications Dropdown Menu 
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
      </li>-->
        <div class="dropdown">

          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Cerrar sesión
              </a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </ul>
        </div>
      </ul>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>


      <ul id="username" class="navbar-nav ms-auto">
        <!-- Authentication Links -->
        @guest
        @if (Route::has('login'))
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        </li>
        @endif

        @if (Route::has('register'))
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        </li>
        @endif
        @else
        <div class="dropdown" id="username">
          <button class=" dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            @if(Auth::check())
            {{ Auth::user()->name }}
            @else
            Usuario no Logeado
            @endif

          </button>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('login') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </div>
        @endguest
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside style="background: #242525 ;" class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="" class="brand-link">
        <i class="bi bi-unity"></i>
        <span class="brand-text font-weight-light ">LEONARDO</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            <li class="nav-item">
              <a class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Home
                  <i class="bi bi-caret-down-fill right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('homeVenta')}}" class="nav-link">
                    <i class="bi bi-house-fill" id="identar"></i>
                    <p>Home</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Almacen
                  <i class="bi bi-caret-down-fill right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('producto.index') }}" class="nav-link">
                    <i class="bi bi-shop-window" id="identar"></i>
                    <p>Productos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('categoria.index') }}" class="nav-link">
                    <i id="identar" class="bi bi-window-split"></i>
                    <p>Categorías</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p>
                  Compras
                  <i class="bi bi-caret-down-fill right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('ingresos.index') }}" class="nav-link">
                    <i id="identar" class="bi bi-cash-coin"></i>
                    <p>Ingresos</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('proveedores.index') }}" class="nav-link">
                    <i id="identar" class="bi bi-truck-flatbed"></i>
                    <p>Proveedores</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tree"></i>
                <p>
                  Ventas
                  <i class="bi bi-caret-down-fill right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('cliente.index') }}" class="nav-link">
                    <i id="identar" class="bi bi-file-person-fill"></i>
                    <p>Clientes</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('ventas.index') }}" class="nav-link">
                    <i id="identar" class="bi bi-cart-check"></i>
                    <p>Ventas</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Seguridad
                  <i class="bi bi-caret-down-fill right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="pages/forms/general.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Usuarios</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="pages/forms/general.html" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Roles</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                <p>
                  Reporteria
                  <i class="bi bi-caret-down-fill right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('reportes.index')}}" class="nav-link">
                    <i id="identar" class="bi bi-building-check"></i>
                    <p>Ventas x Día</p>
                  </a>
                </li>
              </ul>
            </li>
          </ul>


        </nav>




        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->

      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          @yield('contenido')
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="/example-app/public/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="/example-app/public/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  @stack('scripts')

  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="/example-app/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="
https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js
"></script>

  <!-- ChartJS -->
  <script src="/example-app/public/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="/example-app/public/plugins/sparklines/sparkline.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="/example-app/public/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="/example-app/public/plugins/moment/moment.min.js"></script>
  <script src="/example-app/public/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="/example-app/public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="/example-app/public/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="/example-app/public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/example-app/public/dist/js/adminlte.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="/example-app/public/dist/js/pages/dashboard.js"></script>

</body>

</html>