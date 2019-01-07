    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield ('title')</title>
    <link rel="icon" href="images/favicon.png" type="image/png" >

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/all.css')}}">
    <link rel="stylesheet" href="{{asset('css/vendor/pikaday.css')}}">
    
    
    <!-- BOOTSTRAP STYLE -->
    {{-- <link rel="stylesheet" href="{{asset('css/vendor/bootstrap.min.css')}}">     --}}
    <!-- FULLCALENDAR STYLE -->
    <link rel="stylesheet" href="{{asset('css/vendor/fullcalendar.min.css')}}">
    <!-- MAIN STYLE -->
    <link rel="stylesheet" href="{{asset('css/custom/style.css')}}">
    <!-- DASHBOARD STYLE -->
    <link rel="stylesheet" href="{{asset('css/custom/dashboard.css')}}">

    @yield('styles')
    <style>
        .form-section textarea {
            border: 1px solid #302C2C;
            box-sizing: border-box;
            border-radius: 4px;
        }
    </style>

    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">