@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
