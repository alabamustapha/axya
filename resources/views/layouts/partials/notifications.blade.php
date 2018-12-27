
@auth
  <!-- Verification nag -->
  @unless(Auth::user()->is_verified)
    <div class="container">
      <div class="nag nag-danger text-center">
        Verify your account with the link below. <br>
        <div class="text-bold p-1 bg-light">
          <a href="{{Auth::user()->verification_link}}">{{Auth::user()->verification_link}}</a>
        </div>

        {{-- {{ __('For full access on this platform, please verify your account with the verification link sent to '. Auth::user()->email .'.') }}
        <br>
        {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" style="font-weight: bold;text-shadow: 2px1px #fff;color:yellow;">{{ __('click here for a new one.') }}</a> --}}
          
      </div>
    </div>
  @endunless
@endauth

@if(isset($errors) && count($errors) > 0)
<div class="container sticky-top">
  <div class="col text-left">
    <div class="alert alert-danger" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>

      <ul class="list-unstyled">
          @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
    </div>
  </div>
</div>
@endif

@include('flash::message')