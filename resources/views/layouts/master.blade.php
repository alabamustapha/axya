<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{  config('app.name')}} | Dashboard</title>

    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
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
