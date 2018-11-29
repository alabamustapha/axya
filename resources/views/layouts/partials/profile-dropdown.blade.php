
<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
    <img class="rounded-circle" src="{{ Auth::user()->avatar }}" width="25"> 
    <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
    <span class="caret"></span>
</a>

<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
    @can('isAdmin')
    <a class="dropdown-item" href="{{ route('dashboard-main') }}" title="Adimn Dashboard Area">
        <i class="fa fa-user-tie"></i>&nbsp; {{ __('Admin Dashboard') }}
    </a>
    @endcan

    @can('isDoctor')
    <a class="dropdown-item" href="{{ route('doctors.show',  Auth::user()) }}" title="Official Profile Page (Doctor)">
        <i class="fa fa-user-md"></i>&nbsp; {{ __('Official Profile') }}
    </a>
    @endcan

    <a class="dropdown-item" href="{{ route('users.show',  Auth::user()) }}" title="Profile Page (Normal User)">
        <i class="fa fa-user"></i>&nbsp; {{ __('Normal Profile') }}
    </a>

    <a class="dropdown-item" href="{{ route('user_dashboard') }}" title="Dashboard Area (Normal User)">
        <i class="fa fa-tachometer-alt"></i>&nbsp; {{ __('Dashboard') }}
    </a>

    <a class="dropdown-item" href="{{ route('logout') }}" title="Log out of app"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out-alt"></i>&nbsp; {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>