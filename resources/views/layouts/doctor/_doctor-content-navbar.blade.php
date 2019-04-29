<div class="content-navbar-nav">
    <ul class="nav flex-sm-row">

        <li class="nav-item position-relative">
            @include('layouts.partials.dynamic-breadcrumb')
        </li>
        
        @auth
            <li class="nav-item position-relative" title="{{Auth::user()->unreadNotifications->count()}} unread notifications">
                <a class="nav-link mr-1 text-white" href="{{ route('notifications.display', Auth::user()) }}"><i class="fas fa-bell fa-2x"></i>
                    <span class="notification-count">
                        @if (Auth::user()->unreadNotifications->count())
                            {{Auth::user()->unreadNotifications->count()}}
                        @endif
                    </span>
                </a>
            </li>
            
            <li class="nav-item nav-opt">
                <a class="nav-link ml-2 text-white " data-toggle="collapse" href="#optDropdown" role="button" aria-expanded="false"
                    aria-controls="optDropdown">
                    <i class="fas fa-ellipsis-v fa-2x"></i>
                </a>
                <div class="collapse opt-menu shadow-lg" id="optDropdown" style="z-index: 10000;">
                    <div class="opt-items">
                        <div class="extra-opt-items">
                            <a href="{{route('home')}}" class="opt-item">
                                <i class="fas fa-home fa-fw"></i>&nbsp; Home
                            </a>                        
                        </div>

                        <a href="{{route('users.show', Auth::user())}}" class="opt-item">
                            <i class="fas fa-user fa-fw"></i>&nbsp; Profile
                        </a>
                        
                        <a href="{{route('user_dashboard')}}" class="opt-item">
                            <i class="fas fa-tachometer-alt fa-fw"></i>&nbsp; User Dashboard
                        </a>

                        <a href="#" class="opt-item">
                            <i class="fas fa-question-circle fa-fw"></i>&nbsp; Help
                        </a>

                        <a  href="{{ route('logout') }}" class="opt-item sign-out" title="Sign out of app"
                          onclick="event.preventDefault(); 
                          document.getElementById('logout-form').submit();" 
                          class="opt-item sign-out">
                            <i class="fas fa-sign-out-alt fa-fw"></i>&nbsp; {{ __('Sign out') }}</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </li>
        @endauth
    </ul>
</div>