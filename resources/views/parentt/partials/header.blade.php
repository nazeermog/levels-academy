@php
    $org = $currentOrganization ?? null;
    $brandLogo = $org ? asset('images/logo/' . $org->subdomain . '.png') : asset('images/logo/Levels-logo.png');
    $brandName = $org && $org->name ? $org->name : 'Levels Academy';
@endphp
<div id="header" class="mdk-header js-mdk-header mb-0" data-fixed>
  <div class="mdk-header__content">

    <!-- Navbar -->

    <div class="navbar navbar-expand pr-0 navbar-light bg-white navbar-shadow" id="default-navbar" data-primary>

      <!-- Navbar Toggler -->

      <button class="navbar-toggler w-auto mr-16pt d-block d-lg-none rounded-0" type="button" data-toggle="sidebar">
        <span class="material-icons">short_text</span>
      </button>

      <!-- // END Navbar Toggler -->

      <!-- Navbar Brand -->

      <a href="{{route('parentt.dashboard')}}" class="navbar-brand mr-16pt">

        <span class="avatar avatar-sm navbar-brand-icon mr-0 mr-lg-8pt">

          <span class="rounded" style="background:transparent;"><img src="{{ $brandLogo }}" alt="{{ $brandName }} logo" class="img-fluid" style="border-radius: inherit;" onerror="this.src='{{ asset('images/logo/Levels-logo.png') }}'" /></span>

        </span>

        <span class="d-none d-lg-block">
          {{ $brandName }}
        </span>
      </a>

      <!-- // END Navbar Brand -->

      <div class="flex"></div>

      <!-- Navbar Menu -->

      <div class="nav navbar-nav flex-nowrap d-flex mr-16pt">

        <!-- lang dropdown -->
        <div class="nav-item dropdown dropdown-notifications dropdown-xs-down-full" data-toggle="tooltip" data-title="Language" data-placement="bottom" data-boundary="window">
          <button class="nav-link btn-flush dropdown-toggle" type="button" data-toggle="dropdown" data-caret="false">
            <i class="material-icons icon-24pt">language</i>{{ session('locale', config('app.locale')) }}
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <div data-perfect-scrollbar class="position-relative">
              <div class="dropdown-header"><strong>Languages</strong></div>
              <div class="list-group list-group-flush mb-0">
                <a class="dropdown-item" href="{{ route('locale.setting', 'en') }}" data-lang="en">
                  <i class="flag-icon flag-icon-us m-1"></i> English
                </a>
                <a class="dropdown-item" href="{{ route('locale.setting', 'ar') }}" data-lang="ar">
                  <span class="flag-icon flag-icon-sa  m-1"></span> Arabic
                </a>
                <a class="dropdown-item" href="{{ route('locale.setting', 'de') }}" data-lang="de">
                  <i class="flag-icon flag-icon-de  m-1"></i> German
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- // END lang dropdown -->

        <!-- Notifications dropdown -->
        <div class="nav-item dropdown dropdown-notifications dropdown-xs-down-full" data-toggle="tooltip" data-title="Messages" data-placement="bottom" data-boundary="window">
          <button class="nav-link btn-flush dropdown-toggle" type="button" data-toggle="dropdown" data-caret="false">
            <i class="material-icons icon-24pt">mail_outline</i>
          </button>
        </div>
        <!-- // END Notifications dropdown -->

        <!-- Notifications dropdown -->
        <div class="nav-item ml-16pt dropdown dropdown-notifications dropdown-xs-down-full" data-toggle="tooltip" data-title="Notifications" data-placement="bottom" data-boundary="window">
          <button class="nav-link btn-flush dropdown-toggle" type="button" data-toggle="dropdown" data-caret="false">
            <i class="material-icons">notifications_none</i>
            <span class="badge badge-notifications badge-accent">2</span>
          </button>
        </div>
        <!-- // END Notifications dropdown -->

        <div class="nav-item dropdown">
          <a href="#" class="nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown" data-caret="false">

            <span class="avatar avatar-sm mr-8pt2">

              <span class="avatar-title rounded-circle bg-primary"><i class="material-icons">account_box</i></span>

            </span>

          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header"><strong>Account</strong></div>
            <!-- <a class="dropdown-item" href="edit-account.html">Edit Account</a>
            <a class="dropdown-item" href="billing.html">Billing</a>
            <a class="dropdown-item" href="billing-history.html">Payments</a> -->
            <a href="{{ route('users.logout') }}" class="dropdown-item">Logout</a>
          </div>
        </div>
      </div>

      <!-- // END Navbar Menu -->

    </div>

    <!-- // END Navbar -->

  </div>
</div>