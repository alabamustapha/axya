@extends('layouts.master')

@section('title', 'Doctor Login')

@section('content')
    <!-- SIGN IN / REGISTER -->
    <div class="form-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-white p-4">
                            <label class="text-center h4"><i class="fa fa-info-circle"></i> {{ __('Doctor Sign In') }}</label> 
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{ route('doctor.login') }}">
                                @csrf

                                <div class="form-group">
                                    <label for="email" class="col-form-label-sm">{{ __('Doctor Email') }}</label>
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection