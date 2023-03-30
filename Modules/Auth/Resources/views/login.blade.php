<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Luma</title>

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots"
          content="noindex">

    <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&display=swap"
          rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css" href="{{asset('vendor/spinkit.css')}}" rel="stylesheet">

    <!-- Perfect Scrollbar -->
    <link type="text/css" href="{{asset('vendor/perfect-scrollbar.css')}}" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="{{asset('css/material-icons.css')}}" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link type="text/css" href="{{asset('css/fontawesome.css')}}" rel="stylesheet">
    <!-- Preloader -->
    <link type="text/css" href="{{asset('css/preloader.css')}}" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="{{asset('css/app.css')}}" rel="stylesheet">
    <style>
        @font-face {
            font-family: myFirstFont;
            src: url(/fonts/DroidKufi-Regular.ttf);
        }

        * {
            font-family: myFirstFont !important;
        }
    </style>
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

    <div class="mdk-header-layout__content">

        <!-- Drawer Layout -->
        <div class="mdk-drawer-layout js-mdk-drawer-layout"
             data-push
             data-responsive-width="992px">

            <!-- Drawer Layout Content -->
            <div class="mdk-drawer-layout__content page-content">

                <div class="pt-32pt pt-sm-64pt pb-32pt">
                    <div class="container page__container">
                        <div class="row mb-32pt">
                            {{--                            <div class="col-lg-8 d-flex align-items-center">--}}
                            <div class="flex" style="max-width: 100%">

                                @include('auth::notification.error')
                                @include('auth::notification.success')
                            </div>

                            {{--                            </div>--}}

                        </div>
                        <form action="{{route('users.login')}}"
                              class="col-md-5 p-0 mx-auto" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="form-label"
                                       for="email">
                                    البريد الالكتروني :
                                </label>
                                <input id="email"
                                       name="email"
                                       type="text"
                                       class="form-control"
                                       placeholder="Your email address ...">
                            </div>
                            <div class="form-group">
                                <label class="form-label"
                                       for="password">
                                    كلمة السر :
                                </label>
                                <input id="password"
                                       name="password"
                                       type="password"
                                       class="form-control"
                                       placeholder="Your first and last name ...">
                                <p class="text-right"><a href="reset-password.html"
                                                         class="small">
                                        هل نسيت كلمة السر ؟
                                    </a></p>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary" type="submit">
                                    تسجيل الدخول
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="page-separator justify-content-center m-0">
                    <div class="page-separator__text">أو سجل الدخول باستخدام:</div>
                </div>
                <div class="bg-body pt-32pt pb-32pt pb-md-64pt text-center">
                    <div class="container page__container">
                        <a href="index.html"
                           class="btn btn-secondary btn-block-xs">
                            فيسبوك
                        </a>
                        <a href="index.html"
                           class="btn btn-secondary btn-block-xs">
                            تويتر
                        </a>
                        <a href="index.html"
                           class="btn btn-secondary btn-block-xs">غوغل</a>
                    </div>
                </div>

            </div>
            <!-- // END drawer-layout__content -->


        </div>
        <!-- // END drawer-layout -->

    </div>
    <!-- // END Header Layout Content -->

</div>
<!-- // END Header Layout -->

<!-- jQuery -->
<script src="{{asset('vendor/jquery.min.js')}}"></script>

<!-- Bootstrap -->
<script src="{{asset('vendor/popper.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap.min.js')}}"></script>

<!-- Perfect Scrollbar -->
<script src="{{asset('vendor/perfect-scrollbar.min.js')}}"></script>

<!-- DOM Factory -->
<script src="{{asset('vendor/dom-factory.js')}}"></script>

<!-- MDK -->
<script src="{{asset('vendor/material-design-kit.js')}}"></script>

<!-- App JS -->
<script src="{{asset('js/app.js')}}"></script>

<!-- Preloader -->
<script src="{{asset('js/preloader.js')}}"></script>

</body>

</html>
