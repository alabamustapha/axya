<nav class="navbar navbar-expand-md fixed-top navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'AXYA') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                    
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a id="navbarDropdown" class="nav-link {{auth()->user()->notifications->count() ? 'text-danger':'text-secondary'}}" role="button" v-pre 
                            href="{{ route('notifications.display', auth()->user()) }}" 
                            title="{{ auth()->user()->notifications->count() }} notifications"
                        >
                            <i class="fa fa-bell" style="font-size: 120%;"></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        @include('layouts.partials.profile-dropdown')
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>