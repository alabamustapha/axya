@extends('layouts.master')

@section('title', 'Login')

@section('content')
    <!-- SIGN IN / REGISTER -->
    <div class="form-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-white">
                            <h4 class="card-title ">Sign in</h4>
                        </div>
                        <div class="card-body">

                            @include('users.forms.login')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection