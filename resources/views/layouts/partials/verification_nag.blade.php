
@unless(Auth::user()->isVerified())
    <div class="container">
        <div class="alert alert-danger text-center">
            {{ __('For full access on this platform, please verify your account with the verification link sent to '. Auth::user()->email .'.') }}
            <br>
            {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here for a new one.') }}</a>.
            
        </div>
    </div>
@endunless