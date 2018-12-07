<div class="modal text-center p-0" tabindex="-1" role="dialog" id="regLoginForm" style="display:none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content bg-danger">
      
      <div class="modal-header px-3 pt-2 pb-0 mb-0" style="padding: 0.5rem; border-bottom: none;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body p-2 mt-1 mb-0"> 
        {{-- @include('auth.partials.registration-login-form') --}}
        <div class="card bg-transparent mb-0">
          <div class="card-body">

            <div id="toggle-tabs" class="clearfix mb-2 border-bottom" style="margin: 0 auto;">
                <div class="btn btn-sm mb-2" id="login" style="min-width:120px;"><i class="fa fa-sign-in-alt"></i> Sign In</div>
                <div class="btn btn-sm mb-2" id="regform" style="min-width:120px;"><i class="fa fa-user-plus"></i> Sign Up</div>
            </div>  

            <div class="row">

              @if (request()->url() !== route('login'))

                  <div class="col-sm-12" id="login-form">

                      @include('users.forms.login')

                  </div>

              @endif

              @if (request()->url() !== route('register'))

                  <div class="col-sm-12" id="reg-form" style="display:none;">
                      
                      @include('users.forms.register')
                      
                  </div>

              @endif
            </div>
          </div>
        </div>
      </div> <!-- modal-body -->    
    </div>
  </div> <!-- modal-dialog -->
</div>