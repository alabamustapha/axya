@extends('layouts.master')

@section('title', Auth::user()->name .' Transaction '. $transaction->transaction_id)

@section('page-title', 'Transaction '. $transaction->transaction_id)

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">Transaction {{$transaction->transaction_id}}</h1>
</div>

<div class="card">
    <div class="card-body">
        <h5 class="card-title tf-flex">
            <span>
                Patient <br>
                <a href="{{route('users.show', $transaction->user)}}">{{$transaction->user->name}}</a>
            </span>
            <span>
                Doctor <br>
                <a href="{{route('doctors.show', $transaction->doctor)}}">{{$transaction->doctor->name}}</a>
            </span>
        </h5>

        <h6 class="card-subtitle mb-2 text-muted border-bottom px-2 tf-flex">
            {{$transaction->transaction_id}} - {{$transaction->amount}}
        </h6>
        <p class="card-text">
            {{$transaction->appointment->description}}
        </p>
    </div>
    <div class="card-footer text-muted">{{$transaction->status}}</div>
</div>

@endsection