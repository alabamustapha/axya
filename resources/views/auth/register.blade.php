@extends('layouts.master')

@section('title', 'Register')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">{{ __('Register') }}</div>

                <div class="card-body">
                    @include('users.forms.register')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
