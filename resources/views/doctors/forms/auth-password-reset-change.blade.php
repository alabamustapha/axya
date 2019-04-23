@extends('layouts.master')

@section('title', 'Doctor Account Password Reset')
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

                            <form method="POST" action="{{ route('doctor.password.reset-change') }}">
                                @csrf
                                {{ method_field('PATCH') }}

                                @include('doctors.forms.auth-new-password')

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
