<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield ('title')</title>
    <link rel="icon" href="images/favicon.png" type="image/png" >

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('css/all.css')}}">

    <link rel="stylesheet" href="{{asset('css/custom/override.css')}}">

    <link rel="stylesheet" href="{{asset('css/vendor/pikaday.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/jquery.timepicker.css')}}"> --}}
    
    <link rel="stylesheet" href="{{asset('css/custom/style.css')}}">

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    @yield('styles')

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
                      @if (Auth::user()->application_status == '0')
                        Are you a <i class="fa fa-user-md"></i> Medical Doctor? 
                        <a class="btn btn-success btn-lg" href="{{route('doctors.create')}}">Register Here!</a>

                      @else

                        {{ Auth::user()->applicationStatus() }}
                      @endif
                    </h4>
                @endif
              @endif
            @endauth

            @include('layouts.partials.notifications')

            <searches></searches>

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

    <!-- REQUIRED SCRIPTS -->
    <script src="{{asset('js/app.js')}}"></script>

    <script src="{{asset('js/vendor/moment.min.js')}}"></script>
    <script src="{{asset('js/vendor/pikaday.js')}}"></script>
    
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

    @guest
      <!-- inline script -->
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
