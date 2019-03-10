@if (! Request::is('/'))  {{-- Exempt Welcome Page --}}
  @auth
    <div class="text-center">

      <!-- Verification nag -->
      @unless(Auth::user()->is_verified)
        <div class="container my-2 py-2">
          <div class="nag nag-danger">
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

        @if (/*Auth::user()->is_potential_doctor &&*/ !Auth::user()->isDoctor() && Auth::user()->isAccountOwner())
          @if (! Request::is('appointments/*') && ! Request::is('doctors/create'))
              <h4 class="pt-2 text-center">
                {{-- Extract this to a view for doctors personal notifications only. --}}

                {{ Auth::user()->applicationStatus() }}

              </h4>
          @endif
        @endif
      @endunless

      @if (Auth::user()->isDoctor() && Request::is('*/notifications'))
        @if (!Auth::user()->doctor->is_subscribed)
          <small>
            You must be subscribed to appear in search results and to receive appointment from patients on this platform.
            
            <br>

            {{-- <button class="btn btn-primary btn-sm" 
              data-toggle="modal" data-target="#newSubscriptionForm" 
              title="New Subscription">Subscribe Now</button> --}}
              
            <a href="{{ route('subscription_plans.index') }}" class="btn btn-primary btn-sm" 
              title="New Subscription">Subscribe Now</a>
          </small>
        @else
            {{-- <button class="btn btn-primary btn-sm" 
              data-toggle="modal" data-target="#newSubscriptionForm" 
              title="New Subscription">Extend current subscription</button> --}}

            <a href="{{ route('subscription_plans.index') }}" class="btn btn-primary btn-sm" 
              title="New Subscription">Extend current subscription</a>
        @endif
      @endif
    </div>
  @endauth
@endif

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

<div class="col text-left">
  @include('flash::message')
</div>