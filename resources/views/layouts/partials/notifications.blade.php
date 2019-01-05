@auth

  <!-- Verification nag -->
  @unless(Auth::user()->is_verified)
    <div class="container my-2 py-2">
      <div class="nag nag-danger text-center">
        <div class="p-1 bg-light" style="font-size: 14px;">
        
        @if (Auth::user()->verification_link)
        {{-- These two forms with the accompanyibg routes and methods on UserCtrlr are for temporary use only, must be removed!!! --}}
          {{ __('Verify your account with this button') }},
          <form action="{{ route('email_verified') }}" method="post" style="display: inline-block;">@csrf <button type="submit" class="btn btn-sm btn-info">{{ __('Verify Me Now!') }}</button> </form>
        @else
          {{ __('If you did not receive the email') }}, 
          <form action="{{ route('verify_resend') }}" method="post" style="display: inline-block;">@csrf <button type="submit" class="btn btn-sm btn-danger">{{ __('click here for a new one.') }}</button> </form>
        @endif

        {{-- {{ __('For full access on this platform, please verify your account with the verification link sent to '. Auth::user()->email .'.') }}
        <br>
        {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" style="font-weight: bold;text-shadow: 2px1px #fff;color:yellow;">{{ __('click here for a new one.') }}</a> --}}
          
        </div>
      </div>
    </div>

  @else

    @if (! Request::is('appointments/*') && ! Request::is('doctors/create'))
      @if (Auth::user()->isAccountOwner())
          <h4 class="pt-2 text-center">

            {{ Auth::user()->applicationStatus() }}

          </h4>
      @endif
    @endif
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