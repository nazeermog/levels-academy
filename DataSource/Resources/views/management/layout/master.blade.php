<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('datasource::management.partials.header.head')
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="{{asset('images/s2.png')}}" alt="AdminLTELogo" height="100"
             width="100">
    </div>

    <!-- Navbar -->
    @include('datasource::management.partials.header.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->

    @include('datasource::management..partials.sidebar.menu')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        {{--                        <h1 class="m-0">Dashboard v2</h1>--}}
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        {{--                        <ol class="breadcrumb float-sm-right">--}}
                        {{--                            <li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                        {{--                            <li class="breadcrumb-item active">Dashboard v2</li>--}}
                        {{--                        </ol>--}}
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @include('datasource::management.partials.notification.error')
                @include('datasource::management.partials.notification.success')
                @yield('content')
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Main Footer -->
    @include('datasource::management.partials.footer.footer')
</div>
<div id="loading-show">
    <div id="text-overlay" style="display:none;">
        LOADING...
    </div>
</div>
<!-- ./wrapper -->
@include('datasource::management.partials.footer.js')
</body>
</html>
