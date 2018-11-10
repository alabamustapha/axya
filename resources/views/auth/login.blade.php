@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">{{ __('Login') }}</div>

                <div class="card-body">
                    @include('users.forms.login')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
