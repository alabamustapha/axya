@extends('layouts.master')

@section('title', $review->user->name .' Review')

@section('content')
  <div class="contianer">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
      <h1 class="h2">Patient Reviews Dashboard</h1>
    </div>

    <div>
      <h5>{{$review->doctor->name}}</h5>

      <p>
          {{$review->comment}} <br>
          Rating: {{$review->rating}}
      </p>
      
      <p>{{$review->user->name}}</p>
    </div>
 </div>
@endsection