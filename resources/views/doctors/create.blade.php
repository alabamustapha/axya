@extends('layouts.master')

@section('title', Auth::user()->name)

@section('content')

    <div class="col-md-6 offset-md-3">
        @include('doctors.forms.apply')
    </div>

@endsection