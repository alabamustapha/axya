@extends('layouts.master')

@section('title', 'Register')

@section('content')
    <div class="form-auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-white">
                            <h4 class="card-title ">Register</h4>
                        </div>
                        <div class="card-body">
                            
                            @include('users.forms.register')
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
