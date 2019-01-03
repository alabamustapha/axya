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
      <div id="wrapper">

        @include('layouts.partials.header-nav')
        
        <!-- Main content -->
        <div class="content">
          <div class="container">
            @auth
              @if (! Request::is('appointments/*'))
                @if (Auth::user()->isAccountOwner())
                    <h4 class="pt-2 text-center">
                      {{-- @if (Auth::user()->application_status == '0')
                        Are you a <i class="fa fa-user-md"></i> Medical Doctor? 
                        <a class="btn btn-success btn-lg" href="{{route('doctors.create')}}">Register Here!</a>

                      @else --}}

                        {{ Auth::user()->applicationStatus() }}
                      {{-- @endif --}}
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
            
          </div><!-- /.container -->
        </div>

        @include('layouts.partials.footer')
                  
        @guest

            @include('auth.partials.registration-login-modal')

        @endguest

        <vue-progress-bar></vue-progress-bar>
      </div><!-- #/wrapper -->
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
