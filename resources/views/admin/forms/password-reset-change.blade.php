@extends('layouts.admin')

@section('title', 'Admin Account Password Reset')
@section('page-title')
    <i class="fa fa-key"></i>&nbsp;  {{ __('Admin Account Password Reset') }}
@endsection

@section('content')
    <!-- SIGN IN / REGISTER -->
    <div class="form-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">

                            <form method="POST" action="{{ route('admin.password.reset-change') }}">
                                @csrf
                                {{ method_field('PATCH') }}

                                @include('admin.forms._new-password')

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
