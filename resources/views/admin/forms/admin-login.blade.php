@extends('layouts.master')

@section('title', 'Admin Login')

@section('content')
    <!-- SIGN IN / REGISTER -->
    <div class="form-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-white">
                            <span class="card-title h2"><i class="fa fa-info-circle"></i> Admin Sign In</span>
                            {{-- <p>To gain access to the Admin sections sign in with this form</p> --}}
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{ route('admin.login') }}">
                                @csrf
                                      {{--dd(url()->previous(),request()->url())--}}      
                                @if (   
                                    /* request()->url() !== route('admin.login' )  && */
                                      
                                    url()->previous() !== route('admin.login')
                                    )
                                    @php 
                                        // $target_url = request()->url() === route('login' ) ? request()->url() : (url()->previous() ?: request()->url());
                                        $target_url = url()->previous();//request()->url();//
                                        
                                        $url = explode(config('app.url'), $target_url); 
                                        $ref = end($url);
                                    @endphp
                                    {{-- Use regular expression to add the #anchor to this later --}}
                                    <input type="hidden" name="ref" value="{{ $ref }}">
                                @endif
                                <div class="form-group">
                                    <label for="email">{{ __('Admin Email') }}</label>
                                    <input type="email" name="email" class="form-control form-default{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="johndoe@example.com" autofocus required>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="admin_password">{{ __('Admin Password') }}</label>
                                    <input type="password" name="admin_password" class="form-control form-default{{ $errors->has('admin_password') ? ' is-invalid' : '' }}" placeholder="Password" required>

                                    @if ($errors->has('admin_password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('admin_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-theme-blue rounded-pill px-4 mb-3">Submit</button>

                                    <div class="form-group">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a class="btn btn-link" href="{{-- route('admin_password.request') --}}">
                                                    {{ __('Forgot Your Admin Password?') }}
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