<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield ('title')</title>
    <link rel="icon" href="images/favicon.png" type="image/png">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{asset('css/custom/style.css')}}" rel="stylesheet">
    
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
        
        @include('layouts.partials.top_nav')

        <main class="" style="margin-top: 75px;">

            @include('layouts.partials.notifications')
            
            @yield('content')
        </main>
                
        @guest
          @include('auth.partials.registration-login-modal')
        @endguest
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="{{asset('js/vendor/jquery-2.0.3.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script>
      $('div.alert').not('.alert-important').delay(7000).fadeOut(350);
    </script>

    @yield('scripts')
</body>
</html>
