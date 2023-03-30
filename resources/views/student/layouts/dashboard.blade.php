<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    @include('student.partials.head')

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
@include('student.partials.header')
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
            @include('student.partials.footer')
            <!-- // END Footer -->

            </div>
            <!-- // END drawer-layout__content -->
            <!-- Drawer -->
        @include('student.partials.sidebar')
        <!-- // END Drawer -->

        </div>
        <!-- // END drawer-layout -->

    </div>
    <!-- // END Header Layout Content -->

</div>
<!-- // END Header Layout -->
@include('student.partials.script')
</body>

</html>
