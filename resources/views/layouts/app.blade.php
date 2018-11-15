<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
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
        
        @include('layouts.partials.top_nav')

        <main class="" style="margin-top: 75px;">
            @auth
                @include('layouts.partials.verification_nag')
            @endauth

            @include('flash::message')
            
            @yield('content')
        </main>
    </div>
    <script>
      $('div.alert').not('.alert-important').delay(7000).fadeOut(350);
    </script>
</body>
</html>
