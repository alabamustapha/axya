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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">

    <link rel="stylesheet" href="{{asset('css/custom/override.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom/style.css')}}">

    <link rel="stylesheet" href="{{asset('css/vendor/pikaday.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/jquery.timepicker.css')}}">
    {{-- 
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css"> 
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/timepicker@1.11.14/jquery.timepicker.css">
    --}}

    @yield('styles')

    <script>
      @auth
        window.user = @json(auth()->user());
      @endauth
      
      window.appUrl  = @json(config('app.url'));
    </script>
  </head>
  <body class="hold-transition sidebar-mini">

    <div class="wrapper" id="app">

      @include('layouts.partials.dashboard-navbar-sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper" style="min-height:80vh;">

        <!-- Main content -->
        <div class="content">

          <div class="container">
            <div class="col bg-white p-0 mt-0 text-center">
              @auth
                @if (! Request::is('appointments/*'))
                  @if (Auth::user()->isAccountOwner())
                      <h4 class="pt-2">
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

              <nav aria-label="breadcrumb" class="my-0">                
                @include('layouts.partials.dynamic-breadcrumb')
              </nav>
            </div>
          </div>

          @include('layouts.partials.notifications')

          <div class="container-fluid">

            <searches></searches>

            <router-view></router-view>

            @yield('content')
            
          </div><!-- /.container-fluid -->
        </div>
      </div>

      {{-- 
      <footer class="main-footer">
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-{{date('Y')}} <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
      </footer> 
      --}}
                
      @guest

          @include('auth.partials.registration-login-modal')

      @endguest

      <vue-progress-bar></vue-progress-bar>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/vendor/moment.min.js')}}"></script>
    <script src="{{asset('js/vendor/pikaday.js')}}"></script>
    {{-- 
      <script src="https://momentjs.com/downloads/moment.min.js"></script> 
      <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    --}}
    <script>
      $('div.alert').not('.alert-important').delay(7000).fadeOut(350);
    </script>

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

    @yield('scripts')
  </body>
</html>
