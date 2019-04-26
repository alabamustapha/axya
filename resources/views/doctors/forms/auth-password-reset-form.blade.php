@extends('layouts.doctor')

@section('title', 'Doctor Account Password Reset Form')
@section('page-title')
    <i class="fa fa-key"></i>&nbsp;  {{ __('Doctor Account Password Reset') }}
@endsection

@section('content')
    <!-- SIGN IN / REGISTER -->
    <div class="form-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">

                            <form method="POST" action="{{ route('doctor.password.reset-email-link') }}">
                                @csrf
                                {{ method_field('PATCH') }}

                                {{-- @if (Auth::user()->doctor_password)
                                @endif --}}
                                <div class="form-group">
                                    <div class="col">

                                        <label for="email" class="col-form-label-sm">{{ __('Email') }}</label>
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
