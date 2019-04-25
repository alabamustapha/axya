@extends('layouts.admin')

@section('title', 'Admin Account Password Update')
@section('page-title')
    <i class="fa fa-user-tie"></i>&nbsp;  {{ __('Admin Account Password Update') }}
@endsection

@section('content')
    <!-- SIGN IN / REGISTER -->
    <div class="form-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">

                            <form method="POST" action="{{ route('admin.password') }}">
                                @csrf
                                {{ method_field('PATCH') }}

                                @if (Auth::user()->admin_password)
                                <div class="form-group">
                                    <div class="col">

                                        <label for="old_password" class="col-form-label-sm">{{ __('Current Admin Password') }}</label>
                                        <input id="old_password" type="password" minlength="8" class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" name="old_password" placeholder="current password" aria-describedby="oldPasswordHelp" required>
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

                                @include('admin.forms._new-password')

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
