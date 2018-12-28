{{-- <form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="Firstname Surname" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

        <div class="col-md-6">
            <select id="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male" {{old('gender') == 'Male' ? 'selected':''}}>Male</option>
                <option value="Female" {{old('gender') == 'Female' ? 'selected':''}}>Female</option>
                <option value="Other" {{old('gender') == 'Other' ? 'selected':''}}>Other</option>
            </select>

            @if ($errors->has('gender'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('gender') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>

        <div class="col-md-6">
            <input type="date" id="dob" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" name="dob" placeholder="yyyy-mm-dd eg 2000-07-24" required>

            @if ($errors->has('dob'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('dob') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

        <div class="col-md-6">
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="your email address" required>

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="password" required>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>
    

    <div class="form-group row">
        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="re-type password" required>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-8 offset-md-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="terms" value="1" required="required" id="terms" {{ old('terms') ? 'checked' : '' }}>  

                <label class="form-check-label text-small" for="terms">
                    I have read and accepted the <abbr title="Terms of Service"><a href="" class="text-bold text-underline text-primary" target="_blank">Terms of Service</a></abbr> and <abbr title="Privacy Policy"><a href="" class="text-bold text-underline text-primary" target="_blank">Privacy policy</abbr></a>
                </label>
            </div>
        </div>
    </div>
    

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Register') }}
            </button>
        </div>
    </div>
</form>
 --}}


<form>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control form-default"  placeholder="John">
            
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control form-default"  placeholder="Doe">
            
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="username">Email</label>
        <input type="email" class="form-control form-default"  placeholder="johndoe@example.com">

    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control form-default"  placeholder="Password">
    </div>
    <div class="acct-type">
        <div class="row">
            <div class="col-sm-6">
                <div id="doc-acct" class=" acct">
                     I WANT TO ATTEND TO PATIENTS
                </div>
            </div>
            <div class="col-sm-6">
                <div id="pat-acct" class="acct">
                     I WANT TO MEET WITH A DOCTOR
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <button type="submit" class="btn btn-theme-blue rounded-pill px-4">Submit</button>

        @if (request()->url() == route('register' ))
            <div class="form-group mt-2">
                <a class="btn btn-link" href="{{ route('login') }}">
                    {{ __('Already registered? Sign in') }}
                </a>  
            </div>
        @endif
    </div>
</form>