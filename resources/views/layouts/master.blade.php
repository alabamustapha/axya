<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield ('title')</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom/override.css')}}">
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

          @auth
            @include('layouts.partials.verification_nag')
          @endauth

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

          @if(isset($errors) && count($errors) > 0)
            <div class="container">
              <div class="col text-left">
                <div class="alert alert-danger" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>

                  <ul class="list-unstyled">
                      @foreach($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
                </div>
              </div>
            </div>
          @endif

          @include('flash::message')

          <div class="container-fluid">

            <searches></searches>
            <router-view></router-view>

            @yield('content')
            
          </div><!-- /.container-fluid -->
        </div>
      </div>

      {{-- <footer class="main-footer">
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-{{date('Y')}} <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
      </footer> --}}

      <vue-progress-bar></vue-progress-bar>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <script src="{{asset('js/app.js')}}"></script>
    <script>
      $('div.alert').not('.alert-important').delay(7000).fadeOut(350);
    </script>
  </body>
</html>
