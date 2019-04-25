@extends('layouts.admin')

@section('title', 'Admin Login')
@section('page-title')
    <i class="fa fa-user-tie"></i>&nbsp; {{ __('Admin Login') }}
@endsection

@section('content')
    <!-- SIGN IN / REGISTER -->
    <div class="form-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">

                            @include('admin.forms.admin-login-form')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection