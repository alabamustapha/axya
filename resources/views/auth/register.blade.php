@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    @include('users.forms.register')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
