<form method="POST" action="{{ route('doctor.login') }}">
    @csrf

    {{-- @if (   
        /*  Useful when loading login form from any page.*/  
            request()->url() !== route('doctor.login' )
        &&  request()->url() !== route('doctor.logout')                                    
        /*  
        && url()->previous() !== route('doctor.login') 
        && url()->previous() !== route('doctor.logout')  */  
        )
        @php 
            // $target_url = url()->previous() ?: request()->url();
            $target_url = request()->url();
            
            $url = explode(config('app.url'), $target_url); 
            $ref = end($url);
        @endphp
        
        <input type="hidden" name="ref" value="{{ $ref }}">
    @endif --}}

    <div class="form-group">
        <label for="email" class="col-form-label-sm">{{ __('Email') }}</label>
        <input type="email" name="email" class="form-control form-default{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="johndoe@example.com" autofocus required>

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="doctor_password" class="col-form-label-sm">{{ __('Doctor Password') }}</label>
        <input type="password" name="doctor_password" class="form-control form-default{{ $errors->has('doctor_password') ? ' is-invalid' : '' }}" placeholder="Password" required>

        @if ($errors->has('doctor_password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('doctor_password') }}</strong>
            </span>
        @endif
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-theme-blue rounded-pill px-4 mb-3">Submit</button>

        <div class="form-group">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a class="btn btn-link" href="{{ route('doctor.password.reset-email-form') }}">
                        {{ __('Forgot Your Doctor Password?') }}
                    </a>
                </li>
            </ul> 
        </div>
    </div>
</form>