<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible"
          content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Luma</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots"
          content="noindex">

    <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&display=swap"
          rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css"
          href="{{asset('vendor/spinkit.css')}}"
          rel="stylesheet">

    <!-- Perfect Scrollbar -->
    <link type="text/css"
          href="{{asset('vendor/perfect-scrollbar.css')}}"
          rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css"
          href="{{asset('css/material-icons.css')}}"
          rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link type="text/css"
          href="{{asset('css/fontawesome.css')}}"
          rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css"
          href="{{asset('css/preloader.css')}}"
          rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css"
          href="{{asset('css/app.css')}}"
          rel="stylesheet">
    <style>
        @font-face {
            font-family: myFirstFont;
            src: url(/fonts/DroidKufi-Regular.ttf);
        }

        .font-droid {
            font-family: myFirstFont !important;
        }
    </style>
    @stack('css')
</head>

<body class="layout-sticky layout-sticky-subnav ">

<div class="preloader">
    <div class="sk-chase">
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
    </div>

    <!-- <div class="sk-bounce">
<div class="sk-bounce-dot"></div>
<div class="sk-bounce-dot"></div>
</div> -->

    <!-- More spinner examples at https://github.com/tobiasahlin/SpinKit/blob/master/examples.html -->
</div>

<!-- Header Layout -->
<div class="mdk-header-layout js-mdk-header-layout">

    <!-- Header -->

@include('instructor.partials.header')

<!-- // END Header -->

    <!-- Header Layout Content -->
    <div class="mdk-header-layout__content">

        <!-- Drawer Layout -->
        <div class="mdk-drawer-layout js-mdk-drawer-layout"
             data-push
             data-responsive-width="992px">

            <!-- Drawer Layout Content -->
            <div class="mdk-drawer-layout__content page-content">
                <div class="font-droid">


                    @yield('content')
                </div>
                <!-- Footer -->

            @include('instructor.partials.footer')

            <!-- // END Footer -->

            </div>
            <!-- // END drawer-layout__content -->

            <!-- Drawer -->

        @include('instructor.partials.sidebar')
        <!-- // END Drawer -->

        </div>
        <!-- // END drawer-layout -->

    </div>
    <!-- // END Header Layout Content -->

</div>
<!-- // END Header Layout -->
@include('instructor.partials.script')

</body>

</html>
