
@if (   request()->url() !== route('doctor.login' ) 
    &&  request()->url() !== route('doctor.logout'))
    <!-- DOCTOR SIGN IN POP UP -->
    <div class="modal fade" id="doctor-sign-in-modal" tabindex="-1" role="dialog" aria-labelledby="doctorSignInPopup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light px-4">
                    <h4 class="text-center">
                        <strong><i class="fa fa-user-md"></i>Doctor Sign In</strong>
                    </h4>
                </div>
                <div class="modal-body p-4">
                    
                    @include('doctors.forms.doctor-login-form')

                </div>               
            </div>
        </div>
    </div>
@endif