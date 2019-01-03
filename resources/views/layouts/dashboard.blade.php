<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield ('title')</title>
    <link rel="icon" href="images/favicon.png" type="image/png" >

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    {{--
    <link rel="stylesheet" href="{{asset('css/vendor/pikaday.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/jquery.timepicker.css')}}"> 
    --}}
    
    <!-- BOOTSTRAP STYLE -->
    {{-- <link rel="stylesheet" href="{{asset('css/vendor/bootstrap.min.css')}}">     --}}
    <!-- FULLCALENDAR STYLE -->
    <link rel="stylesheet" href="{{asset('css/vendor/fullcalendar.min.css')}}">
    <!-- MAIN STYLE -->
    <link rel="stylesheet" href="{{asset('css/custom/style.css')}}">
    <!-- DASHBOARD STYLE -->
    <link rel="stylesheet" href="{{asset('css/custom/dashboard.css')}}">

    @yield('styles')

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <script>
      @auth
        window.user = @json(auth()->user());
      @endauth
      
      window.appUrl  = @json(config('app.url'));
    </script>
  </head>
  <body>

    <div id="app">
      <div class="d-header dm-nav">

          <div class="trans-box">
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

                          <form class="form-inline">
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
                                          <a href="{{route('users.show', Auth::user())}}" class="opt-item">
                                            <i class="fa fa-user"></i>&nbsp; {{ __('Profile') }}</a>
                                         
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
              
                      </div>
              
                  </div>
              </nav>
          </div>
      </div>
      <div id="buttom-nav"></div>
      <div class="wrapper">

          <nav id="sidebar">

              <!-- Sidebar Header -->
              <div class="sidebar-header ">
                  <div class="avatar">
                      <img src="{{Auth::user()->avatar}}" height="50" class="rounded-circle" alt="user avatar"> 
                      <span class="online-status online mx-1"></span>{{Auth::user()->name}}
                  </div>
                  <div class="avatar-mini">
                      <img src="{{Auth::user()->avatar}}" height="50" class="rounded-circle" alt="user avatar">
                      <span class="online-status online"></span>
                  </div>
                  <!-- <h3>Sublime Admin</h3>
                  <strong>SA</strong> -->
              </div>

              <ul class="nav flex-sm-column">
                  <li class="nav-item">
                      <a class="nav-link" href="{{route('appointments.index')}}">
                          <span class="icon">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M2.85938 0H4.26562V1.45312H2.85938V0Z" fill="white" />
                                  <path d="M5.67188 0H7.07812V1.45312H5.67188V0Z" fill="white" />
                                  <path d="M8.48438 0H9.89062V1.45312H8.48438V0Z" fill="white" />
                                  <path d="M11.2969 0H12.7031V1.45312H11.2969V0Z" fill="white" />
                                  <path d="M14.1094 0H15.5156V1.45312H14.1094V0Z" fill="white" />
                                  <path d="M16.9219 0H18.3281V1.45312H16.9219V0Z" fill="white" />
                                  <path d="M19.7344 0H21.1406V1.45312H19.7344V0Z" fill="white" />
                                  <path d="M21.1406 1.45312V4.26562H19.7344V1.45312H18.3281V4.26562H16.9219V1.45312H15.5156V4.26562H14.1094V1.45312H12.7031V4.26562H11.2969V1.45312H9.89062V4.26562H8.48438V1.45312H7.07812V4.26562H5.67188V1.45312H4.26562V4.26562H2.85938V1.45312H0V5.67188H24V1.45312H21.1406Z"
                                      fill="white" />
                                  <path d="M11.2969 18.3281H12.7031V15.5156H15.5156V14.1094H12.7031V11.2969H11.2969V14.1094H8.48438V15.5156H11.2969V18.3281Z"
                                      fill="white" />
                                  <path d="M0 24H24V7.07812H0V24ZM7.07812 12.7031H9.89062V9.89062H14.1094V12.7031H16.9219V16.9219H14.1094V19.7344H9.89062V16.9219H7.07812V12.7031Z"
                                      fill="white" />
                              </svg>

                          </span>
                          <span class="navlink-active">My Appointments</span>
                      </a>
                  </li>

                  <li class="nav-item">
                  
                      <a class="nav-link" href="#">
                          <span class="icon">
                              <svg width="20" height="26" viewBox="0 0 20 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M10.0002 5.83984C6.8411 5.83984 4.271 8.3457 4.271 11.4258C4.271 14.5059 6.8411 17.0117 10.0002 17.0117C13.1592 17.0117 15.7293 14.5059 15.7293 11.4258C15.7293 8.3457 13.1592 5.83984 10.0002 5.83984ZM12.517 13.3541C12.3893 13.6061 12.2212 13.8126 12.0126 13.9734C11.8039 14.1344 11.5657 14.2557 11.2981 14.3377C11.0303 14.4196 10.7531 14.4697 10.4668 14.4879V15.5898H9.71959V14.4697C9.2899 14.4333 8.86334 14.3513 8.43995 14.2238C8.01647 14.0963 7.63672 13.9355 7.30042 13.7412L8.08501 12.1839C8.25313 12.2872 8.43365 12.3842 8.62678 12.4753C8.78865 12.5543 8.97704 12.6317 9.19183 12.7076C9.40662 12.7835 9.62615 12.8366 9.85032 12.8669V12.0655C9.65719 12.017 9.46412 11.9594 9.2712 11.8925C8.97839 11.7955 8.72626 11.6908 8.51464 11.5783C8.30287 11.4661 8.12844 11.3385 7.99157 11.1958C7.85454 11.0532 7.75339 10.8908 7.68803 10.7086C7.62261 10.5265 7.5899 10.317 7.5899 10.0803C7.5899 9.75244 7.64594 9.46258 7.75803 9.2106C7.87011 8.95873 8.02261 8.74159 8.21574 8.55948C8.40865 8.37738 8.63438 8.23164 8.89287 8.12236C9.15115 8.01308 9.42672 7.94336 9.71949 7.91289V6.99309H10.4667V7.92198C10.6722 7.9463 10.8714 7.98271 11.0645 8.03126C11.2575 8.07991 11.4428 8.13602 11.6202 8.19975C11.7977 8.26353 11.9642 8.33036 12.1199 8.40008C12.2755 8.46996 12.4188 8.53526 12.5496 8.59589L11.765 10.0621C11.628 9.97709 11.4785 9.89813 11.3167 9.82526C11.1796 9.75853 11.0255 9.69637 10.8543 9.63859C10.683 9.581 10.5102 9.53702 10.3359 9.50655V10.3262C10.392 10.3384 10.4511 10.3551 10.5134 10.3762C10.5756 10.3976 10.6409 10.4172 10.7095 10.4354C11.0145 10.5265 11.2901 10.6267 11.5362 10.736C11.7821 10.8453 11.9922 10.9743 12.1666 11.123C12.3409 11.2719 12.4749 11.4524 12.5682 11.6649C12.6616 11.8774 12.7083 12.1354 12.7083 12.4389C12.7085 12.7972 12.6445 13.1023 12.517 13.3541Z"
                                      fill="white" />
                                  <path d="M9.47656 9.78886C9.47656 9.87991 9.5076 9.95436 9.56995 10.012C9.63214 10.0697 9.72552 10.1228 9.85016 10.1713V9.47925C9.60099 9.50972 9.47656 9.61285 9.47656 9.78886Z"
                                      fill="white" />
                                  <path d="M10.6348 12.3888C10.5601 12.325 10.4604 12.269 10.3359 12.2203V12.8942C10.4854 12.8821 10.5912 12.8518 10.6535 12.8032C10.7157 12.7546 10.7469 12.6909 10.7469 12.6119C10.7469 12.527 10.7095 12.4526 10.6348 12.3888Z"
                                      fill="white" />
                                  <path d="M19.2188 4.0625C17.352 4.0625 15.8333 2.58177 15.8333 0.761719V0H4.16667V0.761719C4.16667 2.58177 2.64797 4.0625 0.78125 4.0625H0V16.5513L9.0887 26H10.9113L20 16.5513V4.0625H19.2188ZM10 18.5352C5.97937 18.5352 2.70833 15.3459 2.70833 11.4258C2.70833 7.50567 5.97937 4.31641 10 4.31641C14.0206 4.31641 17.2917 7.50567 17.2917 11.4258C17.2917 15.3459 14.0206 18.5352 10 18.5352Z"
                                      fill="white" />
                              </svg>

                          </span>
                          <span class="navlink-active">Transactions</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      
                      <a class="nav-link" href="{{route('appointments.index')}}">
                          <span class="icon">
                              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M23.9806 0.789727C23.9636 0.710216 23.9346 0.633205 23.8981 0.558694C23.8886 0.539692 23.8791 0.521189 23.8686 0.502186C23.8256 0.426676 23.7756 0.354165 23.7111 0.289656C23.6465 0.225147 23.5735 0.17514 23.498 0.132134C23.48 0.121633 23.462 0.112631 23.443 0.10313C23.3665 0.0656247 23.288 0.0351204 23.206 0.018118C23.2035 0.017618 23.202 0.0171179 23.2 0.0166178C23.1145 -0.00038456 23.0275 -0.00288491 22.9404 0.00261586C22.9214 0.00361601 22.9024 0.00561629 22.8834 0.00811664C22.7954 0.0186181 22.7079 0.0371207 22.6244 0.0711255L0.621767 9.07239C0.229211 9.23292 -0.019324 9.62347 0.00117888 10.0465C0.0216818 10.4701 0.306722 10.8346 0.71328 10.9562L10.1986 13.8021L13.044 23.2874C13.1661 23.6935 13.5306 23.9785 13.9537 23.999C13.9702 23.9995 13.9862 24 14.0027 24C14.4067 24 14.7738 23.756 14.9283 23.3784L23.9296 1.37531C23.9296 1.37481 23.9296 1.37481 23.9296 1.37431C23.9631 1.2923 23.9811 1.20679 23.9916 1.12027C23.9941 1.09877 23.9966 1.07777 23.9976 1.05626C24.0026 0.971252 24.0006 0.88574 23.9841 0.801729C23.9831 0.797728 23.9816 0.793727 23.9806 0.789727ZM18.7813 3.80415L10.7172 11.8688L3.99725 9.8525L18.7813 3.80415ZM14.1472 20.0034L12.1314 13.283L20.1951 5.21935L14.1472 20.0034Z"
                                      fill="white" />
                                  <path d="M8.70845 15.2918C8.31789 14.9013 7.6848 14.9013 7.29425 15.2918L4.79389 17.7922C4.40334 18.1827 4.40334 18.8158 4.79389 19.2064C4.98942 19.4019 5.24496 19.4994 5.50099 19.4994C5.75703 19.4994 6.01257 19.4019 6.20809 19.2064L8.70845 16.706C9.099 16.3155 9.099 15.6824 8.70845 15.2918Z"
                                      fill="white" />
                                  <path d="M1.70761 18.2062L3.20782 16.706C3.59838 16.3155 3.59838 15.6824 3.20782 15.2918C2.81726 14.9013 2.18417 14.9013 1.79362 15.2918L0.293405 16.792C-0.0971506 17.1826 -0.0971506 17.8157 0.293405 18.2062C0.488933 18.4018 0.744469 18.4993 1.00051 18.4993C1.25654 18.4993 1.51208 18.4018 1.70761 18.2062Z"
                                      fill="white" />
                                  <path d="M7.29411 20.7926L5.79389 22.2928C5.40334 22.6833 5.40334 23.3164 5.79389 23.707C5.98942 23.9025 6.24496 24 6.50099 24C6.75703 24 7.01257 23.9025 7.20809 23.707L8.70831 22.2067C9.09886 21.8162 9.09886 21.1831 8.70831 20.7926C8.31775 20.402 7.68466 20.402 7.29411 20.7926Z"
                                      fill="white" />
                              </svg>

                          </span>
                          <span class="navlink-active">Direct Messages</span> <span class="badge badge-danger">1</span>
                      </a>
                  </li>
              </ul>
          </nav>

        <section id="content">
            @auth
              @if (! Request::is('appointments/*'))
                @if (Auth::user()->isAccountOwner())
                    <h4 class="pt-2 text-center">

                      {{ Auth::user()->applicationStatus() }}

                    </h4>
                @endif
              @endif
            @endauth

            @include('layouts.partials.notifications')


            <div class="search-container">
              <div class="search-close mb-0 pb-0">
                <span class="s-close">&times;</span>
              </div>
                  
              <searches></searches>

            </div>

            <router-view></router-view>

            @yield('content')

          <vue-progress-bar></vue-progress-bar>
        </section><!-- #/content -->
      </div>

        @include('layouts.partials.footer')
                  
        @guest

            @include('auth.partials.registration-login-modal')

        @endguest
  </div><!-- #/id -->

    <!-- SCRIPTS -->
    <script src="{{asset('js/app.js')}}"></script>

    <script src="{{asset('js/vendor/moment.min.js')}}"></script>
    <script src="{{asset('js/vendor/pikaday.js')}}"></script>
    <!-- full Calender js -->
    <script src="{{asset('js/vendor/fullcalendar.min.js')}}"></script>
    
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script> $('div.alert').not('.alert-important').delay(7000).fadeOut(350); </script>

    <script>
      // https://github.com/Pikaday/Pikaday ..Customization..
      var picker = new Pikaday({ 
        field: document.getElementById('datepicker'),
        format: 'Y-M-D',
        onSelect: function() {
          console.log(this.getMoment().format('Y-M-D'));
        }
      });
      picker.gotoToday();
    </script>


    <!-- inline scripts -->

    <!-- Full Calendar SCRIPT -->
    <script>
      $(document).ready(function () {

            // page is now ready, initialize the calendar...

           $('#calendar').fullCalendar({
             height: 500,
           
            dayClick: function (date, jsEvent, view) {
                
                   alert('Clicked on: ' + date.format());

               },
            events: [
                   {
                       title: 'Appointment',
                       start: '2019-01-03T13:13:55.008',
                       end: '2019-01-03T13:13:55.008'
                   },
                   {
                       title: 'Event Title2',
                       start: '2019-01-05T13:13:55-0400',
                       end: '2019-01-05T13:13:55-0400'
                   }
               ]
              
          });
            
        });
    </script>

    <!-- SEARCH RESULT SCRIPT -->
    <script>

        $(document).ready(function () {

            /**
            * SCRIPT TO SHOW THE SEARCH RESULT AREA
            */

            let $searchBox = $('#search');
            // create the overlay and append to body
            let $searchOverlay = $("<div id='search-overlay'></div>");
            $('body').append($searchOverlay);

            function removeSearchResult() {
                $('.search-container').removeClass('search-active'),
                    $('#search-result').fadeOut(500),
                    $('.search-close').fadeOut(500),
                    $searchOverlay.fadeOut(500),
                    $('.search-icon').removeClass('bg-white text-theme-blue'),
                    $searchBox.val("");
            }

            function showSearchResult() {
                $searchOverlay.fadeIn(500);

                // push search-container up wards
                $('.search-container').addClass('search-active');

                // display the search list and close btn

                $('#search-result').fadeIn(500);
                $('.search-close').fadeIn(500);

                // change search icon style
                $('.search-icon').addClass('bg-white text-theme-blue');
            }
            // show on keypress to search

            $searchBox.on('keypress', showSearchResult);
            $('button.search-icon').click(function (event) {
                event.preventDefault();
                showSearchResult();
            });
            $searchBox.click(function () {
                if ($searchBox.val() == "") {
                    console.log('empty');
                } else {
                    console.log('not empty');

                }

            });

            $('.s-close').click(removeSearchResult);

            $searchBox.on('keyup', function () {
                if ($(this).val() == "") {
                    removeSearchResult();
                }
            });


            /**
            * SCRIPT TO DISPLAY RESULTS
            */

            //search query

            $searchBox.on('keyup', function () {
                let searchQuery = $searchBox.val();
                $('.result-title').text('Search Result for ' + searchQuery);
            })

        });

    </script>

    @guest
      <!-- SIGN UP SCRIPT -->
      <script>        
        $(document).ready(function(){
           let $docAcct = $('#doc-acct');
           let $patAcct = $('#pat-acct');
           let selectColor = "btn-theme-blue";

           function hasSelectedColor(theClass) {
               return theClass.hasClass(selectColor);
           }

           function toggleColorChange(theClass){
                if (hasSelectedColor(theClass)) {
                    theClass.removeClass(selectColor);

               } else {
                  
                   $('.acct-type').find('.btn-theme-blue').removeClass(selectColor); 

                   theClass.addClass(selectColor);
               }
           }

           $docAcct.click(function(){
               toggleColorChange($(this));               
           })
           $patAcct.click(function(){
               toggleColorChange($(this));               
           })
        });        
      </script>
    @endguest

    @yield('scripts')
  </body>
</html>
