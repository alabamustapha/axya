<nav class="navbar navbar-expand-lg main-nav ">
    <div class="container-fluid">
        <a class="navbar-brand d-inline-block" href="{{route('home')}}">
            <img 
                src="{{ (\Browser::isMobile() || \Browser::isTablet()) 
                          ? asset('images/axya-logo-mini.svg') 
                          : asset('images/axya-logo.png')
                      }}" 
                style="max-height: {{ (Request::path() != '/') ? 47 : 100 }}px;"
                {{-- height="{{ (Request::path() != '/') ? 47 : 100 }}" --}}
                alt="axya logo"
            >
        </a>
        
        @if (Request::path() != '/')
        <div class="navbar-nav mr-auto">
            <form @submit.prevent="searchForQuery" class="form-inline mb-2 w-100">
                <input
                  v-model="search"
                  {{-- @keyup/@key.enter="searchForQuery" --}}
                  type="search"
                  name="search" id="search"
                  aria-label="Search" 
                  placeholder="search doctors, illness..."
                  class="form-control mr-sm-2 m-0 border-0 rounded search-form bg-light px-4"
                  autocomplete="off"
                  minlength="3"
                  required>
  
                  {{-- <button @click="searchForQuery" type="submit" class="search-icon bg-theme-blue">
                      <i class="fa fa-search "></i>
                  </button>  --}}                             
            </form>
        </div>
        @endif

        <div class="dashboard-navbar" id="navbarSupportedContent">

            <ul class="mx-auto list-unstyled">
                <ul class="list-inline">
                    @auth
                    <li class="rounded nav-item mb-2 list-inline-item d-none d-sm-inline-block" title="Visit your dashboard">
                        <a class="nav-link mr-0 px-3" href="{{route('user_dashboard')}}">Dashboard</a>
                    </li>
                    @endauth

                    <li class="rounded nav-item mb-2 list-inline-item dropdown d-none d-sm-inline-block">
                        @include('layouts.partials.dynamic-breadcrumb')
                    </li>
                    @guest                    
                        @if (  request()->url() !== route('login' ) 
                            && request()->url() !== route('register'))
                            <li class="rounded nav-item mb-2 list-inline-item" title="Sign in or register new account">
                                <a class="nav-link mr-0 px-3 sign-in" href="#" data-toggle="modal" data-target="#sign-in-up-modal">Sign In</a>
                            </li>
                        @endif
                    @else

                      <li class="nav-item mb-2 list-inline-item position-relative" title="{{auth()->user()->notifications->count()}} unread notifications">
                          <a class="nav-link mr-0 px-2 text-white" 
                            href="{{ route('notifications.display', auth()->user()) }}"><i class="fas fa-bell{{--  fa-2x --}} notification-icon"></i></a>
                          <span class="notification-count">
                            {{auth()->user()->notifications->count()}}
                          </span>
                      </li>

                      <li class="nav-item mb-2 list-inline-item nav-avatar d-none d-sm-inline-block" title="Logged in user is {{Auth::user()->name}}">
                          <img src="{{ Auth::user()->avatar }}"  height="41" alt="user avatar" class="rounded-circle">
                      </li>

                      <li class="nav-item mb-2 list-inline-item{{--  sm-float-right --}}" title="More menu links">

                          <div class="">
                            <a id="navbarDropdown" class="bg-dark rounded nav-link mr-0 px-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-ellipsis-v px-1 mr-0"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right shadow-lg" aria-labelledby="navbarDropdown">
                                <div class="opt-items text-left">
                                    <div class="extra-opt-items">
                                        <a href="{{route('home')}}" class="opt-item">
                                          <i class="fas fa-home fa-fw"></i>&nbsp; {{ __('Home') }}</a>
                                       
                                    </div>
                                    <a href="{{route('user_dashboard')}}" class="opt-item">
                                      <i class="fas fa-tachometer-alt fa-fw"></i>&nbsp; {{ __('Dashboard') }}
                                    </a>

                                    <a href="{{route('users.show', Auth::user())}}" class="opt-item">
                                      <i class="fas fa-user fa-fw"></i>&nbsp; {{ __('Your User Profile') }}
                                    </a>

                                    <a href="{{ route('doctors.index') }}" class="opt-item d-md-none">
                                      <i class="fas fa-user-md fa-fw"></i>&nbsp; {{ __('Doctors Index') }}
                                    </a>

                                    <span class="dropdown-divider"></span>
                                   
                                    @if (Auth::user()->is_doctor)
                                      <a href="{{route('doctors.show', Auth::user())}}" class="opt-item">
                                        <i class="fas fa-user-md fa-fw"></i>&nbsp; {{ __('Your Doctor Profile') }}
                                      </a>

                                      <a href="{{ Auth::user()->transactions_list }}" class="opt-item">
                                        <i class="fas fa-money-check-alt fa-fw"></i>&nbsp; Payments
                                      </a>

                                      <a href="{{ route('subscription_plans.index') }}" class="opt-item {{Request::path() == 'subscription_plans' ? 'active':''}}">
                                        <i class="fas fa-rss fa-fw"></i>&nbsp; Subscription Plans
                                      </a>
                                    @endif
                                    {{-- <a href="{{Auth::user()->prescriptions_list}}" class="opt-item">
                                        <i class="fas fa-prescription fa-fw"></i>&nbsp; Prescriptions
                                    </a>
                                    
                                    <a href="{{ route('medications.index', Auth::user()) }}" class="opt-item">
                                        <i class="fas fa-pills fa-fw"></i>&nbsp; Medications
                                    </a> --}}

                                    <a href="#" class="opt-item teal">
                                        <i class="fas fa-question-circle fa-fw"></i>&nbsp; Help
                                    </a>
                                    
                                    <a href="{{ route('logout') }}" title="Log out of app"
                                      onclick="event.preventDefault(); 
                                      document.getElementById('logout-form').submit();" 
                                      class="opt-item sign-out">
                                        <i class="fas fa-sign-out-alt fa-fw"></i>&nbsp; {{ __('Sign out') }}</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>

                            </div>
                          </div>
                      </li>
                      {{-- <li class="nav-item mb-2 list-inline-item nav-opt" title="More menus">
                          <a class="nav-link mr-0 px-3 {{-- ml-2 --} } text-white "  data-toggle="collapse" href="#optDropdown" role="button" aria-expanded="false" aria-controls="optDropdown">
                              <i class="fas fa-ellipsis-v px-2 {{-- fa-2x --} }"></i>
                          </a>

                          <div class="collapse opt-menu shadow-lg float-right" id="optDropdown">
                              <div class="opt-items">
                                  <div class="extra-opt-items">
                                      <a href="{{route('home')}}" class="opt-item">
                                        <i class="fas fa-home fa-fw"></i>&nbsp; {{ __('Home') }}</a>
                                     
                                  </div>
                                  <a href="{{route('user_dashboard')}}" class="opt-item">
                                    <i class="fas fa-tachometer-alt fa-fw"></i>&nbsp; {{ __('Dashboard') }}</a>
                                  <a href="{{route('users.show', Auth::user())}}" class="opt-item">
                                    <i class="fas fa-user fa-fw"></i>&nbsp; {{ __('Profile') }}
                                  </a>
                                 
                                  @if (Auth::user()->is_doctor)
                                    <a href="{{route('doctors.show', Auth::user())}}" class="opt-item">
                                      <i class="fas fa-user-md fa-fw"></i>&nbsp; {{ __('Doctor Profile') }}
                                    </a>

                                    <a href="{{ Auth::user()->transactions_list }}" class="opt-item">
                                      <i class="fas fa-money-check-alt fa-fw"></i>&nbsp; Payments
                                    </a>
                                  @endif
                                  <a href="{{Auth::user()->prescriptions_list}}" class="opt-item">
                                      <i class="fas fa-prescription fa-fw"></i>&nbsp; Prescriptions
                                  </a>
                                  
                                  <a href="{{ route('medications.index', Auth::user()) }}" class="opt-item">
                                      <i class="fas fa-pills fa-fw"></i>&nbsp; Medications
                                  </a>

                                  <a href="#" class="opt-item teal">
                                      <i class="fas fa-question-circle fa-fw"></i>&nbsp; Help
                                  </a>
                                  
                                  <a href="{{ route('logout') }}" title="Log out of app"
                                    onclick="event.preventDefault(); 
                                    document.getElementById('logout-form').submit();" 
                                    class="opt-item sign-out">
                                      <i class="fas fa-sign-out-alt fa-fw"></i>&nbsp; {{ __('Sign out') }}</a>

                                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      @csrf
                                  </form>
                              </div>
                          </div>
                      </li> --}}                      
                    @endguest

                    
                    {{-- <li class="nav-item mb-2 list-inline-item">
                        <a class="nav-link px-3" href="#">Contact Us</a>
                    </li> --}}
                </ul>
            </ul>

        </div>

    </div>
</nav>

{{--
  <nav class="navbar navbar-expand-lg main-nav ">
      <div class="container-fluid">
          <a class="navbar-brand" href="{{route('home')}}">
            <img src="{{asset('images/axya-logo.png')}}" height="47" alt="axya logo">
          </a>

          <div class=" dashboard-navbar" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto xs-nav  align-items-center">
                  <li class="nav-item active">
                      <a class="nav-link" href="{{route('user_dashboard')}}">Dashboard</a>
                  </li>
                  <li class="nav-item dropdown">

                      @include('layouts.partials.dynamic-breadcrumb')

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
                  @guest                    
                      @if (  request()->url() !== route('login' ) 
                          && request()->url() !== route('register'))
                          <li class="nav-item">
                              <a class="nav-link sign-in" href="#" data-toggle="modal" data-target="#sign-in-up-modal">Sign in</a>
                          </li>
                      @endif
                  @endguest
              </ul>

              <form @submit.prevent="searchForQuery" class="form-inline">
                  <input
                    v-model="search"
                    { {-- @keyup="searchForQuery" --} }
                    type="search"
                    name="search" id="search"
                    aria-label="Search" 
                    placeholder="search doctors, illness..."
                    class="form-control mr-sm-2 m-0 border-0 rounded search-form bg-dark"
                    autocomplete="off"
                    minlength="3"
                    required>
    
                    { {-- <button @click="searchForQuery" type="submit" class="search-icon bg-theme-blue">
                        <i class="fa fa-search "></i>
                    </button>  --} }                             
              </form>

              @auth
              <a  class="buttom-nav-toggler text-white ml-2" data-toggle="collapse" href="#extra-buttom-nav" role="button" aria-expanded="false" aria-controls="extra-buttom-nav">
                  <i class="fas fa-bars fa-2x"></i>
              </a>
              <ul id="extra-buttom-nav" class=" navbar-nav align-items-center  ">

                  <li class="nav-item">
                      <a class="nav-link mr-1 text-white" href="#"><i class="fas fa-cog fa-2x"></i></a>
                  </li>

                  <li class="nav-item position-relative">
                      <a class="nav-link mr-1 text-white" 
                        href="{{ route('notifications.display', auth()->user()) }}"><i class="fas fa-bell fa-2x"></i></a>
                      <span class="notification-count">
                        {{auth()->user()->notifications->count()}}
                      </span>
                  </li>

                  <li class="nav-item nav-avatar ml-3">
                      <img src="{{ Auth::user()->avatar }}"  height="55" alt="user avatar" class="rounded-circle">
                  </li>

                  <li class="nav-item nav-opt">
                      <a class="nav-link ml-2 text-white "  data-toggle="collapse" href="#optDropdown" role="button" aria-expanded="false" aria-controls="optDropdown">
                          <i class="fas fa-ellipsis-v fa-2x"></i>
                      </a>
                      <div class="collapse opt-menu shadow-lg" id="optDropdown">
                          <div class="opt-items">
                              <div class="extra-opt-items">
                                  <a href="{{route('home')}}" class="opt-item">
                                    <i class="fas fa-home fa-fw"></i>&nbsp; {{ __('Home') }}</a>
                                 
                              </div>
                              <a href="{{route('user_dashboard')}}" class="opt-item">
                                <i class="fas fa-tachometer-alt fa-fw"></i>&nbsp; {{ __('Dashboard') }}</a>
                              <a href="{{route('users.show', Auth::user())}}" class="opt-item">
                                <i class="fas fa-user fa-fw"></i>&nbsp; {{ __('Profile') }}
                              </a>
                             
                              @if (Auth::user()->is_doctor)
                                <a href="{{route('doctors.show', Auth::user())}}" class="opt-item">
                                  <i class="fas fa-user-md fa-fw"></i>&nbsp; {{ __('Doctor Profile') }}
                                </a>

                                <a href="{{ Auth::user()->transactions_list }}" class="opt-item">
                                  <i class="fas fa-money-check-alt fa-fw"></i>&nbsp; Payments
                                </a>
                              @endif
                              <a href="{{Auth::user()->prescriptions_list}}" class="opt-item">
                                  <i class="fas fa-prescription fa-fw"></i>&nbsp; Prescriptions
                              </a>
                              
                              <a href="{{ route('medications.index', Auth::user()) }}" class="opt-item">
                                  <i class="fas fa-pills fa-fw"></i>&nbsp; Medications
                              </a>

                              <a href="#" class="opt-item teal">
                                  <i class="fas fa-question-circle fa-fw"></i>&nbsp; Help
                              </a>
                              
                              <a href="{{ route('logout') }}" title="Log out of app"
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
              </ul>
              @endauth

          </div>

      </div>
  </nav>
--}}