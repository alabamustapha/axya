@extends('layouts.doctor')

@section('title', 'Doctor Login')
@section('page-title')
    <i class="fa fa-sign-in-alt"></i>&nbsp;  {{ __('Doctor Sign In') }}
@endsection

@section('content')
    <!-- SIGN IN / REGISTER -->
    <div class="form-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">

                            @include('doctors.forms.doctor-login-form')

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection