@extends('layouts.master')

@section('title', 'User Prescription')

@section('content')

<div class="table-responsive tp-scrollbar">
    
  @include('prescriptions._card')

</div>

@endsection