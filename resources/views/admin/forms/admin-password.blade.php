@extends('layouts.master')

@section('title', 'Admin Account Password Update')

@section('content')
    <!-- SIGN IN / REGISTER -->
    <div class="form-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-white">
                            <span class="card-title h2"><i class="fa fa-info-circle"></i> Admin Account Password Update</span>
                            <p>Add/Change your Admin Account Password with this Form</p>
                        </div>
                        <div class="card-body">

<form method="POST" action="{{ route('admin.password') }}">
    @csrf
    {{ method_field('PATCH') }}

    <div class="form-group row">
        <label class="col-12 text-center h4">{{Auth::user()->name}} {{ __('Admin Account Password Update') }}</label>  
    </div>

    @if (Auth::user()->admin_password)
    <div class="form-group row">
        <label for="old_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Admin Password') }}</label>

        <div class="col-md-6">
            <input id="old_password" type="password" minlength="8" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" name="old_password" placeholder="old password" aria-describedby="oldPasswordHelp" required>
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
    @endif

    <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

        <div class="col-md-6">
            <input id="password" type="password" minlength="8" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="new password" aria-describedby="passwordHelp" required>
            <small id="passwordHelp" class="form-text text-muted">
                Must be at least <strong>8 characters long</strong> and must be <em>different from your normal account password</em>.
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
            <input id="password-confirm" type="password" minlength="8" class="form-control" name="password_confirmation" placeholder="confirm password" required>
        </div>
    </div>

    <div class="form-group col-12">
        <button type="submit" class="btn btn-primary btn-block">
            {{ __('Update Password') }}
        </button>
    </div>
</form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
