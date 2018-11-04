
<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
    <img class="rounded-circle" src="{{ Auth::user()->avatar }}" width="25"> {{ Auth::user()->name }} <span class="caret"></span>
</a>

<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
    <a class="dropdown-item" href="{{ route('patient_dashboard', Auth::user()) }}">
        {{ __('My Account') }}
    </a>
    <a class="dropdown-item" href="{{ route('users.show',  Auth::user()) }}">
        {{ __('My Dashboard') }}
    </a>
    <a class="dropdown-item" href="{{-- --}}">
        {{ __('Update profile') }}
    </a>
    <a class="dropdown-item" href="{{-- --}}">
        {{ __('Settings') }}
    </a>
    <a class="dropdown-item" href="{{ route('logout') }}"
        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
        {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>