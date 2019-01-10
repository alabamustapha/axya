<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>

    @include('layouts.redesign.head-assets') 

    <script>
      @auth
        window.user = @json(auth()->user());
      @endauth
      
      window.appUrl  = @json(config('app.url'));
    </script>
  </head>
  <body>

    <div id="app">
      <div class="d-header dm-nav">

          <div class="trans-box">
            @include('layouts.redesign.header-nav')
          </div>
      </div>

      <div id="buttom-nav"></div>

      <div class="wrapper">

        <nav id="sidebar">
          @auth
            <!-- Sidebar Header -->
            @include('layouts.redesign.sidebar')              
          @endauth
        </nav>

        <section id="content">

          <div id="content-navbar">
            <div class="container-fluid">
              @include('layouts.redesign.button-page-title') 

              @include('layouts.partials.notifications')
            </div>
              <!-- end container fluid -->
          </div>
          <!-- end content navbar -->


          <div class="search-container">
            @include('layouts.redesign.search-container')
          </div>

          <router-view></router-view>

          <div class="p-3">
            @yield('content')
          </div>

          <vue-progress-bar></vue-progress-bar>
        </section><!-- /#content -->
      </div>

      @include('layouts.partials.footer')
                
      @guest
          @include('auth.partials.registration-login-modal')
      @endguest
      
      @auth
        @if (Auth::user()->is_doctor)
          <!-- Appointment Subscription Form-->
          <div class="modal" tabindex="-1" role="dialog" id="newSubscriptionForm" style="display:none;" aria-labelledby="newSubscriptionFormLabel" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
              <div class="modal-content px-0 pb-0 shadow-none">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                  <span aria-hidden="true">&times;</span>
                </button>
                <br>
                <div class="modal-body">

                  @include('subscriptions.partials.create-form')

                </div>
              </div>
            </div>
          </div>
          <!-- END - Appointment Subscription Form-->
        @endif 
      @endauth
  </div><!-- #/id -->

    <!-- SCRIPTS -->
    @include('layouts.redesign.scripts') 

  </body>
</html>