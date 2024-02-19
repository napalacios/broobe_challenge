<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Broobe Challenge Inicio' }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link href="/plugins/fontawesome/css/all.min.css" rel="stylesheet">
    <link href="/plugins/select2/css/select2.min.css" rel="stylesheet">
    <link href="/plugins/select2/css/select2-bootstrap4.min.css" rel="stylesheet">
    <link href="/plugins/adminlte/css/adminlte.min.css" rel="stylesheet">
    <link href="/plugins/sweetalert2/css/sweetalert2.min.css" rel="stylesheet">
    <script src="/plugins/jquery/jquery.min.js"></script>
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/plugins/adminlte/js/adminlte.js"></script>
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <script src="/plugins/select2/js/i18n/es.js"></script>
    <script src="/plugins/sweetalert2/js/sweetalert2.min.js"></script>
    <script src="/plugins/jquery-knob/js/jquery.knob.min.js"></script>
    <script src="/dist/js/functions.js"></script>
    <script>
        /*$.fn.select2.defaults.set('language', 'es');*/
    </script>
</head>
<body class="sidebar-mini sidebar-collapse layout-fixed" style="height: auto;">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar .sidebar-collapse navbar-dark navbar-indigo">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-lightblue elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link navbar-indigo">
                <img src="https://www.broobe.com/wp-content/uploads/2021/07/cropped-favicon-32x32-1.webp" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Broobe Challenge</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar" style="overflow-y: auto;">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link">
                                <i class="fas fa-chart-line"></i>
                                <p>
                                    Metric <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('metric.run') }}" class="nav-link">
                                        <i class="nav-icon fas fa-play"></i>
                                        <p>Run</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('metric.history') }}" class="nav-link">
                                        <i class="nav-icon fas fa-list-alt"></i>
                                        <p>History</p>
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
        <div class="content-wrapper" style="min-height: 553px;">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid pr-4 pl-4 pt-2">
                    <!-- Small boxes (Stat box) -->
                    {{ $slot }}
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright © 2024 <a href="#">Nahuel Palacios</a>.</strong>
            Todos los derechos reservados
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <div id="sidebar-overlay"></div>
    </div>
    @stack('layout.scripts')    
</body>
</html>