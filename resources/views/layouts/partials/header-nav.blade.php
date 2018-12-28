
<nav class="navbar navbar-expand-lg main-nav bg-theme-blue">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('images/axya-logo.png')}}"  class="img-fluid" alt="axya logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{route('home')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">FAQs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
                <li class="nav-item dropdown">

                    @include('layouts.partials.dynamic-breadcrumb')

                </li>
                @guest                    
                    @if (   request()->url() !== route('login' ) 
                        &&  request()->url() !== route('register'))
                        <li class="nav-item">
                            <a class="nav-link sign-in" href="#" data-toggle="modal" data-target="#sign-in-up-modal">Sign in</a>
                        </li>
                    @endif
                @else

                    <!-- Notifications Section -->
                    <li class="nav-item">
                        <a id="navbarDropdown" class="nav-link {{auth()->user()->notifications->count() ? 'text-danger':'text-secondary'}}" role="button" 
                            href="{{ route('notifications.display', auth()->user()) }}" 
                            title="{{ auth()->user()->notifications->count() }} notifications"
                        >
                            <span style="max-width: 30px;">
                                <i class="fa fa-bell mr-0" style="font-size: 120%;"></i>

                                <sup style="font-size: 50%;" class="p-1 ml-0 bg-light rounded text-danger text-bold">{{ auth()->user()->notifications->count() }}</sup>
                            </span>
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