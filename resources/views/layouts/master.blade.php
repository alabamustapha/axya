<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{  config('app.name')}} | {{ $user->name }} Dashboard</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">
    @auth
      <script>
          window.user = @json(auth()->user());
      </script>
    @endauth
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

          @include('flash::message')

          <div class="container-fluid">

            <router-view></router-view>

            @yield('content')
            
          </div><!-- /.container-fluid -->
        </div>
      </div>

      <footer class="main-footer">
        <!-- Default to the left -->
        {{-- <strong>Copyright &copy; 2014-{{date('Y')}} <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved. --}}
      </footer>

      <vue-progress-bar></vue-progress-bar>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <script src="{{asset('js/app.js')}}"></script>
    <script>
      $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>
  </body>
</html>
