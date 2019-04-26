<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../images/favicon.png" type="image/png">

    @if (app()->environment('local'))
      <link rel="stylesheet" href="{{asset('css/vendor/jquery.dataTables.min.css')}}">
      <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    @else
      <!-- DATATABLE STYLE -->
      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
      <link rel="stylesheet" href="{{asset('css/admin.min.css')}}">
    
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP"
        crossorigin="anonymous">
    @endif
    
    <title>{{ config('app.name') }} - @yield('title')</title>

    <script>
      @auth
        @if (Auth::user()->isStaff() && Auth::user()->isAuthenticatedStaff())
            window.user = @json(auth()->user());//auth()->id());//
        @endif
      @endauth
      
      window.appUrl  = @json(config('app.url'));
    </script>

</head>

<body>
    
  <div id="app" class="wrapper">

    <nav id="sidebar">
        <div class="sidebar-brand">
            <a class="d-inline-block" href="{{route('user_dashboard')}}">        
                <img src="{{ asset('images/axya-logo.png') }}" 
                    height="47" alt="{{ config('app.name') }} logo"
                >
            </a>
        </div>

        <!-- Sidebar Header -->
        <div class="sidebar-header ">
            <div class="avatar">
                <img src="../images/a1.jpg" height="50" class="rounded-circle" alt=""> 
                <span class="online-status online mx-1"></span> {{ Auth::user()->name }}
            </div>
            <div class="avatar-mini">
                <img src="../images/a1.jpg" height="50" class="rounded-circle" alt="">
                <span class="online-status online"></span>
            </div>
        </div>
        
        @include('layouts.admin._admin-left-sidebar')
    </nav>

    <section id="content">
        
      <div id="content-navbar">
        <div class="container-fluid">
           <div class="content-nav-flexer">
               <div class="py-3 d-flex">
           
                   <button type="button" id="sidebarCollapse" class="btn btn-light navbar-btn">
                       <i class="fa fa-align-left"></i>
                       <!-- Shrink Sidebar -->
                   </button>
           
                   <a class="crumb h4 text-white text-uppercase">
                       
                      @yield('page-title')

                   </a>                  
               </div>

               @include('layouts.admin._admin-content-navbar')
           </div> 
        </div>
        <!-- end container fluid -->
      </div>
      <!-- end content navbar -->          

      <section class="main-content mt-40" style="min-height: 70vh;">

        @yield('content')

      </section>                    
      <!-- end admin content -->

      <div class="content-footer">
          <div class="float-right">Admin Area</div>
          <div>...</div>
      </div>
      <!-- end footer -->
    </section>
  </div>
  <!-- end wrapper -->
  
    @if (Auth::user()->isStaff() && ! Auth::user()->isAuthenticatedStaff())

      @include('auth.partials.admin-login-modal')

    @endif

    @include('layouts.admin.admin-scripts')

</body>

</html>