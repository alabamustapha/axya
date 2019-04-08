
@if (   request()->url() !== route('admin.login' ) 
    &&  request()->url() !== route('admin.logout'))
    <!-- Admin SIGN IN POP UP -->
    <div class="modal fade" id="admin-sign-in-modal" tabindex="-1" role="dialog" aria-labelledby="adminSignInPopup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light px-4">
                    <h4 class="text-center">
                        <strong><i class="fa fa-user-tie"></i>Admin Sign In</strong>
                    </h4>
                </div>
                <div class="modal-body p-4">
                    
                    @include('admin.forms.admin-login-form')

                </div>               
            </div>
        </div>
    </div>
@endif