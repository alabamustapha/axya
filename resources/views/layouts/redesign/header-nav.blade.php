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
                                {{-- @keyup="searchForQuery" --}}
                                type="search"
                                name="search" id="search"
                                aria-label="Search" 
                                placeholder="search doctors, illness..."
                                class="form-control mr-sm-2 m-0 border-0 rounded search-form"
                                minlength="3"
                                required>
                
                                {{-- <button @click="searchForQuery" type="submit" class="search-icon bg-theme-blue">
                                    <i class="fa fa-search "></i>
                                </button>  --}}                             
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