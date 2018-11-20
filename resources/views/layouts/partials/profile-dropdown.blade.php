
<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
    <img class="rounded-circle" src="{{ Auth::user()->avatar }}" width="25"> 
    <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
    <span class="caret"></span>
</a>

<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="{{ route('dashboard-main') }}">
        <i class="fa fa-user-tie"></i>&nbsp; {{ __('Admin Dashboard') }}
    </a>
    <a class="dropdown-item" href="{{ route('users.show',  Auth::user()) }}">
        <i class="fa fa-user-check"></i>&nbsp; {{ __('My Dashboard') }}
    </a>
    @if (Auth::user()->is_doctor)
    <a class="dropdown-item" href="{{ route('doctors.show',  Auth::user()) }}">
        <i class="fa fa-user-md"></i>&nbsp; {{ __('Doctor Profile') }}
    </a>
    @endif
    {{-- <a class="dropdown-item" href="#">
        {{ __('Settings') }}
    </a> --}}
    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out-alt"></i>&nbsp; {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>