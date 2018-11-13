@extends('layouts.master')

@section('title', 'Apply as a Doctor')

@section('content')

    <div class="col-md-6 offset-md-3">
      
        @include('doctors.forms.apply')
        
    </div>

@endsection