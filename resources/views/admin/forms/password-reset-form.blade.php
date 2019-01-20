@extends('layouts.master')

@section('title', 'Admin Account Password Update')

@section('content')
    <!-- SIGN IN / REGISTER -->
    <div class="form-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-white p-4">
                            <label class="text-center h4"><i class="fa fa-info-circle"></i> {{ __('Admin Account Password Reset Form') }}</label> 
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{ route('admin.password.reset-email-link') }}">
                                @csrf
                                {{ method_field('PATCH') }}

                                {{-- @if (Auth::user()->admin_password)
                                @endif --}}
                                <div class="form-group">
                                    <div class="col">

                                        <label for="email" class="col-form-label-sm">{{ __('Current Admin Email') }}</label>
                                        <input id="email" type="email" minlength="8" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="email" aria-describedby="emailHelp" required>
                                        <small id="emailHelp" class="form-text text-muted">
                                            <em>Enter your current email correctly</em>.
                                        </small>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Reset Password') }}
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
