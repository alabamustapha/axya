<nav class="navbar navbar-expand-md navbar-light">
    <div class="container">
       
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                    <a class="nav-link btn btn-outline-primary" href="{{ route('register') }}">{{ __('Download app') }}</a>  
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ '#' }}">{{ __('About') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ '#' }}">{{ __('FAQS') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ '#' }}">{{ __('Contact Us') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary" href="{{ route('register') }}">{{ __('Become a doctor') }}</a>
                </li>
                @guest
                    
                @else
                    
                @endguest
            </ul>
        </div>
    </div>
</nav>