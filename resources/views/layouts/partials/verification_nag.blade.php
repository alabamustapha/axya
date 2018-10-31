
@unless(Auth::user()->isVerified())
    <div class="container">
        <div class="nag nag-danger text-center">
            {{ __('For full access on this platform, please verify your account with the verification link sent to '. Auth::user()->email .'.') }}
            <br>
            {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" style="font-weight: bold;text-shadow: 2px1px #fff;color:yellow;">{{ __('click here for a new one.') }}</a>
            
        </div>
    </div>
@endunless