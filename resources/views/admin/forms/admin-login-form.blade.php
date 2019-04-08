<form method="POST" action="{{ route('admin.login') }}">
    @csrf

    {{-- @if (   
        /*  Useful when loading login form from any page. */ 
            request()->url() !== route('admin.login' )
        &&  request()->url() !== route('admin.logout')                                      
        /*  
        &&url()->previous() !== route('admin.login') 
        && url()->previous() !== route('admin.logout')  */ 
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
        <label for="admin_password" class="col-form-label-sm">{{ __('Admin Password') }}</label>
        <input type="password" name="admin_password" class="form-control form-default{{ $errors->has('admin_password') ? ' is-invalid' : '' }}" placeholder="Password" required>

        @if ($errors->has('admin_password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('admin_password') }}</strong>
            </span>
        @endif
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-theme-blue rounded-pill px-4 mb-3">Submit</button>

        <div class="form-group">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a class="btn btn-link" href="{{ route('admin.password.reset-email-form') }}">
                        {{ __('Forgot Your Admin Password?') }}
                    </a>
                </li>
            </ul> 
        </div>
    </div>
</form>