@extends('layouts.master')

@section('title', 'Doctor Account Password Reset')

@section('content')
    <!-- SIGN IN / REGISTER -->
    <div class="form-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-white p-4">
                            <label class="text-center h4"><i class="fa fa-info-circle"></i> {{ __('Doctor Account Password Reset') }}</label> 
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{ route('doctor.password.reset-change') }}">
                                @csrf
                                {{ method_field('PATCH') }}

                                @include('doctor.forms._new-password')

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
