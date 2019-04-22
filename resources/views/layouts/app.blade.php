<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    @include('layouts.redesign.head-assets') 

</head>
<body>
    
    <div id="app">
        <div class="d-header dm-nav">
            <div class="trans-box">
                @include('layouts.redesign.header-nav')
            </div>
        </div>

        <div class="wrapper">
            <section id="content-override" style="min-height: 80vh;">

              <searches></searches>

              <router-view></router-view>

              <div class="p-3 {{ Request::is('subscription_plans') ? 'bg-darker':'' }}">
              
                @include('layouts.partials.notifications')

                @yield('content')
                
              </div>

              <vue-progress-bar></vue-progress-bar>

            </section><!-- /#content-override -->
        </div>

      @unless (Request::is('*/messages') || Request::is('*/messages/*'))
        @include('layouts.partials.footer')
      @endunless
                
      @guest
        @include('auth.partials.registration-login-modal')
      @endguest
    </div>

    <!-- Scripts -->
    @include('layouts.redesign.scripts') 
    
</body>
</html>
