<form method="POST" action="{{ route('password.update', $user) }}">
    @csrf
    {{ method_field('PATCH') }}

    <div class="form-group row">
        <label class="col-12 text-center h4 mb-4 p-3 bg-light">
            <i class="fa fa-key mr-1"></i> 
            {{ __('Password Update') }}

            <br>

            <small class="text-sm p-1 rounded bg-white">
                <em>This is different from forgot password.</em>
            </small>
        </label>  
    </div>

    <div class="form-group row">
        <label for="old_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>

        <div class="col-md-6">
            <input id="old_password" type="password" minlength="6" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" name="old_password" placeholder="old password" aria-describedby="oldPasswordHelp" required>
            <small id="oldPasswordHelp" class="form-text text-muted">
                <em>Enter your current password correctly</em>.
            </small>

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
            <input id="password" type="password" minlength="6" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="new password" aria-describedby="passwordHelp" required>
            <small id="passwordHelp" class="form-text text-muted">
                Must be at least <strong>6 characters long</strong>.
            </small>

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
            <input id="password-confirm" type="password" minlength="6" class="form-control" name="password_confirmation" placeholder="confirm password" required>
        </div>
    </div>

    <div class="form-group col-md-6 offset-md-4">
        <button type="submit" class="btn btn-primary btn-block">
            {{ __('Update Password') }}
        </button>
    </div>
</form>
