    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield ('title')</title>
    <link rel="icon" href="images/favicon.png" type="image/png" >

    <!-- Styles -->
    @if (app()->environment('local'))
        <link rel="stylesheet" href="{{asset('css/vendors.css')}}">
        <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    @else
        <link rel="stylesheet" href="{{asset('css/vendors.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/custom.min.css')}}">
    @endif
    {{-- 
        <!-- To be used strictly on Admin dashboard sectons only -->
        <link rel="stylesheet" href="{{asset('css/custom/admin.css')}}">
    --}}
    @yield('styles')
    <!-- ./Styles -->

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <script>
      @auth
        window.user = @json(auth()->id());//auth()->user()
      @endauth
      
      window.appUrl  = @json(config('app.url'));
    </script>