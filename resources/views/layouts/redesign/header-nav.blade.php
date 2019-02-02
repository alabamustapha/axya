<nav class="navbar navbar-expand-lg main-nav ">
                  <div class="container-fluid">
                      <a class="navbar-brand" href="{{route('home')}}">
                        <img src="{{asset('images/axya-logo.png')}}" height="47" alt="axya logo">
                      </a>
              
                      <div class=" dashboard-navbar" id="navbarSupportedContent">
                          <ul class="navbar-nav ml-auto xs-nav  align-items-center">
                              <li class="nav-item active">
                                  <a class="nav-link" href="{{route('home')}}">Home</a>
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
                                @keyup="searchForQuery"
                                type="search"
                                name="search" id="search"
                                aria-label="Search" 
                                placeholder="search..."
                                class="form-control mr-sm-2 m-0 border-0 rounded search-form" >
                
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
                                                <i class="fa fa-home"></i>&nbsp; {{ __('Home') }}</a>
                                             
                                          </div>
                                          <a href="{{route('user_dashboard')}}" class="opt-item">
                                            <i class="fa fa-tachometer-alt"></i>&nbsp; {{ __('Dashboard') }}</a>
                                          @if (Auth::user()->is_doctor)
                                          <a href="{{route('doctors.show', Auth::user())}}" class="opt-item">
                                            <i class="fa fa-user-md"></i>&nbsp; {{ __('Doctor Profile') }}
                                          </a>
                                          @endif
                                          <a href="{{route('users.show', Auth::user())}}" class="opt-item">
                                            <i class="fa fa-user"></i>&nbsp; {{ __('Profile') }}
                                          </a>
                                         
                                          <a href="#" class="opt-item">Account</a>
                                          <a href="#" class="opt-item">Payment Option</a>
                                          <a href="#" class="opt-item">Help</a>
                                          <a href="{{ route('logout') }}" title="Log out of app"
                                            onclick="event.preventDefault(); 
                                            document.getElementById('logout-form').submit();" 
                                            class="opt-item sign-out">
                                              <i class="fa fa-sign-out-alt"></i>&nbsp; {{ __('Sign out') }}</a>

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