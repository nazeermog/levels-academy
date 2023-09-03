<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->

    <ul class="navbar-nav ml-auto">
    <li class="nav-item">
        <form method="POST" action="{{ route('users.logout') }}">
            @csrf
            <button type="submit" class="btn btn-link nav-link">
                <i class="fas fa-sign-out-alt fa-lg"></i> Logout
            </button>
        </form>
    </li>
</ul>

</nav>
