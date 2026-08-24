<!DOCTYPE html>
<html lang="en"
    dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>levels academey</title>
    <link rel="icon" href="{{ $brandLogo ?? asset('images/logo/Levels-logo.png') }}" type="image/png">

    <!-- Prevent the demo from appearing in search engines -->
    <meta name="robots" content="noindex">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700%7CRoboto:400,500%7CExo+2:600&display=swap" rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css" href="{{ asset('vendor/spinkit.css') }}" rel="stylesheet">

    <!-- Perfect Scrollbar -->
    <link type="text/css" href="{{ asset('vendor/perfect-scrollbar.css') }}" rel="stylesheet">

    <!-- Material Design Icons -->
    <link type="text/css" href="{{ asset('css/material-icons.css') }}" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link type="text/css" href="{{ asset('css/fontawesome.css') }}" rel="stylesheet">

    <!-- Preloader -->
    <link type="text/css" href="{{ asset('css/preloader.css') }}" rel="stylesheet">

    <!-- App CSS -->
    <link type="text/css" href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>


<body class="layout-app ">

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

    <!-- Drawer Layout -->

    <div class="mdk-drawer-layout js-mdk-drawer-layout"
        data-push
        data-responsive-width="992px">
        <div class="mdk-drawer-layout__content page-content">

            <!-- Header -->

            <div class="navbar navbar-expand navbar-light border-bottom-2"
                id="default-navbar"
                data-primary>

                <!-- Navbar toggler -->
                <button class="navbar-toggler w-auto mr-16pt d-block d-lg-none rounded-0"
                    type="button"
                    data-toggle="sidebar">
                    <span class="material-icons">short_text</span>
                </button>

                <!-- Navbar Brand -->
                <a href="#"
                    class="navbar-brand mr-16pt d-lg-none">
                    <!-- <img class="navbar-brand-icon" src="../../public/images/logo/white-100@2x.png" width="30" alt="Luma"> -->

                    <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

                        <span class="avatar-title rounded bg-primary"><img src="../../public/images/illustration/student/128/white.svg"
                                alt="logo"
                                class="img-fluid" /></span>

                    </span>

                    <span class="d-none d-lg-block">Luma</span>
                </a>

                <ul class="nav navbar-nav d-none d-sm-flex flex justify-content-start ml-8pt">
                    <li class="nav-item">
                        <a href="{{route('guest.index')}}"
                            class="nav-link">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#"
                            class="nav-link dropdown-toggle"
                            data-toggle="dropdown"
                            data-caret="false">Courses</a>
                        <div class="dropdown-menu">
                            <a href="#"
                                class="dropdown-item">Browse Courses</a>
                            <a href="#"
                                class="dropdown-item">Preview Course</a>
                            <a href="#"
                                class="dropdown-item">Preview Lesson</a>
                            <a href="#"
                                class="dropdown-item"><span class="mr-16pt">Take Course</span> <span class="badge badge-notifications badge-accent text-uppercase ml-auto">Pro</span></a>
                            <a href="#"
                                class="dropdown-item">Take Lesson</a>
                            <a href="#"
                                class="dropdown-item">Take Quiz</a>
                            <a href="#"
                                class="dropdown-item">Quiz Result</a>
                            <a href="#"
                                class="dropdown-item">Student Dashboard</a>
                            <a href="#"
                                class="dropdown-item">My Courses</a>
                            <a href="#"
                                class="dropdown-item">My Quizzes</a>
                            <a href="#"
                                class="dropdown-item">Help Center</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#"
                            class="nav-link dropdown-toggle"
                            data-toggle="dropdown"
                            data-caret="false">Paths</a>
                        <div class="dropdown-menu">
                            <a href="#"
                                class="dropdown-item">Browse Paths</a>
                            <a href="#"
                                class="dropdown-item">Path Details</a>
                            <a href="#"
                                class="dropdown-item">Skill Assessment</a>
                            <a href="#"
                                class="dropdown-item">Skill Result</a>
                            <a href="#"
                                class="dropdown-item">My Paths</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="#"
                            class="nav-link">Pricing</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#"
                            class="nav-link dropdown-toggle"
                            data-toggle="dropdown"
                            data-caret="false">Teachers</a>
                        <div class="dropdown-menu">
                            <a href="#"
                                class="dropdown-item">Instructor Dashboard</a>
                            <a href="#"
                                class="dropdown-item">Manage Courses</a>
                            <a href="#"
                                class="dropdown-item">Manage Quizzes</a>
                            <a href="#"
                                class="dropdown-item">Earnings</a>
                            <a href="#"
                                class="dropdown-item">Statement</a>
                            <a href="#"
                                class="dropdown-item">Edit Course</a>
                            <a href="#"
                                class="dropdown-item">Edit Quiz</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown"
                        data-toggle="tooltip"
                        data-title="Community"
                        data-placement="bottom"
                        data-boundary="window">
                        <a href="#"
                            class="nav-link dropdown-toggle"
                            data-toggle="dropdown"
                            data-caret="false">
                            <i class="material-icons">people_outline</i>
                        </a>
                        <div class="dropdown-menu">
                            <a href="#"
                                class="dropdown-item">Browse Teachers</a>
                            <a href="#"
                                class="dropdown-item">Student Profile</a>
                            <a href="#"
                                class="dropdown-item">Instructor Profile</a>
                            <a href="#"
                                class="dropdown-item">Blog</a>
                            <a href="#"
                                class="dropdown-item">Blog Post</a>
                            <a href="#"
                                class="dropdown-item">FAQ</a>
                            <a href="#"
                                class="dropdown-item">Help Center</a>
                            <a href="#"
                                class="dropdown-item">Discussions</a>
                            <a href="#"
                                class="dropdown-item">Discussion Details</a>
                            <a href="#"
                                class="dropdown-item">Ask Question</a>
                        </div>
                    </li>
                </ul>

                <ul class="nav navbar-nav ml-auto mr-0">
                    <li class="nav-item">
                        <a href="{{ route('login') }}"
                            class="nav-link"
                            data-toggle="tooltip"
                            data-title="Login"
                            data-placement="bottom"
                            data-boundary="window"><i class="material-icons">lock_open</i></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}"
                            class="btn btn-outline-dark">Get Started</a>
                    </li>
                </ul>
            </div>
            @yield('content')

            {{-- Laravel Vite - JS File --}}
            {{-- {{ module_vite('build-Guest', 'Resources/assets/js/app.js') }} --}}
            <!-- jQuery -->
            <script src="{{ asset('vendor/jquery.min.js') }}"></script>

            <!-- Bootstrap -->
            <script src="{{ asset('vendor/popper.min.js') }}"></script>
            <script src="{{ asset('vendor/bootstrap.min.js') }}"></script>

            <!-- Perfect Scrollbar -->
            <script src="{{ asset('vendor/perfect-scrollbar.min.js') }}"></script>

            <!-- DOM Factory -->
            <script src="{{ asset('vendor/dom-factory.js') }}"></script>

            <!-- MDK -->
            <script src="{{ asset('vendor/material-design-kit.js') }}"></script>

            <!-- App JS -->
            <script src="{{ asset('js/app.js') }}"></script>

            <!-- Preloader -->
            <script src="{{ asset('js/preloader.js') }}"></script>

</body>

</html>