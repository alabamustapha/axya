    <div class="form-group">
        <div class="col">

            <label for="password" class="col-form-label-sm">{{ __('New Password') }}</label>
            <input id="password" type="password" minlength="8" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="new password" aria-describedby="passwordHelp" required>
            <small id="passwordHelp" class="form-text text-muted">
                At least <strong>8 characters long</strong>, must be <em>different from your normal account password</em>.
            </small>

            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>
    

    <div class="form-group">
        <div class="col">

            <label for="password-confirm" class="col-form-label-sm">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" minlength="8" class="form-control" name="password_confirmation" placeholder="confirm password" required>
        </div>
    </div>

    <div class="form-group col-12">
        <button type="submit" class="btn btn-primary btn-block">
            {{ __('Update Password') }}
        </button>
    </div>