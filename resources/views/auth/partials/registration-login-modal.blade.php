
@if (   request()->url() !== route('login' ) 
    &&  request()->url() !== route('register'))
    <!-- SIGN IN / SIGN UP POP UP -->
    <div class="modal fade" id="sign-in-up-modal" tabindex="-1" role="dialog" aria-labelledby="signInSignUpPopup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <ul class="nav nav-tabs sign-in-up-tab" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="sign-in-tab" data-toggle="tab" href="#sign-in" role="tab" aria-controls="sign-in" aria-selected="true">Sign in</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="register-tab" data-toggle="tab" href="#register" role="tab" aria-controls="register" aria-selected="false">Register</a>
                        </li>
                       
                    </ul>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="sign-in" role="tabpanel" aria-labelledby="sign-in-tab">
                            <div class="sign-in-form d-flex justify-content-center">
                                        
                                @include('users.forms.login')

                            </div>
                        </div>
                        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                            <div class="sign-in-form d-flex justify-content-center">
                                        
                                @include('users.forms.register')
                            
                            </div>
                        </div>
                    </div>
                </div>               
            </div>
        </div>
    </div>
@endif