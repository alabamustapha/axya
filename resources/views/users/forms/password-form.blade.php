<form method="POST" action="{{ route('password.update', $user) }}">
    @csrf
    {{ method_field('PATCH') }}

    <div class="form-group row">
        <label class="col-12 text-center h4">{{$user->name}} {{ __('Password Update') }}</label>  
    </div>

    <div class="form-group row">
        <label for="old_password" class="col-md-4 col-form-label text-md-right">{{ __('Present Password') }}</label>

        <div class="col-md-6">
            <input id="old_password" type="password" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" name="old_password" placeholder="present password" required>

            @if ($errors->has('old_password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('old_password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="new password" required>

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
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="confirm password" required>
        </div>
    </div>

    <div class="form-group col-12">
        <button type="submit" class="btn btn-primary btn-block">
            {{ __('Update Password') }}
        </button>
    </div>
</form>
