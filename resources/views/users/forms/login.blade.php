<form method="POST" action="{{ route('login') }}">
    @csrf
                
    @if (   request()->url() !== route('login' )
        &&  request()->url() !== route('logout') 
        &&  request()->url() !== route('register')
        )
        @php 
            $current_url = request()->url();
            
            $url = explode(config('app.url'), $current_url); 
            $ref = end($url);
        @endphp
        {{-- Use regular expression to add the #anchor to this later --}}
        <input type="hidden" name="ref" value="{{ $ref }}">
    @endif
    <div class="form-group">
        <label for="email">{{ __('Email') }}</label>
        <input type="email" name="email" class="form-control form-default{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="johndoe@example.com" autofocus required>

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="form-group">
        <label for="password">{{ __('Password?') }}</label>
        <input type="password" name="password" class="form-control form-default{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" required>

        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-theme-blue rounded-pill px-4 mb-3">Submit</button>

        <div class="form-group">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                </li>
                @if (request()->url() == route('login' ))
                    <!-- Not displayed on other pages except Login since both forms are available in the modal -->
                    <li class="list-inline-item">
                        <a class="btn btn-link" href="{{ route('register') }}">
                            {{ __('New user? Register') }}
                        </a>
                    </li>
                @endif
            </ul> 
        </div>
    </div>
</form>