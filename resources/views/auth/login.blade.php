@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8 mt-5">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    @include('users.forms.login')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
