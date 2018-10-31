
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
          </li>
        </ul>

        <!-- SEARCH FORM -->
        <form class="form-inline ml-3">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </form>

        <!-- Right navbar links -->
        @auth
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a id="navbarDropdown" class="nav-link {{auth()->user()->notifications->count() ? 'text-danger':'text-secondary'}}" role="button" 
                    href="{{ route('notifications.display', auth()->user()) }}" 
                    title="{{ auth()->user()->notifications->count() }} notifications"
                >
                    <i class="fa fa-bell"></i>
                </a>
            </li>

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">

                @include('layouts.partials.profile-dropdown')

            </li>
          </ul>
        @endauth
        
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('home') }}" class="brand-link">
          <img src="{{asset('images/compass.png')}}" alt="{{  config('app.name')}} Logo" class="brand-image img-circle elevation-3"
               style="opacity: .8">
          <span class="brand-text font-weight-light">{{  config('app.name')}}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

          <!-- Sidebar Menu -->
          @include('layouts.partials.dashboard-sidebar')
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>