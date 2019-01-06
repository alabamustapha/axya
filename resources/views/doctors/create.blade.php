@extends('layouts.master')

@section('title', 'Medical Doctors Account Registration')
@section('page-title', 'Register As A Doctor')

@section('content')
 
    <div class="col-md-6 offset-md-3">      
        @include('doctors.forms.apply')        
    </div>

    {{-- @include('doctors.forms.register') --}}

@endsection